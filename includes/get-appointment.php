<?php

if ($_GET) {
    $id = $_GET["id"];
    $action = $_GET["action"];

    if ($action == 'add') {
        echo '
    
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="appointment.php">&times;</a> 
                    <div style="display: flex;justify-content: center;">
                        <div class="abc">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <form action="add-appointment.php" method="POST" class="add-new-form" enctype="multipart/form-data">
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Appointment</p><br>
                                        </td>
                                    </tr>
    
                                    <!-- Hidden field for aid (Admin ID) -->
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="hidden" name="aid" value="' . $userid . '">
                                        </td>
                                    </tr>
    
                                    <!-- Select Patient -->
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="pid" class="form-label">Select Patient: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <select name="pid" class="box" required>';
                                                
                                                // Fetch patients from the database
                                                $patients = $database->query("SELECT pid, pname FROM patient ORDER BY pname ASC");
                                                while ($patient = $patients->fetch_assoc()) {
                                                    $pname = $patient["pname"];
                                                    $pid = $patient["pid"];
                                                    echo "<option value=\"$pid\">$pname</option>";
                                                }
    
                                            echo '
                                            </select><br><br>
                                        </td>
                                    </tr>
    
                                    <!-- Select Schedule -->
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="scheduleid" class="form-label">Select Schedule: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <select name="scheduleid" class="box" required>';
                                                
                                                // Fetch schedules from the database
                                                $schedules = $database->query(
                                                "SELECT DISTINCT schedule.scheduleid, treatment.treatmentname 
                                                        FROM schedule 
                                                        INNER JOIN treatment 
                                                        ON schedule.treatmentid = treatment.treatmentid 
                                                        WHERE schedule.aid = $userid;");
                                                        
                                                    while ($schedule = $schedules->fetch_assoc()) {

                                                    $treatmentname = $schedule["treatmentname"];
                                                    $scheduleid = $schedule["scheduleid"];
                                                    echo "<option value=\"$scheduleid\">$treatmentname</option>";
                                                }
    
                                            echo '                                            

                                            </select><br><br>
                                        </td>
                                    </tr>

                                    <!-- Appointment Date -->
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="appodate" class="form-label">Appointment Date: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="date" name="appodate" class="input-text" min="' . date('Y-m-d') . '" required><br>
                                        </td>
                                    </tr>
    
                                    <!-- Submit and Reset Buttons -->
                                    <tr>
                                        <td colspan="2">
                                            <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="submit" value="Add this Appointment" class="login-btn btn-primary btn" name="addappointment">
                                        </td>
                                    </tr>
                                </form>
                            </table>
                        </div>
                    </div>
                </center>
            </div>
        </div>
        
        ';
    } elseif ($action == "view") {

        $sqlmain = "select * from patient where pid='$id'";
        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();
        $name = $row["pname"];
        $page = $row["page"];
        $psex = $row["psex"];
        $email = $row["pemail"];
        $dob = $row["pdob"];
        $tele = $row["ptel"];
        $address = $row["paddress"];

        echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                            <a class="close" href="appointment.php">&times;</a>
                            <div class="content">

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
                                        <label for="psex" class="form-label">Patient Age: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        ' . $page . '<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="psex" class="form-label">Patient Sex: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        ' . $psex . '<br><br>
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
                                    <td class="label-td" colspan="2">
                                        <label for="Tele" class="form-label">Telephone: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                    ' . $tele . '<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="spec" class="form-label">Address: </label>
                                        
                                    </td>
                                </tr>
                                <tr>
                                <td class="label-td" colspan="2">
                                ' . $address . '<br><br>
                                </td>
                                </tr>
                                <tr>
                                    
                                    <td class="label-td" colspan="2">
                                        <label for="name" class="form-label">Date of Birth: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        ' . $dob . '<br><br>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <a href="appointment.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                    
                                        
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </center>
                        <br><br>
                    </div>
                </div>
            ';
    } elseif ($action == 'add-error') {
        $titleget = $_GET["tname"];
        $nameget = $_GET["pname"];
        $errorget = $_GET["error"];
        if ($errorget == 0) {
            $h2 = "Appointment added successfully.";            
        }
        elseif ($errorget == 1) {
            $error = "There was an error adding your appointment.";
            $h2 = "No Changes Made.";
        }elseif ($errorget == 2) {
            $error = "Schedule data shouldn't be in the past.";
            $h2 = "No Changes Made.";
        }

        echo '
        
        <div id="popup1" class="overlay">
            <div class="popup">
            <center>
                <h2>'. $h2 . '</h2>
                <a class="close" href="appointment.php">&times;</a>
                <div class="content">
                    Patient name: ' . $nameget . '<br>
                    Treatment Name: ' . $titleget . '<br>
                    ' . $error . '
                </div>
                <div style="display: flex;justify-content: center;">
                    <a href="appointment.php" class="non-style-link">
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
        $session = $_GET["session"];
        $apponum = $_GET["apponum"];
        echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                            You want to delete this record<br><br>
                            Patient Name: &nbsp;<b>' . substr($nameget, 0, 40) . '</b><br>
                            Appointment number &nbsp; : <b>' . substr($apponum, 0, 40) . '</b><br><br>
                        </div>
                        <div style="display: flex;justify-content: center;">
                            <a href="delete-appointment.php?id='.$id.'" class="non-style-link">
                                <button class="btn-primary btn" style="display: flex; justify-content: center; align-items: center; margin: 10px; padding: 10px;">
                                    <font class="tn-in-text">&nbsp;Yes&nbsp;</font>
                                </button>
                            </a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="appointment.php" class="non-style-link">
                                <button class="btn-primary btn" style="display: flex; justify-content: center; align-items: center; margin: 10px; padding: 10px;">
                                    <font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font>
                                </button>
                            </a>
                        </div>
                    </center>
                </div>
            </div>
            ';
    }  elseif ($action == 'edit') {
        $nameget = $_GET["name"];
        $docname = $_GET["docname"];
        $session = $_GET["session"];
        $apponum = $_GET["apponum"];
        echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                            You want to mark this appointment as done<br><br>
                            Patient Name: &nbsp;<b>' . htmlspecialchars($nameget) . '</b><br>
                            Therapist Name: &nbsp;<b>' . htmlspecialchars($docname) . '</b><br>
                            Appointment number &nbsp; : <b>' . htmlspecialchars($apponum) . '</b><br><br>
                        </div>
                        <div style="display: flex;justify-content: center;">
                            <a href="appointment.php?id=' . htmlspecialchars($id) 
                            
                            . '&action=confirm_edit&name=' . htmlspecialchars($nameget) 
                            . '&session=' . htmlspecialchars($session) 
                            . '&apponum=' . htmlspecialchars($apponum)                             
                            . '" class="non-style-link">

                                <button class="btn-primary btn" style="display: flex; justify-content: center; align-items: center; margin: 10px; padding: 10px;">
                                    <font class="tn-in-text">&nbsp;Yes&nbsp;</font>
                                </button>
                            </a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="appointment.php" class="non-style-link">
                                <button class="btn-primary btn" style="display: flex; justify-content: center; align-items: center; margin: 10px; padding: 10px;">
                                    <font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font>
                                </button>
                            </a>
                        </div>
                    </center>
                </div>
            </div>
        ';
    } elseif ($action == 'confirm_edit') {
        $nameget = $_GET["name"];
        $session = $_GET["session"];
        $apponum = $_GET["apponum"];
        $sqlmain = "UPDATE appointment SET status='Done' WHERE appoid='$id'";
        if ($database->query($sqlmain) === TRUE) {
            echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                            <h2>Record updated successfully</h2>
                            <a class="close" href="appointment.php">&times;</a>
                            <div class="content">
                                The appointment for <b>' . htmlspecialchars($nameget) . '</b> with appointment number <b>' . htmlspecialchars($apponum) . '</b> has been marked as done.
                            </div>
                            <div style="display: flex;justify-content: center;">
                                <a href="appointment.php" class="non-style-link">
                                    <button class="btn-primary btn" style="display: flex; justify-content: center; align-items: center; margin: 10px; padding: 10px;">
                                        <font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font>
                                    </button>
                                </a>
                            </div>
                        </center>
                    </div>
                </div>
            ';
        } else {
            echo "Error updating record: " . $database->error;
        }
    }
}