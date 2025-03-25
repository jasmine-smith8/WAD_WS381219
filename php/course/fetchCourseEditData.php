<?php
if (!isset($_POST['courseID'])) die("You dun goofed! 😢");

$courseID = $_POST['courseID'];

require_once("../_connect.php");

// Make a prepared query to the server to get the firstName and lastName
$SQL = "SELECT `courseTitle`, `courseDescription`  FROM `courses` WHERE `courseID` = ? LIMIT 1";

$stmt = mysqli_prepare($connect, $SQL);

mysqli_stmt_bind_param($stmt, "i", $courseID);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$row = mysqli_fetch_assoc($result);

echo json_encode($row);