<?php
// Start the session
session_start();

// Enable error reporting
ini_set('display_errors', 1);

// Include the database connection
require_once("../_connect.php");

// Check if the user ID is set
if (!isset($_POST['userID'])) die("Missing user ID");

// Get the user ID
$userID = $_SESSION['userID'];

// Prepare SQL query to delete the user based on the user ID
$SQL = "DELETE FROM `users` WHERE `userID` = ?";

// Prepare the SQL query
$stmt = mysqli_prepare($connect, $SQL);

// Bind the parameters to the query
mysqli_stmt_bind_param($stmt, "i", $userID);

if (mysqli_stmt_execute($stmt))
{
    // If the query is successful, return true
    echo "true";
}
else
{
    // If the query fails, display an error message
    echo "Error deleting user!";
}