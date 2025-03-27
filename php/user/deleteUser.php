<?php
ini_set('display_errors', 1);

if (!isset($_POST['userID'])) die("Missing user ID");

$userID = $_POST['userID'];
require_once("../_connect.php");
// Prepare SQL query to delete the user based on the user ID
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