<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['productid'], $data['pid'], $data['quantity'], $data['pickupdate'], $data['branchid'])) {
    $productid = $data['productid'];
    $pid = $data['pid'];
    $quantity = $data['quantity'];
    $pickupdate = $data['pickupdate'];
    $branchid = $data['branchid'];

    $query = "INSERT INTO reserve (productid, pid, reservequantity, pickupdate, aid) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiisi", $productid, $pid, $quantity, $pickupdate, $branchid);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Reservation confirmed"]);
    } else {
        echo json_encode(["error" => "Reservation failed"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid parameters"]);
}
$conn->close();
?>
