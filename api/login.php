<?php
header("Content-Type: application/json");
include 'db_connect.php';

// Get the raw POST data and decode it
$data = json_decode(file_get_contents('php://input'), true);

// Check if email and password are provided
if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Email and password are required.']);
    exit();
}

$email = $data['email'];
$password = $data['password'];

// Prepare SQL query to check if the user exists
$query = "SELECT pid FROM patient WHERE pemail = ? AND ppassword = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User found, fetch user data
    $user = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'pid' => $user['pid']]);
} else {
    // No user found or incorrect credentials
    http_response_code(401); // Unauthorized
    echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
}

$stmt->close();
$conn->close();
?>
