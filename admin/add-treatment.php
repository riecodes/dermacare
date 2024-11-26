<?php
session_start();

// Check if user is logged in and is an admin
if (isset($_SESSION["user"])) {
    if ($_SESSION["user"] == "" || $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
        exit();
    }
} else {
    header("location: ../login.php");
    exit();
}

if ($_POST) {
    // Include database connection
    include("../connection.php");

    // Get form data
    $treatmentname = $_POST["treatmentname"];
    $treatmenttype = $_POST["treatmenttype"];
    $treatmentdesc = $_POST["treatmentdesc"];
    $treatmentprice = $_POST["treatmentprice"];    
    $treatmentmax = $_POST["treatmentmax"];
    $aid = $_POST["aid"];
    $error = 0;

    // Check if an image file was uploaded
    if (count($_FILES) > 0 && is_uploaded_file($_FILES['treatmentimage']['tmp_name'])) {
        $treatmentimage = file_get_contents($_FILES['treatmentimage']['tmp_name']);        
        $imageSize = $_FILES["treatmentimage"]["size"];
        $imageFileType = strtolower(pathinfo($_FILES["treatmentimage"]["name"], PATHINFO_EXTENSION));

        // Check if image file is valid
        $check = getimagesize($_FILES["treatmentimage"]["tmp_name"]);
        if ($check === false) {
            $error = 1;  // Not a valid image
        }

        // Check file size (limit to 5MB)
        if ($imageSize > 5000000) {
            $error = 2;  // File too large
        }

        // Allow only specific file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $error = 3;  // Invalid file format
        }

        // If no errors, proceed to save the image as a BLOB
        if ($error == 0) {
            // Escape special characters in the input data
            $treatmentname = $database->real_escape_string($treatmentname);
            $treatmenttype = $database->real_escape_string($treatmenttype);
            $treatmentdesc = $database->real_escape_string($treatmentdesc);
            $treatmentprice = $database->real_escape_string($treatmentprice);
            $treatmentmax = $database->real_escape_string($treatmentmax);
            $aid = $database->real_escape_string($aid);
            $treatmentimage = $database->real_escape_string($treatmentimage);

            // Prepare SQL statement to insert treatment data and image blob
            $sql = "INSERT INTO treatment (treatmentname, treatmenttype, treatmentdesc, treatmentprice, treatmentmax, treatmentimage, aid) 
                    VALUES ('$treatmentname', '$treatmenttype', '$treatmentdesc', '$treatmentprice', '$treatmentmax', '$treatmentimage', '$aid')";

            if ($database->query($sql) === TRUE) {
                // On success, redirect to treatment page
                header("location: treatment.php?action=added&name=$treatmentname");
                exit();
            } else {
                $error = 4;  // Database insert error
            }
        }
    } else {
        $error = 4;  // No image uploaded
    }

    // Redirect with error information if something went wrong
    if ($error > 0) {
        header("location: treatment.php?action=add-error&id=$treatmentid&name=$treatmentname&error=$error");
        exit();
    }
} else {
    header("location: treatment.php?action=add-error&id=$treatmentid&name=$treatmentname&error=4");
    exit();
}
?>