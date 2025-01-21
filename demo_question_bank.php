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

// Initialize form variables
$examType = '';
$quantity1 = $quantity2 = $quantity3 = 1; // Default values
$questions = [];
$multipleSubjects = false;
$examTypesSelected = [];

// Handle form submission for filtering questions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $examType = $_POST['exam_type'];
    $multipleSubjects = isset($_POST['subject_type']) && $_POST['subject_type'] == 'multiple';

    // If it's a single subject
    if (!$multipleSubjects) {
        $quantity1 = isset($_POST['quantity1']) ? $_POST['quantity1'] : 1;
        $quantity2 = isset($_POST['quantity2']) ? $_POST['quantity2'] : 1;
        $quantity3 = isset($_POST['quantity3']) ? $_POST['quantity3'] : 1;

        // Fetch questions for each level
        $questions = array_merge(
            getRandomQuestions($conn, $examType, 1, $quantity1),
            getRandomQuestions($conn, $examType, 2, $quantity2),
            getRandomQuestions($conn, $examType, 3, $quantity3)
        );
    }

    // If it's multiple subjects
    if ($multipleSubjects) {
        $examTypesSelected = $_POST['exam_types']; // Array of selected exam types
        $questions = []; // Initialize an empty array to hold questions
        
        foreach ($examTypesSelected as $examType) {
            $quantity1 = isset($_POST["quantity1_$examType"]) ? $_POST["quantity1_$examType"] : 0;
            $quantity2 = isset($_POST["quantity2_$examType"]) ? $_POST["quantity2_$examType"] : 0;
            $quantity3 = isset($_POST["quantity3_$examType"]) ? $_POST["quantity3_$examType"] : 0;

            // Fetch questions for each selected exam type
            $questions = array_merge(
                $questions,
                array_merge(
                    getRandomQuestions($conn, $examType, 1, $quantity1),
                    getRandomQuestions($conn, $examType, 2, $quantity2),
                    getRandomQuestions($conn, $examType, 3, $quantity3)
                )
            );
        }
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
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Manage Question Bank</h2>

        <!-- Subject Type Radio Buttons -->
        <form method="POST" id="subjectForm">
            <div class="row">
                <div class="col-md-3">
                    <label>Subject Type:</label><br>
                    <label><input type="radio" name="subject_type" value="single" <?= !$multipleSubjects ? 'checked' : ''; ?>> Single Subject</label><br>
                    <label><input type="radio" name="subject_type" value="multiple" <?= $multipleSubjects ? 'checked' : ''; ?>> Multiple Subjects</label>
                </div>
            </div>

            <!-- Dynamic Subject Selection and Quantity Fields for Single Subject -->
            <div id="singleSubjectFields">
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
            </div>

            <!-- Dynamic Subject Selection and Quantity Fields for Multiple Subjects -->
            <div id="multipleSubjectFields" style="display: none;">
                <div id="subjectSelectors">
                    <div class="row" id="subjectSelectorRow">
                        <div class="col-md-3">
                            <label>Select Exam Type:</label>
                            <select name="exam_types[]" class="form-select">
                                <option value="">Select Exam Type</option>
                                <?php 
                                // Reset the exam types result pointer for multiple subjects
                                $examTypesResult->data_seek(0);
                                while ($row = $examTypesResult->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($row['exam_type']); ?>"><?= htmlspecialchars($row['exam_type']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- Level 1 -->
                        <div class="col-md-2">
                            <label>Level 1 Question Quantity:</label>
                            <select name="quantity1_[]" class="form-select">
                                <?php for ($i = 1; $i <= 50; $i++): ?>
                                    <option value="<?= $i; ?>"><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <!-- Level 2 -->
                        <div class="col-md-2">
                            <label>Level 2 Question Quantity:</label>
                            <select name="quantity2_[]" class="form-select">
                                <?php for ($i = 1; $i <= 50; $i++): ?>
                                    <option value="<?= $i; ?>"><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <!-- Level 3 -->
                        <div class="col-md-2">
                            <label>Level 3 Question Quantity:</label>
                            <select name="quantity3_[]" class="form-select">
                                <?php for ($i = 1; $i <= 50; $i++): ?>
                                    <option value="<?= $i; ?>"><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <!-- Delete Button for the Subject -->
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger deleteSubjectBtn">Delete</button>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-secondary" id="addSubject">Add Another Subject</button>
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

    <script>
        // Toggle fields based on subject type
        document.querySelectorAll('input[name="subject_type"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                const singleSubjectFields = document.getElementById('singleSubjectFields');
                const multipleSubjectFields = document.getElementById('multipleSubjectFields');
                
                if (this.value === 'multiple') {
                    singleSubjectFields.style.display = 'none';
                    multipleSubjectFields.style.display = 'block';
                } else {
                    singleSubjectFields.style.display = 'block';
                    multipleSubjectFields.style.display = 'none';
                }
            });
        });

        // Add more subject selectors dynamically
        document.getElementById('addSubject').addEventListener('click', function () {
            const subjectRow = document.getElementById('subjectSelectorRow');
            const newRow = subjectRow.cloneNode(true);
            const deleteBtn = newRow.querySelector('.deleteSubjectBtn');
            
            // Add delete functionality to the new row
            deleteBtn.addEventListener('click', function () {
                newRow.remove();
            });

            document.getElementById('subjectSelectors').appendChild(newRow);
        });

        // Add delete functionality to the first row
        const deleteBtns = document.querySelectorAll('.deleteSubjectBtn');
        deleteBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const subjectRow = btn.closest('.row');
                subjectRow.remove();
            });
        });
    </script>
</body>
</html>
