<?php
include 'conn.php';

// Candidate Registration
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
//     $name = $_POST['name'];
//     $mobile = $_POST['mobile'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];
//     $confirm_password = $_POST['confirm_password'];
//     $exam_type = $_POST['exam_type'];
//     $designation = $_POST['designation'];

//     // Check if the email is already registered
//     $check_email_query = "SELECT * FROM candidates WHERE email = '$email'";
//     $check_email_result = $conn->query($check_email_query);

//     if ($check_email_result->num_rows > 0) {
//         echo "<script>alert('Email is already registered. Please login or use a different email.');</script>";
//     }
//     elseif ($password !== $confirm_password) {
//         echo "<script>alert('Passwords do not match!');</script>";
//     } else {
//         $hashed_password = password_hash($password, PASSWORD_DEFAULT);
//         $sql = "INSERT INTO candidates (name, mobile, email, password, exam_type, designation) VALUES ('$name', '$mobile', '$email', '$hashed_password', '$exam_type', '$designation')";
//         if ($conn->query($sql) === TRUE) {
//             echo "<script>alert('Registration Successful');</script>";
//         } else {
//             echo "Error: " . $sql . "<br>" . $conn->error;
//         }
//     }
// }

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
            header("Location: quiz.php");
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
        <h1 class="text-center">Welcome Candidate Login Page</h1>

        <!-- Registration Form -->
       

        <!-- Login Form -->
        <div class="card">
            <div class="card-header">Candidate Login</div>
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
