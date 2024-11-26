<?php
// Set headers for JSON response and CORS (if required by your client setup)
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Use if needed for CORS

// Include database connection
include 'db_connect.php';

try {
    // Check if $conn is set from db_connect.php
    if (!$conn) {
        throw new Exception("Database connection not established.");
    }

    // Query to fetch admin data
    $query = "SELECT aid, aname, aaddress,aemail FROM admin";
    $result = $conn->query($query);

    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    // Fetch all rows as an associative array
    $admins = [];
    while ($row = $result->fetch_assoc()) {
        $admins[] = $row;
    }

    // Output the JSON-encoded result
    echo json_encode($admins);

    // Free the result and close the connection
    $result->free();
    $conn->close();

} catch (Exception $e) {
    // Set HTTP response code to 500 for server error
    http_response_code(500);
    echo json_encode([
        "error" => $e->getMessage()
    ]);
}
?>
