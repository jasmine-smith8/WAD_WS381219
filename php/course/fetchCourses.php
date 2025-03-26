<?php
header('Content-Type: application/json');

require_once("../_connect.php");

$SQL = "SELECT * FROM courses WHERE courseDate >= CURDATE() ORDER BY courseDate ASC";
$result = mysqli_query($connect, $SQL);

$courses = array();
while ($row = mysqli_fetch_assoc($result)) {
    $courses[] = $row;
}

echo json_encode($courses);
?>