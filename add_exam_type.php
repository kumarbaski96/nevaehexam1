<?php
// Include database connection
include 'conn.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted exam type
    $examType = mysqli_real_escape_string($conn, $_POST['examType']);

    // Check if the input is not empty
    if (!empty($examType)) {
        // Insert into the database
        $query = "INSERT INTO exam_type_menu (exam_type) VALUES ('$examType')";
        if (mysqli_query($conn, $query)) {
            // Redirect back to the form or show a success message
            header("Location: show_exam_type.php?message=Exam Type added successfully");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Exam Type cannot be empty.";
    }
}

// Close the database connection
mysqli_close($conn);
?>
