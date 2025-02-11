<?php
session_start();
include 'conn.php'; // Include the database connection file

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Fetch unique exam types
$exam_types_query = "SELECT DISTINCT exam_type FROM exam_type_menu";
$exam_types_result = $conn->query($exam_types_query);

if ($exam_types_result->num_rows === 0) {
    echo "No exam types found.";
    exit;
}

// Get selected values
$selected_exam_type = isset($_POST['exam_type']) ? $_POST['exam_type'] : '';
$selected_question_set = isset($_POST['question_set']) ? $_POST['question_set'] : '';
$candidate_id = isset($_GET['candidate_id']) ? $_GET['candidate_id'] : '';
$exam_duration = isset($_POST['exam_duration']) ? $_POST['exam_duration'] : ''; // New field for exam duration

// Fetch unique question sets based on selected exam type
$question_sets_query = "SELECT DISTINCT code FROM question_bank WHERE exam_type = ?";
$question_sets_stmt = $conn->prepare($question_sets_query);
$question_sets_stmt->bind_param("s", $selected_exam_type);
$question_sets_stmt->execute();
$question_sets_result = $question_sets_stmt->get_result();

// Fetch candidate details
$candidate_email = '';
if ($candidate_id) {
    $email_query = "SELECT email, name, exam_duration FROM candidates WHERE id = ?";
    $email_stmt = $conn->prepare($email_query);
    $email_stmt->bind_param("i", $candidate_id);
    $email_stmt->execute();
    $email_result = $email_stmt->get_result();
    if ($email_row = $email_result->fetch_assoc()) {
        $candidate_email = $email_row['email'];
        $candidate_name = $email_row['name'];
        $exam_duration = $exam_duration ?: $email_row['exam_duration']; // Use existing if no new value is provided
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_exam'])) {
    if ($candidate_id && $selected_question_set && $exam_duration) {
        // Update sec_code and exam_duration in candidates table
        $update_stmt = $conn->prepare("UPDATE candidates SET sec_code = ?, exam_duration = ? WHERE id = ?");
        $update_stmt->bind_param("ssi", $selected_question_set, $exam_duration, $candidate_id);
        
        if ($update_stmt->execute()) {
            // Send email notification
            if (!empty($candidate_email)) {
                $mail = new PHPMailer(true);
                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'baski12.kumar@gmail.com'; // Your SMTP username
                    $mail->Password = 'byqptwrieivhrmbx'; // Your App Password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port = 465;

                    // Recipients
                    $mail->setFrom('baski12.kumar@gmail.com', 'Exam Portal');
                    $mail->addAddress($candidate_email, 'Candidate');

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Exam Set Assigned';
                    $mail->Body = "<p>Dear  $candidate_name,</p>
                        <p>You have been assigned the following exam:</p>
                        <p><b>Exam Type:</b> $selected_exam_type</p>
                        <p><b>Your Examination code: </b> $selected_question_set</p>
                        
                        <p>Best of luck!</p>";

                    $mail->send();
                    echo "<script>alert('Exam set updated successfully and email sent!'); window.location='show_candidate.php';</script>";
                } catch (Exception $e) {
                    echo "<script>alert('Exam updated but email could not be sent: {$mail->ErrorInfo}');</script>";
                }
            } else {
                echo "<script>alert('Exam set updated successfully!'); window.location='show_candidate.php';</script>";
            }
        } else {
            echo "<script>alert('Failed to update exam set.');</script>";
        }
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body { background-color: #f4f4f9; font-family: Arial, sans-serif; }
        .container { margin-top: 50px; }
        .table th, .table td { text-align: center; }
        .btn { margin-top: 20px; }
    </style>
</head>
<body>
<?php include 'header2.php';?>
<div class="container">
    <h2 class="text-center">Select Exam and Question Set</h2>

    <!-- Exam Duration Input -->
    <form method="POST">
        <div class="mb-3">
            <label for="exam_duration" class="form-label">Exam Duration (minutes)</label>
            <input type="number" name="exam_duration" id="exam_duration" class="form-control" value="<?php echo htmlspecialchars($exam_duration); ?>" required>
        </div>

        <!-- Exam Type Dropdown -->
        <div class="mb-3">
            <label for="exam_type" class="form-label">Select Exam Type</label>
            <select name="exam_type" id="exam_type" class="form-select" onchange="this.form.submit()" required>
                <option value="">Select Exam Type</option>
                <?php while ($row = $exam_types_result->fetch_assoc()) { ?>
                    <option value="<?php echo htmlspecialchars($row['exam_type']); ?>" <?php echo ($selected_exam_type == $row['exam_type']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['exam_type']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </form>

    <?php if ($selected_exam_type) { ?>
        <!-- Question Set Dropdown -->
        <form method="POST">
            <input type="hidden" name="exam_type" value="<?php echo htmlspecialchars($selected_exam_type); ?>">
            <input type="hidden" name="exam_duration" value="<?php echo htmlspecialchars($exam_duration); ?>">
            <div class="mb-3">
                <label for="question_set" class="form-label">Select Question Set</label>
                <select name="question_set" id="question_set" class="form-select" required>
                    <option value="">Select Question Set</option>
                    <?php while ($row = $question_sets_result->fetch_assoc()) { ?>
                        <option value="<?php echo htmlspecialchars($row['code']); ?>">
                            <?php echo htmlspecialchars($row['code']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" name="submit_exam" class="btn btn-primary">Save</button>
            <button type="submit" name="submit_exam" value="1" name="send_email" class="btn btn-success">Save & Send Email</button>
        </form>
    <?php } ?>
</div>
</body>
</html>
