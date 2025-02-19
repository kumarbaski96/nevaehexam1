<?php
include 'conn.php';

if (isset($_POST['code'])) {
    $code = $_POST['code'];

    // Query to fetch questions and options where code matches
    $query = "SELECT question, option1, option2, option3, option4, correct_option 
              FROM question_bank 
              WHERE code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<ul class='list-group'>";
        $question_number = 1; // Initialize question number
        while ($row = $result->fetch_assoc()) {
            echo "<li class='list-group-item'>";
            echo "<strong>Q" . $question_number . ":</strong> " . htmlspecialchars($row['question']) . "<br>";
            echo "A) " . htmlspecialchars($row['option1']) . "<br>";
            echo "B) " . htmlspecialchars($row['option2']) . "<br>";
            echo "C) " . htmlspecialchars($row['option3']) . "<br>";
            echo "D) " . htmlspecialchars($row['option4']) . "<br>";
            echo "<strong>Correct Answer:</strong> " . htmlspecialchars($row['correct_option']);
            echo "</li>";
            $question_number++; // Increment question number
        }
        echo "</ul>";
    } else {
        echo "<p>No questions found for this code.</p>";
    }

    $stmt->close();
}
?>
