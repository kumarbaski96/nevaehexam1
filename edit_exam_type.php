<?php
include 'conn.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch current details
    $query = "SELECT * FROM exam_type_menu WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $examType = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $newExamType = $_POST['examType'];

        // Update query
        $updateQuery = "UPDATE exam_type_menu SET exam_type = '$newExamType' WHERE id = $id";
        mysqli_query($conn, $updateQuery);

        header("Location: show_exam_type.php"); // Redirect to the main page
    }
} else {
    die("Invalid request.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Exam Type</title>
</head>
<body>
<?php include 'header2.php';?>

    <h2>Edit Exam Type</h2>
    <form method="POST">
        <label for="examType">Exam Type</label>
        <input type="text" id="examType" name="examType" value="<?= htmlspecialchars($examType['exam_type']); ?>" required>
        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
