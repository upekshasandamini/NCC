<?php
include 'database.php';  // Include the database connection file

// Get the issue ID from the URL parameter
if (isset($_GET['issue_id'])) {
    $issue_id = $_GET['issue_id'];  // Use 'issue_id' from the URL
} else {
    echo "Error: Issue ID not found.";
    exit();
}

// SQL query to update the status to 'Received' (0)
$sql = "UPDATE issued_books SET status = 0 WHERE id = $issue_id";

if (mysqli_query($con, $sql)) {
    // Return success response to the AJAX call
    echo "success";
} else {
    echo "Error updating record: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>
