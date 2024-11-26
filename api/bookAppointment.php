<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include 'db_connect.php';

// Decode the JSON request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['patientId']) && isset($data['treatmentId']) && isset($data['appointDate']) && isset($data['branchId'])) {
    $patientId = $data['patientId'];
    $treatmentId = $data['treatmentId'];
    $appointDate = $data['appointDate'];
    $branchId = $data['branchId'];

    // 1. Get `scheduleid` from `schedule` table using `treatmentId` and `branchId`
    $scheduleQuery = "SELECT scheduleid FROM schedule WHERE treatmentid = ? AND aid = ?";
    $scheduleStmt = $conn->prepare($scheduleQuery);
    $scheduleStmt->bind_param("ii", $treatmentId, $branchId);
    $scheduleStmt->execute();
    $scheduleResult = $scheduleStmt->get_result();

    if ($scheduleRow = $scheduleResult->fetch_assoc()) {
        $scheduleId = $scheduleRow['scheduleid'];
    } else {
        echo json_encode(["error" => "No schedule found for the specified treatment and branch."]);
        $scheduleStmt->close();
        $conn->close();
        exit;
    }
    $scheduleStmt->close();

    // 2. Determine `apponum` for the same `scheduleid` and `appodate`
    $appoQuery = "SELECT MAX(apponum) AS max_apponum FROM appointment WHERE scheduleid = ? AND appodate = ?";
    $appoStmt = $conn->prepare($appoQuery);
    $appoStmt->bind_param("is", $scheduleId, $appointDate);
    $appoStmt->execute();
    $appoResult = $appoStmt->get_result();

    $apponum = 1;  // Default to 1 if no other appointments exist for this schedule and date
    if ($appoRow = $appoResult->fetch_assoc()) {
        if ($appoRow['max_apponum']) {
            $apponum = $appoRow['max_apponum'] + 1;  // Increment by 1 if appointments exist
        }
    }
    $appoStmt->close();

    // 3. Insert appointment into `appointment` table
    $insertQuery = "INSERT INTO appointment (pid, apponum, scheduleid, appodate, aid) VALUES (?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("iiisi", $patientId, $apponum, $scheduleId, $appointDate, $branchId);

    if ($insertStmt->execute()) {
        echo json_encode(["success" => "Appointment booked successfully"]);
    } else {
        echo json_encode(["error" => "Failed to book appointment"]);
    }

    $insertStmt->close();
} else {
    echo json_encode(["error" => "Invalid parameters"]);
}

$conn->close();
?>
