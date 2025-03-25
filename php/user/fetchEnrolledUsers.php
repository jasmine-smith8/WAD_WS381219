<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

if (!isset($_POST['courseID'])){
    echo json_encode(["error" => "Invalid course ID"]);
    die();
} 

$courseID = $_POST['courseID'];

require_once("../_connect.php");

$query = "SELECT c.courseID, c.courseTitle, COUNT(uc.userID) AS enrolledUsers
FROM courses c
LEFT JOIN userCourse uc ON c.courseID = uc.courseID
WHERE c.courseID = ?
GROUP BY c.courseID, c.courseTitle;";

$stmt = $connect->prepare($query);
$stmt->bind_param("i", $courseID);
$stmt->execute();
$result = $stmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);
?>