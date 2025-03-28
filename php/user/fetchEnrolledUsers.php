<?php
session_start();
// Enable error reporting
ini_set('display_errors', 1);

// Include the database connection
require_once("../_connect.php");

// Check if the courseID is set
if (!isset($_POST['courseID'])){
    // If the courseID is not set, return an error message
    echo json_encode(["error" => "Invalid course ID"]);
    die();
} 

// Get the courseID
$courseID = $_POST['courseID'];

// prepare SQL query to get enrolledUsers by counting the number of userIDs in the userCourse table
// The GROUP_CONCAT function is used to concatenate the userIDs, first names, and emails of the enrolled users
$query = "SELECT c.courseID, c.courseTitle, COUNT(uc.userID) AS enrolledUsers,
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

// Create an array to store the users
$users = [];
while ($row = $result->fetch_assoc()) {
    // Add the user to the array
    $users[] = $row;
}

// Return the users as a JSON object
echo json_encode($users);
?>