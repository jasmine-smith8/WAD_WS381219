<?php
header('Content-Type: application/json');

require_once("../php/_connect.php");
// Fetch all users
$SQL = "SELECT * FROM users";
$result = mysqli_query($connect, $SQL);

$users = array();
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

echo json_encode($users);
?>