<?php
session_start();
// Enable error reporting
ini_set('display_errors', 1);

// Set the content type to JSON
header('Content-Type: application/json');

// Include the database connection
require_once("../php/_connect.php");

// Fetch all users
$SQL = "SELECT * FROM users";

// Prepare the SQL statement
$stmt = $connect->prepare($SQL);

// Execute the prepared statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Create an array to store the users
$users = array();
while ($row = mysqli_fetch_assoc($result)) {
    // Add the user to the array
    $users[] = $row;
}

// Return the users as a JSON object
echo json_encode($users);
?>