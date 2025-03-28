<?php
// Enable error reporting
ini_set('display_errors', 1);

// Set the content type to JSON
header('Content-Type: application/json');

// Include the database connection
require_once("../_connect.php");

// Check POST values are set for userID and courseID
if (!isset($_POST['userID']) || !isset($_POST['courseID'])) {
    echo json_encode(["error" => "Missing user ID or course ID"]);
    exit();
}

// Get the user ID and course ID
$userID = $_SESSION['userID'];
$courseID = $_POST['courseID'];

// Fetch courses with dates that have not yet passed
$SQL = "SELECT * FROM courses WHERE courseDate >= CURDATE() ORDER BY courseDate ASC";

// Prepare the statement
$stmt = $connect->prepare($SQL);

// Execute the prepared statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Create an array to store the courses
$courses = array();
while ($row = mysqli_fetch_assoc($result)) {
    // Add the course to the array
    $courses[] = $row;
}

// Return the courses as a JSON object
echo json_encode($courses);
?>