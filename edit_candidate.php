<?php
include 'conn.php';

// Check if the ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch candidate data by ID
    $result = $conn->query("SELECT * FROM candidates WHERE id=$id");

    // Check if data is found
    if ($result->num_rows > 0) {
        $candidate = $result->fetch_assoc();
    } else {
        echo "<script>alert('Candidate not found!'); window.location='show_candidate.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('No ID provided!'); window.location='show_candidate.php';</script>";
    exit;
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $exam_type = $_POST['exam_type'];
    $designation = $_POST['designation'];
    $total_marks = $_POST['total_marks'];
    $status = $_POST['status'];
    $is_exam_completed = $_POST['is_exam_completed'];
    $question_code = $_POST['question_code'];  // New question code field
    $exam_duration = $_POST['exam_duration'];  // New exam duration field

    // Update query
    $updateQuery = "UPDATE candidates SET name='$name', mobile='$mobile', email='$email', exam_type='$exam_type', 
                    designation='$designation', total_marks='$total_marks', status='$status', is_exam_completed='$is_exam_completed', 
                    sec_code='$question_code', exam_duration='$exam_duration' WHERE id=$id";

    if ($conn->query($updateQuery) === TRUE) {
        echo "<script>alert('Candidate details updated successfully!'); window.location='show_candidate.php';</script>";
    } else {
        echo "<script>alert('Error updating record: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Candidate</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Nevaeh Technology</a>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Edit Candidate Details</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $candidate['name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="mobile" class="form-label">Mobile</label>
            <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $candidate['mobile']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $candidate['email']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="exam_type" class="form-label">Exam Type</label>
            <input type="text" class="form-control" id="exam_type" name="exam_type" value="<?php echo $candidate['exam_type']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="designation" class="form-label">Designation</label>
            <input type="text" class="form-control" id="designation" name="designation" value="<?php echo $candidate['designation']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="total_marks" class="form-label">Total Marks</label>
            <input type="number" class="form-control" id="total_marks" name="total_marks" value="<?php echo $candidate['total_marks']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <input type="text" class="form-control" id="status" name="status" value="<?php echo $candidate['status']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="is_exam_completed" class="form-label">Is Exam Completed</label>
            <input type="text" class="form-control" id="is_exam_completed" name="is_exam_completed" value="<?php echo $candidate['is_exam_completed']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="question_code" class="form-label">Question Code</label>
            <input type="text" class="form-control" id="question_code" name="question_code" value="<?php echo $candidate['sec_code']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="exam_duration" class="form-label">Exam Duration (in minutes)</label>
            <input type="number" class="form-control" id="exam_duration" name="exam_duration" value="<?php echo $candidate['exam_duration']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
</body>
</html>
