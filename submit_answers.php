<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $questions = $_POST['questions']; // Question text (not used in DB insert)
    $question_ids = $_POST['question_ids']; // Question IDs
    $answers = $_POST['answers']; // User-selected answers

    $user_id = 1; // Replace with actual user ID from session or login system
    $score = 0;
    $total_questions = count($question_ids);

    foreach ($question_ids as $index => $question_id) {
        $user_answer = $answers[$question_id];

        // Fetch the correct answer from the database
        $stmt = $conn->prepare("SELECT correct_option FROM questions WHERE id = ?");
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        $stmt->bind_result($correct_answer);
        $stmt->fetch();
        $stmt->close();

        // Check if the user's answer is correct
        $is_correct = ($user_answer == $correct_answer) ? 1 : 0;
        if ($is_correct) {
            $score++;
        }

        // Insert user answer into the database
        $insertQuery = "INSERT INTO user_answers (user_id, question_id, user_answer, correct_answer, is_correct)
                        VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("iissi", $user_id, $question_id, $user_answer, $correct_answer, $is_correct);
        $stmt->execute();
        $stmt->close();
    }

    // Store final score
    $insertScoreQuery = "INSERT INTO user_scores (user_id, total_questions, correct_answers, percentage)
                         VALUES (?, ?, ?, ?)";
    $percentage = ($score / $total_questions) * 100;
    $stmt = $conn->prepare($insertScoreQuery);
    $stmt->bind_param("iiid", $user_id, $total_questions, $score, $percentage);
    $stmt->execute();
    $stmt->close();

    $conn->close();

    // Redirect to result page
    header("Location: result.php?score=$score&total=$total_questions");
    exit();
} else {
    echo "Invalid Request!";
}
?>
