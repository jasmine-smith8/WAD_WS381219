<?php
session_start();
if (!isset($_SESSION['userRole'])) {
    header("Location: login.php");
    die("You are not authorised to view this page!");
}
$userRole = $_SESSION['userRole'];
$currentPage = basename($_SERVER['PHP_SELF']);
if ($userRole == 'admin' && $currentPage !== 'adminDashboard.php') {
    header("Location: /admin-pages/adminDashboard.php");
    exit();
} elseif ($userRole == 'user' && $currentPage !== 'userDashboard.php') {
    header("Location: /pages/userDashboard.php");
    exit();
}
?>