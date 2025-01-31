<?php
include 'conn.php';
header('Content-Type: application/json');

if (isset($_GET['candidate_id'])) {
    $candidate_id = intval($_GET['candidate_id']);

    $sql = "SELECT * FROM candidate_personal_details WHERE candidate_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $candidate_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Candidate not found"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
