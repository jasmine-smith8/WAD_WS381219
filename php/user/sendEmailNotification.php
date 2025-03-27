<?php
require_once("../_connect.php");

if (!isset($_POST['userID']) || !isset($_POST['courseID'])) {
    die("Missing POST values");
}

$userID = $_POST['userID'];
$courseID = $_POST['courseID'];
// Get the user's email, first name and the course title
$userInfoSQL = "SELECT u.email, u.firstName, c.courseTitle 
                FROM `users` u 
                JOIN `courses` c ON c.id = ? 
                WHERE u.id = ?";

$userInfoStmt = mysqli_prepare($connect, $userInfoSQL);
mysqli_stmt_bind_param($userInfoStmt, "ii", $courseID, $userID);
mysqli_stmt_execute($userInfoStmt);
$userInfoResult = mysqli_stmt_get_result($userInfoStmt);

if ($userInfoRow = mysqli_fetch_assoc($userInfoResult)) {
    $userEmail = $userInfoRow['email'];
    $userName = $userInfoRow['name'];
    $courseTitle = $userInfoRow['title'];
} else {
    die("User or course not found");
}
// Check if the user is enrolled in the course
$checkSQL = "SELECT * FROM `userCourse` WHERE `userID` = ? AND `courseID` = ?";
$checkStmt = mysqli_prepare($connect, $checkSQL);
mysqli_stmt_bind_param($checkStmt, "ii", $userID, $courseID);
mysqli_stmt_execute($checkStmt);
$result = mysqli_stmt_get_result($checkStmt);

if (mysqli_num_rows($result) > 0) {
    $success = true;
    // Send an email notification to the user
    mail($userEmail, "Successful enrollment in $courseTitle!", "Hi $userName, you have successfully enrolled in $courseTitle!");

} else {
    $success = false;
}

?>