<?php
header("Content-Type: application/json");

include 'db_connect.php';

// Check for branchId parameter in the request
if (isset($_GET['branchId'])) {
    $branchId = intval($_GET['branchId']);


    // Prepare SQL query with a placeholder for branchId
    $query = "SELECT p.productid, p.productname, p.productprice, p.productimage 
              FROM product p 
              JOIN skincare bp ON p.productid = bp.productid 
              WHERE bp.aid = ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $branchId);

    try {
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];

        // Fetch each row as an associative array
        while ($row = $result->fetch_assoc()) {
            $products[] = [
                'productid' => $row['productid'],
                'productname' => $row['productname'],
                'productprice' => $row['productprice'],
                'productimage' => base64_encode($row['productimage']) // Encode image as base64
            ];
        }

        // Return the result as JSON
        echo json_encode(['status' => 'success', 'products' => $products]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'branchId parameter is required']);
}
?>
