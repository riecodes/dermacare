<?php
header("Content-Type: application/json");
include "db_connect.php";  // Database connection file

$response = ["status" => "error", "message" => "Unknown error occurred"];

// Get the JSON input data
$data = json_decode(file_get_contents("php://input"), true);

// Ensure branchId and pid are provided in the request
if (isset($data['branchId']) && isset($data['pid'])) {
    $branchId = intval($data['branchId']);
    $pid = intval($data['pid']);

    // Debug log
    error_log("Received branchId: $branchId, pid: $pid");

    // SQL query to fetch appointment details
    $query = "SELECT t.treatmentname AS sampleTitle, 
                     t.treatmentprice AS samplePrice, 
                     ad.aaddress AS samplePlace, 
                     th.docname AS sampleTherapist, 
                     CONCAT(s.scheduledate, ' ', s.schedulestarttime, ' - ', s.scheduleendtime) AS sampleDateTime 
              FROM appointment a 
              JOIN schedule s ON a.scheduleid = s.scheduleid 
              JOIN treatment t ON s.treatmentid = t.treatmentid 
              JOIN doctor th ON s.docid = th.docid 
              JOIN admin ad ON s.aid = ad.aid 
              WHERE ad.aid = ? AND a.pid = ?";

    // Prepare and execute the query
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ii", $branchId, $pid);
        $stmt->execute();
        $result = $stmt->get_result();

        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }

        $stmt->close();

        // Determine if any appointments were found
        if (!empty($appointments)) {
            $response = ["status" => "success", "data" => $appointments];
        } else {
            $response = ["status" => "empty", "message" => "No appointments found for this branch"];
        }
    } else {
        error_log("Database query failed: " . $conn->error);
        $response = ["status" => "error", "message" => "Database query failed"];
    }
} else {
    error_log("Invalid parameters received.");
    $response = ["status" => "error", "message" => "Invalid parameters"];
}

// Output the JSON response
echo json_encode($response);
$conn->close();
    