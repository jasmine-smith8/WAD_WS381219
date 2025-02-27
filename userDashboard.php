<?php

// Put on every page where you only want logged in users
@session_start();
if (!isset($_SESSION['userRole']))
{
    header("Location: login.php");
    die();
}

if ($_SESSION['userRole'] != 'user')
{
    http_response_code(403);
    die("You shall not pass!");
}

?>

Staff Dashboard