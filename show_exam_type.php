<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Exam Types</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" style="color: orenge;" href="#">Exam Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                        <a class="nav-link" style="color: blue;" href="show_candidate.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: blue;" href="show_question.php">Show Qustions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: blue;" href="add_question.php">Add Questions</a>
                    </li>
                    <!--li class="nav-item">
                        <a class="nav-link" style="color: blue;" href="show_exam_type.php">Show exam type</a>
                    </li-->
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Add Exam Type</h2>
        <form id="addExamTypeForm" action="add_exam_type.php" method="POST">
            <div class="mb-3">
                <label for="examType" class="form-label">Exam Type</label>
                <input type="text" class="form-control" id="examType" name="examType" placeholder="Enter Exam Type" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Exam Type</button>
        </form>
    </div>

    <div class="container mt-5">
        <h2>Exam Types</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Exam Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="examTypesTable">
                <!-- Data will be populated here dynamically using PHP -->
                <?php
                // Include database connection
                include 'conn.php';

                $query = "SELECT * FROM exam_type_menu";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['exam_type']}</td>";
                    echo "<td>" . ($row['status'] == 1 ? 'Active' : 'Inactive') . "</td>";
                    echo "<td>
                        <a href='edit_exam_type.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='delete_exam_type.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                        <a href='exam_type_status.php?id={$row['id']}' class='btn btn-" . ($row['status'] == 1 ? 'secondary' : 'success') . " btn-sm'>" . ($row['status'] == 1 ? 'Deactivate' : 'Activate') . "</a>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>