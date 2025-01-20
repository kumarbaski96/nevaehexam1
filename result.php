<?php
$score = isset($_GET['score']) ? (int)$_GET['score'] : 0;
$total = isset($_GET['total']) ? (int)$_GET['total'] : 0;
$percentage = ($total > 0) ? ($score / $total) * 100 : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Quiz Results</h2>
        <div class="alert alert-info text-center">
            <h4>You scored <?= $score ?> out of <?= $total ?> questions.</h4>
            <h5>Percentage: <?= round($percentage, 2) ?>%</h5>
        </div>
        <a href="index.php" class="btn btn-primary">Take Another Quiz</a>
    </div>
</body>
</html>
