<?php
include 'database.php';  // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $book_id = $_POST['book_id'];
    $isbn_no = $_POST['isbn'];
    $book_title = $_POST['bookTitle'];
    $author = $_POST['author'];
    $member_name = $_POST['memberName'];
    $issue_date = $_POST['issueDate'];
    $due_date = $_POST['dueDate'];

    // SQL query to insert data into issued_books table
    $sql = "INSERT INTO issued_books (book_id, isbn, book_title, author, member_name, issue_date, due_date) 
            VALUES ('$book_id', '$isbn_no', '$book_title', '$author', '$member_name', '$issue_date', '$due_date')";

    if (mysqli_query($con, $sql)) {
        header("Location: issuedBook.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}

mysqli_close($con);  // Close the database connection
?>
