<?php
// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Set content type to JSON
header("Content-Type: application/json");

// Include database connection
include 'database.php';

// Parse the request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Parse the JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    // Extract and sanitize input fields
    $book_id = $input['book_id'] ?? null;
    $isbn_no = $input['isbn'] ?? null;
    $book_title = $input['bookTitle'] ?? null;
    $author = $input['author'] ?? null;
    $member_name = $input['memberName'] ?? null;
    $issue_date = $input['issueDate'] ?? null;
    $due_date = $input['dueDate'] ?? null;

    // Check if all required fields are provided
    if ($book_id && $isbn_no && $book_title && $author && $member_name && $issue_date && $due_date) {
        // SQL query to insert data into issued_books table
        $sql = "INSERT INTO issued_books (book_id, isbn, book_title, author, member_name, issue_date, due_date) 
                VALUES ('$book_id', '$isbn_no', '$book_title', '$author', '$member_name', '$issue_date', '$due_date')";

        if (mysqli_query($con, $sql)) {
            // Success response
            echo json_encode([
                "status" => "success",
                "message" => "Book issued successfully!"
            ]);
        } else {
            // Error response for query execution failure
            echo json_encode([
                "status" => "error",
                "message" => "Failed to issue book: " . mysqli_error($con)
            ]);
        }
    } else {
        // Error response for missing fields
        echo json_encode([
            "status" => "error",
            "message" => "All fields are required!"
        ]);
    }
} else {
    // Invalid request method response
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method. Use POST."
    ]);
}

// Close the database connection
mysqli_close($con);
?>
