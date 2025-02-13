<?php

session_start();

// Prevent access if admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Prevent browser caching of this page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include 'conn.php';


// Initialize search variables
$searchQuery = "";
$searchResults = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchQuery = trim($_POST['search']);
    
    if (!empty($searchQuery)) {
        // If the search query is numeric, check against 'id' as well
        $stmt = $conn->prepare("SELECT * FROM candidates WHERE id = ? OR name LIKE ? OR mobile LIKE ? OR email LIKE ?");
        
        if (is_numeric($searchQuery)) {
            $idSearch = (int)$searchQuery; // Ensure it's treated as an integer
        } else {
            $idSearch = 0; // Dummy ID to avoid SQL errors
        }
        
        $searchTerm = "%$searchQuery%";
        $stmt->bind_param("isss", $idSearch, $searchTerm, $searchTerm, $searchTerm);
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

<?php include 'header2.php';?>

<div class="container mt-5">
    <h2 class="text-center">Candidate Details</h2>
    <a style="color: blue;" class="nav-link" href="candidate_personal_details.php">Click Here For Enter Personal Details </a>
    
    <!-- Search Form -->
    <form method="POST" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Id or nameMobile or Email" value="<?php echo htmlspecialchars($searchQuery); ?>">
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
<script>
    if (performance.navigation.type === 2) { 
        location.reload(true); 
    }
</script>
</body>
</html>
