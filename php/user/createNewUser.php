<?php

if (!isset($_POST['txtFirstName']) ||
    !isset($_POST['txtLastName']) ||
    !isset($_POST['txtemail']) ||
    !isset($_POST['txtPassword']) ||
    !isset($_POST['userRole']) ||
    !isset($_POST['txtJobTitle']))
{
    die("Missing POST values");
}

// Require the connection file
require_once("../php/_connect.php");

$firstName = $_POST['txtFirstName'];
$lastName = $_POST['txtLastName'];
$email = $_POST['txtemail'];
$password = $_POST['txtPassword'];
$userRole = $_POST['userRole'];
$jobTitle = $_POST['txtJobTitle'];

// Hash the password
$password = password_hash($password, PASSWORD_BCRYPT);

// 1) Create the SQL query
$SQL = "INSERT INTO `users` (`firstName`, `lastName`, `email`, `password`, `jobTitle`, `userRole`, `TIMESTAMP`) VALUES (?, ?, ?, ?, ?, ?, current_timestamp())";

// 2) Prepare the SQL query
$stmt = mysqli_prepare($connect, $SQL);

// 3) Bind the parameters - s = string, i = integer, d = double, b = blob
mysqli_stmt_bind_param($stmt, "ssssss", $firstName, $lastName, $email, $password, $jobTitle, $userRole);

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
?>