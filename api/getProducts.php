<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

$query = "SELECT productid, productname, productprice, productimage FROM skincare";
$result = $conn->query($query);

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);
$conn->close();
?>
