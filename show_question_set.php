<?php
session_start();
include 'conn.php'; // Include the database connection file

// Fetch unique exam types
$exam_types_query = "SELECT DISTINCT exam_type FROM question_bank";
$exam_types_result = $conn->query($exam_types_query);

// Check if there are any exam types
if ($exam_types_result->num_rows === 0) {
    echo "No exam types found.";
    exit;
}

// Check if exam_type and question_set are selected
$selected_exam_type = isset($_POST['exam_type']) ? $_POST['exam_type'] : '';
$selected_question_set = isset($_POST['question_set']) ? $_POST['question_set'] : '';
$email_id = isset($_POST['email_id']) ? $_POST['email_id'] : '';

// Fetch unique question sets based on selected exam type
$question_sets_query = "SELECT DISTINCT code FROM question_bank WHERE exam_type = ?";
$question_sets_stmt = $conn->prepare($question_sets_query);
$question_sets_stmt->bind_param("s", $selected_exam_type);
$question_sets_stmt->execute();
$question_sets_result = $question_sets_stmt->get_result();

// Fetch questions based on selected exam type and question set
$questions_query = "SELECT * FROM question_bank WHERE exam_type = ? AND code = ?";
$questions_stmt = $conn->prepare($questions_query);
$questions_stmt->bind_param("ss", $selected_exam_type, $selected_question_set);
$questions_stmt->execute();
$questions_result = $questions_stmt->get_result();

// Check if email ID exists in the candidates table and fetch the existing record if present
if ($email_id) {
    $email_check_query = "SELECT id, email FROM candidates WHERE email = ?";
    $email_check_stmt = $conn->prepare($email_check_query);
    $email_check_stmt->bind_param("s", $email_id);
    $email_check_stmt->execute();
    $email_check_result = $email_check_stmt->get_result();
    $existing_candidate = $email_check_result->fetch_assoc();
}

// Handle form submission for saving the email and updating the sec_code
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_exam'])) {
    if ($existing_candidate) {
        // If candidate exists, update the sec_code in the candidates table
        $update_stmt = $conn->prepare("UPDATE candidates SET sec_code = ? WHERE email = ?");
        $update_stmt->bind_param("ss", $selected_question_set, $email_id);
        if ($update_stmt->execute()) {
            echo "<script>alert('Exam set updated successfully!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Failed to update exam set.');</script>";
        }
    } else {
        echo "<script>alert('No candidate found with this email ID.');</script>";
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
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .table th, .table td {
            text-align: center;
        }
        .btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Select Exam and Question Set</h2>

    <!-- Exam Type Dropdown -->
    <form method="POST">
        <div class="mb-3">
            <label for="exam_type" class="form-label">Select Exam Type</label>
            <select name="exam_type" id="exam_type" class="form-select" onchange="this.form.submit()" required>
                <option value="">Select Exam Type</option>
                <?php while ($row = $exam_types_result->fetch_assoc()) { ?>
                    <option value="<?php echo htmlspecialchars($row['exam_type']); ?>" <?php echo ($selected_exam_type == $row['exam_type']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['exam_type']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </form>

    <?php if ($selected_exam_type) { ?>
        <!-- Question Set Dropdown -->
        <form method="POST">
            <input type="hidden" name="exam_type" value="<?php echo htmlspecialchars($selected_exam_type); ?>">
            <div class="mb-3">
                <label for="question_set" class="form-label">Select Question Set</label>
                <select name="question_set" id="question_set" class="form-select" onchange="this.form.submit()" required>
                    <option value="">Select Question Set</option>
                    <?php while ($row = $question_sets_result->fetch_assoc()) { ?>
                        <option value="<?php echo htmlspecialchars($row['code']); ?>" <?php echo ($selected_question_set == $row['code']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($row['code']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </form>
    <?php } ?>

    <?php if ($selected_question_set) { ?>
        <!-- Email ID Input -->
        <form method="POST">
            <input type="hidden" name="exam_type" value="<?php echo htmlspecialchars($selected_exam_type); ?>">
            <input type="hidden" name="question_set" value="<?php echo htmlspecialchars($selected_question_set); ?>">
            <div class="mb-3">
                <label for="email_id" class="form-label">Enter Candidate Email ID</label>
                <input type="email" name="email_id" id="email_id" class="form-control" value="<?php echo isset($existing_candidate['email']) ? htmlspecialchars($existing_candidate['email']) : ''; ?>" required>
            </div>
            <?php if (isset($existing_candidate['email'])) { ?>
                <div class="mb-3">
                    <p>Email found: <?php echo htmlspecialchars($existing_candidate['email']); ?></p>
                </div>
            <?php } ?>
            <button type="submit" name="save_email" class="btn btn-primary">Save Email</button>
        </form>
    <?php } ?>

    <?php if ($selected_question_set && isset($existing_candidate)) { ?>
        <!-- Submit Button to update sec_code -->
        <form method="POST">
            <input type="hidden" name="exam_type" value="<?php echo htmlspecialchars($selected_exam_type); ?>">
            <input type="hidden" name="question_set" value="<?php echo htmlspecialchars($selected_question_set); ?>">
            <input type="hidden" name="email_id" value="<?php echo htmlspecialchars($email_id); ?>">
            <button type="submit" name="submit_exam" class="btn btn-success">Submit</button>
        </form>
    <?php } ?>
</div>

</body>
</html>
