<?php
header('Content-Type: application/json');
require_once("../_connect.php");

// Fetch courses with dates that have already passed
$SQL = "
    SELECT 
        courseID, 
        courseTitle, 
        courseDescription, 
    FROM 
        courses 
    WHERE 
        STR_TO_DATE(courseDate, '%Y-%m-%d') < CURDATE()
    ORDER BY 
        STR_TO_DATE(courseDate, '%Y-%m-%d') DESC
";

if (!$result) {
    echo json_encode(["error" => "Failed to fetch course history: " . mysqli_error($connect)]);
    exit();
}

$courses = [];
while ($row = mysqli_fetch_assoc($result)) {
    $courses[] = $row;
}

echo json_encode($courses);
?>