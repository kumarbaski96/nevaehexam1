<?php
include 'conn.php';

// Handle Delete


// Fetch Candidates
$candidates = $conn->query("SELECT * FROM candidates");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Candidate Details</title>
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
                        <a class="nav-link" style="color: blue;" href="show_question.php">Show Qustions</a>
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
<div class="container mt-8">
    <h2 class="text-center">Candidate Details</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Exam type</th>
                <th>Designation</th>
                <th>Obtained</th>
                <th>Status</th>
                <th>Complete Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $candidates->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['mobile']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['exam_type']; ?></td>
                    <td><?php echo $row['designation']; ?></td>
                    <td><?php echo $row['total_marks']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['is_exam_completed']; ?></td>
                    <td>
                        <!-- See Candidate Answers Button -->
                        <a href="show_result_details.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Check Answer</a>

                        <!-- Edit Button -->
                        <a href="edit_candidate.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Edit</a>

                        <!-- Delete Button -->
                        <a href="delete_candidate.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" 
                           onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="javascript:void(0);" class="btn btn-secondary" onclick="window.location.href='index.php';">Go Back</a>
</div>
</body>
</html>
