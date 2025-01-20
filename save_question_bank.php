<?php
session_start();
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_questions'])) {
    $examType = $_POST['exam_type'];
    $selectedQuestions = $_POST['selected_questions'];

    function generateCode($length = 6) {
        return strtoupper(substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, $length));
    }

    $code = generateCode();

    foreach ($selectedQuestions as $questionId) {
        // Fetch full question details
        $query = "SELECT question, option1, option2, option3, option4, correct_option FROM questions WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $questionId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Ensure correct_option is correctly stored
            $correctOption = (int) $row['correct_option']; // Ensure it's an integer

            // Insert into question_bank
            $insertQuery = "INSERT INTO question_bank (exam_type, code, question, option1, option2, option3, option4, correct_option)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmtInsert = $conn->prepare($insertQuery);
            $stmtInsert->bind_param(
                "sssssssi",
                $examType,
                $code,
                $row['question'],
                $row['option1'],
                $row['option2'],
                $row['option3'],
                $row['option4'],
                $correctOption
            );
            $stmtInsert->execute();
        }
    }

    echo "<script>alert('Question Bank Created Successfully! Code: $code'); window.location.href='view_question_bank.php';</script>";
}

$conn->close();
?>
