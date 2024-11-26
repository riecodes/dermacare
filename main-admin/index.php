<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/animations.css">  
    <link rel="stylesheet" href="../style/main.css">  
    <link rel="stylesheet" href="../style/admin.css">
        
    <title>Dashboard</title>
    <style>
        .dashbord-tables{
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container{
            animation: transitionIn-Y-bottom  0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
    
    
</head>
<body>
    <?php

    //learn from w3schools.com

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='m'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    

    //import database
    include("../connection.php");
    include("../includes/display-maccount.php")

    
    ?>
    <div class="container">

        <?php include("../includes/sidebar-madmin.php"); ?>

        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top: 15px" >
                        
                <tr >
                    
                    <td colspan="2" class="nav-bar" >
                        
                        <form action="doctors.php" method="post" class="header-search">

                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Search a Branch Admin Name" list="admin">&nbsp;&nbsp;
                            
                            <?php
                                echo '<datalist id="admin">';
                                $list11 = $database->query("select  aname, aemail from  admin;");

                                for ($y=0;$y<$list11->num_rows;$y++){
                                    $row00=$list11->fetch_assoc();
                                    $d=$row00["aname"];
                                    $c=$row00["aemail"];
                                    echo "<option value='$d'><br/>";
                                    echo "<option value='$c'><br/>";
                                };

                            echo ' </datalist>';
                            ?>
                            
                        
                            <input type="Submit" value="Search" class="login-btn btn-primary-soft btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                        
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
                        
                        $badminrow = $database->query("select * from  admin;");
                        $requestrow = $database->query("select * from  request where requestdate='$today';");

                        ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>


                </tr>
                <tr>
                    <td colspan="4">
                        
                        <center>
                        <table class="filter-container" style="border: none;" border="0">
                            <tr>
                                <td colspan="4">
                                    <p style="font-size: 20px;font-weight:600;padding-left: 12px;">Status</p>
                                </td>
                            </tr>
                            <tr>
                            <td style="width: 25%;">
                                    <div  class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex;  display: flex; justify-content: space-between;">
                                        <div>
                                                <div class="h1-dashboard">
                                                    <?php    echo $badminrow->num_rows  ?>
                                                </div><br>
                                                <div class="h3-dashboard">
                                                    Branch Admin Accounts &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                        </div>
                                        <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/persons-blue.svg');"></div>
                                    </div>
                                </td>
                                <td style="width: 25%;">
                                    <div  class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex; display: flex; justify-content: space-between;">
                                        <div>
                                                <div class="h1-dashboard">
                                                    <?php    echo $requestrow->num_rows  ?>
                                                </div><br>
                                                <div class="h3-dashboard">
                                                    Requests Today &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                        </div>
                                        <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/request-hover.svg');"></div>
                                    </div>
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
                                <td>
                                    <p style="padding:10px;padding-left:48px;padding-bottom:0;font-size:23px;font-weight:700;color:var(--primarycolor);">
                                        Branch Admin Accounts
                                    </p>

                                </td>
                                <td>
                                    <p style="text-align:right;padding:10px;padding-right:48px;padding-bottom:0;font-size:23px;font-weight:700;color:var(--primarycolor);">
                                        Request
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <center>
                                    <div class="abc scroll" style="height: 200px;">
                                        <table width="85%" class="sub-table scrolldown" border="0">
                                            <thead>
                                                <tr>    
                                                    <th class="table-heading">
                                                        Branch Name
                                                    </th>
                                                    <th class="table-heading">
                                                        Email
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                                <?php
                                                
                                                $sqlmain= "SELECT aname,aemail FROM admin";

                                                    $result= $database->query($sqlmain);
                    
                                                    if($result->num_rows==0){
                                                        echo '<tr>
                                                        <td colspan="3">
                                                        <br><br><br><br>
                                                        <center>
                                                        <img src="../img/notfound.svg" width="25%">
                                                        
                                                        <br>
                                                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                                        <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Accounts &nbsp;</font></button>
                                                        </a>
                                                        </center>
                                                        <br><br><br><br>
                                                        </td>
                                                        </tr>';
                                                        
                                                    }
                                                    else{
                                                    for ( $x=0; $x<$result->num_rows;$x++){
                                                        $row=$result->fetch_assoc();
                                                        $aname=$row["aname"];
                                                        $aemail=$row["aemail"];
                                                        echo '<tr>

                                                            <td style="font-size:15px;font-weight:500; padding:20px;">
                                                                '.$aname.'
                                                            </td>

                                                            <td style="font-size:15px;font-weight:500; padding:20px;">
                                                                '. $aemail .'
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
                                <td width="50%">
                                    <center>
                                    <div class="abc scroll" style="height: 200px;">
                                        <table width="85%" class="sub-table scrolldown" border="0">
                                            <thead>
                                                <tr>    
                                                    <th class="table-heading">
                                                        Product Name	
                                                    </th>
                                                    <th class="table-heading">
                                                        Admin Name	
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                                <?php
                                                
                                                    $sqlmain = "SELECT *
                                                                FROM request 
                                                                INNER JOIN admin ON request.aid = admin.aid
                                                                INNER JOIN product ON request.productid = product.productid";
                                                                

                                                    $result= $database->query($sqlmain);
                    
                                                    if($result->num_rows==0){
                                                        echo '<tr>
                                                        <td colspan="3">
                                                        <br><br><br><br>
                                                        <center>
                                                        <img src="../img/notfound.svg" width="25%">
                                                        
                                                        <br>
                                                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                                        <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Accounts &nbsp;</font></button>
                                                        </a>
                                                        </center>
                                                        <br><br><br><br>
                                                        </td>
                                                        </tr>';
                                                        
                                                    }
                                                    else{
                                                    for ( $x=0; $x<$result->num_rows;$x++){
                                                        $row=$result->fetch_assoc();
                                                        $productname = $row["productname"];
                                                        $aname = $row["aname"];
                                                        $requestquantity = $row["requestquantity"];
                                                        $requestdate = $row["requestdate"];
                                                        $status = $row["status"];

                                                        echo '<tr>

                                                            <td style="font-size:15px;font-weight:500; padding:20px;">
                                                                '.$productname.'
                                                            </td>

                                                            <td style="font-size:15px;font-weight:500; padding:20px;">
                                                                '. $aname .'
                                                            </td>
                                                            <td style="font-size:15px;font-weight:500; padding:20px;">
                                                                '. $requestquantity .'
                                                            </td>
                                                            <td style="font-size:15px;font-weight:500; padding:20px;">
                                                                '. $requestdate .'
                                                            </td>
                                                            <td style="font-size:15px;font-weight:500; padding:20px;">
                                                                '. $status .'
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
                                        <a href="accounts.php" class="non-style-link"><button class="btn-primary btn" style="width:85%">Show all Accounts</button></a>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <a href="request-i.php" class="non-style-link"><button class="btn-primary btn" style="width:85%">Show all Requests</button></a>
                                    </center>
                                </td>
                            </tr>
                        </table>
                    </td>

                </tr>
                        </table>
                        </center>
                        </td>
                </tr>
            </table>
        </div>
    </div>


</body>
</html>