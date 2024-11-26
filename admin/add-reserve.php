<?php
session_start();

// Check if the user is logged in and is an admin
if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}

if ($_POST) {
    // Include the database connection
    include("../connection.php");

    // Retrieve data from the form
    $reserveid = $_POST["reserveid"];    
    $productid = $_POST["productid"];
    $reservequantity = $_POST["reservequantity"];
    $aid = $_POST["aid"];  // Admin ID

    // Set the default reserve status and reserve date
    $reservedate = date("Y-m-d H:i:s");  // Current timestamp
    $status = 'Pending';  // Initial status for a reserve

    // Fetch the product name based on the product ID
    $sql = "SELECT productname FROM product WHERE productid = '$productid'";
    $result = $database->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $productname = $row["productname"];  // Get the product name for reference

        // Insert the new reserve into the `reserve` table
        $sql = "INSERT INTO reserve (reserveid, productid, reservequantity, aid) 
                VALUES ('$reserveid', '$productid', '$reservequantity', '$aid')";

        // Execute the insert query and redirect
        if ($database->query($sql) === TRUE) {
            header("location: reserve.php?action=added&name=$productname");
        } else {
            echo "Error: " . $sql . "<br>" . $database->error;
        }
    } else {
        echo "Product not found.";
    }
}

