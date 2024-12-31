<?php
// database.php

$hostname = 'localhost';  // Database host
$username = 'root';   // Database username
$password = '';       // Database password
$dbname = 'library_management';  // Database name

// Create a connection
$con = mysqli_connect($hostname, $username, $password, $dbname);

// Check if the connection was successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
