<?php
header("Content-Type: application/json");
include "db_connect.php";

$response = ["status" => "error", "message" => "Unknown error occurred"];

// Decode the JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Check if branchId and pid are set in the decoded data
if (isset($data['branchId']) && isset($data['pid'])) {
    $branchId = intval($data['branchId']);
    $pid = intval($data['pid']);
    
    // Log incoming parameters for debugging
    error_log("Received branchId: $branchId, pid: $pid");

    $query = "SELECT p.productname AS sampleTitle, 
                     p.productprice AS samplePrice, 
                     ad.aaddress AS samplePlace, 
                     r.reservequantity AS sampleQuantity, 
                     r.pickupdate AS sampleDateTime 
              FROM reserve r 
              JOIN product p ON r.productid = p.productid 
              JOIN admin ad ON r.aid = ad.aid 
              WHERE ad.aid = ? AND r.pid = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $branchId, $pid);
    $stmt->execute();
    $result = $stmt->get_result();

    $reservedDetails = [];
    while ($row = $result->fetch_assoc()) {
        $reservedDetails[] = $row;
    }
    $stmt->close();

    if (count($reservedDetails) > 0) {
        $response = ["status" => "success", "data" => $reservedDetails];
    } else {
        $response = ["status" => "empty", "message" => "No reserved products found for this branch"];
    }
} else {
    error_log("Invalid parameters received.");
    $response = ["status" => "error", "message" => "Invalid parameters"];
}

echo json_encode($response);
$conn->close();
?>
