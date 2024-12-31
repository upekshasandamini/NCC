<?php
include 'database.php';  // Include the database connection file

// SQL query to select data from issued_books table
$sql = "SELECT id AS issue_id, 
               book_id, 
               isbn, 
               book_title, 
               author, 
               member_name, 
               issue_date, 
               due_date, 
               status
        FROM issued_books";

$result = mysqli_query($con, $sql);

if (!$result) {
    die("Error fetching data: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css">
    <title>Issued Books</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* Add styling to the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            text-align: center;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn-update {
            background-color: #4CAF50; /* Green background */
            color: white;              /* White text */
            border: none;              /* No border */
            padding: 10px 20px;        /* Padding around text */
            text-align: center;        /* Center the text */
            text-decoration: none;     /* Remove underline */
            display: inline-block;     /* Keep buttons inline */
            font-size: 16px;           /* Font size */
            cursor: pointer;          /* Pointer cursor on hover */
            border-radius: 5px;        /* Rounded corners */
            transition: background-color 0.3s ease; /* Smooth transition on hover */
        }

        .btn-update:hover {
            background-color: #45a049; /* Darker green when hovered */
        }

        .btn-update:disabled {
            background-color: #ccc; /* Light gray background */
            color: #666;             /* Darker gray text */
            cursor: not-allowed;     /* Not allowed cursor */
        }
    </style>

    <!-- Add jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                        <h2>Issued Book's Detail</h2>
                        <a href="issueBookForm.html" class="btn">Issue New Book</a>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <form>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Member ID</th>
                                            <th>Member Name</th>
                                            <th>Book Name</th>
                                            <th>Author</th>
                                            <th>Book ID</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Check if there are records to display
                                        if (mysqli_num_rows($result) > 0) {
                                            // Loop through and display each row of data
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr id='row_" . $row['issue_id'] . "'>";
                                                echo "<td>" . $row['issue_id'] . "</td>";  // Member ID (Issue ID here)
                                                echo "<td>" . $row['member_name'] . "</td>";
                                                echo "<td>" . $row['book_title'] . "</td>";
                                                echo "<td>" . $row['author'] . "</td>";
                                                echo "<td>" . $row['book_id'] . "</td>";
                                                
                                                // Show status as either "Issued" or "Received"
                                                if ($row['status'] == 1) {
                                                    echo "<td>Issued</td>";
                                                    echo "<td><button class='btn-update' onclick='updateStatus(" . $row['issue_id'] . ")'>Mark as Received</button></td>";
                                                } else {
                                                    echo "<td>Received</td>";
                                                    echo "<td><button class='btn-update' disabled>Already Received</button></td>";
                                                }
                                                
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7'>No records found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateStatus(issueId) {
            // Use AJAX to update the status
            $.ajax({
                url: 'updateStatus.php',
                type: 'GET',
                data: { issue_id: issueId },
                success: function(response) {
                    if(response == "success") {
                        // Move the row to the last place after updating status
                        var updatedRow = $('#row_' + issueId);
                        updatedRow.find('td').eq(5).text('Received'); // Change status text
                        updatedRow.find('button').attr('disabled', true).text('Already Received'); // Disable button
                        
                        // Reorder the rows: Move the updated row to the last position
                        $('table').append(updatedRow);
                    } else {
                        alert('Error updating status');
                    }
                }
            });
        }
    </script>

</body>

</html>

<?php
// Close the database connection
mysqli_close($con);
?>
