<?php
// Start session and check user type
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"] == "" || $_SESSION['usertype'] != 'a') {
    header("location: ../login.php");
    exit();
}

// Import database connection
include("../connection.php");

// Handle POST request
if ($_POST) {
    // Extract POST data
    $treatmentid = $_POST['treatmentid'];         
    $treatmentname = $_POST['treatmentname'];         
    $treatmentdesc = $_POST['treatmentdesc'];         
    $treatmentprice = $_POST['treatmentprice'];
    $treatmentmax = $_POST['treatmentmax'];
    $error = 0;

    // Initialize updates array
    $updates = [];
    $bindParams = []; // Array to hold parameters for binding

    if (!empty($treatmentname)) {
        $updates[] = "treatmentname=?";
        $bindParams[] = $treatmentname;
    }
    if (!empty($treatmentdesc)) {
        $updates[] = "treatmentdesc=?";
        $bindParams[] = $treatmentdesc;
    }
    if (!empty($treatmentprice)) {
        $updates[] = "treatmentprice=?";
        $bindParams[] = $treatmentprice;
    }
    if (!empty($treatmentmax)) {
        $updates[] = "treatmentmax=?";
        $bindParams[] = $treatmentmax;
    }

    // Handle image upload if a new image is provided
    if (!empty($_FILES["treatmentimage"]["name"])) {
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($_FILES["treatmentimage"]["name"], PATHINFO_EXTENSION));

        // Check if image file is a valid image
        $check = getimagesize($_FILES["treatmentimage"]["tmp_name"]);
        if ($check === false) {
            $error = 1; // Not a valid image
            $uploadOk = 0;
        }

        // Check file size (limit to 5MB)
        if ($_FILES["treatmentimage"]["size"] > 5000000) {
            $error = 2; // File too large
            $uploadOk = 0;
        }

        // Allow only certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $error = 3; // Invalid file format
            $uploadOk = 0;
        }

        // If everything is ok, read image as BLOB
        if ($uploadOk == 1) {
            $treatmentimage = file_get_contents($_FILES['treatmentimage']['tmp_name']);
            $updates[] = "treatmentimage=?";
            $bindParams[] = $treatmentimage;
        }
    }

    // If there are fields to update, execute the query
    if (!empty($updates)) {
        $sql = "UPDATE treatment SET " . implode(', ', $updates) . " WHERE treatmentid=?";
        $bindParams[] = $treatmentid; // Add treatment ID to parameters

        // Prepare the statement
        if ($stmt = $database->prepare($sql)) {
            // Bind parameters
            $paramTypes = str_repeat('s', count($bindParams) - 1) . 'i'; // Assume strings except for treatmentid
            $stmt->bind_param($paramTypes, ...$bindParams);

            // Execute the statement
            if ($stmt->execute()) {
                header("location: treatment.php?action=edited&name=$treatmentname");
                exit();
            } else {
                header("location: treatment.php?action=edit-error&id=$treatmentid&name=$treatmentname&error=5");
            }

            // Close the statement
            $stmt->close();
        } else {
            // Prepare failed
            header("location: treatment.php?action=edit-error&id=$treatmentid&name=$treatmentname&error=6");
        }
    } else {
        // No updates made
        header("location: treatment.php?action=edit-error&id=$treatmentid&name=$treatmentname&error=4");
    }
} else {
    header("location: treatment.php?action=edit-error&id=$treatmentid&name=$treatmentname&error=4");
}
