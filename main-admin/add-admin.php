<?php
    session_start();

    // Check if user is logged in and has the correct user type
    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='m'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }

    // Import database connection
    include("../connection.php");

    if ($_POST) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        // Initialize error variable
        $error = '3'; // Default error code for no input

        // Check if passwords match
        if ($password == $cpassword) {
            // Check if the email is already in use
            $result = $database->query("SELECT * FROM webuser WHERE email='$email'");
            
            if ($result->num_rows == 1) {
                $error = '1'; // Email already in use
            } else {
                // Insert new admin into the database
                $sql1 = "INSERT INTO admin (aname, aemail, apassword) VALUES ('$name', '$email', '$password')";
                $sql2 = "INSERT INTO webuser (email, usertype) VALUES ('$email', 'a')";
                
                if ($database->query($sql1) && $database->query($sql2)) {
                    $error = '4'; // Successfully added
                } else {
                    $error = '5'; // Error executing queries
                }
            }
        } else {
            $error = '2'; // Passwords do not match
        }
    } else {
        $error = '3'; // No POST data received
    }

    // Redirect to doctors.php with error code
    header("location: accounts.php?action=add&error=".$error);
    exit();
