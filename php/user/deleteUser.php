<?php

// Enable PHP Errors (Otherwise you'll just get a 500 status code)
ini_set('display_errors', 1);

if (!isset($_POST['userID'])) die("Missing user ID");

$userID = $_POST['userID'];
require_once("../_connect.php");

$SQL = "DELETE FROM `users` WHERE `userID` = ?";

$stmt = mysqli_prepare($connect, $SQL);

mysqli_stmt_bind_param($stmt, "i", $userID);

if (mysqli_stmt_execute($stmt))
{
    echo "true";
}
else
{
    echo "Error deleting user!";
}