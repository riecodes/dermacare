<?php

// Start session and check user type
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"] == "" || $_SESSION['usertype'] != 'm') {
    header("location: ../login.php");
    exit();
}

// Import database connection
include("../connection.php");

if ($_POST) {
    // Extract POST data
    $requestid = $_POST['requestid'];          // Request ID
    $productname = $_POST['productname'];      // Product name
    $requestquantity = $_POST['requestquantity'];  // Request quantity
    $status = $_POST['status'];            // Status

    // Build the update query for requestquantity and status
    $updates = [];
    if (!empty($requestquantity)) {
        $updates[] = "requestquantity='$requestquantity'";  // Update the request quantity
    }
    if (!empty($status)) {
        $updates[] = "status='$status'";  // Update the status
    }

    // If fields need updating, execute the update query
    if (!empty($updates)) {
        $sql1 = "UPDATE request SET " . implode(', ', $updates) . " WHERE requestid=$requestid";
        $database->query($sql1);
    }

    // Redirect back to the request list page with success
    header("location: request-m-i.php?action=edited&id=$requestid&name=$productname");
    exit();

} else {
    // No POST data received, redirect back to request page
    header("location: request-m-i.php");
    exit();
}
