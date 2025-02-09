<?php
session_start();
include 'conn.php';

// Ensure the user is logged in
if (!isset($_SESSION['id']) || !isset($_SESSION['name']) || !isset($_SESSION['exam_type'])) {
    echo "<script>alert('Session Expired. Please log in again.'); window.location='index.php';</script>";
    exit;
}

$candidate_id = $_SESSION['id'];
$name = $_SESSION['name'];
$exam_type = $_SESSION['exam_type'];

if (isset($_POST['exam_code']) && !empty($_POST['exam_code'])) {
    $exam_code = $_POST['exam_code'];
    $_SESSION['exam_code'] = $exam_code;
} else {
    if (isset($_SESSION['exam_code'])) {
        $exam_code = $_SESSION['exam_code'];
    } else {
        echo "<script>alert('Invalid Exam Code!'); window.location='index.php';</script>";
        exit;
    }
}

// Pagination setup
$questions_per_page = 3;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$offset = ($page - 1) * $questions_per_page;

// Fetch total questions
$total_questions_query = $conn->prepare("SELECT COUNT(*) as total FROM question_bank WHERE code = ?");
$total_questions_query->bind_param("s", $exam_code);
$total_questions_query->execute();
$total_result = $total_questions_query->get_result()->fetch_assoc();
$total_questions = $total_result['total'];
$total_pages = ceil($total_questions / $questions_per_page);

// Fetch questions for the current page
$exam_query = $conn->prepare("SELECT * FROM question_bank WHERE code = ? LIMIT ? OFFSET ?");
$exam_query->bind_param("sii", $exam_code, $questions_per_page, $offset);
$exam_query->execute();
$questions_result = $exam_query->get_result();

if ($questions_result->num_rows === 0) {
    echo "<script>alert('No questions found!'); window.location='index.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_exam'])) {
    $score = 0;

    foreach ($_POST as $question_id => $user_answer) {
        if ($question_id === 'submit_exam' || $question_id === 'exam_code' || $question_id === 'page') continue;

        $stmt = $conn->prepare("SELECT question, correct_option FROM question_bank WHERE id = ?");
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $question_data = $result->fetch_assoc();

        if ($question_data && isset($question_data['correct_option'])) {
            $correct_option = $question_data['correct_option'];
            $question_text = $question_data['question'];
        } else {
            continue;
        }

        $status = ($user_answer == $correct_option) ? 'Correct' : 'Incorrect';
        if ($status === 'Correct') $score++;

        $insert_stmt = $conn->prepare("INSERT INTO question_results (candidate_id, exam_type, question_id, question, user_answer, correct_option, status) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("isissss", $candidate_id, $exam_type, $question_id, $question_text, $user_answer, $correct_option, $status);
        $insert_stmt->execute();
    }

    $insert_result_stmt = $conn->prepare("INSERT INTO results (candidate_id, exam_type, marks_obtained) VALUES (?, ?, ?)");
    $insert_result_stmt->bind_param("isi", $candidate_id, $exam_type, $score);
    $insert_result_stmt->execute();

    $update_stmt = $conn->prepare("UPDATE candidates SET total_marks = ?, status = 'Completed', is_exam_completed = 1 WHERE id = ?");
    $update_stmt->bind_param("ii", $score, $candidate_id);
    $update_stmt->execute();

    echo "<script>alert('Exam Completed. Your Score: $score'); window.location='index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exam</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Hello, <?php echo htmlspecialchars($name); ?>!</h2>
        <h3>Exam Type: <?php echo htmlspecialchars($exam_type); ?></h3>
        <form method="POST">
            <input type="hidden" name="exam_code" value="<?php echo htmlspecialchars($exam_code); ?>">
            <input type="hidden" name="page" value="<?php echo $page; ?>">

            <?php 
            $question_number = $offset + 1;
            while ($question = $questions_result->fetch_assoc()) { ?>
                <div class="mb-3">
                    <p><strong>Q<?php echo $question_number++; ?>.</strong> <?php echo htmlspecialchars($question['question']); ?></p>
                    <input type="radio" name="<?php echo $question['id']; ?>" value="1" required> <?php echo htmlspecialchars($question['option1']); ?><br>
                    <input type="radio" name="<?php echo $question['id']; ?>" value="2"> <?php echo htmlspecialchars($question['option2']); ?><br>
                    <input type="radio" name="<?php echo $question['id']; ?>" value="3"> <?php echo htmlspecialchars($question['option3']); ?><br>
                    <input type="radio" name="<?php echo $question['id']; ?>" value="4"> <?php echo htmlspecialchars($question['option4']); ?><br>
                </div>
            <?php } ?>

            <div class="d-flex justify-content-between">
                <?php if ($page > 1) { ?>
                    <button type="submit" name="prev" value="<?php echo $page - 1; ?>" class="btn btn-secondary">Previous</button>
                <?php } ?>
                
                <?php if ($page < $total_pages) { ?>
                    <button type="submit" name="next" value="<?php echo $page + 1; ?>" class="btn btn-primary">Next</button>
                <?php } else { ?>
                    <button type="submit" name="submit_exam" class="btn btn-success">Submit</button>
                <?php } ?>
            </div>
        </form>
    </div>
</body>
</html>
