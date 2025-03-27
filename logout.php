<?php
// Logout
@session_start();
// Unset all session variables
unset($_SESSION['userRole']);
session_destroy();

header("Location: login.php");