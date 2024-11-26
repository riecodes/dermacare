<?php
// Set content type to JSON
header("Content-Type: application/json");

// Include the database connection file
require_once 'db_connect.php';

// Get the branch ID from the query parameter, with validation
$branchId = isset($_GET['branchId']) ? intval($_GET['branchId']) : 0;

// Ensure a valid branch ID is provided
if ($branchId <= 0) {
    echo json_encode(["error" => "Invalid branch ID"]);
    exit();
}

// SQL query to retrieve treatments of type 'Consult' limited to 3 results
$query = "SELECT t.treatmentid, t.treatmentname, t.treatmentprice, t.treatmentimage, t.treatmenttype 
          FROM schedule s 
          JOIN treatment t ON s.treatmentid = t.treatmentid 
          WHERE s.aid = ? AND t.treatmenttype = 'Consult' 
          LIMIT 3";

// Prepare the statement
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $branchId);
$stmt->execute();
$result = $stmt->get_result();

// Check if any records are found
if ($result->num_rows > 0) {
    $treatments = [];

    // Loop through the result set
    while ($row = $result->fetch_assoc()) {
        $row['treatmentimage'] = base64_encode($row['treatmentimage']); // Encode the image as base64
        $treatments[] = $row;
    }

    // Return the result as JSON
    echo json_encode(["treatments" => $treatments]);

} else {
    // No records found for the given branch ID
    echo json_encode(["message" => "No treatments found for this branch ID."]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
