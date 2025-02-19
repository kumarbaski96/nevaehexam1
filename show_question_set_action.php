<?php
include 'conn.php'; // Include database connection

// Handle delete request for multiple records
if (isset($_POST['delete_selected'])) {
    if (!empty($_POST['selected_codes'])) {
        $codes = $_POST['selected_codes'];
        $placeholders = implode(',', array_fill(0, count($codes), '?'));
        $query = "DELETE FROM question_bank WHERE code IN ($placeholders)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(str_repeat("s", count($codes)), ...$codes);
        if ($stmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page
            exit();
        }
        $stmt->close();
    }
}

// Handle single delete request
if (isset($_POST['single_delete_code'])) {
    $code = $_POST['single_delete_code'];
    $query = "DELETE FROM question_bank WHERE code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $code);
    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page
        exit();
    }
    $stmt->close();
}

// Fetch distinct question bank data based on unique code
$query = "SELECT MIN(id) as id, exam_type, code FROM question_bank GROUP BY code ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Bank Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function deleteSingle(code) {
            if (confirm("Are you sure you want to delete this record?")) {
                document.getElementById("single_delete_code").value = code;
                document.getElementById("delete_form").submit();
            }
        }

        function showQuestions(code) {
            $.ajax({
                url: "fetch_questions_set.php", 
                type: "POST",
                data: { code: code },
                success: function(response) {
                    $("#questionModalBody").html(response);
                    $("#questionModal").modal("show");
                }
            });
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Question Bank Management</h2>

    <!-- Go Back Button -->
    <a href="show_candidate.php" class="btn btn-secondary mb-3">Go Back</a>

    <form method="POST" id="delete_form">
        <input type="hidden" name="single_delete_code" id="single_delete_code">
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>Select</th>
                    <th>ID</th>
                    <th>Exam Type</th>
                    <th>Unique Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><input type="checkbox" name="selected_codes[]" value="<?php echo $row['code']; ?>"></td>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['exam_type']; ?></td>
                    <td><?php echo $row['code']; ?></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteSingle('<?php echo $row['code']; ?>')">Delete</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="showQuestions('<?php echo $row['code']; ?>')">Show Questions</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <button type="submit" name="delete_selected" class="btn btn-danger">Delete Selected</button>
    </form>
</div>

<!-- Modal for displaying questions -->
<div class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="questionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="questionModalLabel">Questions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="questionModalBody">
                <!-- Questions will be loaded here -->
            </div>
        </div>
    </div>
</div>
</body>
</html>
