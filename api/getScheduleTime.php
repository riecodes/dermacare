<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require_once 'db_connect.php';

// Check if the required GET parameters are provided
if (isset($_GET['treatmentId']) && isset($_GET['branchId'])) {
    $treatmentId = $_GET['treatmentId'];
    $branchId = $_GET['branchId'];

    // SQL query to get schedule times
    $query = "SELECT schedulestarttime, scheduleendtime FROM schedule WHERE treatmentid = ? AND aid = ?";
    $stmt = $conn->prepare($query);

    // Check if the statement prepared correctly
    if ($stmt) {
        $stmt->bind_param("ii", $treatmentId, $branchId); 
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are results
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            // No records found; provide feedback
            echo json_encode(["schedulestarttime" => null, "scheduleendtime" => null, "message" => "No schedule times found for the specified treatmentId and branchId."]);
        }

        $stmt->close();
    } else {
        // Error preparing statement; provide feedback
        echo json_encode(["error" => "Failed to prepare the SQL statement."]);
    }
} else {
    // Parameters missing; provide feedback
    echo json_encode(["error" => "Missing parameters treatmentId and/or branchId."]);
}

// Close database connection
$conn->close();
?>
