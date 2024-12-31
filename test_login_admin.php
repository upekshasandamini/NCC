<?php
// Database connection settings
$host = "localhost";
$username = "root"; // Default username for XAMPP/WAMP
$password = ""; // Default password for XAMPP/WAMP
$dbname = "library_management"; // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$user_name = $_POST['user_name'];
$password = $_POST['password'];

// Check if admin exists
$sql = "SELECT * FROM admins WHERE user_name = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user_name, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Redirect to admin.html if login is successful
    header("Location: test_admin.html");
    exit();
} else {
    // Redirect back to login page with an error message
    echo "<script>
            alert('Invalid Username or Password!');
            window.location.href='test_form.html';
          </script>";
}

// Close connection
$stmt->close();
$conn->close();
?>
