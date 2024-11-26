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
    
    // Check if both DateTime objects were created successfully
    if ($start === false || $end === false) {
        return null; // Indicates an error in time format
    }

    return $start == $end; // Returns true if times are the same
}

// Validation function to check if the duration exceeds 8 hours
function isDurationExceedsEightHours($startTime, $endTime) {
    $start = DateTime::createFromFormat('H:i', $startTime);
    $end = DateTime::createFromFormat('H:i', $endTime);
    
    // Check if both DateTime objects were created successfully
    if ($start === false || $end === false) {
        return null; // Indicates an error in time format
    }

    // Calculate the difference in hours
    $diff = $start->diff($end);
    $hours = $diff->h + ($diff->i / 60); // Convert to decimal hours

    return $hours > 8; // Returns true if duration exceeds 8 hours
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize POST data
    $id = (int)$_POST["id"];
    $docid = (int)$_POST["docid"];
    $treatmentid = (int)$_POST["treatmentid"];
    $date = $database->real_escape_string($_POST["date"]);
    $starttime = $database->real_escape_string($_POST["starttime"]);
    $endtime = $database->real_escape_string($_POST["endtime"]);
    $aid = (int)$_POST["aid"];

    // Get treatmentname by joining schedule and treatment table
    $sql = "SELECT treatmentname FROM schedule INNER JOIN treatment ON schedule.treatmentid = treatment.treatmentid WHERE scheduleid = $aid";
    $result = $database->query($sql);
    $row = $result->fetch_assoc();
    $title = $row['treatmentname'];

    // Validate schedule times
    if (isTimeSame($starttime, $endtime) === true) {
        // Redirect with error message if times are the same
        header("Location: schedule.php?action=edit-error&error=1&id=$id&name=$title");
        exit();
    }

    if (isDurationExceedsEightHours($starttime, $endtime) === true) {
        // Redirect with error message if duration exceeds 8 hours
        header("Location: schedule.php?action=edit-error&error=2&id=$id&name=$title");
        exit();
    }

    // Prepare and execute the UPDATE query
    $sql = "UPDATE schedule 
            SET docid = '$docid', treatmentid = '$treatmentid', scheduledate = '$date', schedulestarttime = '$starttime', scheduleendtime = '$endtime', aid = '$aid' 
            WHERE scheduleid = $id";
    
    if ($database->query($sql) === TRUE) {
        // Redirect with success message
        header("Location: schedule.php?action=updated&title=" . urlencode($title));
        exit();
    } else {
        // Handle errors
        echo "Error: " . $sql . "<br>" . $database->error;
    }
}

