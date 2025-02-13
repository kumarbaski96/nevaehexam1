<?php
include 'conn.php';
session_start();

if (isset($_POST['update_email'])) {
    $current_email = $_POST['current_email'];
    $new_email = $_POST['new_email'];
    $confirm_email = $_POST['confirm_email'];

    // Check if new email and confirm email match
    if ($new_email !== $confirm_email) {
        echo "<script>alert('New email and confirm email do not match!');</script>";
    } else {
        // Check if current email exists
        $query = "SELECT * FROM admins WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $current_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update email
            $update_query = "UPDATE admins SET email = ? WHERE email = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ss", $new_email, $current_email);
            $stmt->execute();

            echo "<script>alert('Email updated successfully! Please log in with your new email.'); window.location.href='admin_login.php';</script>";
        } else {
            echo "<script>alert('Current email not found!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Email</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card p-4 shadow" style="width: 350px;">
        <h3 class="text-center">Update Email</h3>
        <form method="POST" onsubmit="return validateEmail()">
            <div class="mb-3">
                <label>Current Email</label>
                <input type="email" name="current_email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>New Email</label>
                <input type="email" name="new_email" id="new_email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Confirm New Email</label>
                <input type="email" name="confirm_email" id="confirm_email" class="form-control" required>
                <small id="emailError" class="text-danger"></small>
            </div>
            <button type="submit" name="update_email" class="btn btn-primary w-100">Update Email</button>
            <a href="admin_login.php" class="btn btn-secondary w-100 mt-2">Back to Login</a>
        </form>
    </div>

    <script>
        function validateEmail() {
            let newEmail = document.getElementById("new_email").value;
            let confirmEmail = document.getElementById("confirm_email").value;
            let emailError = document.getElementById("emailError");

            if (newEmail !== confirmEmail) {
                emailError.textContent = "Emails do not match!";
                return false;
            } else {
                emailError.textContent = "";
                return true;
            }
        }
    </script>
</body>
</html>
