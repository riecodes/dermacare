<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/animations.css">  
    <link rel="stylesheet" href="../style/main.css">  
    <link rel="stylesheet" href="../style/admin.css">
        
    <title>Request</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
</style>
</head>
<body>
    <?php

    
    
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
    include("../includes/display-aaccount.php");

    ?>
    <div class="container">
        <?php include("../includes/sidebar-aadmin.php") ?>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%" >
                    <a href="schedule.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Request Manager</p>
                                           
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

                            $list110 = $database->query("SELECT * FROM request WHERE aid = $userid AND stockid IS NOT NULL;");
                            
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
                    <td colspan="4" >
                        <div style="display: flex;margin-top: 40px;">
                        <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Request a Product</div>
                        <a href="?action=add&id=' . $requestid . '&error=0" class="non-style-link"><button  class="login-btn btn-primary btn button-icon" style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add a Request</font></button>
                        </a>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;" >
                    
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All Requests (<?php echo $list110->num_rows; ?>)</p>
                    </td>
                    
                </tr>
                
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" border="0">
                                <thead>
                                    <tr>
                                        <th class="table-heading">
                                            Stock Name
                                        </th>
                                        <th class="table-heading">
                                            Request Quantity
                                        </th>
                                        <th class="table-heading">
                                            Request Date
                                        </th>
                                        <th class="table-heading">
                                            Status
                                        </th>
                                        <th class="table-heading">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    // Query to select only the requests for the current logged-in user
                                    $sqlmain = "SELECT request.requestid, admin.aname, stock.stockname, request.requestquantity, request.requestdate, request.status 
                                                FROM request 
                                                INNER JOIN admin ON request.aid = admin.aid
                                                INNER JOIN stock ON request.stockid = stock.stockid
                                                WHERE request.aid = '$userid'
                                                ORDER BY request.requestdate ASC";

                                    $result = $database->query($sqlmain);

                                    if ($result->num_rows == 0) {
                                        echo '
                                        <tr>
                                            <td colspan="7">

                                            <br><br><br><br>
                                            <center>
                                                <img src="../img/notfound.svg" width="25%">

                                                <br>

                                                <p class="heading-main12" style="margin-left: 45px; font-size:20px; color:rgb(49, 49, 49)">
                                                    We couldn\'t find any requests for you!
                                                </p>
                                                <a class="non-style-link" href="request-s.php">
                                                    <button class="login-btn btn-primary-soft btn" style="display: flex; justify-content: center; align-items: center; margin-left:20px;">
                                                        <font>&nbsp; Show all Requests &nbsp;</font>
                                                    </button>
                                                </a>
                                            </center>

                                            <br><br><br><br>

                                            </td>
                                        </tr>';
                                    } else {
                                        for ($x = 0; $x < $result->num_rows; $x++) {
                                            $row = $result->fetch_assoc();
                                            $requestid = $row["requestid"];
                                            $aname = $row["aname"];
                                            $stockname = $row["stockname"];
                                            $requestdate = $row["requestdate"];
                                            $requestquantity = $row["requestquantity"];
                                            $requeststatus = $row["status"];
                                        echo '
                                        <tr>
                                            <td>' . $stockname . '</td>
                                            <td>' . $requestquantity . '</td>
                                            <td>' . $requestdate . '</td>
                                            <td>' . $requeststatus . '</td>
                                            <td style="padding: 10px;">
                                                <div style="display:flex; justify-content: center; gap: 10px; align-items: center;">
                                                    <a href="?action=drop&id=' . $requestid . '&name=' . $stockname . '" class="non-style-link">
                                                        <button class="btn-primary-soft btn button-icon btn-delete">
                                                            <font class="tn-in-text">Remove</font>
                                                        </button>
                                                    </a>                                                       
                                                </div>
                                            </td>
                                        </tr>
                                        ';

                                        }
                                    }
                                    ?>
                                </tbody>
                                </table>
                            </div>
                        </center>
                    </td>
                    </tr>

            </table>
        </div>
    </div>
    <?php include("../includes/get-request-s.php") ?>
    </div>

</body>
</html>