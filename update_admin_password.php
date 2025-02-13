<?php
include 'conn.php';
session_start();

if (isset($_POST['update_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if new password and confirm password match
    if ($new_password !== $confirm_password) {
        echo "<script>alert('New password and confirm password do not match!');</script>";
    } else {
        // Check if current password exists
        $query = "SELECT * FROM admins WHERE password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $current_password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update password
            $update_query = "UPDATE admins SET password = ? WHERE password = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ss", $new_password, $current_password);
            $stmt->execute();

            echo "<script>alert('Password updated successfully! Please log in with your new password.'); window.location.href='admin_login.php';</script>";
        } else {
            echo "<script>alert('Current password is incorrect!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card p-4 shadow" style="width: 350px;">
        <h3 class="text-center">Update Password</h3>
        <form method="POST" onsubmit="return validatePassword()">
            <div class="mb-3">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control" required>
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
            <button type="submit" name="update_password" class="btn btn-primary w-100">Update Password</button>
            <a href="admin_login.php" class="btn btn-secondary w-100 mt-2">Back to Login</a>
        </form>
    </div>

    <script>
        function validatePassword() {
            let newPassword = document.getElementById("new_password").value;
            let confirmPassword = document.getElementById("confirm_password").value;
            let passwordError = document.getElementById("passwordError");

            if (newPassword !== confirmPassword) {
                passwordError.textContent = "Passwords do not match!";
                return false;
            } else {
                passwordError.textContent = "";
                return true;
            }
        }
    </script>
</body>
</html>
