<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $examType = $_POST['exam_type'] ?? '';
    $quantity1 = (int)$_POST['quantity1'];
    $quantity2 = (int)$_POST['quantity2'];
    $quantity3 = (int)$_POST['quantity3'];

    if (empty($examType)) {
        echo "Please select a valid exam type.";
        exit;
    }

    // Build query to fetch questions based on selected filters
    $query = "SELECT * FROM questions WHERE exam_type = ? ORDER BY level LIMIT ?, ?, ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("siii", $examType, $quantity1, $quantity2, $quantity3);
    $stmt->execute();
    $result = $stmt->get_result();

    $output = '';
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['question']}</td>
                        <td>{$row['options']}</td>
                        <td><input type='checkbox' class='select-question' name='selected_questions[]' value='{$row['id']}'></td>
                    </tr>";
    }

    if (empty($output)) {
        $output = "<tr><td colspan='4' class='text-center'>No questions found</td></tr>";
    }

    echo $output;
}
?>
