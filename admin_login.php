
<?php
// Include the database connection file
include 'conn.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepared statement to fetch admin credentials
    $query = "SELECT * FROM admins WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();

            // Set session variables for the admin
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];

            // Redirect to the candidates page
            header("Location: show_candidate.php");
            exit();
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
        <h1 class="text-center">Admin Login Page</h1>

        <!-- Registration Form -->
       

        <!-- Login Form -->
        <div class="card">
            <div class="card-header">Admin Login</div>
            <div class="card-body">
            <form method="POST" onsubmit="return validateForm()">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" 
               class="form-control" 
               id="email" 
               name="email" 
               placeholder="Enter your email (e.g., example@domain.com)" 
               required>
        <small id="emailError" class="text-danger"></small>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" 
               class="form-control" 
               id="password" 
               name="password" 
               placeholder="Password must include one uppercase letter, one digit, and one special character" 
               required>
        <small id="passwordError" class="text-danger"></small>
    </div>
    <button type="submit" name="login" class="btn btn-success">Login</button>
    <a href="javascript:void(0);" class="btn btn-secondary" onclick="window.location.href='index.php';">Go Back</a>
</form>
                
            </div>
        </div>
        
    </div>
    <script>
    // Real-time validation for email and password
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');

    emailField.addEventListener('input', () => {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Ensures '@' and '.' are present
        if (!emailPattern.test(emailField.value)) {
            emailError.textContent = "Please enter a valid email address (e.g., example@domain.com).";
        } else {
            emailError.textContent = "";
        }
    });

    passwordField.addEventListener('input', () => {
        const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
        if (!passwordPattern.test(passwordField.value)) {
            passwordError.textContent = "Password must be at least 8 characters long, include one uppercase letter, one digit, and one special character.";
        } else {
            passwordError.textContent = "";
        }
    });

    // Form submission validation
    function validateForm() {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

        if (!emailPattern.test(emailField.value)) {
            alert("Invalid email format. Please enter a valid email address.");
            emailField.focus();
            return false;
        }

        if (!passwordPattern.test(passwordField.value)) {
            alert("Invalid password. Password must be at least 8 characters long, include one uppercase letter, one digit, and one special character.");
            passwordField.focus();
            return false;
        }

        return true;
    }
</script>
</body>
</html>
