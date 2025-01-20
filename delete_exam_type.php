<?php
include 'conn.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete query
    $deleteQuery = "DELETE FROM exam_type_menu WHERE id = $id";
    mysqli_query($conn, $deleteQuery);

    header("Location: show_exam_type.php"); // Redirect to the main page
} else {
    die("Invalid request.");
}
?>
