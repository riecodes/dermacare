<?php

// Start session and check user type
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"] == "" || $_SESSION['usertype'] != 'm') {
    header("location: ../login.php");
    exit();
}

// Import database connection
include("../connection.php");

if ($_POST) {
    // Extract POST data
    $name = $_POST['name'];          // Branch name
    $oldemail = $_POST['oldemail'];  // Old email for verification
    $email = $_POST['email'];        // New email
    $password = $_POST['password'];  // Password
    $cpassword = $_POST['cpassword']; // Confirm password
    $id = $_POST['id00'];            // Admin ID

    // Initialize error code
    $error = '3';

    // Check if passwords match
    if ($password == $cpassword) {
        // Query to check if the email is already used by another admin
        $result = $database->query("SELECT admin.aid FROM admin INNER JOIN webuser ON admin.aemail = webuser.email WHERE webuser.email='$email'");
        
        // Fetch the ID associated with the email
        if ($result->num_rows == 1) {
            $id2 = $result->fetch_assoc()["aid"];
        } else {
            $id2 = $id;
        }
        
        // If the email is used by another admin, show error
        if ($id2 != $id) {
            $error = '1';
        } else {
            // Build the update query dynamically to update only non-empty fields
            $updates = [];
            if (!empty($name)) {
                $updates[] = "aname='$name'";  // Update the branch name
            }
            if (!empty($password)) {
                $updates[] = "apassword='$password'";  // Update the password
            }
            if (!empty($email)) {
                $updates[] = "aemail='$email'";  // Update the email
            }

            // If any fields need updating, execute the update query
            if (!empty($updates)) {
                $sql1 = "UPDATE admin SET " . implode(', ', $updates) . " WHERE aid=$id";
                $database->query($sql1);

                // Update email in the webuser table if the email has changed
                if (!empty($email)) {
                    $sql2 = "UPDATE webuser SET email='$email' WHERE email='$oldemail'";
                    $database->query($sql2);
                }

                // Set success error code
                $error = '4';
            }
        }
    } else {
        // Password confirmation error
        $error = '2';
    }
} else {
    // No POST data received
    $error = '3';
}

// Redirect back to accounts.php with the error code and ID
header("location: accounts.php?action=edit&error=" . $error . "&id=" . $id);
exit();

