<?php
session_start();
include 'conn.php';

// Prevent access if admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Prevent browser caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Initialize search variables
$searchQuery = "";
$searchResults = null;

// Handle real-time search request (AJAX)
if (isset($_POST['query'])) {
    $searchQuery = trim($_POST['query']);
    
    if (!empty($searchQuery)) {
        $stmt = $conn->prepare("SELECT * FROM candidates WHERE id = ? OR name LIKE ? OR mobile LIKE ? OR email LIKE ?");
        
        if (is_numeric($searchQuery)) {
            $idSearch = (int)$searchQuery; // Treat as integer for ID search
        } else {
            $idSearch = 0;
        }
        
        $searchTerm = "%$searchQuery%";
        $stmt->bind_param("isss", $idSearch, $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        $searchResults = $stmt->get_result();
    }

    // Return search results in AJAX response
    if ($searchResults->num_rows > 0) {
        while ($row = $searchResults->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>".htmlspecialchars($row['name'])."</td>
                <td>".htmlspecialchars($row['mobile'])."</td>
                <td>".htmlspecialchars($row['email'])."</td>
                <td>".htmlspecialchars($row['exam_type'])."</td>
                <td>".htmlspecialchars($row['designation'])."</td>
                <td>".htmlspecialchars($row['total_marks'])."</td>
                <td>".htmlspecialchars($row['status'])."</td>
                <td>
                    <a href='show_result_details.php?id={$row['id']}' class='btn btn-warning btn-sm'>Check Answer</a>
                    <a href='edit_candidate.php?id={$row['id']}' class='btn btn-info btn-sm'>Edit</a>
                    <a href='delete_candidate.php?delete={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                    <a href='show_question_set.php?candidate_id={$row['id']}' class='btn btn-primary btn-sm'>Set Code</a>
                    <a href='edit_candidate_details.php?id={$row['id']}' class='btn btn-success btn-sm'>Edit Personal Details</a>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='9' class='text-center'>No results found</td></tr>";
    }
    exit(); // Stop further execution after sending AJAX response
}

// Fetch all candidates if no search is performed
$candidates = $conn->query("SELECT * FROM candidates");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>

<?php include 'header2.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Candidate Details</h2>
    <a style="color: blue;" class="nav-link" href="candidate_personal_details.php">Click Here For Enter Personal Details</a>
    
    <!-- Search Form -->
    <form method="POST" class="mb-3">
        <div class="input-group">
            <input type="text" id="search" name="search" class="form-control" placeholder="Search by Id, Name, Mobile, or Email">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- Candidate Table -->
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
        <tbody id="candidateTable">
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
document.getElementById("search").addEventListener("keyup", function() {
    let searchValue = this.value.trim();

    if (searchValue.length > 0) {
        fetch("show_candidate.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "query=" + encodeURIComponent(searchValue)
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById("candidateTable").innerHTML = data;
        })
        .catch(error => console.error("Error:", error));
    } else {
        location.reload(); // Reloads the page when search is cleared
    }
});
</script>
</body>
</html>
