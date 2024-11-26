<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['productid'], $data['newQuantity'])) {
    $productid = $data['productid'];
    $newQuantity = $data['newQuantity'];

    $query = "UPDATE skincare SET skincarequantity = ? WHERE productid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $newQuantity, $productid);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Quantity updated"]);
    } else {
        echo json_encode(["error" => "Failed to update quantity"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid parameters"]);
}
$conn->close();
?>
