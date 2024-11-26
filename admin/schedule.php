<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/animations.css">
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/admin.css">
    <title>Schedule</title>
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
        if (empty($_SESSION["user"]) || $_SESSION['usertype'] != 'a') {
            header("location: ../login.php");
            exit();
        } else {
            $useremail = $_SESSION["user"];
        }
    } else {
        header("location: ../login.php");
        exit();
    }

    include("../connection.php");
    include("../includes/display-aaccount.php");
    ?>
    <div class="container">
        <?php include("../includes/sidebar-aadmin.php"); ?>
        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0; margin:0; padding:0; margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="schedule.php">
                            <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                                <font class="tn-in-text">Back</font>
                            </button>
                        </a>
                    </td>
                    <td>
                        <form action="" method="post" class="header-search" style="display: flex; gap: 20px;">
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Treatment Name" list="schedule">
                            <datalist id="schedule">
                                <?php
                                $list110 = $database->query("SELECT DISTINCT treatment.treatmentname FROM schedule INNER JOIN treatment ON schedule.treatmentid = treatment.treatmentid WHERE schedule.aid = $userid;");
                                while ($row00 = $list110->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($row00["treatmentname"], ENT_QUOTES) . "'></option>";
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
                        <div style="display: flex; margin-top: 40px;">
                            <div class="heading-main12" style="margin-left: 45px; font-size:20px; color:rgb(49, 49, 49); margin-top: 5px;">Schedule a Session</div>
                            <a href="?action=add&id=none&error=0" class="non-style-link">
                                <button class="login-btn btn-primary btn button-icon" style="margin-left:25px; background-image: url('../img/icons/add.svg');">Add a Session</button>
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">
                            All Sessions (<?php echo $list110->num_rows; ?>)
                        </p>
                    </td>
                </tr>

                <?php
                $keyword = isset($_POST["search"]) ? $database->real_escape_string($_POST["search"]) : '';
                if (!empty($keyword)) {
                    $sqlsearch = "SELECT schedule.*, doctor.docname, treatment.treatmentname, treatment.treatmentmax
                                  FROM schedule
                                  INNER JOIN doctor ON schedule.docid = doctor.docid
                                  INNER JOIN treatment ON schedule.treatmentid = treatment.treatmentid
                                  WHERE schedule.aid = $userid AND (
                                        treatment.treatmentname = '$keyword' OR
                                        treatment.treatmentname LIKE '$keyword%' OR
                                        treatment.treatmentname LIKE '%$keyword' OR
                                        treatment.treatmentname LIKE '%$keyword%'
                                  )";
                } else {
                    $sqlsearch = "SELECT schedule.*, doctor.docname, treatment.treatmentname, treatment.treatmentmax
                                  FROM schedule
                                  INNER JOIN doctor ON schedule.docid = doctor.docid
                                  INNER JOIN treatment ON schedule.treatmentid = treatment.treatmentid
                                  WHERE schedule.aid = $userid
                                  ORDER BY schedule.scheduledate DESC, schedule.schedulestarttime DESC";
                }

                $result = $database->query($sqlsearch);
                ?>

                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" border="0">
                                    <thead>
                                        <tr>
                                            <th class="table-heading">Treatment Name</th>
                                            <th class="table-heading">Therapist</th>
                                            <th class="table-heading">Scheduled Date</th>
                                            <th class="table-heading">Scheduled Time</th>
                                            <th class="table-heading">Treatment Max</th>
                                            <th class="table-heading">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows == 0) {
                                            echo '
                                            <tr>
                                                <td colspan="6">
                                                    <br><br><br><br>
                                                    <center>
                                                        <img src="../img/notfound.svg" width="25%">
                                                        <br>
                                                        <p class="heading-main12" style="font-size: 20px; color: rgb(49, 49, 49);">We couldn\'t find anything related to your keywords!</p>
                                                        <a class="non-style-link" href="schedule.php">
                                                            <button class="login-btn btn-primary-soft btn">Show all Sessions</button>
                                                        </a>
                                                    </center>
                                                    <br><br><br><br>
                                                </td>
                                            </tr>';
                                        } else {
                                            while ($row = $result->fetch_assoc()) {
                                                $scheduleid = $row["scheduleid"];
                                                $docname = $row["docname"];
                                                $treatmentname = $row["treatmentname"];
                                                $treatmentmax = $row["treatmentmax"];
                                                $scheduledate = $row["scheduledate"];
                                                $schedulestarttime = $row["schedulestarttime"];
                                                $scheduleendtime = $row["scheduleendtime"];

                                                echo '
                                                <tr>
                                                    <td>&nbsp;' . htmlspecialchars(substr($treatmentname, 0, 30)) . '</td>
                                                    <td>' . htmlspecialchars(substr($docname, 0, 20)) . '</td>
                                                    <td style="text-align: center;">' . htmlspecialchars($scheduledate) . '</td>
                                                    <td style="text-align: center;">' . htmlspecialchars("{$schedulestarttime} - {$scheduleendtime}") . '</td>
                                                    <td style="text-align: center;">' . htmlspecialchars($treatmentmax) . '</td>
                                                    <td style="padding: 10px;">
                                                        <div style="display: flex; justify-content: center; gap: 10px; align-items: center;">
                                                            <a href="?action=edit&id=' . $scheduleid . '" class="non-style-link">
                                                                <button class="btn-primary-soft btn button-icon btn-edit">Edit</button>
                                                            </a>
                                                            <a href="?action=view&id=' . $scheduleid . '" class="non-style-link">
                                                                <button class="btn-primary-soft btn button-icon btn-view">View</button>
                                                            </a>
                                                            <a href="?action=drop&id=' . $scheduleid . '&name=' . urlencode($treatmentname) . '" class="non-style-link">
                                                                <button class="btn-primary-soft btn button-icon btn-delete">Remove</button>
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
    <?php include("../includes/get-schedule.php"); ?>
</body>
</html>
