<?php
session_start();
// Enable error reporting
ini_set('display_errors', 1);

// Include the database connection
require_once("../_connect.php");

// Check if the user ID is set
if (!isset($_POST['userID'])) die("Missing user ID");

// Get the user ID
$userID = $_SESSION['userID'];

// Make a prepared query to the server to get the firstName and lastName based on the user ID
$SQL = "SELECT `firstName`, `lastName`  FROM `users` WHERE `userID` = ? LIMIT 1";

// Prepare the SQL query
$stmt = mysqli_prepare($connect, $SQL);

// Bind the parameters to the query
mysqli_stmt_bind_param($stmt, "i", $userID);

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result from the query
$result = mysqli_stmt_get_result($stmt);

// Fetch the row from the result
$row = mysqli_fetch_assoc($result);

// Return the row as a JSON object
echo json_encode($row);