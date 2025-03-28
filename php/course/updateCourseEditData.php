<?php
// Enable error reporting
ini_set('display_errors', 1);

// Include the database connection
require_once("../_connect.php");

// Check if the courseID, courseTitle or courseDescription is set
if (!isset($_POST['courseID']) ||
    !isset($_POST['courseTitle']) ||
    !isset($_POST['courseDescription']))
{
    die("Missing course ID, course title or course description");
}

// Get the courseID, courseTitle and courseDescription
$courseID = $_POST['courseID'];
$courseTitle = $_POST['courseTitle'];
$courseDescription = $_POST['courseDescription'];

// Make a prepared query to the server to update the courseTitle and courseDescription
$SQL = "UPDATE `courses` SET `courseTitle` = ?, `courseDescription` = ? WHERE `courseID` = ?";

// Prepare the SQL query
$stmt = mysqli_prepare($connect, $SQL);

// Bind the parameters to the query
mysqli_stmt_bind_param($stmt, "ssi", $courseTitle, $courseDescription, $courseID);

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
    echo "Course update failed!";
}