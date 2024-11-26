<?php
session_start();

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}

if ($_POST) {
    // Import database connection
    include("../connection.php");

    // Get form data
    $requestid = $_POST["requestid"];
    $productid = $_POST["productid"];
    $requestquantity = $_POST["requestquantity"];
    $requestdate = $_POST["date"]; // Correct field name is 'date' from form
    $status = 'Pending'; // Default status when creating a new request
    $aid = $_POST["aid"];

    // Fetch productname based on productid
    $sql = "SELECT productname FROM product WHERE productid = '$productid'";
    $result = $database->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $productname = $row["productname"]; // Extract productname

        // SQL query to insert data into request table
        $sql = "INSERT INTO request (productid, requestquantity, requestdate, status, aid) 
                VALUES ('$productid', '$requestquantity', '$requestdate', '$status', '$aid')";

        // Execute the query and redirect
        if ($database->query($sql) === TRUE) {
            header("location: request-i.php?action=added&name=$productname&id=$productid");
        } else {
            echo "Error: " . $sql . "<br>" . $database->error;
        }
    } else {
        echo "Product not found.";
    }
}

