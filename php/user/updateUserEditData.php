<?php
// Enable error reporting
ini_set('display_errors', 1);

// Include the database connection
require_once("../_connect.php");

// Check if the user ID, first name or last name is set
if (!isset($_POST['userID']) ||
    !isset($_POST['firstName']) ||
    !isset($_POST['lastName']))
{
    die("Missing user ID, first name or last name");
}

// Get the user ID, first name and last name
$userID = $_SESSION['userID'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];

// Make a prepared query to the server to update the firstName and lastName based on the user ID
$SQL = "UPDATE `users` SET `firstName` = ?, `lastName` = ? WHERE `userID` = ?";

// Prepare the SQL query
$stmt = mysqli_prepare($connect, $SQL);

// Bind the parameters to the query
mysqli_stmt_bind_param($stmt, "ssi", $firstName, $lastName, $userID);

// Execute the query
$query = mysqli_stmt_execute($stmt);

if ($query)
{
    // If the query is successful, return true
    echo "true";
}
else
{
    // If the query fails, display an error message
    echo "User update failed!";
}