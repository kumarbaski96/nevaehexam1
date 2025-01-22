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
        $checkQuery = "SELECT id FROM questions WHERE unique_code = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();
    } while ($result->num_rows > 0);
    return $code;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exam_type'])) {
    $questions = [];
    $mode = $_POST['mode']; // Capture mode selection

    foreach ($_POST['exam_type'] as $index => $examType) {
        $quantity1 = $_POST['quantity1'][$index];
        $quantity2 = $_POST['quantity2'][$index];
        $quantity3 = $_POST['quantity3'][$index];

        $questions = array_merge(
            $questions,
            getRandomQuestions($conn, $examType, 1, $quantity1),
            getRandomQuestions($conn, $examType, 2, $quantity2),
            getRandomQuestions($conn, $examType, 3, $quantity3)
        );
    }

    // Insert selected questions into mcq_question_bank
    if (!empty($_POST['selected_questions'])) {
        foreach ($_POST['selected_questions'] as $questionId) {
            $uniqueCode = generateUniqueCode($conn);
            $selectedExamType = ($mode === "multiple") ? "Aptitude" : $_POST['exam_type'][0];

            $insertQuery = "INSERT INTO mcq_question_bank (unique_code, question_id, exam_type) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sis", $uniqueCode, $questionId, $selectedExamType);
            $stmt->execute();
        }
    }
}
// Function to get random questions based on exam type and level
function getRandomQuestions($conn, $examType, $level, $quantity) {
    $query = "SELECT id, question, option1, option2, option3, option4, correct_option, level 
              FROM questions WHERE exam_type = ? AND level = ? 
              ORDER BY RAND() LIMIT ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $examType, $level, $quantity);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Handle form submission for fetching questions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exam_type'])) {
    $questions = [];
    foreach ($_POST['exam_type'] as $index => $examType) {
        $quantity1 = $_POST['quantity1'][$index];
        $quantity2 = $_POST['quantity2'][$index];
        $quantity3 = $_POST['quantity3'][$index];

        $questions = array_merge(
            $questions,
            getRandomQuestions($conn, $examType, 1, $quantity1),
            getRandomQuestions($conn, $examType, 2, $quantity2),
            getRandomQuestions($conn, $examType, 3, $quantity3)
        );
    }
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
    <script>
        function addExamType() {
            const container = document.getElementById("examTypeContainer");

            const div = document.createElement("div");
            div.classList.add("row", "exam-type-entry", "mt-2");
            div.innerHTML = `
                <div class="col-md-3">
                    <label>Exam Type:</label>
                    <select name="exam_type[]" class="form-select">
                        <?php foreach ($examTypes as $examType): ?>
                            <option value="<?= htmlspecialchars($examType); ?>"><?= htmlspecialchars($examType); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Level 1 Quantity:</label>
                    <input type="number" name="quantity1[]" class="form-control" min="1" max="50" value="1">
                </div>
                <div class="col-md-2">
                    <label>Level 2 Quantity:</label>
                    <input type="number" name="quantity2[]" class="form-control" min="1" max="50" value="1">
                </div>
                <div class="col-md-2">
                    <label>Level 3 Quantity:</label>
                    <input type="number" name="quantity3[]" class="form-control" min="1" max="50" value="1">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger" onclick="this.parentElement.parentElement.remove();">Remove</button>
                </div>
            `;
            container.appendChild(div);
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Manage Question Bank</h2>

        <!-- Filter Form -->
        <form method="POST">
            <label>Select Mode:</label>
            <div>
                <input type="radio" name="mode" value="single" checked onclick="document.getElementById('addExamBtn').style.display='none';"> Single Question
                <input type="radio" name="mode" value="multiple" onclick="document.getElementById('addExamBtn').style.display='block';"> Multiple Questions
            </div>

            <div id="examTypeContainer">
                <div class="row mt-3">
                    <div class="col-md-3">
                        <label>Exam Type:</label>
                        <select name="exam_type[]" class="form-select">
                            <?php foreach ($examTypes as $examType): ?>
                                <option value="<?= htmlspecialchars($examType); ?>"><?= htmlspecialchars($examType); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Level 1 Quantity:</label>
                        <input type="number" name="quantity1[]" class="form-control" min="1" max="50" value="1">
                    </div>
                    <div class="col-md-2">
                        <label>Level 2 Quantity:</label>
                        <input type="number" name="quantity2[]" class="form-control" min="1" max="50" value="1">
                    </div>
                    <div class="col-md-2">
                        <label>Level 3 Quantity:</label>
                        <input type="number" name="quantity3[]" class="form-control" min="1" max="50" value="1">
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-primary mt-3" id="addExamBtn" onclick="addExamType();" style="display: none;">Add Exam Type</button>
            <button type="submit" class="btn btn-primary mt-3">Fetch Questions</button>
        </form>

        <hr>

        <!-- Questions Table -->
        <h3>Available Questions</h3>
        <form method="POST" action="save_question_bank.php">
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
