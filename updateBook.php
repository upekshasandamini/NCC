<?php
include('database.php');

// Fetch the book details if the ID is passed
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Fetch current book details
    $sql = "SELECT * FROM books WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        die("Book not found.");
    }
} else {
    die("No book ID specified.");
}

// Update the book details if the form is submitted
if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $author = mysqli_real_escape_string($con, $_POST['author']);
    $isbn = mysqli_real_escape_string($con, $_POST['isbn']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    // Update query
    $query = "UPDATE books SET title = '$title', author = '$author', isbn = '$isbn', category = '$category', description = '$description' WHERE id = $book_id";

    if (mysqli_query($con, $query)) {
        // Redirect to BookManagement.php page after update
        header("Location: BookManagement.php");
        exit; // Don't forget to call exit after header redirect
    } else {
        echo "Error updating book: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url(images/add.jpg) no-repeat;
            background-position: center;
            background-size: cover;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-size: 14px;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #d86a22;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #e69560;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Edit Book</h2>
    <form action="updateBook.php?id=<?php echo $book_id; ?>" method="POST">
        <div class="form-group">
            <label for="title">Book Title</label>
            <input type="text" id="title" name="title" placeholder="Enter book title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" id="author" name="author" placeholder="Enter author name" value="<?php echo htmlspecialchars($book['author']); ?>" required>
        </div>
        <div class="form-group">
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn" placeholder="Enter ISBN number" value="<?php echo htmlspecialchars($book['isbn']); ?>" required>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select id="category" name="category" required>
                <option value="">Select Category</option>
                <option value="fiction" <?php echo $book['category'] == 'fiction' ? 'selected' : ''; ?>>Fiction</option>
                <option value="non-fiction" <?php echo $book['category'] == 'non-fiction' ? 'selected' : ''; ?>>Non-fiction</option>
                <option value="science" <?php echo $book['category'] == 'science' ? 'selected' : ''; ?>>Science</option>
                <option value="history" <?php echo $book['category'] == 'history' ? 'selected' : ''; ?>>History</option>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" placeholder="Enter a brief description"><?php echo htmlspecialchars($book['description']); ?></textarea>
        </div>
        <div class="form-group">
            <button type="submit" name="submit">Update Book</button>
        </div>
    </form>
</div>
</body>
</html>
