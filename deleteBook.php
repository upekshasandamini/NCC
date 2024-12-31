<?php
include('database.php');

// Check if the 'id' is passed in the URL
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Delete query
    $query = "DELETE FROM books WHERE id = $book_id";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Book deleted successfully!');</script>";
        header("Location: BookManagement.php"); // Redirect after deletion
        exit;
    } else {
        echo "Error deleting book: " . mysqli_error($con);
    }
} else {
    die("No book ID specified.");
}
?>
