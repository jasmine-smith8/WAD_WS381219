<?php
// Enable error reporting
ini_set('display_errors', 1);

// Set the content type to JSON
header('Content-Type: application/json');

// Include the database connection
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
    // If the query fails, return an error message
    echo json_encode(["error" => "Failed to fetch course history: " . mysqli_error($connect)]);
    exit();
}
// Create an array to store the courses
$courses = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Add the course to the array
    $courses[] = $row;
}

// Return the courses as a JSON object
echo json_encode($courses);
?>