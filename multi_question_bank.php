<?php
session_start();
include 'conn.php';

// Function to get random questions for a specific exam type and level
function getRandomQuestions($conn, $examType, $level, $quantity) {
    $query = "SELECT id, question, option1, option2, option3, option4, correct_option, level 
              FROM questions WHERE exam_type = ? AND level = ? 
              ORDER BY RAND() LIMIT ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $examType, $level, $quantity);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Fetch distinct exam types from the exam_type_menu table
$examTypesQuery = "SELECT DISTINCT exam_type FROM exam_type_menu";
$examTypesResult = $conn->query($examTypesQuery);

// Initialize variables
$questions = [];
$examTypesSelected = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['exam_types']) && is_array($_POST['exam_types'])) {
        foreach ($_POST['exam_types'] as $examType) {
            $quantity1 = $_POST["quantity1_$examType"] ?? 0;
            $quantity2 = $_POST["quantity2_$examType"] ?? 0;
            $quantity3 = $_POST["quantity3_$examType"] ?? 0;

            // Fetch and merge questions
            $questions = array_merge(
                $questions,
                getRandomQuestions($conn, $examType, 1, $quantity1),
                getRandomQuestions($conn, $examType, 3, $quantity3)
            );
        }
    }
}

// Save selected questions into the question bank
if (isset($_POST['selected_questions'])) {
    foreach ($_POST['selected_questions'] as $questionID) {
        $query = "INSERT INTO question_bank (question_id, exam_type, question, option1, option2, option3, option4, correct_option, level) 
                  SELECT id, exam_type, question, option1, option2, option3, option4, correct_option, level FROM questions WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $questionID);
        $stmt->execute();
    }
    echo "<script>alert('Question Bank Saved Successfully!');</script>";
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

        <!-- Subject Selection Form -->
        <form method="POST" id="questionForm">
            <div id="subjectFields">
                <div class="row subjectRow">
                    <div class="col-md-3">
                        <label>Select Exam Type:</label>
                        <select name="exam_types[]" class="form-select examType">
                            <option value="">Select Exam Type</option>
                            <?php while ($row = $examTypesResult->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($row['exam_type']); ?>"><?= htmlspecialchars($row['exam_type']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Level 1 -->
                    <div class="col-md-2">
                        <label>Level 1 Questions:</label>
                        <select name="quantity1_[]" class="form-select">
                            <?php for ($i = 1; $i <= 50; $i++): ?>
                                <option value="<?= $i; ?>"><?= $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <!-- Level 3 -->
                    <div class="col-md-2">
                        <label>Level 3 Questions:</label>
                        <select name="quantity3_[]" class="form-select">
                            <?php for ($i = 1; $i <= 50; $i++): ?>
                                <option value="<?= $i; ?>"><?= $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger removeSubject mt-4">Remove</button>
                    </div>
                </div>
            </div>

            <button type="button" id="addSubject" class="btn btn-secondary mt-3">Add Another Subject</button>
            <button type="submit" class="btn btn-primary mt-3">Fetch Questions</button>
        </form>

        <hr>

        <!-- Questions Table -->
        <h3>Available Questions</h3>
        <form method="POST" action="">
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
                        <th>Level</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($questions)): ?>
                        <?php foreach ($questions as $question): ?>
                            <tr>
                                <td><?= $question['id']; ?></td>
                                <td><?= htmlspecialchars($question['question']); ?></td>
                                <td><?= htmlspecialchars($question['option1']); ?></td>
                                <td><?= htmlspecialchars($question['option2']); ?></td>
                                <td><?= htmlspecialchars($question['option3']); ?></td>
                                <td><?= htmlspecialchars($question['option4']); ?></td>
                                <td class="text-center"><strong><?= $question['correct_option']; ?></strong></td>
                                <td class="text-center"><strong><?= $question['level']; ?></strong></td>
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

    <script>
        document.getElementById('addSubject').addEventListener('click', function () {
            let newRow = document.querySelector('.subjectRow').cloneNode(true);
            document.getElementById('subjectFields').appendChild(newRow);
            newRow.querySelector('.removeSubject').addEventListener('click', function () {
                newRow.remove();
            });
        });
        
        document.querySelectorAll('.removeSubject').forEach(button => {
            button.addEventListener('click', function () {
                button.closest('.subjectRow').remove();
            });
        });
    </script>
</body>
</html>
