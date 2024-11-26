<?php
session_start();

if (isset($_SESSION["user"])) {
    if ($_SESSION["user"] == "" || $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}

if ($_POST) {
    // Import database connection
    include("../connection.php");

    // Get form data
    $stockname = $_POST["stockname"];
    $stockdesc = $_POST["stockdesc"];
    $stockquantity = $_POST["stockquantity"];
    $stockprice = $_POST["stockprice"];
    $aid = $_POST["aid"];
    $error = 0;

    // Handle image upload
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
            // Save stock information and image path to the database
            $sql = "INSERT INTO stock (stockname, stockdesc, stockquantity, stockprice, stockimage, aid) 
                    VALUES ('$stockname', '$stockdesc', '$stockquantity', '$stockprice', '$target_file', '$aid')";

            // Execute the query and redirect
            if ($database->query($sql) === TRUE && $error == 0) {
                header("location: stock.php?action=added&name=$stockname");
            } else {
                header("location: stock.php?action=add-error&id=$stockid&name=$stockname&error=$error");
            }
        } else {
            header("location: stock.php?action=add-error&id=$stockid&name=$stockname&error=4");
        }
    }else {
        header("location: stock.php?action=add-error&id=$stockid&name=$stockname&error=$error");
    }
}else {
    header("location: stock.php?action=add-error&id=$stockid&name=$stockname&error=$error");
}