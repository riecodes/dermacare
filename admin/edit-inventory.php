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
    $productid = $_POST['productid'];         
    $productname = $_POST['productname'];         
    $productdesc = $_POST['productdesc'];
    $productquantity = $_POST['productquantity'];         
    $productprice = $_POST['productprice']; 
    $error = 0;

    // Initialize updates array
    $updates = [];
    $bindParams = []; // Array to hold parameters for binding

    if (!empty($productname)) {
        $updates[] = "productname=?";
        $bindParams[] = $productname;
    }
    if (!empty($productdesc)) {
        $updates[] = "productdesc=?";
        $bindParams[] = $productdesc;
    }
    if (!empty($productprice)) {
        $updates[] = "productprice=?";
        $bindParams[] = $productprice;
    }
    if (!empty($productquantity)) {
        $updates[] = "productquantity=?";
        $bindParams[] = $productquantity;
    }
    
    // Handle image upload if a new image is provided
    if (!empty($_FILES["productimage"]["name"])) {
        $uploadOk = 1;
        // Read image as BLOB
        $productimage = file_get_contents($_FILES['productimage']['tmp_name']);
        $imageFileType = strtolower(pathinfo($_FILES["productimage"]["name"], PATHINFO_EXTENSION));

        // Check if image file is a valid image
        $check = getimagesize($_FILES["productimage"]["tmp_name"]);
        if ($check === false) {
            $error = 1; // Not a valid image
            $uploadOk = 0;
        }

        // Check file size (limit to 5MB)
        if ($_FILES["productimage"]["size"] > 5000000) {
            $error = 2; // File too large
            $uploadOk = 0;
        }

        // Allow only certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $error = 3; // Invalid file format
            $uploadOk = 0;
        }

        // If everything is ok, proceed to save image as BLOB
        if ($uploadOk == 1) {
            $updates[] = "productimage=?";
            $bindParams[] = $productimage;
        }
    }

    // If there are fields to update, execute the query
    if (!empty($updates)) {
        $sql = "UPDATE product SET " . implode(', ', $updates) . " WHERE productid=?";
        $bindParams[] = $productid; // Add product ID to parameters

        // Prepare the statement
        if ($stmt = $database->prepare($sql)) {
            // Bind parameters
            $paramTypes = str_repeat('s', count($bindParams) - 1) . 'i'; // Assume strings except for productid
            $stmt->bind_param($paramTypes, ...$bindParams);

            // Execute the statement
            if ($stmt->execute()) {
                header("location: inventory.php?action=edited&name=$productname");
                exit();
            } else {
                header("location: inventory.php?action=edit-error&id=$productid&name=$productname&error=5");
            }

            // Close the statement
            $stmt->close();
        } else {
            // Prepare failed
            header("location: inventory.php?action=edit-error&id=$productid&name=$productname&error=6");
        }
    } else {
        // No updates made
        header("location: inventory.php?action=edit-error&id=$productid&name=$productname&error=4");
    }
} else {
    header("location: inventory.php?action=edit-error&id=$productid&name=$productname&error=4");
}
