<?php
// Enable PHP Errors for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if required POST parameters are set
if (!isset($_POST['userID']) || !isset($_POST['courseID'])) {
    die("Missing user ID or course ID");
}

// Include the database connection file
require_once("../_connect.php");

// Retrieve POST parameters
$userID = $_POST['userID'];
$courseID = $_POST['courseID'];

// Prepare SQL query to delete the user's enrollment
$SQL = "DELETE FROM `userCourse` WHERE `userID` = ? AND `courseID` = ?";
$stmt = mysqli_prepare($connect, $SQL);
mysqli_stmt_bind_param($stmt, "ii", $userID, $courseID);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["success" => true, "message" => "User enrollment removed successfully."]);
} else {
    echo "Error removing user enrollment!";
}
?>