<?php
if ($_GET) {

    $id = $_GET["id"];
    $action = $_GET["action"];

    if ($action == 'drop') {
        $nameget = $_GET["name"];
        echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="patient.php">&times;</a>
                        <div class="content">
                            You want to delete this record<br>(' . substr($nameget, 0, 40) . ').
                        </div>
                        <div style="display: flex;justify-content: center;">
                            <a href="delete-patient.php?id=' . $id . '" class="non-style-link">
                                <button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px 15px;"
                                    <font class="tn-in-text">
                                        Yes
                                    </font>
                                </button>
                            </a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="patient.php" class="non-style-link">
                                <button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px 15px;">
                                    <font class="tn-in-text">
                                        No
                                    </font>
                                </button>
                            </a>
                        </div>
                    </center>
                </div>
            </div>';

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
                                <a class="close" href="patient.php">&times;</a> 
                                <div style="display: flex; justify-content: center;">
                                    <div class="abc">
                                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                            <tr>
                                                <td class="label-td" colspan="2">' . $errorlist[$error_1] . '</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p style="padding: 0; margin: 0; text-align: left; font-size: 25px; font-weight: 500;">Add Patient Details.</p>
                                                  <br><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <form action="add-patient.php" method="POST" class="add-new-form">
                                                    <label for="Email" class="form-label">Email: </label>
                                                    <input type="hidden" value="' . $id . '" name="id00">
                                                    <input type="hidden" name="oldemail" value="' . $email . '">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <input type="email" name="email" class="input-text" placeholder="Email Address" required><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="name" class="form-label">Name: </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <input type="text" name="name" class="input-text" placeholder="Patient Name"  required><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="page" class="form-label">Patient Age: </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <input type="text" name="page" class="input-text input-text" placeholder="Patients Age"  required><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="psex" class="form-label">Patient Sex: </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <select name="psex" class="input-text" required>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="tel" class="form-label">Telephone: </label>
                                                </td>
                                            </tr>                                                                                                                    
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <input type="tel" name="tel" class="input-text" placeholder="Telephone Number"  required><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="address" class="form-label">Address: </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <input type="text" name="address" class="input-text" placeholder="Address" required><br>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="dob" class="form-label">Date of Birth: </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <input type="date" name="dob" class="input-text" required><br>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="password" class="form-label">Password: </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <input type="password" name="password" class="input-text" placeholder="Define a Password" required><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="cpassword" class="form-label">Confirm Password: </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <input type="password" name="cpassword" class="input-text" placeholder="Confirm Password" required><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="submit" value="Save" class="login-btn btn-primary btn">
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
            }else {
                echo '
                    <div id="popup1" class="overlay">
                            <div class="popup">
                            <center>
                            <br><br><br><br>
                                <h2>New Patient Added Successfully!</h2>
                                <a class="close" href="patient.php">&times;</a>
                                <div class="content">
                                    
                                    
                                </div>
                                <div style="display: flex;justify-content: center;">
                                
                                <a href="patient.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>

                                </div>
                                <br><br>
                            </center>
                    </div>
                    </div>
                    ';
            }
        
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
                            <a class="close" href="patient.php">&times;</a>
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
                                        <a href="patient.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                    
                                        
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </center>
                        <br><br>
                    </div>
                </div>
            ';
    } elseif ($action == 'edit') {
    $sqlmain = "SELECT * FROM patient WHERE pid='$id'";
    $result = $database->query($sqlmain);
    $row = $result->fetch_assoc();

    $name = $row["pname"];
    $email = $row["pemail"];
    $address = $row["paddress"];
    $page = $row["page"];
    $psex = $row["psex"];
    $dob = $row["pdob"];
    $tel = $row["ptel"];

    $error_1 = $_GET["error"];
    $errorlist = array(
        '1' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>',
        '2' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Confirmation Error! Reconfirm Password</label>',
        '3' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
        '4' => "",
        '0' => '',
    );

        if ($error_1 != '4') {
            echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                            <a class="close" href="patient.php">&times;</a> 
                            <div style="display: flex; justify-content: center;">
                                <div class="abc">
                                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                        <tr>
                                            <td class="label-td" colspan="2">' . $errorlist[$error_1] . '</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="padding: 0; margin: 0; text-align: left; font-size: 25px; font-weight: 500;">Edit Patient Details.</p>
                                                <br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <form action="edit-patient.php" method="POST" class="add-new-form">
                                                <label for="Email" class="form-label">Email: </label>
                                                <input type="hidden" value="' . $id . '" name="id00">
                                                <input type="hidden" name="oldemail" value="' . $email . '">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="email" name="email" class="input-text" placeholder="Email Address" value="' . $email . '" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="name" class="form-label">Name: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="text" name="name" class="input-text" placeholder="Patient Name" value="' . $name . '" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="page" class="form-label">Patient Age: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="text" name="page" class="input-text input-text" value="'. $page . '"  required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="psex" class="form-label">Patient Sex: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <select name="psex" class="input-text" required>
                                                    <option value="Male" ' . ($psex == 'Male' ? 'selected' : '') . '>Male</option>
                                                    <option value="Female" ' . ($psex == 'Female' ? 'selected' : '') . '>Female</option>
                                                </select><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="tel" class="form-label">Telephone: </label>
                                            </td>
                                        </tr>                                                                                                                    
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="tel" name="tel" class="input-text" placeholder="Telephone Number" value="' . $tel . '" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="address" class="form-label">Address: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="text" name="address" class="input-text" placeholder="Address" value="' . $address . '" required><br>
                                            </td> 
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="dob" class="form-label">Date of Birth: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="text" name="dob" class="input-text" placeholder="Address" value="' . $dob . '" required><br>
                                            </td> 
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="password" class="form-label">Password: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="password" name="password" class="input-text" placeholder="Define a Password" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="cpassword" class="form-label">Confirm Password: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="password" name="cpassword" class="input-text" placeholder="Confirm Password" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="submit" value="Save" class="login-btn btn-primary btn">
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
    } else {

        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
            <center>
                <br><br><br><br>
                <h2>Edit Successfully!</h2>
                <a class="close" href="patient.php">&times;</a>
                <div style="display: flex; justify-content: center;">
                <a href="patient.php" class="non-style-link">
                    <button class="btn-primary btn" style="display: flex; justify-content: center; align-items: center; margin: 10px; padding: 10px;">
                    <font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font>
                    </button>
                </a>
                </div>
                <br><br>
            </center>
            </div>
        </div>
        ';

    }
}
