<?php
session_start();

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
    // Import database connection
    include("../connection.php");

    // Get form data
    $productname = $_POST["productname"];
    $productdesc = $_POST["productdesc"];
    $productquantity = $_POST["productquantity"];
    $productprice = $_POST["productprice"];
    $aid = $_POST["aid"];
    $error = 0;

    // Check if an image file was uploaded
    if (count($_FILES) > 0 && is_uploaded_file($_FILES['productimage']['tmp_name'])) {
        $productimage = file_get_contents($_FILES['productimage']['tmp_name']);
        $imageSize = $_FILES["productimage"]["size"];
        $imageFileType = strtolower(pathinfo($_FILES["productimage"]["name"], PATHINFO_EXTENSION));

        // Check if image file is valid
        $check = getimagesize($_FILES["productimage"]["tmp_name"]);
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
            // Prepare SQL statement to insert product data and image blob
            $sql = "INSERT INTO product (productname, productdesc, productquantity, productprice, productimage, aid) 
                    VALUES (?, ?, ?, ?, ?, ?)";

            if ($stmt = $database->prepare($sql)) {
                // Bind parameters (including image as BLOB)
                $stmt->bind_param("ssdiss", $productname, $productdesc, $productquantity, $productprice, $productimage, $aid);
                if ($stmt->execute()) {
                    // On success, redirect to inventory page
                    header("location: inventory.php?action=added&name=$productname");
                    exit();
                } else {
                    $error = 4;  // Database insert error
                }

                // Close the statement
                $stmt->close();
            } else {
                $error = 4;  // Error preparing SQL
            }
        }
    } else {
        $error = 4;  // No image uploaded
    }

    // Redirect with error information if something went wrong
    if ($error > 0) {
        header("location: inventory.php?action=add-error&name=$productname&error=$error");
        exit();
    }
} else {
    header("location: inventory.php?action=add-error&name=$productname&error=4");
    exit();
}
