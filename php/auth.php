<?php

require_once("_connect.php");

if (!isset($_POST['username']) || !isset($_POST['password'])) die("Missing POST data");

$username = $_POST['username'];
$password = $_POST['password'];

// Input Validation to be added later :)

$SQL = "SELECT * FROM `users` WHERE `username` = ?";

$stmt = mysqli_prepare($connect, $SQL);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);

// Get the result from the MySQL query
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

        $_SESSION['userID'] = $USER['userID'];
        $_SESSION['username'] = $USER['username'];
        $_SESSION['firstName'] = $USER['firstName'];
        $_SESSION['lastName'] = $USER['lastName'];

        $_SESSION['userRole'] = $USER['userRole'];

        die("true");
    }
}

echo "Invalid username or password!";