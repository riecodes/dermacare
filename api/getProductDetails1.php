<?php
header("Content-Type: application/json");
include 'db_connect.php';  // Include your database connection

$response = ['status' => 'error', 'message' => 'An error occurred'];

if (isset($_GET['productid'])) {
    $productId = intval($_GET['productid']);

    // Prepare SQL query to get product details
    $query = "SELECT productname, productdesc, productprice FROM product WHERE productid = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $productId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $product = $result->fetch_assoc();
                $response = [
                    'status' => 'success',
                    'product' => [
                        'productName' => $product['productname'],
                        'productDesc' => $product['productdesc'],
                        'productPrice' => (float) $product['productprice']
                    ]
                ];
            } else {
                $response['message'] = 'Product not found';
            }
        } else {
            $response['message'] = 'Failed to execute query';
        }

        $stmt->close();
    } else {
        $response['message'] = 'Failed to prepare query';
    }
} else {
    $response['message'] = 'Invalid or missing product ID';
}

echo json_encode($response);
$conn->close();
