<?php
// Enable error reporting
ini_set('display_errors', 1);

// Include the database connection
require_once("../_connect.php");

// Check if the required fields are set
if (!isset($_POST['txtFirstName']) ||
    !isset($_POST['txtLastName']) ||
    !isset($_POST['txtemail']) ||
    !isset($_POST['txtPassword']) ||
    !isset($_POST['userRole']) ||
    !isset($_POST['txtJobTitle']))
{
    die("Missing POST values");
}

// Get the POST values
$firstName = $_POST['txtFirstName'];
$lastName = $_POST['txtLastName'];
$email = $_POST['txtemail'];
$password = $_POST['txtPassword'];
$userRole = $_POST['userRole'];
$jobTitle = $_POST['txtJobTitle'];

// Hash the password
$password = password_hash($password, PASSWORD_BCRYPT);

// prepared statement to insert the user data into the database
$SQL = "INSERT INTO `users` (`firstName`, `lastName`, `email`, `password`, `jobTitle`, `userRole`, `TIMESTAMP`) VALUES (?, ?, ?, ?, ?, ?, current_timestamp())";

// Prepare the SQL query
$stmt = mysqli_prepare($connect, $SQL);

// Bind the parameters to the query
mysqli_stmt_bind_param($stmt, "ssssss", $firstName, $lastName, $email, $password, $jobTitle, $userRole);

// Execute the query
$query = mysqli_stmt_execute($stmt);

if ($query)
{
    // Redirect to the index page, which will redirect to the dashboard
    header("Location: /../../index.php");
}
else
{
    // If the query fails, display an error message
    echo "User creation failed!";
}
?>