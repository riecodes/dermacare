<?php
header("Content-Type: application/json");

include 'db_connect.php';

ini_set('memory_limit', '512M'); // Increased memory limit for handling large files
ini_set('output_buffering', 'Off'); // Disable output buffering to prevent truncation

$response = ['status' => 'error', 'message' => 'Unknown error occurred'];

if (isset($_GET['patientId'])) {
    $patientId = intval($_GET['patientId']);

    // Prepare the SQL query
    $query = "SELECT pemail, pname, paddress, page, psex, pdob, ptel, ppassword, ppic FROM patient WHERE pid = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        $response['message'] = 'Failed to prepare statement';
        echo json_encode($response, JSON_UNESCAPED_SLASHES);
        exit();
    }

    $stmt->bind_param("i", $patientId);

    try {
        $stmt->execute();
        $result = $stmt->get_result();
        $patient = $result->fetch_assoc();

        if ($patient) {
            $patient['ppic'] = base64_encode($patient['ppic']); // Encode binary image data as Base64
            
            // Populate response with patient data
            $response['status'] = 'success';
            $response['patient'] = $patient;

            // Log the length of the Base64-encoded image for debugging
            $base64Length = strlen($patient['ppic']);
            $response['log'] = "Base64-encoded image length: " . $base64Length;
            $response['log1'] = "Binary image data length: " . strlen($patient['ppic']);
            $response['log2'] = "Base64 image length: " . $base64Length;

            // Optional: Log length to server logs for tracking
            error_log("Base64 image length: " . $base64Length);
            error_log("Binary image data length: " . strlen($patient['ppic']));
        } else {
            $response['message'] = 'No patient found';
        }

    } catch (Exception $e) {
        $response['message'] = 'Database error: ' . $e->getMessage();
    } finally {
        $stmt->close();
    }
} else {
    $response['message'] = 'patientId parameter is required';
}

echo json_encode($response, JSON_UNESCAPED_SLASHES);
$conn->close();
?>
