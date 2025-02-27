<?php

session_start();

if (!isset($_SESSION['userRole']))
{
    header("Location: login.php");
    die("You are not authorised to view this page!");
}

$userRole = $_SESSION['userRole'];

if ($userRole == 'admin')
{
    header("Location: adminDashboard.php");
}
else
{
    header("Location: userDashboard.php");
}