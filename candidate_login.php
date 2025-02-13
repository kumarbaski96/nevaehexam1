<?php
include 'conn.php';
session_start();

// Candidate Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM candidates WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $candidate = $result->fetch_assoc();
        if ($candidate['status'] === 'Completed' && $candidate['is_exam_completed'] == 1) {
            echo "<script>alert('You have already given the exam.'); window.location.href = 'index.php';</script>";
        } elseif (password_verify($password, $candidate['password'])) {
            $_SESSION['id'] = $candidate['id'];
            $_SESSION['name'] = $candidate['name'];
            $_SESSION['exam_type'] = $candidate['exam_type'];
            header("Location: insert_code.php");
            exit();
        } else {
            echo "<script>alert('Invalid Password');</script>";
        }
    } else {
        echo "<script>alert('Email not registered');</script>";
    }
}

// Password Reset Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $email = $_POST['reset_email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        $sql = "SELECT * FROM candidates WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $update_sql = "UPDATE candidates SET password = ? WHERE email = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("ss", $hashed_password, $email);
            $stmt->execute();

            echo "<script>alert('Password updated successfully! Please log in with your new password.'); window.location.href='candidate_login.php';</script>";
        } else {
            echo "<script>alert('Email not found!');</script>";
        }
    }
}
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
        }
        .btn-custom {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 18px;
            width: 100%;
        }
        .btn-custom:hover {
            opacity: 0.9;
        }
        .forgot-password {
            margin-top: 10px;
            color: #6a11cb;
            cursor: pointer;
        }
        .modal-content {
            border-radius: 12px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Candidate Login</h2>
        <form method="POST">
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" name="login" class="btn btn-custom">Login</button>
            <p class="forgot-password" data-bs-toggle="modal" data-bs-target="#resetModal">Forgot Password?</p>
        </form>
    </div>

    <!-- Password Reset Modal -->
    <div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-4">
                <h3 class="text-center">Reset Password</h3>
                <form method="POST" onsubmit="return validateResetPassword()">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="reset_email" id="reset_email" class="form-control" required>
                        <small id="emailError" class="text-danger"></small>
                    </div>
                    <div class="mb-3">
                        <label>New Password</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Confirm New Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        <small id="passwordError" class="text-danger"></small>
                    </div>
                    <button type="submit" name="reset_password" class="btn btn-primary w-100">Reset Password</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function validateResetPassword() {
            let email = document.getElementById("reset_email").value;
            let newPassword = document.getElementById("new_password").value;
            let confirmPassword = document.getElementById("confirm_password").value;
            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
            let emailError = document.getElementById("emailError");
            let passwordError = document.getElementById("passwordError");

            if (!email.match(emailPattern)) {
                emailError.textContent = "Invalid email format.";
                return false;
            } else {
                emailError.textContent = "";
            }

            if (!newPassword.match(passwordPattern)) {
                passwordError.textContent = "Password must be 8+ chars, 1 uppercase, 1 number, 1 special char.";
                return false;
            } else if (newPassword !== confirmPassword) {
                passwordError.textContent = "Passwords do not match!";
                return false;
            } else {
                passwordError.textContent = "";
            }

            return true;
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
