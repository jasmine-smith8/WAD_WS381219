<?php
// Enable error reporting
ini_set('display_errors', 1);

// Include the database connection
require_once("_connect.php");

// Check if the email and password is set
if (!isset($_POST['email']) || !isset($_POST['password'])) die("Missing POST data");

// Get the email and password
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare SQL query to get the user data based on the email
$SQL = "SELECT * FROM `users` WHERE `email` = ?";

// Prepare the SQL query
$stmt = mysqli_prepare($connect, $SQL);

// Bind the parameters to the query
mysqli_stmt_bind_param($stmt, "s", $email);

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result from the query
$result = mysqli_stmt_get_result($stmt);

// Check if one row was returned
if (mysqli_num_rows($result) == 1)
{
    // Get user data from the MySQL result
    $USER = mysqli_fetch_assoc($result);

    // Check password using password_verify and bcrypt
    if (password_verify($password, $USER['password']))
    {
        @session_start();
        // Set the session variables
        $_SESSION['userID'] = $USER['userID'];
        $_SESSION['email'] = $USER['email'];
        $_SESSION['firstName'] = $USER['firstName'];
        $_SESSION['lastName'] = $USER['lastName'];

        $_SESSION['userRole'] = $USER['userRole'];

        die("true");
    }
}

echo "Invalid email or password!";
