<?php
header('Content-Type: application/json'); // Set the content type to JSON
include "db_connect.php";
// Check if branchId is set in the query parameters
if (isset($_GET['branchId'])) {
    $branchId = intval($_GET['branchId']); // Get and sanitize the branchId

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT docname FROM doctor WHERE aid = ?");
    $stmt->bind_param("i", $branchId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all matching doctors as an array
    $doctors = [];
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row['docname'];
    }

    // Return the list of doctors as JSON
    echo json_encode($doctors);

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(["error" => "branchId parameter is required."]);
}

// Close the database connection
$conn->close();
?>
