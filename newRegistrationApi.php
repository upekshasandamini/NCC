<?php
header("Content-Type: application/json");
include 'database.php';

// Allow cross-origin requests for testing
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// Parse the request method
$requestMethod = $_SERVER['REQUEST_METHOD'];
parse_str(file_get_contents("php://input"), $input); // Parse body for PUT/DELETE

// Initialize response
$response = [
    "status" => "error",
    "message" => "Invalid Request"
];

if ($requestMethod == 'GET') {
    if (isset($_GET['id'])) {
        // Fetch single user
        $user = getUserById($_GET['id']);
        if ($user) {
            $response = [
                "status" => "success",
                "data" => $user
            ];
        } else {
            $response['message'] = "User not found";
        }
    } else {
        // Fetch all users
        $users = getUsers();
        $response = [
            "status" => "success",
            "data" => $users
        ];
    }
} elseif ($requestMethod == 'POST') {
    // Add new user
    $input = json_decode(file_get_contents('php://input'), true);
    $full_name = $input['full_name'] ?? null;
    $user_name = $input['user_name'] ?? null;
    $email = $input['email'] ?? null;
    $contact_no = $input['contact_no'] ?? null;
    $password = $input['password'] ?? null;

    if ($full_name && $user_name && $email && $contact_no && $password) {
        if (addUser($full_name, $user_name, $email, $contact_no, $password)) {
            $response = [
                "status" => "success",
                "message" => "User added successfully"
            ];
        } else {
            $response['message'] = "Failed to add user";
        }
    } else {
        $response['message'] = "Missing required fields";
    }
} elseif ($requestMethod == 'PUT') {
    // Update existing user
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id'] ?? null;
    $full_name = $input['full_name'] ?? null;
    $user_name = $input['user_name'] ?? null;
    $email = $input['email'] ?? null;
    $contact_no = $input['contact_no'] ?? null;
    $password = $input['password'] ?? null;

    if ($id && $full_name && $user_name && $email && $contact_no && $password) {
        if (updateUser($id, $full_name, $user_name, $email, $contact_no, $password)) {
            $response = [
                "status" => "success",
                "message" => "User updated successfully"
            ];
        } else {
            $response['message'] = "Failed to update user";
        }
    } else {
        $response['message'] = "Missing required fields";
    }
} elseif ($requestMethod == 'DELETE') {
    // Delete user
    $id = $input['id'] ?? null;

    if ($id) {
        if (deleteUser($id)) {
            $response = [
                "status" => "success",
                "message" => "User deleted successfully"
            ];
        } else {
            $response['message'] = "Failed to delete user";
        }
    } else {
        $response['message'] = "Missing user ID";
    }
}

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
