<?php
include 'conn.php';

$selected_exam_type = isset($_GET['exam_type']) ? $conn->real_escape_string($_GET['exam_type']) : '';

// Fetch questions based on the selected exam type
$query = "SELECT * FROM questions";
if (!empty($selected_exam_type)) {
    $query .= " WHERE exam_type='$selected_exam_type'";
}
$questions = $conn->query($query);

if (!$questions) {
    die("Error in query: " . $conn->error);
}

// Fetch exam types where status = 1
$exam_types = $conn->query("SELECT DISTINCT exam_type FROM exam_type_menu WHERE status = 1");

if (!$exam_types) {
    die("Error in fetching exam types: " . $conn->error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $option1 = mysqli_real_escape_string($conn, $_POST['option1']);
    $option2 = mysqli_real_escape_string($conn, $_POST['option2']);
    $option3 = mysqli_real_escape_string($conn, $_POST['option3']);
    $option4 = mysqli_real_escape_string($conn, $_POST['option4']);
    $correct_option = (int)$_POST['correct_option']; // Casting to integer
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $level = (int)$_POST['question_level']; // Added level as an integer
    
    // Prepare the SQL query with placeholders (added `level`)
    $stmt = $conn->prepare("INSERT INTO questions (question, option1, option2, option3, option4, correct_option, exam_type, level) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Bind the parameters to the placeholders (added 'i' for level)
    $stmt->bind_param("sssssisi", $question, $option1, $option2, $option3, $option4, $correct_option, $category, $level);
    
    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Question Added Successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    
    // Close the statement
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Question</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
<?php include 'header2.php';?>
<div class="container mt-5">
    <h2 class="text-center">Add MCQ Question</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="question" class="form-label">Question</label>
            <textarea name="question" class="form-control" id="question" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="option1" class="form-label">Option 1</label>
            <input type="text" name="option1" class="form-control" id="option1" required>
        </div>
        <div class="mb-3">
            <label for="option2" class="form-label">Option 2</label>
            <input type="text" name="option2" class="form-control" id="option2" required>
        </div>
        <div class="mb-3">
            <label for="option3" class="form-label">Option 3</label>
            <input type="text" name="option3" class="form-control" id="option3" required>
        </div>
        <div class="mb-3">
            <label for="option4" class="form-label">Option 4</label>
            <input type="text" name="option4" class="form-control" id="option4" required>
        </div>
        <div class="mb-3">
            <label for="correct_option" class="form-label">Correct Option (Enter 1, 2, 3, or 4)</label>
            <input type="number" name="correct_option" class="form-control" id="correct_option" min="1" max="4" required>
        </div>
        <div class="mb-3">
            <label for="question_level" class="form-label">Question Level</label>
            <select name="question_level" class="form-select" id="question_level" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <!-- <option value="4">4</option>
                <option value="5">5</option> -->
            </select>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select name="category" class="form-select" id="category" required>
                <!-- <option value="">Select Exam Type</option> -->
                <?php while ($row = $exam_types->fetch_assoc()) { ?>
                    <option value="<?php echo htmlspecialchars($row['exam_type']); ?>" 
                        <?php if ($selected_exam_type === $row['exam_type']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($row['exam_type']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Question</button>
    </form>
</div>
</body>
</html>
