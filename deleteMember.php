<?php
include('database.php'); // Make sure the connection is correctly included

// Check if the 'id' is passed in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id']; // Capture the user ID from the URL

    // Delete query
    $query = "DELETE FROM users WHERE id = $user_id"; // Use $user_id instead of $book_id

    // Check if connection is successful
    if (mysqli_query($con, $query)) {
        echo "<script>alert('User deleted successfully!');</script>";
        header("Location: Member.php"); // Redirect after deletion
        exit;
    } else {
        echo "Error deleting user: " . mysqli_error($con); // Use $conn instead of $con
    }
} else {
    die("No user ID specified.");
}
?>
