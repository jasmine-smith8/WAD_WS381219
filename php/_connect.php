<?php

// Database connection - in an ideal world, this would be in a separate .env file, but for the sake of simplicity, it's here 😇
// These credentials are for Jack Biggs' database, please change them to your own credentials
$host = "plesk.remote.ac";
$email = "WS381219_JasmineSmith";
$password = "29Vfb00_s";
$dbname = "WS381219_WAD";

// Connect to the database and return the connection object
$connect = mysqli_connect($host, $email, $password, $dbname);

// If the connection fails, kill the script and output an error message
if (!$connect)
{
    die("Connection to database has failed! Sad times 😢");
}