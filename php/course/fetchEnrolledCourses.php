<?php
// Enable error reporting
ini_set('display_errors', 1);

// Include the database connection
require_once("../_connect.php");

// Check if the courseID is set
if (!isset($_POST['courseID'])){
    echo json_encode(["error" => "Invalid course ID"]);
    die();
} 
// Get the courseID
$courseID = $_POST['courseID'];

// prepare SQL query to get enrolledUsers by counting the number of userIDs in the userCourse table
// and then joining the users table to get the first names and emails of the users who are enrolled in the course
$query = "SELECT 
    c.courseID, 
    c.courseTitle, 
    COUNT(uc.userID) AS enrolledUsers,
    GROUP_CONCAT(uc.userID SEPARATOR ', ') AS enrolledUserIDs,
    GROUP_CONCAT(u.firstName SEPARATOR ', ') AS enrolledFirstNames,
    GROUP_CONCAT(u.email SEPARATOR ', ') AS enrolledEmails
FROM courses c
LEFT JOIN userCourse uc ON c.courseID = uc.courseID
LEFT JOIN users u ON uc.userID = u.userID
WHERE c.courseID = ?
GROUP BY c.courseID, c.courseTitle;";

// Prepare the statement
$stmt = $connect->prepare($query);

// Bind the parameters to the query
$stmt->bind_param("i", $courseID);

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Create an array to store the courses
$courses = [];
while ($row = $result->fetch_assoc()) {
    // Add the course to the array
    $courses[] = $row;
}

// Return the courses as a JSON object
echo json_encode($courses);
?>