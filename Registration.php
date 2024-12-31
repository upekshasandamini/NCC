<?php
// Database connection
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "library_management";

// Create connection
$con = new mysqli($hostname, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if form data is set and sanitize
$email = isset($_POST['email']) ? $con->real_escape_string($_POST['email']) : '';
$password = isset($_POST['password']) ? $con->real_escape_string($_POST['password']) : '';
$full_name = isset($_POST['full_name']) ? $con->real_escape_string($_POST['full_name']) : '';
$user_name = isset($_POST['user_name']) ? $con->real_escape_string($_POST['user_name']) : '';
$contact_no = isset($_POST['contact_no']) ? $con->real_escape_string($_POST['contact_no']) : '';

// Check if the form data is not empty
if ($full_name && $user_name && $contact_no && $email && $password) {
    // SQL query to insert data into the users table
    $sql = "INSERT INTO users (full_name, user_name, email, contact_no, password) 
            VALUES ('$full_name', '$user_name', '$email', '$contact_no', '$password')";

    if ($con->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
} else {
    echo "All fields are required!";
}

// Close the connection
$con->close();
?>
