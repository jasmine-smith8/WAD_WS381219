<?php
// Enable error reporting
ini_set('display_errors', 1);
// Start the session
@session_start();
// Unset all session variables
unset($_SESSION['userRole']);
unset($_SESSION['userID']);
// Destroy the session
session_destroy();
// Redirect to the login page
header("Location: login.php");
?>
<script>
    // Clear sessionStorage on logout
    sessionStorage.clear();
    sessionStorage.removeItem('userID');
    window.location.href = "login.php";
</script>