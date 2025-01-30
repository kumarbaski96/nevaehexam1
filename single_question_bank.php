<?php
session_start();
include 'conn.php';

// Fetch distinct exam types from exam_type_menu table
$examTypesQuery = "SELECT DISTINCT exam_type FROM exam_type_menu";
$examTypesResult = $conn->query($examTypesQuery);

if (!$examTypesResult) {
    die("Query failed: " . $conn->error);
}

// Fetch all exam types into an array
$examTypes = [];
while ($row = $examTypesResult->fetch_assoc()) {
    $examTypes[] = $row['exam_type'];
}

$questions = [];

// Function to generate a unique 6-digit alphanumeric code
function generateUniqueCode($conn) {
    do {
        $code = strtoupper(substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6));
        $checkQuery = "SELECT id FROM question_bank WHERE code = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();
    } while ($result->num_rows > 0);
    return $code;
}

// Function to get random questions based on exam type and level
function getRandomQuestions($conn, $examType, $level, $quantity) {
    $query = "SELECT id, question, option1, option2, option3, option4, correct_option, level FROM questions WHERE exam_type = ? AND level = ? ORDER BY RAND() LIMIT ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $examType, $level, $quantity);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Handle form submission for fetching questions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exam_type'])) {
    $examType = $_POST['exam_type']; // Use the selected exam type

    $quantity1 = $_POST['quantity1'];
    $quantity2 = $_POST['quantity2'];
    $quantity3 = $_POST['quantity3'];

    $questions = array_merge(
        $questions,
        getRandomQuestions($conn, $examType, 1, $quantity1),
        getRandomQuestions($conn, $examType, 2, $quantity2),
        getRandomQuestions($conn, $examType, 3, $quantity3)
    );
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_questions'])) {
    $uniqueCode = generateUniqueCode($conn); // Generate a single unique code for the question set

    foreach ($_POST['selected_questions'] as $questionId) {
        // Retrieve question details including exam_type
        $query = "SELECT question, option1, option2, option3, option4, correct_option, exam_type FROM questions WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $questionId);
        $stmt->execute();
        $questionData = $stmt->get_result()->fetch_assoc();

        // Use the actual exam_type from the database
        $examType = $questionData['exam_type'];

        // Insert into question_bank
        $insertQuery = "INSERT INTO question_bank (code, question_id, exam_type, question, option1, option2, option3, option4, correct_option) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sisssssss", $uniqueCode, $questionId, $examType, $questionData['question'], $questionData['option1'], 
                          $questionData['option2'], $questionData['option3'], $questionData['option4'], $questionData['correct_option']);
        $stmt->execute();
    }

    echo "<script>alert('Unique code generated: $uniqueCode');</script>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Single Question Bank</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        function addExamType() {
            const container = document.getElementById("examTypeContainer");

            const div = document.createElement("div");
            div.classList.add("row", "exam-type-entry", "mt-2");
            div.innerHTML = `
                <div class="col-md-3">
                    <label>Exam Type:</label>
                    <select name="exam_type" class="form-select">
                        <?php foreach ($examTypes as $examType): ?>
                            <option value="<?= htmlspecialchars($examType); ?>"><?= htmlspecialchars($examType); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Level 1 Quantity:</label>
                    <input type="number" name="quantity1" class="form-control" min="1" max="50" value="1">
                </div>
                <div class="col-md-2">
                    <label>Level 2 Quantity:</label>
                    <input type="number" name="quantity2" class="form-control" min="1" max="50" value="1">
                </div>
                <div class="col-md-2">
                    <label>Level 3 Quantity:</label>
                    <input type="number" name="quantity3" class="form-control" min="1" max="50" value="1">
                </div>
            `;
            container.appendChild(div);
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Manage Single Question Bank</h2>

        <!-- Filter Form -->
        <form method="POST">
            <div id="examTypeContainer">
                <div class="row mt-3">
                    <div class="col-md-3">
                        <label>Exam Type:</label>
                        <select name="exam_type" class="form-select">
                            <?php foreach ($examTypes as $examType): ?>
                                <option value="<?= htmlspecialchars($examType); ?>"><?= htmlspecialchars($examType); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Level 1 Quantity:</label>
                        <input type="number" name="quantity1" class="form-control" min="1" max="50" value="1">
                    </div>
                    <div class="col-md-2">
                        <label>Level 2 Quantity:</label>
                        <input type="number" name="quantity2" class="form-control" min="1" max="50" value="1">
                    </div>
                    <div class="col-md-2">
                        <label>Level 3 Quantity:</label>
                        <input type="number" name="quantity3" class="form-control" min="1" max="50" value="1">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Fetch Questions</button>
        </form>

        <hr>

        <!-- Questions Table -->
        <h3>Available Questions</h3>
        <form method="POST">
            <input type="hidden" name="mode" value="single">
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
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($questions as $question): ?>
                        <tr>
                            <td><?= $question['id']; ?></td>
                            <td><?= htmlspecialchars($question['question']); ?></td>
                            <td><?= htmlspecialchars($question['option1']); ?></td>
                            <td><?= htmlspecialchars($question['option2']); ?></td>
                            <td><?= htmlspecialchars($question['option3']); ?></td>
                            <td><?= htmlspecialchars($question['option4']); ?></td>
                            <td><?= $question['correct_option']; ?></td>
                            <td><input type="checkbox" name="selected_questions[]" value="<?= $question['id']; ?>" checked></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-success">Create Question Bank</button>
        </form>
    </div>
</body>
</html>
