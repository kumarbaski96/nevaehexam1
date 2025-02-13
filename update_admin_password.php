<?php
include 'conn.php';
session_start();

if (isset($_POST['update_password'])) {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo "<script>alert('New password and confirm password do not match!');</script>";
    } else {
        // Check if email exists
        $query = "SELECT * FROM admins WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            
            // Update password
            $update_query = "UPDATE admins SET password = ? WHERE email = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ss", $hashed_password, $email);
            $stmt->execute();

            echo "<script>alert('Password updated successfully! Please log in with your new password.'); window.location.href='admin_login.php';</script>";
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
    <title>Update Password - Admin</title>
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
        .password-container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .password-container h3 {
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
    </style>
</head>
<body>
    <div class="password-container">
        <h3>Update Admin Password</h3>
        <form method="POST" onsubmit="return validatePassword()">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
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
            <button type="submit" name="update_password" class="btn btn-custom">Update Password</button>
            <a href="admin_login.php" class="btn btn-secondary w-100 mt-2">Back to Login</a>
        </form>
    </div>

    <script>
        function validatePassword() {
            let email = document.getElementById("email").value;
            let newPassword = document.getElementById("new_password").value;
            let confirmPassword = document.getElementById("confirm_password").value;
            let emailError = document.getElementById("emailError");
            let passwordError = document.getElementById("passwordError");
            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

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
</body>
</html>
