<?php
include 'conn.php';

// Initialize search variables
$searchQuery = "";
$searchResults = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchQuery = trim($_POST['search']);
    
    if (!empty($searchQuery)) {
        $stmt = $conn->prepare("SELECT * FROM candidates WHERE mobile LIKE ? OR email LIKE ?");
        $searchTerm = "%$searchQuery%";
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $searchResults = $stmt->get_result();
    }
}

// Fetch all candidates if no search is performed
$candidates = $searchResults ?: $conn->query("SELECT * FROM candidates");
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
        <a class="navbar-brand" href="#">Examination Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            
                <li class="nav-item"><a class="nav-link" href="single_question_bank.php">Create Single Question</a></li>
                <li class="nav-item"><a class="nav-link" href="multiple_question_bank.php">Create Multiple Question</a></li>
                <li class="nav-item"><a class="nav-link" href="show_question.php">Show Questions</a></li>
                <li class="nav-item"><a class="nav-link" href="add_question.php">Add Questions</a></li>
                <li class="nav-item"><a class="nav-link" href="single_question_bank.php">Add bulk Questions</a></li>
                <li class="nav-item"><a class="nav-link" href="show_exam_type.php">Show Exam Type</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Candidate Details</h2>
    <a style="color: blue;" class="nav-link" href="candidate_personal_details.php">Click Here For Enter Personal Details </a>
    
    <!-- Search Form -->
    <form method="POST" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Mobile or Email" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Exam Type</th>
                <th>Designation</th>
                <th>Obtained</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $candidates->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['exam_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['designation']); ?></td>
                    <td><?php echo htmlspecialchars($row['total_marks']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
    <a href="show_result_details.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Check Answer</a>
    <a href="edit_candidate.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Edit</a>
    <a href="delete_candidate.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
    <a href="show_question_set.php?candidate_id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Set Code</a>
    <!-- New Edit Personal Details Button -->
    <a href="edit_candidate_details.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Edit Personal Details</a>
</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary">Go Back</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
