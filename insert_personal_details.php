<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'conn.php';
    
    $candidate_id = $_POST['candidate_id'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    
    $stmt = $conn->prepare("INSERT INTO candidate_personal_details (candidate_id, dob, gender, nationality, address, city, state, zip_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $candidate_id, $dob, $gender, $nationality, $address, $city, $state, $zip_code);
    
    if ($stmt->execute()) {
        echo "<script>alert('Personal details added successfully!'); window.location.href='personal_details_form.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>
