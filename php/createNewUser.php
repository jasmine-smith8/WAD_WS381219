<?php

if (!isset($_POST['txtFirstName']) ||
    !isset($_POST['txtLastName']) ||
    !isset($_POST['txtUsername']) ||
    !isset($_POST['txtPassword']))
{
    die("Missing POST values");
}

// Require the connection file
require_once("_connect.php");

$firstName = $_POST['txtFirstName'];
$lastName = $_POST['txtLastName'];
$username = $_POST['txtUsername'];
$password = $_POST['txtPassword'];

// Hash the password
$password = password_hash($password, PASSWORD_BCRYPT);

// 1) Create the SQL query
$SQL = "INSERT INTO `users` (`userID`, `firstName`, `lastName`, `username`, `password`, `TIMESTAMP`) VALUES (NULL, ?, ?, ?, ?, current_timestamp())";

// 2) Prepare the SQL query
$stmt = mysqli_prepare($connect, $SQL);

// 3) Bind the parameters - s = string, i = integer, d = double, b = blob
mysqli_stmt_bind_param($stmt, "ssss", $firstName, $lastName, $username, $password);

// 4) Execute the statement
$query = mysqli_stmt_execute($stmt);

if ($query)
{
    header("Location: ../index.php");
}
else
{
    echo "User creation failed!";
}