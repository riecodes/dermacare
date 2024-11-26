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
    $stockid = $_POST['stockid'];         
    $stockname = $_POST['stockname'];         
    $stockdesc = $_POST['stockdesc'];         
    $stockprice = $_POST['stockprice'];
    $stockquantity = $_POST['stockquantity']; 
    $error = 0;
    
    // Initialize updates array
    $updates = [];
    if (!empty($stockname)) {
        $updates[] = "stockname='$stockname'";
    }
    if (!empty($stockdesc)) {
        $updates[] = "stockdesc='$stockdesc'";
    }
    if (!empty($stockprice)) {
        $updates[] = "stockprice='$stockprice'";
    }
    if (!empty($stockquantity)) {
        $updates[] = "stockquantity='$stockquantity'";
    }

    // Handle image upload if a new image is provided
    if (!empty($_FILES["stockimage"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["stockimage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a valid image
        $check = getimagesize($_FILES["stockimage"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $error = 1;
            $uploadOk = 0;
        }

        // Check file size (limit to 5MB)
        if ($_FILES["stockimage"]["size"] > 5000000) {
            $error = 2;
            $uploadOk = 0;
        }

        // Allow only certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $error = 3;
            $uploadOk = 0;
        }

        // If everything is ok, try to upload file
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["stockimage"]["tmp_name"], $target_file)) {
                $updates[] = "stockimage='$target_file'";
            } else {
                $error = 4;
            }
        }
    }

    if (!empty($updates)) {
        $sql = "UPDATE stock SET " . implode(', ', $updates) . " WHERE stockid='$stockid'";
        if ($database->query(query: $sql) && $error === 0) {
            header("location: stock.php?action=edited&name=$stockname");
            exit();
        } else {
            header("location: stock.php?action=edit-error&id=$stockid&name=$stockname&error=$error");
        }
    }
} else {
    header("location: stock.php?action=edit-error&id=$stockid&name=$stockname&error=4");
}
