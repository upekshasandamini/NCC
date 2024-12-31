<?php
include 'database.php'; // Ensure this is the correct path to your database connection file

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the `id` parameter

    // Fetch member details from the database
    $query = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($con, $query); // Use $conn, not $con

    if (!$result) {
        // Debugging: Check if query execution fails
        echo "Error executing query: " . mysqli_error($conn);
        exit;
    }

    if ($result && mysqli_num_rows($result) > 0) {
        $member = mysqli_fetch_assoc($result);
    } else {
        echo "Member not found.";
        exit;
    }
} else {
    echo "Invalid member ID.";
    exit;
}

// Handle form submission for updating member details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
    $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contact_no = mysqli_real_escape_string($con, $_POST['contact_no']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirmed_PW = mysqli_real_escape_string($con, $_POST['confirmed_PW']);

    // Check if passwords match
    if ($password !== $confirmed_PW) {
        echo "Passwords do not match.";
        exit;
    }

    // Update the member details in the `users` table
    $update_query = "
        UPDATE users 
        SET full_name = '$full_name', user_name = '$user_name', email = '$email', contact_no = '$contact_no', password = '$password'
        WHERE id = $id
    ";

    if (mysqli_query($con, $update_query)) {
        header("Location: Member.php?message=Member updated successfully"); // Redirect back to the Member page
        exit;
    } else {
        echo "Error updating member: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Member</title>
    <link rel="stylesheet" href="style_signUp.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>

    <div class="wrapper">
        <form action="updateMember.php?id=<?php echo $id; ?>" method="POST">
            <h1>Update Member</h1>
            
            <!-- Full Name Field -->
            <div class="input-box">
                <div class="input-field">
                    <input type="text" class="form-controller" name="full_name" value="<?php echo htmlspecialchars($member['full_name']); ?>" placeholder="Full Name" required>
                    <i class='bx bx-user'></i>
                </div>
            </div>
            
            <!-- User Name Field -->
            <div class="input-box">
                <div class="input-field">
                    <input type="text" class="form-controller" name="user_name" value="<?php echo htmlspecialchars($member['user_name']); ?>" placeholder="User Name" required>
                    <i class='bx bx-user'></i>
                </div>
            </div>
            
            <!-- Email Field -->
            <div class="input-box">
                <div class="input-field">
                    <input type="email" class="form-controller" name="email" value="<?php echo htmlspecialchars($member['email']); ?>" placeholder="Email" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input-field">
                    <input type="text" class="form-controller" name="contact_no" value="<?php echo htmlspecialchars($member['contact_no']); ?>" placeholder="Contact Number" required>
                    <i class='bx bx-phone'></i>
                </div>
            </div>
            
            <!-- Password Fields -->
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

            <!-- Update Button -->
            <button type="submit" name="submit" class="btn">Update Member</button>
        </form>
    </div>

</body>

</html>
