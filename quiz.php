<?php
include 'conn.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

$candidate_id = $_SESSION['id'];
$exam_type = $_SESSION['exam_type'];
$name = $_SESSION['name'];

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;

    foreach ($_POST as $question_id => $user_answer) {
        // Fetch the question details and correct answer
        $sql = "SELECT question, correct_option FROM questions WHERE id=$question_id";
        $result = $conn->query($sql);
        $question_data = $result->fetch_assoc();

        $question_text = $conn->real_escape_string($question_data['question']);
        $correct_option = $question_data['correct_option'];
        $status = ($user_answer == $correct_option) ? 'Correct' : 'Incorrect';

        if ($status === 'Correct') $score++;

        // Insert the detailed result for this question
        $conn->query("INSERT INTO question_results (candidate_id, exam_type, question_id, question, user_answer, correct_option, status)
                      VALUES ($candidate_id, '$exam_type', $question_id, '$question_text', $user_answer, $correct_option, '$status')");
    }

    // Insert the overall result
    $conn->query("INSERT INTO results (candidate_id, exam_type, marks_obtained) VALUES ($candidate_id, '$exam_type', $score)");
    $conn->query("UPDATE candidates SET total_marks=$score, status='Completed', is_exam_completed=1 WHERE id=$candidate_id");

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
    <style>
        #timer {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
        .logout-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
    <script>
        // Prevent back navigation after logout
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
</head>
<body>
    <!-- Header with Logout Button -->
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Exam Portal</span>
            <a href="?logout=true" class="btn btn-danger logout-btn">Logout</a>
        </div>
    </nav>

    <div class="container mt-5">
        <!-- Timer Display -->
        <div id="timer" class="alert alert-primary">
            Time Remaining: 01:00:00
        </div>

        <!-- Candidate Details -->
        <h2 class="text-center">Hello: <?php echo $name; ?></h2>
        <h2 class="text-center">Exam: <?php echo $exam_type; ?></h2>

        <!-- Exam Form -->
        <form method="POST">
            <?php while ($row = $questions->fetch_assoc()) { ?>
                <div class="mb-3">
                    <p><?php echo $row['question']; ?></p>
                    <input type="radio" name="<?php echo $row['id']; ?>" value="1"> <?php echo htmlspecialchars($row['option1']); ?><br>
                    <input type="radio" name="<?php echo $row['id']; ?>" value="2"> <?php echo htmlspecialchars($row['option2']); ?><br>
                    <input type="radio" name="<?php echo $row['id']; ?>" value="3"> <?php echo htmlspecialchars($row['option3']); ?><br>
                    <input type="radio" name="<?php echo $row['id']; ?>" value="4"> <?php echo htmlspecialchars($row['option4']); ?><br>
                </div>
            <?php } ?>
            <button class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        // Set the initial time (1 hour in seconds)
        let timeRemaining = 60 * 60;

        // Function to format time as HH:MM:SS
        function formatTime(seconds) {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;
            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }

        // Function to update the timer
        function updateTimer() {
            const timerElement = document.getElementById('timer');
            timerElement.textContent = `Time Remaining: ${formatTime(timeRemaining)}`;
            if (timeRemaining > 0) {
                timeRemaining--; // Decrease time by 1 second
            } else {
                // Timer reaches 0, submit the form automatically
                clearInterval(timerInterval);
                alert('Time is up! Your answers will be submitted automatically.');
                document.querySelector('form').submit();
            }
        }

        // Start the timer and update every second
        const timerInterval = setInterval(updateTimer, 1000);
    </script>
</body>
</html>
