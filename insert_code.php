<?php 
session_start();

// Ensure $candidate is properly defined (fetch from DB if necessary)
if (!isset($_SESSION['id']) || !isset($_SESSION['name']) || !isset($_SESSION['exam_type'])) {
    echo "<script>alert('Session Expired. Please log in again.'); window.location='index.php';</script>";
    exit;
}

// Assign session values properly
$_SESSION['id'] = $_SESSION['id'];  
$_SESSION['name'] = $_SESSION['name'];
$_SESSION['exam_type'] = $_SESSION['exam_type'];

// Check if exam code is set before using it
$exam_code = isset($_POST['exam_code']) ? $_POST['exam_code'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examination Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
            font-family: Arial, sans-serif;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }
        label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: #667eea;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #564b93;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Start Examination</h2>
        <form action="quiz.php" method="POST">
            <label for="examCode">Please enter your Exam code</label>
            <input type="text" id="examCode" name="exam_code" placeholder="Enter Your Exam Code" required>
            <button type="submit">Start Examination</button>
        </form>
    </div>
</body>
</html>
