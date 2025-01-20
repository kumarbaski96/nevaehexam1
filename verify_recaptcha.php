<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recaptchaResponse = $_POST['g-recaptcha-response']; // The reCAPTCHA response token
    $secretKey = 'YOUR_SECRET_KEY'; // Replace with your secret key
    
    // Make a request to Google's reCAPTCHA API
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaResponse");
    $responseData = json_decode($response);
    
    if ($responseData->success) {
        echo "reCAPTCHA validation successful. Form submitted!";
        // Proceed with form processing (e.g., authentication)
    } else {
        echo "reCAPTCHA validation failed. Please try again.";
    }
}
?>
