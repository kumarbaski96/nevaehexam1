<?php
include 'conn.php'; // Ensure this file correctly connects to the database

// Fetch exam types dynamically from the database
$exam_types = [];
$result = $conn->query("SELECT id, exam_type FROM exam_type_menu");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $exam_types[] = $row; // Add each exam type to the array
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file']) && isset($_POST['exam_type'])) {
    $exam_type_id = $_POST['exam_type']; // Get selected exam type
    $file = $_FILES['file']['tmp_name'];

    if ($file) {
        $content = file_get_contents($file);
        $lines = explode("\n", trim($content));
        $questions = [];
        $answers = [];

        foreach ($lines as $line) {
            $line = trim($line);

            if (preg_match('/^(\d+)\.\s*(.*)/', $line, $matches)) {
                $q_no = $matches[1];
                $question = $matches[2];
                $questions[$q_no] = ['question' => $question, 'options' => []];
            } elseif (preg_match('/^[a-d]\)\s*(.*)/', $line, $matches)) {
                $questions[$q_no]['options'][] = $matches[1];
            } elseif (preg_match('/^Answers:\s*(.*)/', $line, $matches)) {
                $answers = explode(", ", trim($matches[1]));
            }
        }

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO mcq_questions (exam_type, question, option1, option2, option3, option4, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");

        // Loop through questions and insert into the database
        foreach ($questions as $q_no => $data) {
            $question = mysqli_real_escape_string($conn, $data['question']);
            $option1 = mysqli_real_escape_string($conn, $data['options'][0]);
            $option2 = mysqli_real_escape_string($conn, $data['options'][1]);
            $option3 = mysqli_real_escape_string($conn, $data['options'][2]);
            $option4 = mysqli_real_escape_string($conn, $data['options'][3]);

            $correct_option = 0;
            foreach ($answers as $answer) {
                if (preg_match('/(\d+)([a-d])/', $answer, $match) && $match[1] == $q_no) {
                    $correct_option = ord($match[2]) - ord('a') + 1;
                    break;
                }
            }

            // Bind parameters and execute the query
            $stmt->bind_param("isssssi", $exam_type_id, $question, $option1, $option2, $option3, $option4, $correct_option);
            if ($stmt->execute()) {
                echo "Question $q_no inserted successfully.<br>";
            } else {
                echo "Error inserting question $q_no: " . $stmt->error . "<br>";
            }
        }

        // Close the prepared statement
        $stmt->close();
        echo "<script>alert('File uploaded and questions inserted successfully!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload MCQ File</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #4A90E2;
        }

        label {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
            display: block;
        }

        select, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .alert {
            color: green;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Upload MCQ Questions</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="exam_type">Select Exam Type:</label>
            <select name="exam_type" id="exam_type" required>
                <option value="">--Select Exam Type--</option>
                <?php
                // Populate the select dropdown with exam types from the database
                foreach ($exam_types as $exam) {
                    echo "<option value='" . $exam['id'] . "'>" . $exam['exam_type'] . "</option>";
                }
                ?>
            </select>

            <label for="file">Upload MCQ File:</label>
            <input type="file" name="file" id="file" required>

            <button type="submit">Upload</button>
        </form>

        <?php if (isset($success_message)): ?>
            <div class="alert"><?= $success_message ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
