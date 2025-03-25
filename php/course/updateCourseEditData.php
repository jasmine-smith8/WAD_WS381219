<?php

if (!isset($_POST['courseID']) ||
    !isset($_POST['courseTitle']) ||
    !isset($_POST['courseDescription']))
{
    die("You dun goofed! 😢");
}

require_once("../_connect.php");

$courseID = $_POST['courseID'];
$courseTitle = $_POST['courseTitle'];
$courseDescription = $_POST['courseDescription'];

$SQL = "UPDATE `courses` SET `courseTitle` = ?, `courseDescription` = ? WHERE `courseID` = ?";

$stmt = mysqli_prepare($connect, $SQL);

mysqli_stmt_bind_param($stmt, "ssi", $courseTitle, $courseDescription, $courseID);

$query = mysqli_stmt_execute($stmt);

if ($query)
{
    echo "true";
}
else
{
    echo "User update failed!";
}