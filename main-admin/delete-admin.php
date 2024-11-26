<?php

session_start();

if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='m'){
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}

// Check if the GET request contains the ID parameter
if (isset($_GET["id"])) {
    // Import database connection
    include("../connection.php");

    $id = $_GET["id"];
    
    // Fetch admin details based on the provided ID
    $result = $database->query("SELECT * FROM admin WHERE aid=$id");
    
    if ($result->num_rows > 0) {
        // Get the email associated with this admin
        $email = ($result->fetch_assoc())["aemail"];

        // First, delete the associated records in the treatment table
        $sqlTreatment = $database->query("DELETE FROM treatment WHERE aid=$id");

        if ($sqlTreatment) {
            // Delete the admin from the webuser table and the admin table
            $sql1 = $database->query("DELETE FROM webuser WHERE email='$email'");
            $sql2 = $database->query("DELETE FROM admin WHERE aid=$id");

            if ($sql1 && $sql2) {
                // Redirect to the admin list if deletion is successful
                header("location: accounts.php?action=delete&status=success");
            } else {
                // Handle SQL failure case
                header("location: accounts.php?action=delete&status=error");
            }
        } else {
            // If unable to delete from treatment table
            header("location: accounts.php?action=delete&status=treatmenterror");
        }
    } else {
        // If no admin is found with the provided ID
        header("location: accounts.php?action=delete&status=notfound");
    }
} else {
    // If the ID is not provided in the GET request
    header("location: accounts.php?action=delete&status=missingid");
}
exit();

?>
