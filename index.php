<?php
include 'conn.php';

// Candidate Registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $exam_type = $_POST['exam_type'];
    $designation = $_POST['designation'];

    // Check if the email is already registered
    $check_email_query = "SELECT * FROM candidates WHERE email = '$email'";
    $check_email_result = $conn->query($check_email_query);

    if ($check_email_result->num_rows > 0) {
        echo "<script>alert('Email is already registered. Please login or use a different email.');</script>";
    }
    elseif ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO candidates (name, mobile, email, password, exam_type, designation, exam_duration) 
        VALUES ('$name', '$mobile', '$email', '$hashed_password', '$exam_type', '$designation', 3600)";

        //$sql = "INSERT INTO candidates (name, mobile, email, password, exam_type, designation) VALUES ('$name', '$mobile', '$email', '$hashed_password', '$exam_type', '$designation')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration Successful');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}


// Fetch available exam types
//$exam_types = $conn->query("SELECT DISTINCT exam_type FROM questions");
$exam_types = $conn->query("SELECT * from exam_type_menu where status=1");

if (!$exam_types) {
    die("Error fetching data: " . $conn->error);
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
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
            max-width: 450px;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            background: white;
            padding: 20px;
        }
        .btn-primary {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            border: none;
            padding: 10px;
            border-radius: 8px;
            font-size: 16px;
        }
        .btn-primary:hover {
            background: linear-gradient(to right, #2575fc, #6a11cb);
        }
        .form-label {
            font-weight: bold;
            color: #333;
        }
        .form-control {
            border-radius: 6px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
     <!-- Header Menu -->
     <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Nevaeh Technology</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" style="color: blue;" href="candidate_login.php">Candidate Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: blue;" href="admin_login.php">Admin Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h3 class="text-center">Exam Portal Registration</h3>

        <!-- Registration Form -->
        <div class="card mb-4">
            <div class="card-header bg-orange">Candidate Registration</div>
            <div class="card-body">
            <form method="POST" id="registrationForm">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" maxlength="100" required>
        <div id="nameFeedback" class="form-text text-danger"></div>
    </div>
    <div class="mb-3">
        <label for="mobile" class="form-label">Mobile</label>
        <input type="text" class="form-control" id="mobile" name="mobile" required>
        <div id="mobileFeedback" class="form-text text-danger"></div>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
        <div id="emailFeedback" class="form-text text-danger"></div>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
        <div id="passwordFeedback" class="form-text text-danger"></div>
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        <div id="confirmPasswordFeedback" class="form-text text-danger"></div>
    </div>
    <div class="mb-3">
        <label for="exam_type" class="form-label">Select Exam Type</label>
        <select class="form-select" id="exam_type" name="exam_type" required>
            <option value="">-- Select Exam Type --</option>
            <?php while ($row = $exam_types->fetch_assoc()) { ?>
                <option value="<?php echo htmlspecialchars($row['exam_type']); ?>">
                    <?php echo htmlspecialchars($row['exam_type']); ?>
                </option>
            <?php } ?>
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

       
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const nameInput = document.getElementById('name');
        const mobileInput = document.getElementById('mobile');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');

        const nameFeedback = document.getElementById('nameFeedback');
        const mobileFeedback = document.getElementById('mobileFeedback');
        const emailFeedback = document.getElementById('emailFeedback');
        const passwordFeedback = document.getElementById('passwordFeedback');
        const confirmPasswordFeedback = document.getElementById('confirmPasswordFeedback');

        // Validation Rules
        const validateName = () => {
            if (nameInput.value.trim().length > 100) {
                nameFeedback.textContent = 'Name should not exceed 100 characters.';
            } else {
                nameFeedback.textContent = '';
            }
        };

        const validateMobile = () => {
            if (!/^\d{10}$/.test(mobileInput.value)) {
                mobileFeedback.textContent = 'Mobile number must be exactly 10 digits.';
            } else {
                mobileFeedback.textContent = '';
            }
        };

        const validateEmail = () => {
            if (!/^[^@]+@[^@]+\.[^@]+$/.test(emailInput.value)) {
                emailFeedback.textContent = 'Invalid email format. Must contain "@" and ".".';
            } else {
                emailFeedback.textContent = '';
            }
        };

        const validatePassword = () => {
            if (!/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+]).{8,}$/.test(passwordInput.value)) {
                passwordFeedback.textContent = 'Password must contain at least one capital letter, one digit, one special character, and be at least 8 characters long.';
            } else {
                passwordFeedback.textContent = '';
            }
        };

        const validateConfirmPassword = () => {
            if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordFeedback.textContent = 'Passwords do not match.';
            } else {
                confirmPasswordFeedback.textContent = '';
            }
        };

        // Add Event Listeners
        nameInput.addEventListener('blur', validateName);
        mobileInput.addEventListener('blur', validateMobile);
        emailInput.addEventListener('blur', validateEmail);
        passwordInput.addEventListener('blur', validatePassword);
        confirmPasswordInput.addEventListener('blur', validateConfirmPassword);

        // Final Form Validation
        document.getElementById('registrationForm').addEventListener('submit', (event) => {
            validateName();
            validateMobile();
            validateEmail();
            validatePassword();
            validateConfirmPassword();

            if (
                nameFeedback.textContent ||
                mobileFeedback.textContent ||
                emailFeedback.textContent ||
                passwordFeedback.textContent ||
                confirmPasswordFeedback.textContent
            ) {
                event.preventDefault();
                alert('Please fix the errors in the form before submitting.');
            }
        });
    });
</script>
<script>
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
</script>
</body>
</html>
