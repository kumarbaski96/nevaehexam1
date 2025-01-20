<?php
session_start();
include 'conn.php'; // Ensure 'conn.php' is the correct file and includes the database connection.

// Initialize session for storing selected questions
if (!isset($_SESSION['selected_questions'])) {
    $_SESSION['selected_questions'] = [];
}

// Get user input
$exam_type = isset($_GET['exam_type']) ? trim($_GET['exam_type']) : '';
$level = isset($_GET['level']) ? trim($_GET['level']) : '';
$question_limit = isset($_GET['question_limit']) ? (int)$_GET['question_limit'] : 5;

// Fetch available exam types
$examTypesQuery = "SELECT DISTINCT exam_type FROM exam_type_menu";
$examTypesResult = $conn->query($examTypesQuery);
if (!$examTypesResult) {
    die("Error fetching exam types: " . $conn->error);
}

// Fetch available levels
$levelsQuery = "SELECT DISTINCT level FROM questions WHERE status = 1";
$levelsResult = $conn->query($levelsQuery);
if (!$levelsResult) {
    die("Error fetching levels: " . $conn->error);
}

// Fetch questions based on filters only if all filters are selected
$questions = [];
if (!empty($exam_type) && !empty($level) && !empty($question_limit)) {
    $sql = "SELECT id, question, option1, option2, option3, option4 
            FROM questions WHERE status = 1";

    $params = [];
    $types = "";

    if (!empty($exam_type)) {
        $sql .= " AND LOWER(exam_type) = LOWER(?)";
        $params[] = $exam_type;
        $types .= "s";
    }

    if (!empty($level)) {
        $sql .= " AND level = ?";
        $params[] = $level;
        $types .= "s";
    }

    $sql .= " ORDER BY RAND() LIMIT ?";
    $params[] = $question_limit;
    $types .= "i";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param($types, ...$params);
    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $questions = $result->fetch_all(MYSQLI_ASSOC);
    }
}

// Store selected questions temporarily in session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question_ids'])) {
    foreach ($_POST['question_ids'] as $question_id) {
        if (!in_array($question_id, array_column($_SESSION['selected_questions'], 'id'))) {
            $_SESSION['selected_questions'][] = [
                'id' => $question_id,
                'exam_type' => $exam_type,
                'level' => $level
            ];
        }
    }
}

// Final submission - store all selected questions in question_bank
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['final_submit'])) {
    // Generate a single set code for this question set
    $set_code = "QBSET" . strtoupper(bin2hex(random_bytes(3)));

    foreach ($_SESSION['selected_questions'] as $selected) {
        $insertQuery = "INSERT INTO question_bank (question_id, exam_type, level, set_code) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        if (!$insertStmt) {
            die("Error preparing insert statement: " . $conn->error);
        }
        $insertStmt->bind_param("isis", $selected['id'], $selected['exam_type'], $selected['level'], $set_code);
        if (!$insertStmt->execute()) {
            die("Error executing insert statement: " . $insertStmt->error);
        }
    }

    // Clear session after storing
    $_SESSION['selected_questions'] = [];
}

// Fetch stored questions from session
$selectedQuestions = $_SESSION['selected_questions'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dynamic Quiz</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Dynamic Quiz</h2>

        <!-- Filter Form -->
        <form method="GET" action="">
            <div class="row">
                <div class="col-md-4">
                    <label>Select Exam Type:</label>
                    <select name="exam_type" class="form-select mb-3" onchange="this.form.submit()">
                        <option value="">All</option>
                        <?php while ($row = $examTypesResult->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($row['exam_type']); ?>" 
                                <?= $exam_type == $row['exam_type'] ? 'selected' : '' ?> >
                                <?= htmlspecialchars($row['exam_type']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Select Level:</label>
                    <select name="level" class="form-select mb-3" onchange="this.form.submit()">
                        <option value="">All</option>
                        <?php while ($row = $levelsResult->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($row['level']); ?>" 
                                <?= $level == $row['level'] ? 'selected' : '' ?> >
                                <?= htmlspecialchars($row['level']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Number of Questions:</label>
                    <select name="question_limit" class="form-select mb-3" onchange="this.form.submit()">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>" <?= $question_limit == $i ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
        </form>

        <!-- Display message if no filters selected -->
        <?php if (empty($exam_type) || empty($level) || empty($question_limit)): ?>
            <p class="text-warning">Please select an Exam Type, Level, and Number of Questions to proceed.</p>
        <?php endif; ?>

        <!-- Display Questions -->
        <form method="POST" action="">
            <?php if (!empty($questions)): ?>
                <?php foreach ($questions as $questionData): ?>
                    <div class="card p-3 mb-3">
                        <h4><?= htmlspecialchars($questionData['question']); ?></h4>

                        <input type="checkbox" name="question_ids[]" value="<?= htmlspecialchars($questionData['id']); ?>">
                        <label>Select this question</label>

                        <p><strong>Options:</strong></p>
                        <ul>
                            <li><?= htmlspecialchars($questionData['option1']); ?></li>
                            <li><?= htmlspecialchars($questionData['option2']); ?></li>
                            <li><?= htmlspecialchars($questionData['option3']); ?></li>
                            <li><?= htmlspecialchars($questionData['option4']); ?></li>
                        </ul>
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary mt-3">Add to Selection</button>
            <?php else: ?>
                <p class="text-danger mt-3">No questions found for the selected filters.</p>
            <?php endif; ?>
        </form>

        <h3 class="mt-5">Selected Questions</h3>
        <?php foreach ($selectedQuestions as $selected): ?>
            <div class="card p-3 mb-3">
                <h4>Question ID: <?= htmlspecialchars($selected['id']); ?> 
                    <span class="badge bg-primary">Level <?= htmlspecialchars($selected['level']); ?></span>
                </h4>
            </div>
        <?php endforeach; ?>

        <form method="POST">
            <button type="submit" name="final_submit" class="btn btn-success mt-3">Finalize & Save Question Set</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
