<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['userRole'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['userRole'] != 'user') {
    http_response_code(403);
    die("403 Forbidden: You are not a user!");
}
?>