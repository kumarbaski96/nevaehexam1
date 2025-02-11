
<?php
include 'conn.php';
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

echo "PHPMailer loaded successfully!";
// Ensure database connection exists
if (!isset($conn)) {
    die("Database connection not found.");
}

// Fetch candidate's email
$candidateQuery = $conn->prepare("SELECT email FROM candidates WHERE id = ?");
$candidateQuery->bind_param("i", $candidate_id);
$candidateQuery->execute();
$result = $candidateQuery->get_result();

if ($result->num_rows > 0) {
    $candidateData = $result->fetch_assoc();
    $candidateEmail = $candidateData['email'];

    // Email subject and HTML body
    $subject = "Your Exam Results - $exam_type";
    $message = "
        <html>
        <head>
            <title>Your Exam Results</title>
        </head>
        <body>
            <p>Dear <strong>$name</strong>,</p>
            <p>Your exam has been successfully completed.</p>
            <p><strong>Exam Type:</strong> $exam_type</p>
            <p><strong>Marks Obtained:</strong> $score / $total_questions</p>
            <p>Thank you for participating.</p>
            <p>Best regards,<br>Exam Portal Team</p>
        </body>
        </html>
    ";

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP Server Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'baski12.kumar@gmailcom';   // Your SMTP username
        $mail->Password = 'jtmhhlzbvoldmpin';     // Your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Sender & Recipient
        $mail->setFrom('no-reply@gmail.com', 'Exam Portal');
        $mail->addAddress($candidateEmail, $name);
        $mail->isHTML(true);

        // Email Content
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = strip_tags($message); // Plain text alternative

        // Send Email
        if ($mail->send()) {
            error_log("Email sent successfully to $candidateEmail");
        } else {
            error_log("Email failed to send: " . $mail->ErrorInfo);
        }
    } catch (Exception $e) {
        error_log("Email could not be sent. Error: " . $mail->ErrorInfo);
    }
} else {
    error_log("Error: Candidate email not found.");
}
?>

      
       