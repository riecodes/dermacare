<?php
session_start();

// Redirect to login page if not logged in or not an admin
if (!isset($_SESSION["user"]) || $_SESSION['usertype'] != 'a') {
    header("Location: ../login.php");
    exit();
}

// Import database connection
include "../connection.php";

// Validation function to check if the start and end times are the same
function isTimeSame($startTime, $endTime) {
    $start = DateTime::createFromFormat('H:i', $startTime);
    $end = DateTime::createFromFormat('H:i', $endTime);
    
    return $start == $end; // Returns true if times are the same
}

// Validation function to check if the duration exceeds 8 hours
function isDurationExceedsEightHours($startTime, $endTime) {
    $start = DateTime::createFromFormat('H:i', $startTime);
    $end = DateTime::createFromFormat('H:i', $endTime);
    
    // Calculate the difference in hours
    $diff = $start->diff($end);
    $hours = $diff->h + ($diff->i / 60); // Convert to decimal hours

    return $hours > 8; // Returns true if duration exceeds 8 hours
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize POST data
    $docid = $_POST["docid"];
    $treatmentid = $_POST["treatmentid"];
    $date = $_POST["date"];
    $starttime = $_POST["starttime"];
    $endtime = $_POST["endtime"];
    $aid = $_POST["aid"];

    // Get treatmentname using treatmentid on schedule table
    $sql = "SELECT treatmentname FROM treatment WHERE treatmentid = $treatmentid";
    $result = $database->query($sql);
    $row = $result->fetch_assoc();
    $title = $row['treatmentname'];

    // Validate schedule times
    if (isTimeSame($starttime, $endtime)) {
        // Redirect with error message if times are the same
        header("Location: schedule.php?action=add-error&error=1");
        exit();
    }

    if (isDurationExceedsEightHours($starttime, $endtime)) {
        // Redirect with error message if duration exceeds 8 hours
        header("Location: schedule.php?action=add-error&error=2");
        exit();
    }

    // Prepare and execute the INSERT query
    $sql = "INSERT INTO schedule (docid, treatmentid, scheduledate, schedulestarttime, scheduleendtime, aid) VALUES ('$docid', '$treatmentid', '$date', '$starttime', '$endtime', '$aid')";
    
    if ($database->query($sql) === TRUE) {
        // Redirect with success message
        header("Location: schedule.php?action=added&title=" . urlencode($title));
        exit();
    } else {
        // Handle errors
        echo "Error: " . $sql . "<br>" . $database->error;
    }
}

