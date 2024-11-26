<?php
    session_start();

    // Check if user is logged in and has the correct user type
    if (isset($_SESSION["user"])) {
        if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'a') {
            header("location: ../login.php");
        }
    } else {
        header("location: ../login.php");
    }

    // Import database connection
    include("../connection.php");

    if ($_POST) {
        // Get appointment details from the form
        $pid = $_POST['pid'];
        $scheduleid = $_POST['scheduleid'];
        $appodate = $_POST['appodate'];        
        $aid = $_POST['aid'];        
        $status = "Pending";
        
        // Get treatmentname by getting the scheduleid from appointment table then traverse to treatment table
        $sql = "SELECT treatmentname FROM schedule INNER JOIN treatment ON schedule.treatmentid = treatment.treatmentid WHERE scheduleid = '$scheduleid'";
        $result = $database->query($sql);
        $row = $result->fetch_assoc();
        $treatmentname = $row['treatmentname'];
        
        
        // appodate should not be behind the scheduledate
        $sql = "SELECT scheduledate FROM schedule WHERE scheduleid = '$scheduleid'";
        $result = $database->query($sql);
        $row = $result->fetch_assoc();
        $scheduledate = $row['scheduledate'];

        if ($appodate < $scheduledate) {
            header("location: appointment.php?action=add-error&name=$pid&tname=$treatmentname&error=2"); // Schedule date is in the past
            exit();
        }

        // apponum should be automatically determined based on the scheduleid +1 on appointment table
        $sql = "SELECT apponum FROM appointment WHERE scheduleid = '$scheduleid'";
        $result = $database->query($sql);
        $apponum = $result->num_rows + 1;



        // Insert new appointment into the database
        $sql = "INSERT INTO appointment (pid, scheduleid, appodate, apponum, status, aid) 
                VALUES ('$pid', '$scheduleid', '$appodate', '$apponum', '$status', '$aid')";
        echo $sql;
        // Check if the query was successful
        if ($database->query($sql)) {
            header("location: appointment.php?action=add-error&pname=$pid&tname=$treatmentname&error=0"); // Adding successful
            echo $sql;
        } else {
            header("location: appointment.php?action=add-error&pname=$pid&tname=$treatmentname&error=1"); // Adding failed
        }
    }