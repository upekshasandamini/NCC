<?php
include_once 'database.php';  // Include the database connection file

// Now you can use the $con variable
$query = "SELECT * FROM users";
$result = mysqli_query($con, $query);

if ($result) {
    // Process your result
} else {
    echo "Error: " . mysqli_error($con);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css">
    <title>Member Management</title>
    <style>
        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        td {
            background-color: #fff;
        }

        .btn-update {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        /* Button styling for actions */
        .actions {
            display: flex;
            justify-content: space-around;
        }

        /* Add User Button styling */
.btn-add {
    background-color: #E07B39; /* Blue */
    color: white;
    padding: 12px 20px;
    text-decoration: none;
    border-radius: 8px;
    font-size: 16px;
    display: inline-block;
    transition: background-color 0.3s ease;
}

.btn-add:hover {
    background-color:rgb(177, 112, 69); /* Darker blue on hover */
}


        .form-container {
            margin: 20px;
        }

        .form-container input {
            margin: 10px;
            padding: 10px;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-container button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
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
                        <h2>Details of Members</h2>
                        <a href="Registration.html" class="btn-add">Add User</a>
                    </div>

                    <!-- Add User Button -->
                    

                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <!-- Table with headings -->
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User Name</th>
                                        <th>Registered Date</th>
                                        <th>Contact No</th>
                                        <th>E-mail</th>
                                        <th>Actions</th> <!-- Added actions column for buttons -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Display members if available
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['user_name']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['contact_no']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                            echo "<td class='actions'>
                                                    <a href='updateMember.php?id=" . $row['id'] . "' class='btn-update'>Update</a>
                                                    <a href='deleteMember.php?id=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this member?\")'>Delete</a>
                                                  </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>No members found.</td></tr>";
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
