<?php
if (!isset($_POST['userID']) || !isset($_POST['courseID'])) {
    die("Missing POST values");
}

// Require the connection file
require_once("../_connect.php");

$userID = $_POST['userID'];
$courseID = $_POST['courseID'];
$enrolled = 1; 
$attendees = 1; // Default to 1 attendee for a new enrolment

// Check if the user is already enrolled in the course
$checkSQL = "SELECT * FROM `userCourse` WHERE `userID` = ? AND `courseID` = ?";
$checkStmt = mysqli_prepare($connect, $checkSQL);
mysqli_stmt_bind_param($checkStmt, "ii", $userID, $courseID);
mysqli_stmt_execute($checkStmt);
$result = mysqli_stmt_get_result($checkStmt);

if (mysqli_num_rows($result) > 0) {
    // User is already enrolled
    echo "User is already enrolled in this course.";
    exit;
}

// If not enrolled, proceed with the insertion
$SQL = "INSERT INTO `userCourse` (`userID`, `courseID`, `enrolled`, `attendees`) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($connect, $SQL);
mysqli_stmt_bind_param($stmt, "iibi", $userID, $courseID, $enrolled, $attendees);
$query = mysqli_stmt_execute($stmt);

if ($query) {
    echo "true";
} else {
    echo "Enrolment creation failed!";
}
?>