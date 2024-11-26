<?php

// Import database
include "../connection.php";

if ($_POST) {
    $name = $_POST['name'];
    $oldemail = $_POST["oldemail"];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $page = $_POST['page'];
    $psex = $_POST['psex'];
    $id = $_POST['id00'];

    if ($password == $cpassword) {
        $error = '3';
        $result = $database->query("SELECT patient.pid 
                                    FROM patient 
                                    INNER JOIN webuser 
                                    ON patient.pemail = webuser.email 
                                    WHERE webuser.email = '$email';");
        $id2 = ($result->num_rows == 1) ? $result->fetch_assoc()["pid"] : $id;

        if ($id2 != $id) {
            $error = '1';
        } else {
            $sql1 = "UPDATE patient 
                     SET pemail='$email', pname='$name', ppassword='$password', ptel='$tel', pdob='$dob', paddress='$address', page='$page', psex='$psex' 
                     WHERE pid=$id;";
            $database->query($sql1);

            $sql1 = "UPDATE webuser 
                     SET email='$email' 
                     WHERE email='$oldemail';";
            $database->query($sql1);

            $error = '4';
        }
    } else {
        $error = '2';
    }
} else {
    $error = '3';
}

header("location: patient.php?action=edit&error={$error}&id={$id}");
