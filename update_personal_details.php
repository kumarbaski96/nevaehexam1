<?php
include 'conn.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $candidate_id = intval($_POST['candidate_id']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];

    $sql = "UPDATE candidate_personal_details SET dob=?, gender=?, nationality=?, address=?, city=?, state=?, zip_code=? WHERE candidate_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $dob, $gender, $nationality, $address, $city, $state, $zip_code, $candidate_id);

    if ($stmt->execute()) {
        
        echo json_encode(["success" => "Details updated successfully"]);
        //header("Location: show_candidate.php");
    } else {
        echo json_encode(["error" => "Failed to update details"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
