<?php
// Include the database connection file
include 'conn.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepared statement to fetch admin credentials
    $query = "SELECT * FROM admins WHERE email = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();

            // Verify the hashed password
            if (password_verify($password, $admin['password'])) {
                // Set session variables for the admin
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_email'] = $admin['email'];

                // Redirect to the candidates page
                header("Location: show_candidate.php");
                exit();
            } else {
                echo "<script>alert('Invalid email or password. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Invalid email or password. Please try again.');</script>";
        }

        $stmt->close();
    } else {
        echo "Error preparing the query: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Exam Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            color: white;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .btn-custom {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 8px;
            transition: 0.3s;
            width: 100%;
        }
        .btn-custom:hover {
            opacity: 0.9;
        }
        .text-danger {
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center">Admin Login</h2>
        <form method="POST" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                <small id="emailError" class="text-danger"></small>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                <small id="passwordError" class="text-danger"></small>
            </div>
            <button type="submit" name="login" class="btn btn-custom">Login</button>
            <p class="text-center mt-3">
                <a href="update_admin_email.php">Update Email?</a> |
                <a href="update_admin_password.php">Forgot Password?</a>
            </p>
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
            passwordError.textContent = passwordPattern.test(passwordField.value) ? "" : "Password must be 8+ chars, 1 uppercase, 1 number, 1 special char.";
        });

        function validateForm() {
            return emailError.textContent === "" && passwordError.textContent === "";
        }
    </script>
</body>
</html>
