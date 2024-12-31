<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css">
    <title>Book Management</title>
</head>

<body>
    <div class="side-menu">
        <div class="brand-name">
            <h1>BookNest</h1>
        </div>
        <ul>
            <li><img src="images/dashboard.png" alt="">&nbsp; <span><a href="admin.php">Dashboard</a></span> </li>
            <li><img src="images/book.png" alt="">&nbsp;<span><a href="BookManagement.php">Book Management</a></span></li>
            <li><img src="images/member.png" alt="">&nbsp;<span><a href="Member.php">Member Management</a></span> </li>
            <li><img src="images/lending.webp" alt="">&nbsp;<span><a href="issuedBook.php">Borrow and Return</a></span></li>
        </ul>
    </div>

    <div class="container">
        <div class="header">
            <div class="nav">
                <div class="search">
                    <input type="text" placeholder="Search..">
                    <button type="submit"><img src="images/search.png" alt=""></button>
                </div>
                <div class="user">
                    <button type="#"><img src="images/notification.png" alt=""></button>
                    <div class="img-case">
                        <button type="#"><img src="images/user.png" alt=""></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="content-2">
                <div class="recent-books">
                    <div class="title">
                        <h2>Details of Books</h2>
                        <a href="AddNewBook.php" class="btn">Add New Book</a>
                    </div>

                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <table class="table-bordered" width="900px" style="text-align: center">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ISBN</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th>Actions</th> <!-- Added actions column for buttons -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include('database.php'); // Include the database connection

                                    // Query to fetch book data
                                    $sql = "SELECT id, isbn, title, author, category FROM books";
                                    $result = $con->query($sql);

                                    if ($result->num_rows > 0) {
                                        // Loop through and display each row
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row['id'] . "</td>";
                                            echo "<td>" . $row['isbn'] . "</td>";
                                            echo "<td>" . $row['title'] . "</td>";
                                            echo "<td>" . $row['author'] . "</td>";
                                            echo "<td>" . $row['category'] . "</td>";
                                            echo "<td>
                                                    <a href='updateBook.php?id=" . $row['id'] . "' class='btn btn-update'>Update</a> 
                                                    <a href='deleteBook.php?id=" . $row['id'] . "' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this book?\")'>Delete</a>
                                                  </td>";  // Update and Delete buttons
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>No books found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
