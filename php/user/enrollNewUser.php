<?php
// Start the session
session_start();

// Enable error reporting
ini_set('display_errors', 1);

// Include the database connection
require_once("../_connect.php");

// Check if the userID and courseID is set
if (!isset($_POST['userID']) || !isset($_POST['courseID'])) {
    die("Missing POST values");
}

$userID = $_SESSION['userID'];
$courseID = $_POST['courseID'];
$enrolled = 1; 
$attendees = 1; // Default to 1 attendee for a new enrollment

// Check if the user is already enrolled in the course
$checkSQL = "SELECT * FROM `userCourse` WHERE `userID` = ? AND `courseID` = ?";
$checkStmt = mysqli_prepare($connect, $checkSQL);
mysqli_stmt_bind_param($checkStmt, "ii", $userID, $courseID);
mysqli_stmt_execute($checkStmt);
$result = mysqli_stmt_get_result($checkStmt);

if (mysqli_num_rows($result) > 0) {
    // If the user is already enrolled in the course, display an error message
    echo "User is already enrolled in this course.";
    exit;
}
//Check if a course is already full
$checkSQL = "SELECT `maxAttendees`, 
                    (SELECT COUNT(`userID`) FROM `userCourse` WHERE `courseID` = ?) AS enrolledUsers 
             FROM `courses` WHERE `courseID` = ?";

$checkStmt = mysqli_prepare($connect, $checkSQL);

mysqli_stmt_bind_param($checkStmt, "ii", $courseID, $courseID);

mysqli_stmt_execute($checkStmt);

$result = mysqli_stmt_get_result($checkStmt);

$row = mysqli_fetch_assoc($result);

if ($row['maxAttendees'] <= $row['enrolledUsers']) {
    // If the course is full, display an error message
    echo "Course is full!";
    exit;
}

// If not enrolled, proceed with the insertion
$SQL = "INSERT INTO `userCourse` (`userID`, `courseID`, `enrolled`, `attendees`) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($connect, $SQL);
mysqli_stmt_bind_param($stmt, "iibi", $userID, $courseID, $enrolled, $attendees);
$query = mysqli_stmt_execute($stmt);

if ($query) {
    // If the query is successful, return true
    echo "true";
} else {
    // If the query fails, display an error message
    echo "Enrollment creation failed!";
}
?>