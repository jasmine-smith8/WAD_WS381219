<?php
header('Content-Type: application/json');

if (!isset($_POST['userID'])) die("You dun goofed! 😢");

$userID = $_POST['userID'];

require_once("../_connect.php");

// Make a prepared query to the server to get the firstName and lastName
$SQL = "SELECT `firstName`, `lastName`  FROM `users` WHERE `userID` = ? LIMIT 1";

$stmt = mysqli_prepare($connect, $SQL);

mysqli_stmt_bind_param($stmt, "i", $userID);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$row = mysqli_fetch_assoc($result);

echo json_encode($row);