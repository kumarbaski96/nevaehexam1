<?php
include 'conn.php';
// $conn = new mysqli("localhost", "root", "", "nevaeh_exam");
// if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
// Fetch all distinct exam types for the dropdown
$selected_exam_type = isset($_GET['exam_type']) ? $conn->real_escape_string($_GET['exam_type']) : '';

// Fetch questions based on the selected exam_type
$query = "SELECT * FROM questions";
if (!empty($selected_exam_type)) {
    $query .= " WHERE exam_type='$selected_exam_type'";
}
$questions = $conn->query($query);

if (!$questions) {
    die("Error in query: " . $conn->error);
}

// Fetch all distinct exam types for the dropdown
$exam_types = $conn->query("SELECT DISTINCT exam_type FROM exam_type_menu");
if (!$exam_types) {
    die("Error in fetching exam types: " . $conn->error);
}
// Insert question
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $option1 = mysqli_real_escape_string($conn, $_POST['option1']);
    $option2 = mysqli_real_escape_string($conn, $_POST['option2']);
    $option3 = mysqli_real_escape_string($conn, $_POST['option3']);
    $option4 = mysqli_real_escape_string($conn, $_POST['option4']);
    $correct_option = (int)$_POST['correct_option']; // Casting to integer
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Prepare the SQL query with placeholders
    $stmt = $conn->prepare("INSERT INTO questions (question, option1, option2, option3, option4, correct_option, exam_type) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Bind the parameters to the placeholders
    $stmt->bind_param("sssssis", $question, $option1, $option2, $option3, $option4, $correct_option, $category);

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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" style="color: orenge;" href="#">Nevaeh Technology</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" style="color: red;" href="show_question.php">Show Qustions</a>
                    </li>
                    <!--li class="nav-item">
                        <a class="nav-link" style="color: blue;" href="add_question.php">Add Questions</a>
                    </li-->
                    <li class="nav-item">
                        <a class="nav-link" style="color: blue;" href="show_exam_type.php">Show exam type</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
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
            <label for="category" class="form-label">Category</label>
            <select name="category" class="form-select" id="category" required>
                <option value="Python">select Exam Type</option>    
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
