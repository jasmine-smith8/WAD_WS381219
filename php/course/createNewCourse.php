<?php

if (!isset($_POST['courseTitle']) ||
    !isset($_POST['courseDescription']) ||
    !isset($_POST['courseDate']) ||
    !isset($_POST['courseDuration']) ||
    !isset($_POST['maxAttendees'])) {
    die("Missing POST values");
}

// Require the connection file
require_once("../_connect.php");

$courseTitle = $_POST['courseTitle'];
$courseDesc = $_POST['courseDescription'];
$courseDate = $_POST['courseDate'];
$courseDur = $_POST['courseDuration'];
$maxAttendees = $_POST['maxAttendees'];

// 1) Create the SQL query
$SQL = "INSERT INTO `courses` (`courseTitle`, `courseDescription`, `courseDate`, `courseDuration`, `maxAttendees`) VALUES (?, ?, ?, ?, ?)";

// 2) Prepare the SQL query
$stmt = mysqli_prepare($connect, $SQL);

// 3) Bind the parameters - s = string, i = integer, d = double, b = blob
mysqli_stmt_bind_param($stmt, "ssiii", $courseTitle, $courseDesc, $courseDate, $courseDur, $maxAttendees);

// 4) Execute the statement
$query = mysqli_stmt_execute($stmt);

if ($query)
{
    header("Location: ../../admin-pages/adminCourseDashboard.php");
}
else
{
    echo "Course creation failed!";
}
?>