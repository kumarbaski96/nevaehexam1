<?php
include 'conn.php';
// Handle Delete

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM candidates WHERE id=$id");
    $conn->query("DELETE FROM question_results WHERE candidate_id=$id");
    $conn->query("DELETE FROM results WHERE candidate_id=$id");
    header("Location: show_candidate.php");
    exit;
}
?>