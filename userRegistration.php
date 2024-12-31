<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Collect form data
    $full_name = $_POST['name'];
    $user_name = $_POST['username'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $confirmed_PW = $_POST['confirmed_PW'];

    // Basic validation (you can add more)
    if ($password == $confirmed_PW) {
        // Database connection
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $dbname = "library_management";

        // Create connection
        $conn = new mysqli($hostname, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to insert data into the users table
        $sql = "INSERT INTO users (full_name, user_name, email, contact_no, password) 
                VALUES ('$full_name', '$user_name', '$email', '$contact', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the connection
        $conn->close();
    } else {
        echo "Passwords do not match!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style_signUp.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<div class="wrapper">
    <form action="" method="POST">
        <h1>Registration</h1>
        <div class="input-box">
            <div class="input-field">
                <input type="text" class="form-controller" name="name" placeholder="Full Name" required>
                <i class='bx bx-user'></i>
            </div>
            <div class="input-field">
                <input type="text" class="form-controller" name="username" placeholder="User Name" required>
                <i class='bx bx-user'></i>
            </div>
        </div>
        <div class="input-box">
            <div class="input-field">
                <input type="email" class="form-controller" name="email" placeholder="Email" required>
                <i class='bx bxs-envelope'></i>
            </div>
            <div class="input-field">
                <input type="number" class="form-controller" name="contact" placeholder="Contact Number" required>
                <i class='bx bx-phone'></i>
            </div>
        </div>
        <div class="input-box">
            <div class="input-field">
                <input type="password" class="form-controller" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="input-field">
                <input type="password" class="form-controller" name="confirmed_PW" placeholder="Confirm Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
        </div>
        <label><input type="checkbox">I hereby declare that the above information provided is true and correct.</label>
        <button type="submit" name="submit" class="btn">Register</button>
    </form>
</div>

</body>
</html>
