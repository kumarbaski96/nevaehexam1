<?php
include 'conn.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Define the candidate id and exam type
// $candidate_id = $_SESSION['id'];  // Assuming the candidate ID is stored in the session
// $exam_type = $_SESSION['exam_type'];  // Assuming exam type is stored in the session

// Fetch candidate's email and name
$candidateQuery = $conn->query("SELECT email, name FROM candidates WHERE id=$candidate_id");

if ($candidateQuery && $candidateQuery->num_rows > 0) {
    $candidateData = $candidateQuery->fetch_assoc();
    $candidateEmail = $candidateData['email'];
    $candidateName = $candidateData['name'];

    // Email content
    $subject = "Your Exam Results - $exam_type";
    $message = "Dear $candidateName,\n\nYour exam has been successfully completed.\n\nExam: $exam_type\nYour Score: $score\n\nThank you for participating.\n\nBest regards,\nExam Portal Team";

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'baski12.kumar@gmail.com';  // Your Gmail email address
        $mail->Password = 'jxeczvecrtqsoqvs';     // Use your Google app password if you have 2FA enabled
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender and recipient settings
        $mail->setFrom('hr@neavehtech.com', 'Exam Portal');
        $mail->addAddress($candidateEmail, $candidateName);

        // Email content
        $mail->Subject = $subject;
        $mail->Body    = $message;

        // Send email
        if ($mail->send()) {
            echo "<script>alert('Exam Completed. Your Score: $score. A confirmation email has been sent to $candidateEmail'); window.location='index.php';</script>";
        }
    } catch (Exception $e) {
        // Handle email sending errors
        echo "<script>alert('Exam Completed. Your Score: $score. However, the email could not be sent. Error: {$mail->ErrorInfo}'); window.location='index.php';</script>";
    }
} else {
    // Handle cases where the candidate's email cannot be fetched
    echo "<script>alert('Error: Could not fetch candidate email.'); window.location='index.php';</script>";
}
?>
