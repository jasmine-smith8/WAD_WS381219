<?php
require_once("_connect.php");

$SQL = "SELECT * FROM courses";
$result = mysqli_query($connect, $SQL);

$users = array();
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

echo json_encode($users);
?>