<?php
header("Content-Type: application/json");
include "db_connect.php";
$treatmentId = isset($_GET['treatmentId']) ? intval($_GET['treatmentId']) : 0;
$branchId = isset($_GET['branchId']) ? intval($_GET['branchId']) : 0;

if ($treatmentId && $branchId) {
    $stmt = $conn->prepare("SELECT schedule_date FROM schedule WHERE treatment_id = ? AND branch_id = ?");
    $stmt->bind_param("ii", $treatmentId, $branchId);
    $stmt->execute();
    $result = $stmt->get_result();

    $dates = [];
    while ($row = $result->fetch_assoc()) {
        $dates[] = $row['schedule_date'];
    }

    echo json_encode($dates);
} else {
    echo json_encode(["error" => "Invalid parameters"]);
}

$stmt->close();
$conn->close();
?>
