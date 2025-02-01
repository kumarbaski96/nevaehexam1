<?php
include 'conn.php';

// Check connection

// Handle the dropdown selection
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
$exam_types = $conn->query("SELECT * FROM exam_type_menu WHERE status=1");
if (!$exam_types) {
    die("Error in fetching exam types: " . $conn->error);
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $conn->real_escape_string($_GET['delete_id']);
    $conn->query("DELETE FROM questions WHERE id='$delete_id'");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle toggle status request
if (isset($_GET['toggle_id'])) {
    $toggle_id = $conn->real_escape_string($_GET['toggle_id']);
    $current_status = $conn->query("SELECT status FROM questions WHERE id='$toggle_id'")->fetch_assoc()['status'];
    $new_status = $current_status == 1 ? 0 : 1;
    $conn->query("UPDATE questions SET status='$new_status' WHERE id='$toggle_id'");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Questions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" style="color: orange;" href="#">Exam Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                    <a class="nav-link" style="color: blue;" href="show_candidate.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: blue;" href="add_question.php">Add Questions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: blue;" href="show_exam_type.php">Show exam type</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Filter Questions by Exam Type</h2>

    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-8">
                <select name="exam_type" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Select Exam Type --</option>
                    <?php while ($row = $exam_types->fetch_assoc()) { ?>
                        <option value="<?php echo htmlspecialchars($row['exam_type']); ?>" 
                            <?php if ($selected_exam_type === $row['exam_type']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($row['exam_type']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Option 1</th>
                <th>Option 2</th>
                <th>Option 3</th>
                <th>Option 4</th>
                <th>Correct Option</th>
                <th>Category</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($questions->num_rows > 0) {
                while ($row = $questions->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['question']); ?></td>
                        <td><?php echo htmlspecialchars($row['option1']); ?></td>
                        <td><?php echo htmlspecialchars($row['option2']); ?></td>
                        <td><?php echo htmlspecialchars($row['option3']); ?></td>
                        <td><?php echo htmlspecialchars($row['option4']); ?></td>
                        <td><?php echo htmlspecialchars($row['correct_option']); ?></td>
                        <td><?php echo htmlspecialchars($row['exam_type']); ?></td>
                        <td><?php echo $row['status'] == 1 ? 'Active' : 'Inactive'; ?></td>
                        <td>
                            <a href="edit_question.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            <a href="?toggle_id=<?php echo $row['id']; ?>" class="btn btn-secondary btn-sm">
                                <?php echo $row['status'] == 1 ? 'Deactivate' : 'Activate'; ?>
                            </a>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="10" class="text-center">No questions found for the selected exam type</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
