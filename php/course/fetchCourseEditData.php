<?php
// Enable error reporting
ini_set('display_errors', 1);

// Check if the courseID is set
if (!isset($_POST['courseID'])) die("Missing course ID");

// Get the courseID
$courseID = $_POST['courseID'];

// Include the database connection
require_once("../_connect.php");

// Make a prepared query to the server to get the courseTitle and courseDescription
$SQL = "SELECT `courseTitle`, `courseDescription`  FROM `courses` WHERE `courseID` = ? LIMIT 1";

// Prepare the SQL query
$stmt = mysqli_prepare($connect, $SQL);

// Bind the parameters to the query
mysqli_stmt_bind_param($stmt, "i", $courseID);

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result from the query
$result = mysqli_stmt_get_result($stmt);

// Fetch the row from the result
$row = mysqli_fetch_assoc($result);

// Return the row as a JSON object
echo json_encode($row);