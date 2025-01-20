<?php
include 'conn.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get current status
    $query = "SELECT status FROM exam_type_menu WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $currentStatus = mysqli_fetch_assoc($result)['status'];

    // Toggle status
    $newStatus = $currentStatus == 1 ? 0 : 1;
    $toggleQuery = "UPDATE exam_type_menu SET status = $newStatus WHERE id = $id";
    mysqli_query($conn, $toggleQuery);

    header("Location: show_exam_type.php"); // Redirect to the main page
} else {
    die("Invalid request.");
}
?>
