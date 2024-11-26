<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require_once 'db_connect.php';

if (isset($_GET['treatmentId']) && isset($_GET['branchId']) && isset($_GET['appointDate'])) {
    $treatmentId = $_GET['treatmentId'];
    $branchId = $_GET['branchId'];
    $appointDate = $_GET['appointDate'];

    // SQL to get treatmentMax from treatment table
    $query = "SELECT t.treatmentmax FROM treatment t
              JOIN schedule s ON t.treatmentid = s.treatmentid
              WHERE s.treatmentid = ? AND s.aid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $treatmentId, $branchId);
    $stmt->execute();
    $result = $stmt->get_result();
    $treatmentMax = $result->num_rows > 0 ? $result->fetch_assoc()['treatmentmax'] : 0;
    $stmt->close();

    // SQL to get the max apponum for this scheduleId and date
    $query = "SELECT MAX(apponum) AS max_apponum FROM appointment WHERE scheduleid = ? AND appodate = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $treatmentId, $appointDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $maxApponum = $result->num_rows > 0 ? $result->fetch_assoc()['max_apponum'] : 0;
    $stmt->close();

    // Return JSON response with maxApponum and treatmentMax
    echo json_encode(["maxApponum" => $maxApponum, "treatmentMax" => $treatmentMax]);
} else {
    echo json_encode(["error" => "Invalid parameters"]);
}

$conn->close();
?>
