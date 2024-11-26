<?php
    
    if($_GET){
        $id=$_GET["id"];
        $action=$_GET["action"];
        
        if ($action == 'view') {
            $sqlmain="SELECT schedule.*, doctor.docname,treatment.treatmentname, treatment.treatmentmax
                    FROM schedule
                    INNER JOIN doctor ON schedule.docid = doctor.docid
                    INNER JOIN treatment ON schedule.treatmentid = treatment.treatmentid
                    WHERE schedule.scheduleid = $id
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
                        WHERE schedule.scheduleid = $id
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

