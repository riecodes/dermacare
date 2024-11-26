<?php



//import database
include "../connection.php";



if ($_POST) {
    //print_r($_POST);
    $result = $database->query("SELECT * FROM webuser");
    $name = $_POST['name'];
    $oldemail = $_POST["oldemail"];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $tele = $_POST['Tele'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $id = $_POST['id00'];

    if ($password == $cpassword) {
        $error = '3';

        $sqlmain = "SELECT admin.aid FROM admin INNER JOIN webuser ON admin.aemail=webuser.email WHERE webuser.email=?;";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        //$resultqq= $database->query("SELECT * FROM doctor WHERE docid='$id';");
        $id2 = ($result->num_rows == 1) ? $result->fetch_assoc()["aid"] : $id;

        if ($id2 != $id) {
            $error = '1';
            //$resultqq1= $database->query("SELECT * FROM doctor WHERE docemail='$email';");
            //$did= $resultqq1->fetch_assoc()["docid"];
            //if($resultqq1->num_rows==1){

        } else {

            
            $sql1 = "UPDATE admin SET aemail='$email',aname='$name',apassword='$password',atel='$tele',aaddress='$address' WHERE aid=$id ;";
            $database->query($sql1);
            echo $sql1;
            $sql1 = "UPDATE webuser SET email='$email' WHERE email='$oldemail' ;";
            $database->query($sql1);
            echo $sql1;

            $error = '4';
        }
    } else {
        $error = '2';
    }
} else {
    //header('location: signup.php');
    $error = '3';
}


header("location: settings.php?action=edit&error=$error&id=$id");
?>



</body>

</html>