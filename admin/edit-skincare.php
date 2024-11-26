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
    $skincareid = $_POST["skincareid"];    
    $productid = $_POST["productid"];
    $skincarequantity = $_POST["skincarequantity"];
    $aid = $_POST["aid"];  // Admin ID

    // Fetch the product name based on the product ID
    $sql = "SELECT productname FROM product WHERE productid = '$productid'";
    $result = $database->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $productname = $row["productname"];  // Get the product name for reference

        // Update the existing skincare record in the `skincare` table
        $sql = "UPDATE skincare 
                SET productid = '$productid', 
                    skincarequantity = '$skincarequantity', 
                    aid = '$aid' 
                WHERE skincareid = '$skincareid'";

        // Execute the update query and redirect
        if ($database->query($sql) === TRUE) {
            header("location: skincare.php?action=edited&name=$productname&id=$skincareid");
        } else {
            echo "Error: " . $sql . "<br>" . $database->error;
        }
    } else {
        echo "Product not found.";
    }
} else {
    // If no POST data, redirect to skincare.php
    header("location: skincare.php");
}
