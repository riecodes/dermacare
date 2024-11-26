<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/animations.css">
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/admin.css">
    <title>Appointments</title>
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

    // Check if the user is logged in and is of type 'admin'
    if (isset($_SESSION["user"])) {
        if (empty($_SESSION["user"]) || $_SESSION['usertype'] != 'a') {
            header("Location: ../login.php");
            exit();
        } else {
            $useremail = $_SESSION["user"];
        }
    } else {
        header("Location: ../login.php");
        exit();
    }

    // Import database connection and necessary includes
    include("../connection.php");
    include("../includes/display-aaccount.php");

    // Set timezone and fetch current date
    date_default_timezone_set('Asia/Kolkata');
    $today = date('Y-m-d');

    // Get the count of all appointments
    $list110 = $database->query("SELECT * FROM appointment WHERE aid = $userid;");
    $appointmentCount = $list110 ? $list110->num_rows : 0;
    ?>
    
    <div class="container">
        <?php include("../includes/sidebar-aadmin.php"); ?>
        
        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0; margin: 0; padding: 0; margin-top: 25px;">
                <tr>
                    <td width="13%">
                        <a href="appointment.php">
                            <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top: 11px; padding-bottom: 11px; margin-left: 20px; width: 125px;">
                                <font class="tn-in-text">Back</font>
                            </button>
                        </a>
                    </td>
                    <td>
                        <form action="" method="post" class="header-search" style="display: flex; gap: 20px;">
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Patient Name" list="schedule">
                            <datalist id="schedule">
                                <?php
                                $list110 = $database->query("SELECT pname, pemail FROM patient;");
                                while ($row00 = $list110->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($row00["pname"], ENT_QUOTES) . "'>";
                                    echo "<option value='" . htmlspecialchars($row00["pemail"], ENT_QUOTES) . "'>";
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
                        <div style="display: flex;margin-top: 40px">
                            <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Appointment Manager</div>
                            <a href="?action=add&id=none&error=0" class="non-style-link"><button class="login-btn btn-primary btn button-icon" style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add a Appointment</font></button>
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" >
                        <p class="heading-main12" style="margin-left: 45px; font-size: 18px; color: rgb(49, 49, 49);">
                            All Appointments (<?php echo $appointmentCount; ?>)
                        </p>
                    </td>
                </tr>

                <?php
                $keyword = isset($_POST["search"]) ? $database->real_escape_string($_POST["search"]) : '';

                if (!empty($keyword)) {
                    $sqlmain = "SELECT appointment.appoid, treatment.treatmentname, schedule.scheduleid, doctor.docname, patient.pname, patient.pid, 
                            schedule.scheduledate, appointment.apponum, appointment.appodate, appointment.status 
                            FROM schedule 
                            INNER JOIN appointment ON schedule.scheduleid = appointment.scheduleid 
                            INNER JOIN patient ON patient.pid = appointment.pid 
                            INNER JOIN doctor ON schedule.docid = doctor.docid 
                            INNER JOIN treatment ON schedule.treatmentid = treatment.treatmentid
                            WHERE (patient.pemail='$keyword' OR patient.pname='$keyword' OR patient.pname LIKE '$keyword%' OR patient.pname LIKE '%$keyword' OR patient.pname LIKE '%$keyword%')
                            AND schedule.aid = $userid
                            ORDER BY schedule.scheduleid ASC, appointment.apponum ASC";
                } else {
                    $sqlmain = "SELECT appointment.appoid, treatment.treatmentname, schedule.scheduleid, doctor.docname, patient.pname, patient.pid, 
                            schedule.scheduledate, appointment.apponum, appointment.appodate, appointment.status 
                            FROM schedule 
                            INNER JOIN appointment ON schedule.scheduleid = appointment.scheduleid 
                            INNER JOIN patient ON patient.pid = appointment.pid 
                            INNER JOIN doctor ON schedule.docid = doctor.docid 
                            INNER JOIN treatment ON schedule.treatmentid = treatment.treatmentid
                            WHERE schedule.aid = $userid
                            ORDER BY schedule.scheduleid ASC, appointment.apponum ASC";
                }

                $result = $database->query($sqlmain);
                ?>

                <!-- Display Appointments -->
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" border="0">
                                    <thead>
                                        <tr>
                                            <th class="table-heading">Appo ID</th>
                                            <th class="table-heading">Patient name</th>
                                            <th class="table-heading">Appointment number</th>
                                            <th class="table-heading">Therapist</th>
                                            <th class="table-heading">Treatment name</th>                                            
                                            <th class="table-heading">Appointment Date</th>
                                            <th class="table-heading">Status</th>
                                            <th class="table-heading">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result && $result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $pid = $row["pid"];

                                                echo '
                                                <tr style="text-align: center; padding: 10px;">
                                                    <td>' . htmlspecialchars($row["appoid"]) . '</td>
                                                    <td style="font-weight: 600;">' . htmlspecialchars(substr($row["pname"], 0, 25)) .  '</td>
                                                    <td style="text-align: center; font-weight: 500; color: var(--btnnicetext);">' . htmlspecialchars($row["apponum"]) . '</td>
                                                    <td>' . htmlspecialchars(substr($row["docname"], 0, 25)) . '</td>
                                                    <td>' . htmlspecialchars(substr($row["treatmentname"], 0, 15)) . '</td>
                                                    <td>' . htmlspecialchars($row["appodate"]) . '</td>
                                                    <td>' . htmlspecialchars($row["status"]) . '</td>
                                                    <td style="padding: 10px;">
                                                        <div style="display: flex; justify-content: center; gap: 10px; align-items: center;">

                                                            <a href="?action=view&id=' . htmlspecialchars($pid) 
                                                                . '&name=' . htmlspecialchars($row["pname"]) 
                                                                . '" class="non-style-link">

                                                                <button class="btn-primary-soft btn button-icon btn-view">
                                                                    <font class="tn-in-text">View</font>
                                                                </button>
                                                            </a>

                                                            <a href="?action=drop&id=' . htmlspecialchars($row["appoid"]) 
                                                                . '&name=' . htmlspecialchars($row["pname"]) 
                                                                . '&session=' . htmlspecialchars($row["treatmentname"]) 
                                                                . '&apponum=' . htmlspecialchars($row["apponum"])
                                                                . '&docname=' . htmlspecialchars($row["docname"]) 
                                                                . '" class="non-style-link">

                                                                <button class="btn-primary-soft btn button-icon btn-delete">
                                                                    <font class="tn-in-text">Cancel</font>
                                                                </button>
                                                            </a>

                                                            <a href="?action=edit&id=' . htmlspecialchars($row["appoid"]) 
                                                                . '&name=' . htmlspecialchars($row["pname"]) 
                                                                . '&session=' . htmlspecialchars($row["treatmentname"]) 
                                                                . '&apponum=' . htmlspecialchars($row["apponum"])
                                                                . '&docname=' . htmlspecialchars($row["docname"])
                                                                . '" class="non-style-link">

                                                                <button class="btn-primary-soft btn button-icon btn-edit">
                                                                    <font class="tn-in-text">Done</font>
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>';
                                            }
                                        } else {
                                            echo '
                                            <tr>
                                                <td colspan="7">
                                                    <center>
                                                        <img src="../img/notfound.svg" width="25%">
                                                        <p class="heading-main12" style="margin-left: 45px; font-size: 20px; color: rgb(49, 49, 49);">
                                                            We couldn\'t find anything related to your keywords!
                                                        </p>
                                                        <a class="non-style-link" href="appointment.php">
                                                            <button class="login-btn btn-primary-soft btn" style="display: flex; justify-content: center; align-items: center; margin-left: 20px;">
                                                                <font class="tn-in-text">Show all Appointments</font>
                                                            </button>
                                                        </a>
                                                    </center>
                                                </td>
                                            </tr>';
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

    <?php include("../includes/get-appointment.php"); ?>
</body>
</html>
