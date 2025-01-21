<?php
session_start();
include 'conn.php';

// Fetch distinct exam types from candidates table
$examTypesQuery = "SELECT DISTINCT exam_type FROM candidates";
$examTypesResult = $conn->query($examTypesQuery);

// Initialize form variables
$examType = '';
$quantity1 = $quantity2 = $quantity3 = 1; // Default values
$questions = [];

// Handle form submission for filtering questions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exam_type'])) {
    $examType = $_POST['exam_type'];
    $quantity1 = $_POST['quantity1'];
    $quantity2 = $_POST['quantity2'];
    $quantity3 = $_POST['quantity3'];

    // Function to get random questions
    function getRandomQuestions($conn, $examType, $level, $quantity) {
        $query = "SELECT id, question, option1, option2, option3, option4, correct_option, level 
                  FROM questions WHERE exam_type = ? AND level = ? 
                  ORDER BY RAND() LIMIT ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sii", $examType, $level, $quantity);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Fetch questions for each level
    $questions = array_merge(
        getRandomQuestions($conn, $examType, 1, $quantity1),
        getRandomQuestions($conn, $examType, 2, $quantity2),
        getRandomQuestions($conn, $examType, 3, $quantity3)
    );
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Question Bank</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Manage Question Bank</h2>

        <!-- Filter Form -->
        <form method="POST">
            <div class="row">
                <div class="col-md-3">
                    <label>Select Exam Type:</label>
                    <select name="exam_type" id="exam_type" class="form-select">
                        <option value="">Select Exam Type</option>
                        <?php while ($row = $examTypesResult->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($row['exam_type']); ?>" <?= ($examType == $row['exam_type']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($row['exam_type']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Level 1 -->
                <div class="col-md-2">
                    <label>Level 1 Question Quantity:</label>
                    <select name="quantity1" id="quantity1" class="form-select">
                        <?php for ($i = 1; $i <= 50; $i++): ?>
                            <option value="<?= $i; ?>" <?= ($quantity1 == $i) ? 'selected' : ''; ?>><?= $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <!-- Level 2 -->
                <div class="col-md-2">
                    <label>Level 2 Question Quantity:</label>
                    <select name="quantity2" id="quantity2" class="form-select">
                        <?php for ($i = 1; $i <= 50; $i++): ?>
                            <option value="<?= $i; ?>" <?= ($quantity2 == $i) ? 'selected' : ''; ?>><?= $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <!-- Level 3 -->
                <div class="col-md-2">
                    <label>Level 3 Question Quantity:</label>
                    <select name="quantity3" id="quantity3" class="form-select">
                        <?php for ($i = 1; $i <= 50; $i++): ?>
                            <option value="<?= $i; ?>" <?= ($quantity3 == $i) ? 'selected' : ''; ?>><?= $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Fetch Questions</button>
        </form>

        <hr>

        <!-- Questions Table -->
        <h3>Available Questions</h3>
        <form method="POST" action="save_question_bank.php">
            <input type="hidden" name="exam_type" value="<?= htmlspecialchars($examType); ?>">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Question</th>
                        <th>Option 1</th>
                        <th>Option 2</th>
                        <th>Option 3</th>
                        <th>Option 4</th>
                        <th>Correct Option</th>
                        <th>Level</th> <!-- New Column for Question Level -->
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($questions) > 0): ?>
                        <?php foreach ($questions as $question): ?>
                            <tr>
                                <td><?= $question['id']; ?></td>
                                <td><?= htmlspecialchars($question['question']); ?></td>
                                <td><?= htmlspecialchars($question['option1']); ?></td>
                                <td><?= htmlspecialchars($question['option2']); ?></td>
                                <td><?= htmlspecialchars($question['option3']); ?></td>
                                <td><?= htmlspecialchars($question['option4']); ?></td>
                                <td class="text-center"><strong><?= $question['correct_option']; ?></strong></td>
                                <td class="text-center"><strong><?= $question['level']; ?></strong></td> <!-- Display Level -->
                                <td><input type="checkbox" name="selected_questions[]" value="<?= $question['id']; ?>" checked></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="9" class="text-center">No questions found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <button type="submit" class="btn btn-success">Create Question Bank</button>
        </form>
    </div>
</body>
</html>
