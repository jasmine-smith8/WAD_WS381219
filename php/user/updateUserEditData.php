<?php

if (!isset($_POST['userID']) ||
    !isset($_POST['firstName']) ||
    !isset($_POST['lastName']))
{
    die("You dun goofed! 😢");
}

require_once("../_connect.php");

$userID = $_POST['userID'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];

$SQL = "UPDATE `users` SET `firstName` = ?, `lastName` = ? WHERE `userID` = ?";

$stmt = mysqli_prepare($connect, $SQL);

mysqli_stmt_bind_param($stmt, "ssi", $firstName, $lastName, $userID);

$query = mysqli_stmt_execute($stmt);

if ($query)
{
    echo "true";
}
else
{
    echo "User update failed!";
}