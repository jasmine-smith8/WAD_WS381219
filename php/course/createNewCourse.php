<?php

if (!isset($_POST['courseTitle']) ||
    !isset($_POST['courseDescription']) ||
    !isset($_POST['courseDate']) ||
    !isset($_POST['courseDuration']) ||
    !isset($_POST['maxAttendees'])) {
    die("Missing POST values");
}

require_once("../_connect.php");

$courseTitle = $_POST['courseTitle'];
$courseDescription = $_POST['courseDescription'];
$courseDate = $_POST['courseDate'];
$courseDur = $_POST['courseDuration'];
$maxAttendees = $_POST['maxAttendees'];

$SQL = "INSERT INTO `courses` (`courseTitle`, `courseDescription`, `courseDate`, `courseDuration`, `maxAttendees`) VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($connect, $SQL);

mysqli_stmt_bind_param($stmt, "sssii", $courseTitle, $courseDescription, $courseDate, $courseDur, $maxAttendees);

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