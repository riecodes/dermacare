<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

if (isset($_GET['productid'])) {
    $productid = $_GET['productid'];

    $query = "SELECT skincarequantity FROM skincare WHERE productid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(["availableQuantity" => $row['skincarequantity']]);
    } else {
        echo json_encode(["error" => "Product not found"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid parameters"]);
}
$conn->close();
?>
