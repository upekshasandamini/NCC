<?php
include('database.php');  // Include the database connection file

include('database.php');



// Query to get recently issued books from the database
$sql = "SELECT book_id, book_title, issue_date, status FROM issued_books";
$result = mysqli_query($con, $sql); // Now it will use the valid $con connection

// Check if the first query was successful
if (!$result) {
    die("Error fetching recently issued books: " . mysqli_error($con));
}

// Query to get the total number of books
$sql_books_count = "SELECT COUNT(*) AS total_books FROM books";
$result_books_count = mysqli_query($con, $sql_books_count);

// Check if the query was successful
if ($result_books_count) {
    $row = mysqli_fetch_assoc($result_books_count);
    $total_books = $row['total_books'];
} else {
    $total_books = 0; // If there is an error, set the count to 0
}

// Query to get the total number of users
$sql_users_count = "SELECT COUNT(*) AS total_users FROM users";
$result_users_count = mysqli_query($con, $sql_users_count);

// Check if the query was successful
if ($result_users_count) {
    $row = mysqli_fetch_assoc($result_users_count);
    $total_users = $row['total_users'];
} else {
    $total_users = 0; // If there is an error, set the count to 0
}

// Query to get the total number of checkouts (issued books)
$sql_checkouts_count = "SELECT COUNT(*) AS total_checkouts FROM issued_books";
$result_checkouts_count = mysqli_query($con, $sql_checkouts_count);

// Check if the query was successful
if ($result_checkouts_count) {
    $row = mysqli_fetch_assoc($result_checkouts_count);
    $total_checkouts = $row['total_checkouts'];
} else {
    $total_checkouts = 0; // If there is an error, set the count to 0
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css">
    <title>Admin Panel</title>
</head>

<body>
    <div class="side-menu">
        <div class="brand-name">
            <h1>BookNest</h1>
        </div>
        <ul>
            <li><img src="images/dashboard.png" alt="">&nbsp; <span><a href="admin.php">Dashboard</a></span></li>
            <li><img src="images/book.png" alt="">&nbsp;<span><a href="BookManagement.php">Book Management</a></span></li>
            <li><img src="images/member.png" alt="">&nbsp;<span><a href="Member.php">Member Management</a></span></li>
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
                    <a href="AddNewBook.php" class="btn">Add New Book</a>
                    <button type="#"><img src="images/notification.png" alt=""></button>
                    <div class="img-case">
                        <button type="#"><img src="images/user.png" alt=""></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="cards">
                <div class="card">
                    <div class="box">
                        <h1><?php echo $total_books; ?></h1>
                        <h3>Books</h3>
                    </div>
                    <div class="icon-case">
                        <img src="images/bookcard.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1><?php echo $total_users; ?></h1>
                        <h3>Users</h3>
                    </div>
                    <div class="icon-case">
                        <img src="images/users.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1><?php echo $total_checkouts; ?></h1>
                        <h3>Checkouts</h3>
                    </div>
                    <div class="icon-case">
                        <img src="images/borrow.png" alt="">
                    </div>
                </div>
            </div>

            <div class="content-2">
                <div class="recent-books">
                    <div class="title">
                        <h2>Recently Issued Books</h2>
                        <a href="issuedBook.php" class="btn">View All</a>
                    </div>

                    <!-- Table displaying recently issued books -->
                    <table>
                        <tr>
                            <th>Book ID</th>
                            <th>Book Name</th>
                            <th>Issued Date</th>
                            <th>Status</th>
                        </tr>
                        <?php
                        // Display the records from the database
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['book_id'] . "</td>";
                                echo "<td>" . $row['book_title'] . "</td>";
                                echo "<td>" . $row['issue_date'] . "</td>";
                                echo "<td>" . ($row['status'] == 1 ? 'Issued' : 'Returned') . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No records found</td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<?php
// Close the database connection
mysqli_close($con);
?>
