<?php
session_start();
include 'conn.php'; // Ensure your DB connection file is included

// Ensure the user is logged in
if (!isset($_SESSION['id']) || !isset($_SESSION['name']) || !isset($_SESSION['exam_type'])) {
    echo "<script>alert('Session Expired. Please log in again.'); window.location='index.php';</script>";
    exit;
}

// Assign session variables
$candidate_id = $_SESSION['id'];
$name = $_SESSION['name'];
$exam_type = $_SESSION['exam_type'];

// Get the exam code from the POST request or session
if (isset($_POST['exam_code']) && !empty($_POST['exam_code'])) {
    $exam_code = $_POST['exam_code'];
} else {
    if (isset($_SESSION['exam_code'])) {
        $exam_code = $_SESSION['exam_code'];
    } else {
        echo "<script>alert('Invalid Exam Code!'); window.location='index.php';</script>";
        exit;
    }
}

// Fetch the remaining time in seconds from the database
$exam_duration_query = $conn->prepare("SELECT exam_duration FROM candidates WHERE sec_code = ?");
$exam_duration_query->bind_param("s", $exam_code);
$exam_duration_query->execute();
$exam_duration_result = $exam_duration_query->get_result();
$exam_duration = 0;

if ($exam_duration_result->num_rows > 0) {
    $exam_data = $exam_duration_result->fetch_assoc();
    $exam_duration = $exam_data['exam_duration']; // Duration in seconds
} else {
    echo "<script>alert('Exam not found!'); window.location='index.php';</script>";
    exit;
}

// Fetch questions for this exam code
$exam_query = $conn->prepare("SELECT * FROM question_bank WHERE code = ?");
$exam_query->bind_param("s", $exam_code);
$exam_query->execute();
$questions_result = $exam_query->get_result();

if ($questions_result->num_rows === 0) {
    echo "<script>alert('No questions found for this exam code!'); window.location='index.php';</script>";
    exit;
}

// Handle logout request
if (isset($_GET['logout'])) {
    // Update the candidate's status to "Completed" and set is_exam_completed = 1
    $conn->query("UPDATE candidates SET status='Completed', is_exam_completed=1 WHERE id=$candidate_id");

    // Destroy the session
    session_destroy();

    // Redirect to index.php
    header("Location: index.php");
    exit;
}

// Handle the form submission when the exam is completed
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_exam'])) {
    $score = 0;

    // Loop through the posted answers
    foreach ($_POST as $question_id => $user_answer) {
        // Skip the submit button and exam_code
        if ($question_id === 'submit_exam' || $question_id === 'exam_code') continue;

        // Fetch the question details and correct answer
        $stmt = $conn->prepare("SELECT question, correct_option FROM question_bank WHERE id = ?");
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $question_data = $result->fetch_assoc();

        // Ensure correct_option is available
        if ($question_data && isset($question_data['correct_option'])) {
            $correct_option = $question_data['correct_option'];
            $question_text = $conn->real_escape_string($question_data['question']);
        } else {
            // Log an error if correct_option is missing or invalid
            error_log("No valid correct_option found for question ID: $question_id");
            continue; // Skip this question and don't insert the result
        }

        // Check if the user’s answer is correct
        $status = ($user_answer == $correct_option) ? 'Correct' : 'Incorrect';

        // Increase score if answer is correct
        if ($status === 'Correct') $score++;

        // Insert the detailed result for this question
        $insert_stmt = $conn->prepare("INSERT INTO question_results (candidate_id, exam_type, question_id, question, user_answer, correct_option, status) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("isissss", $candidate_id, $exam_type, $question_id, $question_text, $user_answer, $correct_option, $status);

        if ($insert_stmt->execute()) {
            // Log the successful insertion
            error_log("Inserted result for question ID: $question_id");
        } else {
            // Log the error if insert failed
            error_log("Failed to insert result for question ID: $question_id, Error: " . $insert_stmt->error);
        }
    }

$total_questions = $questions_result->num_rows;
// Update the candidate's total_questions count
$update_questions_stmt = $conn->prepare("UPDATE candidates SET total_questions = ? WHERE id = ?");
$update_questions_stmt->bind_param("ii", $total_questions, $candidate_id);
$update_questions_stmt->execute();

    // Insert the overall result
    $insert_result_stmt = $conn->prepare("INSERT INTO results (candidate_id, exam_type, marks_obtained) VALUES (?, ?, ?)");
    $insert_result_stmt->bind_param("isi", $candidate_id, $exam_type, $score);
    $insert_result_stmt->execute();

    // Update candidate status and total marks
    $update_stmt = $conn->prepare("UPDATE candidates SET total_marks = ?, status = 'Completed', is_exam_completed = 1 WHERE id = ?");
    $update_stmt->bind_param("ii", $score, $candidate_id);
    $update_stmt->execute();

    // Notify the user and redirect
    echo "<script>alert('Exam Completed. Your Score: $score'); window.location='index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examination</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        #timer {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    
    <div class="container mt-5">
        <!-- Timer Display -->
        <div id="timer" class="alert alert-primary">
            Time Remaining: <?php echo gmdate("H:i:s", $exam_duration); ?>
        </div>
        <h2 class="text-center">Hello, <?php echo htmlspecialchars($name); ?>!</h2>
        <h3 class="text-center">Exam Type: <?php echo htmlspecialchars($exam_type); ?></h3>

        <form method="POST">
            <input type="hidden" name="exam_code" value="<?php echo htmlspecialchars($exam_code); ?>">

            <h4>Answer the following questions:</h4>

            <?php 
            $question_number = 1; // Initialize question number
            while ($question = $questions_result->fetch_assoc()) { ?>
                <div class="mb-3">
                    <p><strong>Q<?php echo $question_number++; ?>.</strong><?php echo htmlspecialchars($question['question']); ?></p>
                    <input type="radio" name="<?php echo $question['id']; ?>" value="1" required> a)<?php echo htmlspecialchars($question['option1']); ?><br>
                    <input type="radio" name="<?php echo $question['id']; ?>" value="2"> b)<?php echo htmlspecialchars($question['option2']); ?><br>
                    <input type="radio" name="<?php echo $question['id']; ?>" value="3"> c)<?php echo htmlspecialchars($question['option3']); ?><br>
                    <input type="radio" name="<?php echo $question['id']; ?>" value="4"> d)<?php echo htmlspecialchars($question['option4']); ?><br>
                </div>
            <?php } ?>

            <button type="submit" name="submit_exam" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        let timeRemaining = <?php echo $exam_duration; ?>; // Timer starting from the exam duration in seconds

        function formatTime(seconds) {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;
            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }

        function updateTimer() {
            const timerElement = document.getElementById('timer');
            timerElement.textContent = `Time Remaining: ${formatTime(timeRemaining)}`;
            if (timeRemaining > 0) {
                timeRemaining--;
                // Update every 60 seconds on the server
                if (timeRemaining % 60 === 0) {
                    fetch('update_time.php?exam_code=<?php echo $exam_code; ?>&time_remaining=' + timeRemaining);
                }
            } else {
                clearInterval(timerInterval);
                alert('Time is up! Your answers will be submitted automatically.');
                document.querySelector('form').submit();
            }
        }

        const timerInterval = setInterval(updateTimer, 1000);
    </script>
</body>
</html>
