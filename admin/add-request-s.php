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
    $stockid = $_POST["stockid"];
    $requestquantity = $_POST["requestquantity"];
    $requestdate = $_POST["date"]; // Correct field name is 'date' from form
    $status = 'Pending'; // Default status when creating a new request
    $aid = $_POST["aid"];

    // Fetch stockname based on stockid
    $sql = "SELECT stockname FROM stock WHERE stockid = '$stockid'";
    $result = $database->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stockname = $row["stockname"]; // Extract stockname

        // SQL query to insert data into request table
        $sql = "INSERT INTO request (stockid, requestquantity, requestdate, status, aid) 
                VALUES ('$stockid', '$requestquantity', '$requestdate', '$status', '$aid')";

        // Execute the query and redirect
        if ($database->query($sql) === TRUE) {
            header("location: request-s.php?action=added&name=$stockname&id=$stockid");
        } else {
            echo "Error: " . $sql . "<br>" . $database->error;
        }
    } else {
        echo "Product not found.";
    }
}

