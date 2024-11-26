<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/animations.css">
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/admin.css">

    <title>Inventory</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table {
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
                <tr>
                    <td width="13%">
                        <a href="reserve.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                                <font class="tn-in-text">Back</font>
                            </button></a>
                    </td>
                    <td>
                        <form action="" method="post" class="header-search" style="display: flex; gap: 20px;">
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Reserved Products" list="products">
                            <datalist id="products">
                                <?php
                                $list110 = $database->query("SELECT productid FROM reserve WHERE aid = $userid;");

                                while ($row00 = $list110->fetch_assoc()) {
                                    $productid = $row00["productid"];
                                    $sqlmain = $database->query("SELECT productname FROM product WHERE productid = '$productid'");
                                    if ($result = $sqlmain->fetch_assoc()) {
                                        $name = $result["productname"];
                                        echo "<option value='" . htmlspecialchars($name, ENT_QUOTES) . "'>";
                                    }
                                }
                                ?>
                            </datalist>
                            <input type="submit" value="Search" class="login-btn btn-primary btn" style="padding: 10px 25px;">
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

                            $list110 = $database->query("select  * from  reserve WHERE aid = $userid;");                            

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
                        <div style="display: flex;margin-top: 40px;">
                            <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Reserve Manager</div>
                            <a href="?action=add&id=none&error=0" class="non-style-link"><button class="login-btn btn-primary btn button-icon" style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add a Reserve</font></button>
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Reserve Products (<?php echo $list110->num_rows; ?>)</p>
                    </td>
                </tr>

                <?php
                $keyword = isset($_POST["search"]) ? $database->real_escape_string($_POST["search"]) : '';

                if (!empty($keyword)) {
                    // Joining reserve with product to get the productname
                    $sqlmain = "
                        SELECT reserve.*, product.productname
                        FROM reserve
                        INNER JOIN product ON reserve.productid = product.productid
                        WHERE reserve.aid = $userid AND (
                            product.productname = '$keyword' OR
                            product.productname LIKE '$keyword%' OR
                            product.productname LIKE '%$keyword' OR
                            product.productname LIKE '%$keyword%'
                        )";
                } else {
                    // Default query to fetch reserves for the user
                    $sqlmain = "
                        SELECT reserve.*, product.productname
                        FROM reserve
                        INNER JOIN product ON reserve.productid = product.productid
                        WHERE reserve.aid = $userid
                        ORDER BY reserve.pickupdate DESC";
                }

                $result = $database->query($sqlmain);
                ?>


                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" border="0">
                                    <thead>
                                        <tr>
                                            <th class="table-heading">Product Name</th>
                                            <th class="table-heading">Reserve Quantity</th>
                                            <th class="table-heading">Pickup Date</th>
                                            <th class="table-heading">Status</th>
                                            <th class="table-heading">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php


                                    if ($result->num_rows == 0) {
                                    echo '

                                        <tr>
                                            <td colspan="7">
                                            <br><br><br><br>
                                            <center>
                                            <img src="../img/notfound.svg" width="25%">
                                            <br>
                                            <p class="heading-main12" style="margin-left: 45px; font-size:20px; color:rgb(49, 49, 49)">
                                                We couldn\'t find any products for you!
                                            </p>
                                            <a class="non-style-link" href="inventory.php">
                                                <button class="login-btn btn-primary-soft btn" style="display: flex; justify-content: center; align-items: center; margin-left:20px;">
                                                    <font>&nbsp; Show all Reserves &nbsp;</font>
                                                </button>
                                            </a>
                                            </center>
                                            <br><br><br><br>
                                            </td>
                                        </tr>
                                    
                                    ';

                                    } else {

                                    for ($x = 0; $x < $result->num_rows; $x++) {
                                        $row = $result->fetch_assoc();
                                        $reserveid = $row["reserveid"];
                                        $productid = $row["productid"];
                                        $productname = $row["productname"];
                                        $pickupdate = $row["pickupdate"]; 
                                        $status = $row["status"];
                                        $reservequantity = $row["reservequantity"];                                                                            
                                            
                                    echo '
                                        <tr>
                                            <td>' . $productname . '</td>
                                            <td>' . $reservequantity . '</td>
                                            <td>' . $pickupdate . '</td>
                                            <td>' . $status . '</td>
                                            <td style="padding: 10px;">
                                                <div style="display:flex; justify-content: center; gap: 10px; align-items: center;">

                                                    <a href="?action=drop&id=' . $reserveid . '&name=' . $productname . '" class="non-style-link">
                                                        <button class="btn-primary-soft btn button-icon btn-delete">
                                                            <font class="tn-in-text">Cancel</font>
                                                        </button>
                                                    </a>
                                                    <a href="?action=edit&id=' . $reserveid . '&name=' . $productname . '" class="non-style-link">
                                                        <button class="btn-primary-soft btn button-icon btn-edit">
                                                            <font class="tn-in-text">Done</font>
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
    <?php include("../includes/get-reserve.php") ?>
    </div>
</body>
</html>