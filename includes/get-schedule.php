<?php

if ($_GET) {
    $id = $_GET["id"];
    $action = $_GET["action"];

    if ($action == 'add') {

        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="schedule.php">&times;</a> 
                    <div style="display: flex;justify-content: center;">
                        <div class="abc">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <form action="add-schedule.php" method="POST" class="add-new-form">
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Session.</p><br>                                            
                                            <input type="hidden" name="aid" value="' . $userid . '">
                                        </td>
                                    </tr>                                            
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="docid" class="form-label">Select Therapist: </label>
                                        </td>
                                    </tr>                                
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <select name="docid" id="" class="box" required>
                                            ';

                                            $list11 = $database->query("SELECT * FROM doctor WHERE aid = $userid ORDER BY docname ASC;");

                                            for ($y = 0; $y < $list11->num_rows; $y++) {
                                                $row00 = $list11->fetch_assoc();
                                                $sn = $row00["docname"];
                                                $id00 = $row00["docid"];
                                                echo "
                                                <option value=" . $id00 . ">
                                                    $sn
                                                </option><br/>
                                                ";
                                            };

                                            echo '
                                            </select><br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="treatmentname" class="form-label">Treatment Name: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <select name="treatmentid" id="" class="box" required >
                                            ';

                                            $list11 = $database->query("SELECT * FROM treatment WHERE aid = $userid ORDER BY treatmentid ASC;");

                                            for ($y = 0; $y < $list11->num_rows; $y++) {
                                                $row00 = $list11->fetch_assoc();
                                                $sn = $row00["treatmentname"];
                                                $id00 = $row00["treatmentid"];
                                                echo "
                                                <option value=" . $id00 . ">
                                                    $sn
                                                </option><br/>
                                                ";
                                            };

                                            echo '
                                            </select><br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="date" class="form-label">Session Date: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="date" name="date" class="input-text" min="' . date('Y-m-d') . '" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="starttime" class="form-label">Schedule Start Time: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="time" name="starttime" class="input-text" placeholder="Start Time" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="endtime" class="form-label">Schedule End Time: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="time" name="endtime" class="input-text" placeholder="End Time" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="submit" value="Place this Session" class="login-btn btn-primary btn" name="shedulesubmit">
                                        </td>
                                    </tr>
                                </form>
                            </table>
                        </div>
                    </div>
                </center>

                <br><br>

            </div>
        </div>
        ';
    } elseif ($action == 'edit') {
        $id = $_GET["id"];

        $sqlmain="SELECT schedule.*, doctor.docname,treatment.treatmentname, treatment.treatmentmax
                FROM schedule
                INNER JOIN doctor ON schedule.docid = doctor.docid
                INNER JOIN treatment ON schedule.treatmentid = treatment.treatmentid
                WHERE schedule.scheduleid = $id AND schedule.aid = $userid
        ";
        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();
        $docname = $row["docname"];
        $scheduleid = $row["scheduleid"];
        $scheduledate = $row["scheduledate"];
        $schedulestarttime = $row["schedulestarttime"];
        $scheduleendtime = $row["scheduleendtime"];
        $treatmentid = $row['treatmentid'];
        $treatmentname = $row["treatmentname"];
        $treatmentmax = $row['treatmentmax'];

        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="schedule.php">&times;</a> 
                    <div style="display: flex;justify-content: center;">
                        <div class="abc">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <form action="edit-schedule.php" method="POST" class="add-new-form">
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Edit Session.</p><br>
                                            <input type="hidden" name="treatmentid" value="' . $treatmentid . '">
                                            <input type="hidden" name="aid" value="' . $userid . '">
                                            <input type="hidden" name="id" value="' . $scheduleid . '">
                                        </td>
                                    </tr>
                                    <tr>
                                        
                                        <td class="label-td" colspan="2">
                                            <label for="docid" class="form-label">Select Therapist: </label>
                                        </td>
                                    </tr>                                
                                        <td class="label-td" colspan="2">
                                            <select name="docid" class="box" >
                                                ';

                                                    $list11 = $database->query("SELECT * FROM doctor WHERE aid = $userid ORDER BY docid ASC;");

                                                    for ($y = 0; $y < $list11->num_rows; $y++) {
                                                        $row00 = $list11->fetch_assoc();
                                                        $sn = $row00["docname"];
                                                        $id00 = $row00["docid"];
                                                        echo "<option value=" . $id00 . ">$sn</option><br/>";
                                                    }

                                                echo'
                                            </select><br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="treatmentid" class="form-label">Treatment Name: </label>
                                        </td>
                                    </tr>
                                    <tr>                                
                                        <td class="label-td" colspan="2">
                                            <select name="treatmentid" class="box" >
                                                ';

                                                $list11 = $database->query("SELECT * FROM treatment WHERE aid = $userid ORDER BY treatmentid ASC;");

                                            for ($y = 0; $y < $list11->num_rows; $y++) {
                                                $row00 = $list11->fetch_assoc();
                                                $sn = $row00["treatmentname"];
                                                $id00 = $row00["treatmentid"];
                                                echo "
                                                <option value=" . $id00 . ">
                                                    $sn
                                                </option><br/>
                                                ";
                                            };

                                                echo'
                                            </select><br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="date" class="form-label">Session Date: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="date" name="date" class="input-text" min="' . date('Y-m-d') . '" value="'. $scheduledate.'" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="starttime" class="form-label">Schedule Start Time: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="time" name="starttime" class="input-text" value="'. $schedulestarttime .'" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="endtime" class="form-label">Schedule End Time: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="time" name="endtime" class="input-text" value="'. $scheduleendtime .'" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="submit" value="Edit this Session" class="login-btn btn-primary btn" name="shedulesubmit">
                                        </td>
                                    </tr>
                                </form>
                            </table>
                        </div>
                    </div>
                </center>
                <br><br>
            </div>
        </div>
        ';
    } elseif ($action == 'added') {
        $titleget = $_GET["title"];
        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                <br><br>
                    <h2>Session Placed.</h2>
                    <a class="close" href="schedule.php">&times;</a>
                    <div class="content">
                    ' . substr($titleget, 0, 40) . ' was scheduled.<br><br>
                        
                    </div>
                    <div style="display: flex;justify-content: center;">
                    
                    <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                    <br><br><br><br>
                    </div>
                </center>
            </div>
        </div>
        ';
    } elseif ($action == 'updated') {
        $titleget = $_GET["title"];
        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                <br><br>
                    <h2>Session Updated.</h2>
                    <a class="close" href="schedule.php">&times;</a>
                    <div class="content">
                        ' . substr($titleget, 0, 40) . ' was re-scheduled.<br><br>
                    </div>
                    <div style="display: flex;justify-content: center;">
                        <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                        <br><br><br><br>
                    </div>
                </center>
            </div>
        </div>
        ';
    } elseif ($action == 'add-error') {
        $idget = $_GET["id"];
        $titleget = $_GET["title"];
        $errorget = $_GET["error"];
        if ($errorget == 1) {
            $error = "Start time shouldn't be equal to End Time!.";
        } elseif ($errorget == 2) {
            $error = "Session duration should not exceed 8 hours!";
        } elseif ($errorget == 3) {            
            $error = "Sorry, there was an error adding/editing your schedule.";
        }

        echo '
        
        <div id="popup1" class="overlay">
            <div class="popup">
            <center>
                <h2>No Changes Made.</h2>
                <a class="close" href="schedule.php">&times;</a>
                <div class="content">
                    Title name: ' . $titleget . '<br>
                    ' . $error . '
                </div>
                <div style="display: flex;justify-content: center;">
                    <a href="schedule.php" class="non-style-link">
                        <button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                            <font class="tn-in-text">
                                &nbsp;&nbsp;OK&nbsp;&nbsp;
                            </font>
                        </button>
                    </a>
                </div>
            </center>
            </div>
        </div>

        ';
        
    } elseif ($action == 'edit-error') {
        $idget = $_GET["id"];
        $titleget = $_GET["title"];
        $errorget = $_GET["error"];
        if ($errorget == 1) {
            $error = "Start time shouldn't be equal to End Time!.";
        } elseif ($errorget == 2) {
            $error = "Session duration should not exceed 8 hours!";
        } elseif ($errorget == 3) {            
            $error = "Sorry, there was an error adding/editing your schedule.";
        }

        echo '
        
        <div id="popup1" class="overlay">
            <div class="popup">
            <center>
                <h2>No Changes Made.</h2>
                <a class="close" href="schedule.php">&times;</a>
                <div class="content">
                    Title name: ' . $titleget . ' (ID: '. $idget. ') <br>
                    ' . $error . '
                </div>
                <div style="display: flex;justify-content: center;">
                    <a href="schedule.php" class="non-style-link">
                        <button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                            <font class="tn-in-text">
                                &nbsp;&nbsp;OK&nbsp;&nbsp;
                            </font>
                        </button>
                    </a>
                </div>
            </center>
            </div>
        </div>

        ';
    } elseif ($action == 'drop') {
        $nameget = $_GET["name"];
        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <h2>Are you sure?</h2>
                    <a class="close" href="schedule.php">&times;</a>
                    <div class="content">
                        You want to delete this record<br>(' . substr($nameget, 0, 40) . ').
                    </div>
                    <div style="display: flex;justify-content: center;">
                        <a href="delete-session.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
                    </div>
                </center>
            </div>
        </div>
        ';
    } elseif ($action == 'view') {
        $sqlmain="SELECT schedule.*, doctor.docname,treatment.treatmentname, treatment.treatmentmax
                FROM schedule
                INNER JOIN doctor ON schedule.docid = doctor.docid
                INNER JOIN treatment ON schedule.treatmentid = treatment.treatmentid
                WHERE schedule.scheduleid = $id AND schedule.aid = $userid
        ";
        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();
        $docname = $row["docname"];
        $scheduleid = $row["scheduleid"];
        $scheduledate = $row["scheduledate"];
        $schedulestarttime = $row["schedulestarttime"];
        $scheduleendtime = $row["scheduleendtime"];
        $treatmentmax = $row['treatmentmax'];
    
        $sqlmain12="SELECT * 
                    FROM appointment
                    INNER JOIN patient ON patient.pid = appointment.pid
                    INNER JOIN schedule ON schedule.scheduleid = appointment.scheduleid
                    WHERE schedule.scheduleid = $id AND schedule.aid = $userid
        ";
        $result12 = $database->query($sqlmain12);
    
        echo '
        <div id="popup1" class="overlay">
            <div class="popup" style="width: 70%;">
                <center>
                    <h2></h2>
                    <a class="close" href="schedule.php">&times;</a>
                    <div class="content">
                    </div>
                    <div class="abc scroll" style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Therapist of this session: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">' . $docname . '<br><br></td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="treatmentname" class="form-label">Treatment Name: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">' . $treatmentname . '<br><br></td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="date" class="form-label">Scheduled Date: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">' . $scheduledate . '<br><br></td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Scheduled Time: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">' . $schedulestarttime . ' - ' . $schedulestarttime . '<br><br></td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label"><b>Patients that Already registered for this session:</b> (' . $result12->num_rows . "/" . $treatmentmax . ')</label><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <center>
                                        <div class="abc scroll">
                                            <table width="100%" class="sub-table scrolldown" border="0">
                                                <thead>
                                                    <tr>
                                                        <th class="table-heading">Patient ID</th>
                                                        <th class="table-heading">Patient Name</th>
                                                        <th class="table-heading">Appointment Number</th>
                                                        <th class="table-heading">Patient Telephone</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
    
        if ($result12->num_rows == 0) {
            echo '
            <tr>
                <td colspan="7">
                    <br><br><br><br>
                    <center>
                        <img src="../img/notfound.svg" width="25%">
                        <br>
                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We couldn\'t find anything related to your keywords!</p>
                        <a class="non-style-link" href="appointment.php">
                            <button class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Appointments &nbsp;</button>
                        </a>
                    </center>
                    <br><br><br><br>
                </td>
            </tr>';
        } else {
            for ($x = 0; $x < $result12->num_rows; $x++) {
                $row = $result12->fetch_assoc();
                $apponum = $row["apponum"];
                $pid = $row["pid"];
                $pname = $row["pname"];
                $ptel = $row["ptel"];
    
                echo '
                <tr style="text-align:center;">
                    <td>' . substr($pid, 0, 15) . '</td>
                    <td style="font-weight:600;padding:25px">' . substr($pname, 0, 25) . '</td>
                    <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);">' . $apponum . '</td>
                    <td>' . substr($ptel, 0, 25) . '</td>
                </tr>';
            }
        }
    
        echo '
                                                </tbody>
                                            </table>
                                        </div>
                                    </center>
                                </td> 
                            </tr>
                        </table>
                    </div>
                </center>
                <br><br>
            </div>
        </div>';
    }
}
