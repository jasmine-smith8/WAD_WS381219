<?php

if (!isset($_POST['userID']) ||
    !isset($_POST['firstName']) ||
    !isset($_POST['lastName']))
{
    die("Missing user ID, first name or last name");
}

require_once("../_connect.php");

$userID = $_POST['userID'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];

// Make a prepared query to the server to update the firstName and lastName based on the user ID
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