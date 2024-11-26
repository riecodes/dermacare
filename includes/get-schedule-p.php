<?php

if ($_GET) {
    $id = $_GET["id"];
    $action = $_GET["action"];
    $pid = $userid;
    if ($action == 'add') {

        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="schedule.php">&times;</a> 
                    <div style="display: flex;justify-content: center;">
                        <div class="abc">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <form action="add-appointment.php" method="POST" class="add-new-form">
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add an Appointment.</p><br>                                            
                                        </td>
                                    </tr>';                                
                                    
                                    // Query to get the highest apponum
                                    $result = $database->query("SELECT MAX(apponum) AS max_apponum FROM appointment");
                                    $row = $result->fetch_assoc();
                                    $apponum = $row['max_apponum'] + 1;

                                    
                                    echo'
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="hidden" name="apponum" value="' . $apponum . '">
                                            <input type="hidden" name="pid" value="' . $userid . '">
                                            <input type="hidden" name="scheduleid" value="' . $id . '">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="date" class="form-label">Appointment Date: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="date" name="date" class="input-text" min="' . date('Y-m-d') . '" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="submit" value="Place this Appointment" class="login-btn btn-primary btn" name="shedulesubmit">
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
    } 
}
