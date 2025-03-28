<?php
// Start the session
session_start();

// Enable PHP Errors for debugging
ini_set('display_errors', 1);

// Include the database connection file
require_once("../_connect.php");

// Check if required POST parameters are set
if (!isset($_SESSION['userID']) || !isset($_POST['courseID'])) {
    die("Missing user ID or course ID");
}

// Retrieve POST parameters
// Get the user ID from the session
$userID = $_SESSION['userID'];
$courseID = $_POST['courseID'];

// Prepare SQL query to delete the user's enrollment
$SQL = "DELETE FROM `userCourse` WHERE `userID` = ? AND `courseID` = ?";

// Prepare the SQL query
$stmt = mysqli_prepare($connect, $SQL);

// Bind the parameters to the query
mysqli_stmt_bind_param($stmt, "ii", $userID, $courseID);

if (mysqli_stmt_execute($stmt)) {
    // If the query is successful, return a success message
    echo json_encode(array("success" => true, "message" => "User enrollment removed successfully"));
} else {
    // If the query fails, display an error message
    echo "Error removing user enrollment!";
}
?>