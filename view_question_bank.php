<?php
session_start();
include 'conn.php';

$query = "SELECT * FROM question_bank ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Question Bank</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'header2.php';?>
    <div class="container mt-5">
        <h2 class="text-center">Question Bank</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Exam Type</th>
                    <th>Code</th>
                    <th>Question</th>
                    <th>Option 1</th>
                    <th>Option 2</th>
                    <th>Option 3</th>
                    <th>Option 4</th>
                    <th>Correct Option</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['exam_type']); ?></td>
                        <td><?= htmlspecialchars($row['code']); ?></td>
                        <td><?= htmlspecialchars($row['question']); ?></td>
                        <td><?= htmlspecialchars($row['option1']); ?></td>
                        <td><?= htmlspecialchars($row['option2']); ?></td>
                        <td><?= htmlspecialchars($row['option3']); ?></td>
                        <td><?= htmlspecialchars($row['option4']); ?></td>
                        <td><strong><?= $row['correct_option']; ?></strong></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php $conn->close(); ?>
