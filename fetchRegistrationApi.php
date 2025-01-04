<?php
header("Content-Type: application/json");

// Allow cross-origin requests (for testing)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Database connection
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "library_management";

// Create connection
$con = new mysqli($hostname, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $con->connect_error]);
    exit();
}

// Parse request method
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == 'POST') {
    // Get JSON input
    $input = json_decode(file_get_contents("php://input"), true);

    // Extract and sanitize input data
    $full_name = isset($input['full_name']) ? $con->real_escape_string(trim($input['full_name'])) : null;
    $user_name = isset($input['user_name']) ? $con->real_escape_string(trim($input['user_name'])) : null;
    $email = isset($input['email']) ? $con->real_escape_string(trim($input['email'])) : null;
    $contact_no = isset($input['contact_no']) ? $con->real_escape_string(trim($input['contact_no'])) : null;
    $password = isset($input['password']) ? $con->real_escape_string(trim($input['password'])) : null;

    // Validate required fields
    if ($full_name && $user_name && $email && $contact_no && $password) {
        // Insert data into the database
        $sql = "INSERT INTO users (full_name, user_name, email, contact_no, password) 
                VALUES ('$full_name', '$user_name', '$email', '$contact_no', '$password')";

        if ($con->query($sql) === TRUE) {
            http_response_code(201);
            echo json_encode(["status" => "success", "message" => "User registered successfully"]);
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Error: " . $con->error]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "All fields are required!"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed. Use POST."]);
}

// Close the connection
$con->close();
?>
