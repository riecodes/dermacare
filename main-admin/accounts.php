<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/animations.css">  
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/admin.css">
        
    <title>Branch Admins</title>
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

    //learn from w3schools.com
    
    session_start();

    if (isset($_SESSION["user"])) {
        if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'm') {
            header("location: ../login.php");
        } else {
            $useremail = $_SESSION["user"];
        }

    } else {
        header("location: ../login.php");
    }



    //import database
    include("../connection.php");
    include("../includes/display-maccount.php");

    ?>

    <div class="container">
    <?php include("../includes/sidebar-madmin.php"); ?>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;padding-top: 15px;">
                <tr >
                    <td width="13%">
                        <a href="index.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <form action="accounts.php" method="post" class="header-search">

                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Search a Branch Name or Email" list="admin">&nbsp;&nbsp;

                            <?php
                            echo '<datalist id="admin">';
                            $list11 = $database->query("select  aname, aemail from  admin;");

                            for ($y = 0; $y < $list11->num_rows; $y++) {
                                $row00 = $list11->fetch_assoc();
                                $d = $row00["aname"];
                                $c = $row00["aemail"];
                                echo "<option value='$d'><br/>";
                                echo "<option value='$c'><br/>";
                            }
                            ;

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

                            $date = date('Y-m-d');
                            echo $date;
                            ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label" style="display: flex; justify-content: center; align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>

                <tr >
                    <td colspan="2" style="padding-top:30px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Add New Branch Admin</p>
                    </td>

                    <td colspan="2">
                        <a href="?action=add&id=none&error=0" class="non-style-link">
                            <button  class="login-btn btn-primary btn button-icon" style="display: flex;justify-content: center;align-items: center;margin-left:75px;background-image: url('../img/icons/add.svg');">Add New</font></button>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">
                            All Branch Admins (<?php echo $list11->num_rows; ?>)
                        </p>
                    </td>
                </tr>

                <?php

                if ($_POST) {
                    $keyword = $_POST["search"];
                    $sqlmain = "select * from admin where aemail='$keyword' or aname='$keyword' or aname like '$keyword%' or aname like '%$keyword' or aname like '%$keyword%'";
                } else {
                    $sqlmain = "select * from admin order by aid asc";
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
                                            Branch Name
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
                                                    <img src="../img/notfound.svg" width="25%"> <br>
                                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                                    <a class="non-style-link" href="accounts.php"><button  class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Branch Admins &nbsp;</font></button>
                                                    </a>
                                                    </center>
                                                <br><br><br><br>
                                                </td>
                                            </tr>';

                                    } else {
                                        for ($x = 0; $x < $result->num_rows; $x++) {
                                            $row = $result->fetch_assoc();
                                            $aid = $row["aid"];
                                            $name = $row["aname"];
                                            $email = $row["aemail"];
                                            $password = $row["apassword"];
                                            echo '
                                            
                                            <tr>
                                                <td> ' . $name . '</td>
                                                <td> ' . $email  . ' </td>

                                                <td>
                                                    <div style="padding: 10px; display: flex; justify-content: center; gap: 20px">
                                                        <a href="?action=edit&id=' . $aid . '&error=0" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-edit"><font class="tn-in-text">Edit</font></button></a>
                                                        
                                                        <a href="?action=view&id=' . $aid . '" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"><font class="tn-in-text">View</font></button></a>
                                                        
                                                        <a href="?action=drop&id=' . $aid . '&name=' . $name . '" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-delete" ><font class="tn-in-text">Remove</font></button></a>
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
    <?php
    if ($_GET) {

        $id = $_GET["id"];
        $action = $_GET["action"];

        // DROP //
        // DROP //
        // DROP //
        // DROP //
        // DROP //
        // DROP //
        // DROP //

        if ($action == 'drop') {
            $nameget = $_GET["name"];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="accounts.php">&times;</a>
                        <div class="content">
                            You want to delete this record<br>(' . substr($nameget, 0, 40) . ').
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-admin.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="accounts.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            ';

            // VIEW //
            // VIEW //
            // VIEW //
            // VIEW //
            // VIEW //
            // VIEW //
            // VIEW //

        } elseif ($action == 'view') {
            $sqlmain = "select * from admin where aid='$id'";
            $result = $database->query($sqlmain);
            $row = $result->fetch_assoc();
            $name = $row["aname"];
            $email = $row["aemail"];
            $password = $row["apassword"];
            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <h2></h2>
                        <a class="close" href="accounts.php">&times;</a>
                        <div class="content">
                           <br>
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Name: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    ' . $name . '<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Email: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ' . $email . '<br><br>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <a href="accounts.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                </td>
                            </tr>
                        </table>
                        </div>
                    </center>
                    <br><br>
                </div>
            </div>
            ';

            // ADD //
            // ADD //
            // ADD //
            // ADD //
            // ADD //
            // ADD //
            
        } elseif ($action == 'add') {
            $error_1 = $_GET["error"];
            $errorlist = array(
                '1' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>',
                '2' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Conformation Error! Reconform Password</label>',
                '3' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
                '4' => "",
                '0' => '',

            );
            if ($error_1 != '4') {
                echo '
                    <div id="popup1" class="overlay">
                        <div class="popup">
                            <center>
                            <a class="close" href="accounts.php">&times;</a> 
                            <div style="display: flex;justify-content: center;">
                                <div class="abc">
                                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                        <tr>
                                            <td class="label-td" colspan="2">' . $errorlist[$error_1] . '</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Branch Admin.</p><br><br>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <form action="add-admin.php" method="POST" class="add-new-form">
                                            <td class="label-td" colspan="2">
                                                <label for="name" class="form-label">Name: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="text" name="name" class="input-text" placeholder="Branch Name" required><br>
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="Email" class="form-label">Email: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="email" name="email" class="input-text" placeholder="Email Address" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="password" class="form-label">Password: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="password" name="password" class="input-text" placeholder="Defind a Password" required><br>
                                            </td>
                                        </tr><tr>
                                            <td class="label-td" colspan="2">
                                                <label for="cpassword" class="form-label">Conform Password: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="password" name="cpassword" class="input-text" placeholder="Conform Password" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            
                                                <input type="submit" value="Add" class="login-btn btn-primary btn">
                                            </td>
                                        </tr>
                                        </form>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </center>
                        <br><br>
                        </div>
                    </div>
                ';
            }else {
                echo '
                    <div id="popup1" class="overlay">
                            <div class="popup">
                            <center>
                            <br><br><br><br>
                                <h2>New Record Added Successfully!</h2>
                                <a class="close" href="accounts.php">&times;</a>
                                <div class="content">
                                    
                                    
                                </div>
                                <div style="display: flex;justify-content: center;">
                                
                                <a href="accounts.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>

                                </div>
                                <br><br>
                            </center>
                    </div>
                    </div>
                    ';
            }

            // EDIT //
            // EDIT //
            // EDIT //
            // EDIT //
            // EDIT //
            // EDIT //

        } elseif ($action == 'edit') {
            $sqlmain = "select * from admin where aid='$id'";
            $result = $database->query($sqlmain);
            $row = $result->fetch_assoc();
            $name = $row["aname"];
            $email = $row["aemail"];

            $error_1 = $_GET["error"];
            $errorlist = array(
                '1' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>',
                '2' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Conformation Error! Reconform Password</label>',
                '3' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
                '4' => "",
                '0' => '',

            );

            if ($error_1 != '4') {
                echo '
                    <div id="popup1" class="overlay">
                        <div class="popup">
                        <center>
                            <a class="close" href="accounts.php">&times;</a> 
                            <div style="display: flex;justify-content: center;">
                                <div class="abc">
                                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                        <tr>

                                            <td class="label-td" colspan="2">' . $errorlist[$error_1] . '</td>
                                            
                                        </tr>
                                        <tr>

                                            <td>
                                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">
                                                    Edit Branch Admin Details.
                                                </p>

                                              <br><br>
                                            </td>

                                        </tr>                                        
                                        <tr>
                                            
                                            <td class="label-td" colspan="2">
                                                <label for="name" class="form-label">Branch Name: </label>
                                            </td>

                                        </tr>
                                        <tr>

                                            <td class="label-td" colspan="2">
                                            <form action="edit-admin.php" method="POST" class="add-new-form">
                                                <input type="text" name="name" class="input-text" placeholder="Branch Name" value="' . $name . '" ><br>
                                            </td>
                                            
                                        </tr>
                                        <tr>

                                            <td class="label-td" colspan="2">
                                                <label for="Email" class="form-label">Email: </label>
                                                <input type="hidden" value="' . $id . '" name="id00">
                                                <input type="hidden" name="oldemail" value="' . $email . '" >
                                            </td>

                                        </tr>
                                        <tr>

                                            <td class="label-td" colspan="2">
                                                <input type="email" name="email" class="input-text" placeholder="Email Address" value="' . $email . '" ><br>
                                            </td>

                                        </tr>                                        
                                        <tr>

                                            <td class="label-td" colspan="2">
                                                <label for="password" class="form-label">Password: </label>
                                            </td>

                                        </tr>
                                        <tr>

                                            <td class="label-td" colspan="2">
                                                <input type="password" name="password" class="input-text" placeholder="Defind a Password" ><br>
                                            </td>

                                        </tr>
                                        <tr>

                                            <td class="label-td" colspan="2">
                                                <label for="cpassword" class="form-label">Conform Password: </label>
                                            </td>

                                        </tr>
                                        <tr>

                                            <td class="label-td" colspan="2">
                                                <input type="password" name="cpassword" class="input-text" placeholder="Conform Password" ><br>
                                            </td>

                                        </tr>
                                        
                                        <tr>

                                            <td colspan="2">

                                                <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="submit" value="Save" class="login-btn btn-primary btn">

                                            </td>
                            
                                        </tr>
                                    
                                        </form>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </center>
                        <br><br>
                        </div>
                    </div>
                    ';
            } else {
                echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                        <br><br><br><br>
                        <h2>Edit Successfully!</h2>
                        <a class="close" href="accounts.php">&times;</a>
                        <div class="content">
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                            <a href="accounts.php" class="non-style-link">
                                <button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                                    <font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font>
                                </button>
                            </a>
                        </div>
                        <br><br>
                        </center>
                    </div>
                </div> 
                ';
            };
        };
    };

    ?>
    </div>

</body>
</html>