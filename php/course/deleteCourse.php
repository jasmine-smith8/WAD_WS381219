<?php
// Enable error reporting
ini_set('display_errors', 1);

// Check if the courseID is set
if (!isset($_POST['courseID'])) die("Missing course ID");

// Get the courseID
$courseID = $_POST['courseID'];

// Include the database connection
require_once("../_connect.php");

// Make a prepared query to the server to delete the course
$SQL = "DELETE FROM `courses` WHERE `courseID` = ?";

// Prepare the SQL query
$stmt = mysqli_prepare($connect, $SQL);

// Bind the parameters to the query
mysqli_stmt_bind_param($stmt, "i", $courseID);

// Execute the query
if (mysqli_stmt_execute($stmt))
{
    // If the query is successful, return true
    echo "true";
}
else
{
    // If the query fails, display an error message
    echo "Error deleting course!";
}