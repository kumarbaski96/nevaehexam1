<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}
include 'conn.php';
//$conn = new mysqli("localhost", "root", "", "nevaeh_exam");
$candidate_id = $_SESSION['id'];
$exam_type = $_SESSION['exam_type'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    foreach ($_POST as $question_id => $answer) {
        $sql = "SELECT correct_option FROM questions WHERE id=$question_id";
        $result = $conn->query($sql);
        if ($result->fetch_assoc()['correct_option'] == $answer) $score++;
    }

    $conn->query("INSERT INTO results (candidate_id, exam_type, marks_obtained) VALUES ($candidate_id, '$exam_type', $score)");
    $conn->query("UPDATE candidates SET total_marks=$score, status='Completed' WHERE id=$candidate_id");

    echo "<script>alert('Exam Completed. Your Score: $score'); window.location='index.php';</script>";
    exit;
}

$questions = $conn->query("SELECT * FROM questions WHERE exam_type='$exam_type'");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exam</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
<?php include 'header2.php';?>
<div class="container mt-5">
    <h2 class="text-center">Exam: <?php echo $exam_type; ?></h2>
    <form method="POST">
        <?php while ($row = $questions->fetch_assoc()) { ?>
            <div class="mb-3">
                <p><?php echo $row['question']; ?></p>
                <input type="radio" name="<?php echo $row['id']; ?>" value="1"> <?php echo $row['option1']; ?><br>
                <input type="radio" name="<?php echo $row['id']; ?>" value="2"> <?php echo $row['option2']; ?><br>
                <input type="radio" name="<?php echo $row['id']; ?>" value="3"> <?php echo $row['option3']; ?><br>
                <input type="radio" name="<?php echo $row['id']; ?>" value="4"> <?php echo $row['option4']; ?><br>
            </div>
        <?php } ?>
        <button class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>