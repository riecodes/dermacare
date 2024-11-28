<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/animations.css">
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/admin.css">

    <title>Therapists</title>
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
    include("../includes/display-aaccount.php");

    ?>
    <div class="container">
        <?php include("../includes/sidebar-aadmin.php") ?>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr>
                    <td width="13%">
                        <a href="doctors.php"><button class="login-btn btn-primary-soft btn btn-icon-back"
                                style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                                <font class="tn-in-text">Back</font>
                            </button></a>
                    </td>
                    <td>
                        <form action="" method="post" class="header-search" style="display: flex; gap: 20px;">

                            <input 
                            type="search" 
                            name="search" 
                            class="input-text header-searchbar"
                            placeholder="Search Therapist name or Email" 
                            list="doctors">

                            <?php
                            echo '
                            <datalist id="doctors">';

                            $list11 = $database->query("SELECT docname, docemail FROM doctor WHERE aid = $userid;");

                            for ($y = 0; $y < $list11->num_rows; $y++) {
                                $row00 = $list11->fetch_assoc();
                                $d = $row00["docname"];
                                $c = $row00["docemail"];
                                echo "<option value='$d'><br/>";
                                echo "<option value='$c'><br/>";
                            };

                            echo ' 
                            </datalist>';
                            ?>

                            <input 
                            type="Submit" 
                            value="Search" 
                            class="login-btn btn-primary btn"
                            style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">

                        </form>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php
                            date_default_timezone_set('Asia/Kolkata');

                            $date = date('Y-m-d');
                            echo $date;
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
                            <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Add A Therapist</div>
                            <a href="?action=add&id=' . $reserveid . '&error=0" class="non-style-link"><button class="login-btn btn-primary btn button-icon" style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add New</font></button>
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All
                            Therapists (<?php echo $list11->num_rows; ?>)
                        </p>
                    </td>
                </tr>

                <?php
                if ($_POST) {
                    $keyword = $_POST["search"];

                    $sqlmain = "SELECT * FROM doctor WHERE aid = $userid and docemail='$keyword' or docname='$keyword' or docname like '$keyword%' or docname like '%$keyword' or docname like '%$keyword%'";
                } else {
                    $sqlmain = "SELECT * FROM doctor WHERE aid = $userid ORDER BY docid ASC";

                }
                ?>

                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" border="0">
                                    <thead>
                                        <tr>
                                            <th class="table-heading">
                                                Therapist Name
                                            </th>
                                            <th class="table-heading">
                                                Email
                                            </th>
                                            <th class="table-heading">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php

                                    $result = $database->query($sqlmain);

                                    if ($result->num_rows == 0) {
                                        echo '
                                        <tr>
                                            <td colspan="4">

                                            <br><br><br><br>

                                            <center>
                                            <img src="../img/notfound.svg" width="25%">

                                            <br>

                                            <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">
                                                We  couldnt find anything related to your keywords !
                                            </p>
                                            <a class="non-style-link" href="doctors.php">
                                                <button  class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">
                                                    <font>
                                                        &nbsp; Show all Therapists &nbsp;
                                                    </font>
                                                </button>
                                            </a>
                                            </center>

                                            <br><br><br><br>

                                            </td>
                                        </tr>';

                                    } else {
                                        for ($x = 0; $x < $result->num_rows; $x++) {
                                            $row = $result->fetch_assoc();
                                            $docid = $row["docid"];
                                            $name = $row["docname"];
                                            $email = $row["docemail"];                                                                                        
                                        echo 
                                        '<tr>
                                            <td style="padding: 10px;"> 
                                                ' . substr($name, 0, 30) . '
                                            </td>
                                            <td>
                                                ' . substr($email, 0, 20) . '
                                            </td>
                                            <td style="padding: 10px;">
                                                <div style="display:flex; justify-content: center; gap: 10px; align-items: center;">                                                
                                                    <a href="?action=edit&id=' . $docid . '&error=0" class="non-style-link">
                                                        <button class="btn-primary-soft btn button-icon btn-edit">
                                                            <font class="tn-in-text">
                                                                Edit
                                                            </font>
                                                        </button>
                                                    </a>
                                                    <a href="?action=view&id='.$docid.'" class="non-style-link">
                                                        <button  class="btn-primary-soft btn button-icon btn-view">
                                                            <font class="tn-in-text">
                                                                View
                                                            </font>
                                                        </button>
                                                    </a>
                                                    
                                                    <a href="?action=drop&id='.$docid.'&name='.$name.'" class="non-style-link">
                                                        <button  class="btn-primary-soft btn button-icon btn-delete">
                                                            <font class="tn-in-text">
                                                            Remove
                                                            </font>
                                                        </button>
                                                    </a>
                                                </div>
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
            </table>
        </div>
    </div>

    <?php include("../includes/get-doctor.php") ?>
    
    </div>

</body>

</html>