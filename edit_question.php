<?php
include 'conn.php';

// Check if the question ID is provided
if (!isset($_GET['id'])) {
    die("Question ID not provided.");
}

$id = $conn->real_escape_string($_GET['id']);

// Fetch the question data
$result = $conn->query("SELECT * FROM questions WHERE id='$id'");
if ($result->num_rows === 0) {
    die("Question not found.");
}

$question = $result->fetch_assoc();

// Handle form submission to update the question
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_text = $conn->real_escape_string($_POST['question']);
    $option1 = $conn->real_escape_string($_POST['option1']);
    $option2 = $conn->real_escape_string($_POST['option2']);
    $option3 = $conn->real_escape_string($_POST['option3']);
    $option4 = $conn->real_escape_string($_POST['option4']);
    $correct_option = $conn->real_escape_string($_POST['correct_option']);
    $exam_type = $conn->real_escape_string($_POST['exam_type']);

    $update_query = "
        UPDATE questions 
        SET question='$question_text', option1='$option1', option2='$option2', option3='$option3', option4='$option4', correct_option='$correct_option', exam_type='$exam_type'
        WHERE id='$id'
    ";

    if ($conn->query($update_query)) {
        header("Location: show_question.php"); // Redirect back to the questions page
        exit;
    } else {
        echo "Error updating question: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Question</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Question</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Question</label>
            <input type="text" name="question" class="form-control" value="<?php echo htmlspecialchars($question['question']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Option 1</label>
            <input type="text" name="option1" class="form-control" value="<?php echo htmlspecialchars($question['option1']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Option 2</label>
            <input type="text" name="option2" class="form-control" value="<?php echo htmlspecialchars($question['option2']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Option 3</label>
            <input type="text" name="option3" class="form-control" value="<?php echo htmlspecialchars($question['option3']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Option 4</label>
            <input type="text" name="option4" class="form-control" value="<?php echo htmlspecialchars($question['option4']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Correct Option</label>
            <input type="text" name="correct_option" class="form-control" value="<?php echo htmlspecialchars($question['correct_option']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Category (Exam Type)</label>
            <input type="text" name="exam_type" class="form-control" value="<?php echo htmlspecialchars($question['exam_type']); ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Update Question</button>
        <a href="view_questions.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
