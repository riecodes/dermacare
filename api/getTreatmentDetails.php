<?php
header("Content-Type: application/json");
include 'db_connect.php';  // Connect to the database

$response = ['status' => 'error', 'message' => 'An error occurred'];

if (isset($_GET['treatmentId'])) {
    $treatmentId = intval($_GET['treatmentId']);

    // Prepare the SQL query to fetch treatment details by ID
    $query = "SELECT treatmentname, treatmentdesc, treatmentprice FROM treatment WHERE treatmentid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $treatmentId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $treatment = $result->fetch_assoc();
            $response = [
                'status' => 'success',
                'treatment' => [
                    'name' => $treatment['treatmentname'],
                    'description' => $treatment['treatmentdesc'],
                    'price' => $treatment['treatmentprice']
                ]
            ];
        } else {
            $response['message'] = 'Treatment not found';
        }
    } else {
        $response['message'] = 'Failed to execute query';
    }

    $stmt->close();
} else {
    $response['message'] = 'Invalid treatment ID';
}

echo json_encode($response);
$conn->close();
