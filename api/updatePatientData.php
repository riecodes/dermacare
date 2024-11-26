<?php
header("Content-Type: application/json");

include 'db_connect.php';

$response = ['status' => 'error', 'message' => 'Unknown error occurred'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientId = $_POST['patientId'];
    $email = $_POST['pemail'];
    $name = $_POST['pname'];
    $address = $_POST['paddress'];
    $age = $_POST['age'];
    $sex = $_POST['psex'];
    $dob = $_POST['pdob'];
    $phone = $_POST['pphone'];
    $password = $_POST['ppass'];

    // Check if an image was uploaded
    $profilePic = null;
    if (isset($_FILES['ppic']) && $_FILES['ppic']['error'] === UPLOAD_ERR_OK) {
        $profilePic = file_get_contents($_FILES['ppic']['tmp_name']);
    }

    // Prepare SQL query
    $query = "UPDATE patient SET pemail = ?, pname = ?, paddress = ?, page = ?, psex = ?, pdob = ?, ptel = ?, ppassword = ?, ppic = ? WHERE pid = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sssisssssi", $email, $name, $address, $age, $sex, $dob, $phone, $password, $profilePic, $patientId);

        if ($stmt->execute()) {
            $response = ['status' => 'success', 'message' => 'Patient data updated'];
        } else {
            $response['message'] = 'Failed to execute update';
        }
        $stmt->close();
    } else {
        $response['message'] = 'Failed to prepare statement';
    }
} else {
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
$conn->close();
