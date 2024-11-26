<?php
    session_start();

    // Check if user is logged in and has the correct user type
    if(isset($_SESSION["user"])){
        if(($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'a'){
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
        $age = $_POST['page'];
        $sex = $_POST['psex'];
        $tel = $_POST['tel'];
        $address = $_POST['address'];
        $dob = $_POST['dob'];

        // Initialize error variable
        $error = '3'; // Default error code for no input

        // Check if passwords match
        if ($password == $cpassword) {
            // Check if the email is already in use
            $result = $database->query("SELECT * FROM webuser WHERE email='$email'");
            
            if ($result->num_rows == 1) {
                $error = '1'; // Email already in use
            } else {
                // Insert new patient into the database
                $sql1 = "INSERT INTO patient (pname, pemail, ppassword, page, psex, ptel, paddress, pdob) 
                         VALUES ('$name', '$email', '$password', '$age', '$sex', '$tel', '$address', '$dob')";
                $sql2 = "INSERT INTO webuser (email, usertype) VALUES ('$email', 'p')";
                
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

    // Redirect to patient.php with error code
    header("location: patient.php?action=add&error=".$error);
    exit();

