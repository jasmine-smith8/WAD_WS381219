<?php
// Enable error reporting
ini_set('display_errors', 1);

// Include the database connection
require_once("../_connect.php");

// Check if the userID and courseID is set
if (!isset($_POST['userID']) || !isset($_POST['courseID'])) {
    die("Missing POST values");
}

// Get the userID and courseID
$userID = $_SESSION['userID'];
$courseID = $_POST['courseID'];

// Get the user's email, first name and the course title
$userInfoSQL = "SELECT u.email, u.firstName, c.courseTitle 
                FROM `users` u 
                JOIN `courses` c ON c.id = ? 
                WHERE u.id = ?";

// Prepare the SQL query
$userInfoStmt = mysqli_prepare($connect, $userInfoSQL);

// Bind the parameters to the query
mysqli_stmt_bind_param($userInfoStmt, "ii", $courseID, $userID);

// Execute the query
mysqli_stmt_execute($userInfoStmt);

// Get the result from the query
$userInfoResult = mysqli_stmt_get_result($userInfoStmt);

// Fetch the row from the result
if ($userInfoRow = mysqli_fetch_assoc($userInfoResult)) {
    // Get the user's email, first name and the course title
    $userEmail = $userInfoRow['email'];
    $userName = $userInfoRow['name'];
    $courseTitle = $userInfoRow['title'];
} else {
    // If the user or course is not found, return an error message
    die("User or course not found");
}
// Check if the user is enrolled in the course by checking the userCourse table
$checkSQL = "SELECT * FROM `userCourse` WHERE `userID` = ? AND `courseID` = ?";

// Prepare the SQL query
$checkStmt = mysqli_prepare($connect, $checkSQL);

// Bind the parameters to the query
mysqli_stmt_bind_param($checkStmt, "ii", $userID, $courseID);

// Execute the query
mysqli_stmt_execute($checkStmt);

// Get the result from the query
$result = mysqli_stmt_get_result($checkStmt);

if (mysqli_num_rows($result) > 0) {
    $success = true;
    // Send an email notification to the user
    mail($userEmail, "Successful enrollment in $courseTitle!", "Hi $userName, you have successfully enrolled in $courseTitle!");

} else {
    $success = false;
}

?>