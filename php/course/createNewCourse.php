<?php
// Enable error reporting
ini_set('display_errors', 1);
// Check if the POST values are set
if (!isset($_POST['courseTitle']) ||
    !isset($_POST['courseDescription']) ||
    !isset($_POST['courseDate']) ||
    !isset($_POST['courseDuration']) ||
    !isset($_POST['maxAttendees'])) {
    die("Missing POST values");
}
// Include the database connection
require_once("../_connect.php");

// Get the POST values
$courseTitle = $_POST['courseTitle'];
$courseDescription = $_POST['courseDescription'];
$courseDate = $_POST['courseDate'];
$courseDur = $_POST['courseDuration'];
$maxAttendees = $_POST['maxAttendees'];

// Make a prepared query to the server to insert the course data
$SQL = "INSERT INTO `courses` (`courseTitle`, `courseDescription`, `courseDate`, `courseDuration`, `maxAttendees`) VALUES (?, ?, ?, ?, ?)";

// Prepare the SQL query
$stmt = mysqli_prepare($connect, $SQL);

// Bind the parameters to the query
mysqli_stmt_bind_param($stmt, "sssii", $courseTitle, $courseDescription, $courseDate, $courseDur, $maxAttendees);

// Execute the query
$query = mysqli_stmt_execute($stmt);

if ($query)
{
    // Redirect to the admin course dashboard
    header("Location: ../../admin-pages/adminCourseDashboard.php");
}
else
{
    // If the query fails, display an error message
    echo "Course creation failed!";
}
?>