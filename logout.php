<?php
session_start();
session_unset(); // Remove session variables
session_destroy(); // Destroy session completely

// Prevent browser caching after logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Force logout and redirect
echo "<script>
    sessionStorage.clear();
    localStorage.clear();
    window.location.href = 'index.php';
</script>";
exit();
?>