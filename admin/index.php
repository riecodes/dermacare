<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/animations.css">
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/admin.css?v=3">

    <title>Dashboard</title>
    <style>
        .dashbord-tables {
            animation: transitionIn-Y-over 0.5s;
        }

        .filter-container {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>


</head>

<body>
    <?php

    //learn from w3schools.com

    session_start();

    if (isset($_SESSION["user"])) {
        if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'a') {
            header("location: ../login.php");
        } else {
            $useremail = $_SESSION["user"];
        }
    } else {
        header("location: ../login.php");
    }


    //import database
    include("../connection.php");
    include("../includes/display-aaccount.php")


    ?>
    <div class="container">
        <?php include("../includes/sidebar-aadmin.php") ?>
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;">
                <tr>
                    <td colspan="2" class="nav-bar">
                        <form action="doctors.php" method="post" class="header-search">
                            
                            <?php
                            echo '<datalist id="doctors">';
                            $list11 = $database->query("SELECT  docname,docemail FROM  doctor WHERE aid = $userid;");

                            for ($y = 0; $y < $list11->num_rows; $y++) {
                                $row00 = $list11->fetch_assoc();
                                $d = $row00["docname"];
                                $c = $row00["docemail"];
                                echo "<option value='$d'><br/></option>";
                                echo "<option value='$c'><br/></option>";
                            };

                            echo ' </datalist>';
                            ?>

                        </form>

                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php
                            date_default_timezone_set('Asia/Kolkata');

                            $today = date('Y-m-d');
                            echo $today;

                            $doctorrow = $database->query("SELECT * FROM  doctor;");
                            $patientrow = $database->query("SELECT * FROM  patient;");
                            $appointmentrow = $database->query("SELECT * FROM  appointment where appodate>='$today';");
                            $schedulerow = $database->query("SELECT * FROM  schedule where scheduledate='$today';");

                            ?>
                        </p>
                    </td>
                    <td width="10%">
                        <div style="display: flex;justify-content: center;align-items: center;">
                            <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                            <a href="settings.php">
                                <button class="btn-label btn" style="display: flex; justify-content: center; align-items: center; cursor: pointer;"><img src="../img/icons/accountsettings.svg" width="100%"></button>
                            </a>
                        </div>                        
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <table class="filter-container doctor-header" style="border: none;width:95%" border="0">
                                <tr>
                                    <td>
                                        <h3>Welcome!</h3>
                                        <h1><?php echo $username  ?>.</h1>
                                        <p>Thanks for joining with us. We are always trying to get you a complete service<br>
                                            You can view your dailly schedule, Reach Patients Appointment at home!<br><br>
                                        </p>
                                        <a href="appointment.php" class="non-style-link"><button class="btn-primary btn" style="width:30%">View My Appointments</button></a>
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </table>
                        </center>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table width="100%" border="0" class="dashbord-tables">                    
                            <tr>
                                <td width="50%">
                                    <center>
                                        <div class="abc scroll" style="height: 200px;">
                                            <table width="93%" class="sub-table scrolldown" border="0">
                                                <thead>
                                                    <tr>
                                                        <th class="table-heading">
                                                            Patient name
                                                        </th>
                                                        <th class="table-heading">
                                                            Therapist
                                                        </th>
                                                        <th class="table-heading">
                                                            Treatment Name
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $nextweek = date("Y-m-d", strtotime("+1 week"));
                                                    $sqlmain = "SELECT appointment.*, doctor.docname, patient.pname, treatment.treatmentname
                                                                FROM appointment 
                                                                INNER JOIN schedule ON schedule.scheduleid = appointment.scheduleid 
                                                                INNER JOIN patient ON patient.pid = appointment.pid 
                                                                INNER JOIN doctor ON schedule.docid = doctor.docid
                                                                INNER JOIN treatment ON schedule.treatmentid = treatment.treatmentid
                                                                WHERE schedule.scheduledate >= '$today' AND schedule.scheduledate <= '$nextweek' AND schedule.aid = $userid
                                                                ORDER BY appodate DESC";

                                                    $result = $database->query($sqlmain);

                                                    if ($result->num_rows == 0) {
                                                        echo '<tr>
                                                    <td colspan="3">
                                                    <br><br><br><br>
                                                    <center>
                                                    <img src="../img/notfound.svg" width="25%">
                                                    
                                                    <br>
                                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                                    <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Appointments &nbsp;</font></button>
                                                    </a>
                                                    </center>
                                                    <br><br><br><br>
                                                    </td>
                                                    </tr>';
                                                    } else {
                                                        for ($x = 0; $x < $result->num_rows; $x++) {
                                                            $row = $result->fetch_assoc();
                                                            $appoid = $row["appoid"];
                                                            $scheduleid = $row["scheduleid"];
                                                            $treatmentname = $row["treatmentname"];
                                                            $docname = $row["docname"];
                                                            $pname = $row["pname"];
                                                            $apponum = $row["apponum"];
                                                            $appodate = $row["appodate"];
                                                            echo '<tr style="text-align: center;">


                                                      
                                                        <td style="text-align:center;font-size:18px;font-weight:600; padding:20px;"> 
                                                            &nbsp;' . substr($pname, 0, 25) . '
                                                        </td >
                                                        <td style="text-align:center;font-size:18px;font-weight:400; padding:20px;"> 
                                                            &nbsp;' . substr($docname, 0, 25) . '
                                                        </td >
                                                        <td>
                                                            ' . substr($treatmentname, 0, 15) . '
                                                        </td>

                                                    </tr>';
                                                        }
                                                    }

                                                    ?>

                                                </tbody>

                                            </table>
                                        </div>
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center>
                                        <a href="appointment.php" class="non-style-link"><button class="btn-primary btn" style="width:93%">Show all Appointments</button></a>
                                    </center>
                                </td>
                            </tr>                            
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top: 50px;">
                        <table width="100%" border="0" class="dashbord-tables">                    
                            <tr>
                                <td>
                                    <center>
                                        <div class="abc scroll" style="height: 200px;">
                                            <table width="92.5%" class="sub-table scrolldown" border="0">
                                                <thead>
                                                    <tr>

                                                        <th class="table-heading">
                                                            Product Name
                                                        </th>
                                                        <th class="table-heading">
                                                            Reserve Quantity
                                                        </th>
                                                        <th class="table-heading">
                                                            Status
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $nextweek = date("Y-m-d", strtotime("+1 week"));
                                                    $sqlmain = "SELECT 
                                                    reserve.*, product.productname
                                                                FROM reserve
                                                                INNER JOIN product ON product.productid = reserve.productid
                                                                WHERE reserve.aid = $userid AND status = 'Pending'";

                                                    $result = $database->query($sqlmain);

                                                    if ($result->num_rows == 0) {
                                                        echo '<tr>
                                                    <td colspan="3">
                                                    <br><br><br><br>
                                                    <center>
                                                    <img src="../img/notfound.svg" width="25%">
                                                    
                                                    <br>
                                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                                    <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Appointments &nbsp;</font></button>
                                                    </a>
                                                    </center>
                                                    <br><br><br><br>
                                                    </td>
                                                    </tr>';
                                                    } else {
                                                        for ($x = 0; $x < $result->num_rows; $x++) {
                                                            $row = $result->fetch_assoc();
                                                            $reserveid = $row["reserveid"];
                                                            $productid = $row["productid"];
                                                            $reservequantity = $row["reservequantity"];
                                                            $productname = $row["productname"];
                                                            $status = $row["status"];
                                                            echo '<tr style="text-align: center;">



                                                        <td style="text-align:center;font-size:18px;font-weight:600; padding:20px;"> 
                                                            &nbsp;' . substr($productname, 0, 25) . '
                                                        </td >
                                                        <td>
                                                            ' . substr($reservequantity, 0, 15) . '
                                                        </td>
                                                        <td>
                                                            ' . substr($status, 0, 15) . '
                                                        </td>

                                                    </tr>';
                                                        }
                                                    }

                                                    ?>

                                                </tbody>

                                            </table>
                                        </div>
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center>
                                        <a href="skincare.php" class="non-style-link"><button class="btn-primary btn" style="width:92.5%">Show all Reserves</button></a>
                                    </center>
                                </td>
                            </tr>                            
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>