<?php
ini_set('display_errors', 1);

if (!isset($_POST['courseID'])) die("Missing course ID");

$courseID = $_POST['courseID'];

require_once("../_connect.php");

$SQL = "DELETE FROM `courses` WHERE `courseID` = ?";

$stmt = mysqli_prepare($connect, $SQL);

mysqli_stmt_bind_param($stmt, "i", $courseID);

if (mysqli_stmt_execute($stmt))
{
    echo "true";
}
else
{
    echo "Error deleting course!";
}