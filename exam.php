<?php
include 'conn.php';
// Database Configuration
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "nevaeh_exam";

// $conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// Candidate Registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $exam_type = $_POST['exam_type'];
    $designation = $_POST['designation'];

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO candidates (name, mobile, email, password, exam_type, designation) VALUES ('$name', '$mobile', '$email', '$hashed_password', '$exam_type', '$designation')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration Successful');</script>";
            
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Candidate Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM candidates WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $candidate = $result->fetch_assoc();
        if (password_verify($password, $candidate['password'])) {
            session_start();
            $_SESSION['candidate_id'] = $candidate['id'];
            $_SESSION['name'] = $candidate['name'];
            $_SESSION['exam_type'] = $candidate['exam_type'];
            header("Location: quiz.php");
            //echo "<script>alert('Login Successful'); window.location.href='exam.php';</script>";
        } else {
            echo "<script>alert('Invalid Password');</script>";
        }
    } else {
        echo "<script>alert('Email not registered');</script>";
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
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Exam Portal</h1>

        <!-- Registration Form -->
        <div class="card mb-4">
            <div class="card-header">Candidate Registration</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="exam_type" class="form-label">Exam Type</label>
                        <select class="form-select" id="exam_type" name="exam_type" required>
                            <option value="C">C</option>
                            <option value="C++">C++</option>
                            <option value="Java">Java</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="designation" class="form-label">Designation</label>
                        <input type="text" class="form-control" id="designation" name="designation" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>

        <!-- Login Form -->
        <div class="card">
            <div class="card-header">Candidate Login</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-success">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<!-- Create a new file named `exam.php` for the exam page where questions will be displayed and answers submitted. -->
