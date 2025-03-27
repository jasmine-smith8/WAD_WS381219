<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['userRole'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    die("You are not authorised to view this page!");
}
$userRole = $_SESSION['userRole'];
$currentPage = basename($_SERVER['PHP_SELF']);
// Redirect the user based on their role
if ($userRole == 'admin' && $currentPage !== 'adminDashboard.php') {
    header("Location: /admin-pages/adminDashboard.php");
    exit();
} elseif ($userRole == 'user' && $currentPage !== 'userDashboard.php') {
    header("Location: /pages/userDashboard.php");
    exit();
}
?>