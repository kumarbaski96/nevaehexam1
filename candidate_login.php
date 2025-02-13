<?php
include 'conn.php';


// Candidate Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM candidates WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $candidate = $result->fetch_assoc();
        if ($candidate['status'] === 'Completed' && $candidate['is_exam_completed'] == 1) {
            echo "<script>
                alert('You have already given the exam.');
                window.location.href = 'index.php';
            </script>";
        } elseif (password_verify($password, $candidate['password'])) {
            session_start();
            $_SESSION['id'] = $candidate['id'];
            $_SESSION['name'] = $candidate['name'];
            $_SESSION['exam_type'] = $candidate['exam_type'];
            //header("Location: quiz.php");
            header("Location: insert_code.php");
        } else {
            echo "<script>alert('Invalid Password');</script>";
        }
    } else {
        echo "<script>alert('Email not registered');</script>";
    }
}

// Fetch available exam types
// $exam_types = $conn->query("SELECT DISTINCT exam_type FROM questions");

// if (!$exam_types) {
//     die("Error fetching data: " . $conn->error);
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Login - Exam Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .login-container h2 {
            color: #6a11cb;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            transition: 0.3s;
        }
        .form-control:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 10px rgba(106, 17, 203, 0.2);
        }
        .btn-custom {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 18px;
            transition: 0.3s;
            width: 100%;
        }
        .btn-custom:hover {
            opacity: 0.9;
        }
        .btn-secondary {
            border-radius: 8px;
            padding: 12px;
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Candidate Login</h2>
        <form method="POST" onsubmit="return validateForm()">
            <div class="mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                <small id="emailError" class="text-danger"></small>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                <small id="passwordError" class="text-danger"></small>
            </div>
            <button type="submit" name="login" class="btn btn-custom">Login</button>
            <a href="index.php" class="btn btn-secondary">Go Back</a>
        </form>
    </div>

    <script>
        const emailField = document.getElementById('email');
        const passwordField = document.getElementById('password');
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');

        emailField.addEventListener('input', () => {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            emailError.textContent = emailPattern.test(emailField.value) ? "" : "Invalid email format.";
        });

        passwordField.addEventListener('input', () => {
            const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
            passwordError.textContent = passwordPattern.test(passwordField.value) ? "" : "Invalid password format.";
        });

        function validateForm() {
            if (!emailField.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                alert("Invalid email format.");
                emailField.focus();
                return false;
            }
            if (!passwordField.value.match(/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/)) {
                alert("Invalid password format.");
                passwordField.focus();
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
