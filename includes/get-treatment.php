<?php
if ($_GET) {
    $id = $_GET["id"];
    $action = $_GET["action"];

    if ($action == 'add') {
        echo '

        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="treatment.php">&times;</a> 
                    <div style="display: flex;justify-content: center;">
                        <div class="abc">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <form action="add-treatment.php" method="POST" class="add-new-form" enctype="multipart/form-data">
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Treatment.</p><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">                                                    
                                            <label for="treatmentid" class="form-label"> Treatment For:  </label>
                                            <input type="hidden" name="aid" value="' . $userid . '">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="treatmentadmin" class="input-text" value="' . $username . ' " readonly required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="treatmentname" class="form-label">Treatment Name: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="treatmentname" class="input-text" placeholder="Name of the treatment" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="treatmenttype" class="form-label">Treatment Type: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <select name="treatmenttype" class="box">';

                                                // Define the possible enum values
                                                $status_options = ['Consult', 'None'];

                                                // Echo the opening of the select tag
                                                foreach ($status_options as $status) {
                                                    // Check if the current status matches the enum option
                                                    $selected = ($treatmenttype == $status) ? 'selected' : '';
                                                    echo "<option value='$status' $selected>$status</option>";
                                                }

                                                echo '

                                            </select><br><br>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="treatmentdesc" class="form-label">Treatment Desc: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="treatmentdesc" class="input-text" placeholder="Treatment description" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="treatmentprice" class="form-label">Treatment Price: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="treatmentprice" class="input-text" placeholder="How much for the treatment?" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="treatmentmax" class="form-label">Treatment Max: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="treatmentmax" class="input-text" placeholder="How many max patients can book this treatment?" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="treatmentimage" class="form-label">Treatment Image: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="file" name="treatmentimage" class="input-text" accept="image/*" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="submit" value="Add this Treatment" class="login-btn btn-primary btn" name="addtreatment">
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

    } elseif ($action == 'drop') {
        $nameget = $_GET["name"];
        echo '

        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <h2>Are you sure?</h2>
                    <a class="close" href="treatment.php">&times;</a>
                    <div class="content">
                        You want to delete this record<br>(' . substr($nameget, 0, 40) . ').
                    </div>
                    <div style="display: flex;justify-content: center;">
                        <a href="delete-treatment.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="treatment.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
                    </div>
                </center>
            </div>
        </div>

        ';

    } elseif ($action == 'edit') {
        $sqlmain = "SELECT * FROM treatment INNER JOIN admin ON treatment.aid = admin.aid WHERE treatmentid = '$id'";
        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();

        $treatmentid = $row["treatmentid"];
        $treatmentname = $row["treatmentname"];
        $treatmenttype = $row["treatmenttype"];
        $treatmentdesc = $row["treatmentdesc"];
        $treatmentprice = $row["treatmentprice"];

        echo '

        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="treatment.php">&times;</a> 
                    <div class="abc">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                            <form action="edit-treatment.php" method="POST" class="add-new-form" enctype="multipart/form-data">
                                <tr>
                                    <td>
                                        <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">
                                            Edit Treatment Details.
                                        </p>                                                                                    
                                    </td>
                                </tr>
        

                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="treatmentname" class="form-label">Treatment Name: </label>
                                    </td>
                                    <td class="label-td" colspan="2">
                        
                                        <input type="hidden" name="treatmentid" value="' . $treatmentid . '">
                                        <input type="text" name="treatmentname" class="input-text" placeholder="Treatment Name" value="' . $treatmentname . '" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="treatmenttype" class="form-label">Treatment Type: </label>
                                    </td>
                                    <td class="label-td" colspan="2">
                                        <select name="treatmenttype" class="box">';

                                            // Define the possible enum values
                                            $status_options = ['Consult', 'None'];

                                            // Echo the opening of the select tag
                                            foreach ($status_options as $status) {
                                                // Check if the current status matches the enum option
                                                $selected = ($treatmenttype == $status) ? 'selected' : '';
                                                echo "<option value='$status' $selected>$status</option>";
                                            }

                                            echo '

                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="treatmentdesc" class="form-label">Treatment Desc: </label>
                                    </td>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="treatmentdesc" class="input-text" placeholder="Treatment Desc" value="' . $treatmentdesc . '" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="treatmentprice" class="form-label">Treatment Price: </label>
                                    </td>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="treatmentprice" class="input-text" placeholder="Treatment Price" value="' . $treatmentprice . '" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="treatmentmax" class="form-label">Treatment Max: </label>
                                    </td>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="treatmentmax" class="input-text" placeholder="Treatment Max" value="' . $treatmentmax . '" >
                                    </td>
                                </tr>                                
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="treatmentimage" class="form-label">Treatment Image: </label>
                                    </td>
                                    <td class="label-td" colspan="2">                                                
                                        <input type="file" name="treatmentimage" class="input-text" accept="image/*">
                                    </td> 
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <div style="display: flex; justify-content: space-between; gap: 10px;">
                                            <input type="reset" value="Reset" style="flex: 1;" class="login-btn btn-primary-soft btn ">
                                            <input type="submit" value="Save" style="flex: 1;" class="login-btn btn-primary btn">
                                        </div>
                                    </td>
                                </tr>
                            </form>
                        </table>
                    </div>
                </center>
            </div>
        </div>
        ';

    } elseif ($action == 'added') {
        $nameget = $_GET["name"];
        echo '

        <div id="popup1" class="overlay">
            <div class="popup">
            <center>
                <h2>Treatment Added.</h2>
                <a class="close" href="treatment.php">&times;</a>
                <div class="content">
                ' . substr($nameget, 0, 40) . ' was added as a treatment.<br><br>
                    
                </div>
                <div style="display: flex;justify-content: center;">
                
                <a href="treatment.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                <br><br><br><br>
                </div>
            </center>
            </div>
        </div>

        ';

    } elseif ($action == 'edited') {
        $nameget = $_GET["name"];            
        echo '

        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <h2>Treatment Updated.</h2>
                    <a class="close" href="treatment.php">&times;</a>
                    <div class="content">
                        Treatment ' . $nameget . ' was updated.<br><br>
                    </div>
                    <div style="display: flex;justify-content: center;">
                    
                        <a href="treatment.php" class="non-style-link">
                            <button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                                <font class="tn-in-text">
                                    &nbsp;&nbsp;OK&nbsp;&nbsp;
                                </font>
                            </button>
                        </a>

                        <br><br><br><br>

                    </div>
                </center>
            </div>
        </div>

        ';

    } elseif ($action == 'add-error') {
        $idget = $_GET["id"];
        $nameget = $_GET["name"];
        $errorget = $_GET["error"];
        if ($errorget == 1) {
            $error = "File is not an image.";
        }elseif ($errorget == 2) {
            $error = "Sorry, your file is too large.";
        }elseif ($errorget == 3) {
            $error = "Sorry, only JPG, JPEG, & PNG files are allowed.";
        }elseif ($errorget == 4) {
            $error = "Sorry, there was an error adding/editing your treatment.";
        }

        echo '
        
        <div id="popup1" class="overlay">
            <div class="popup">
            <center>
                <h2>No Changes Made.</h2>
                <a class="close" href="treatment.php">&times;</a>
                <div class="content">
                    Treatment name: ' . $nameget . '<br>
                    ' . $error . '
                </div>
                <div style="display: flex;justify-content: center;">
                    <a href="treatment.php" class="non-style-link">
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
        $nameget = $_GET["name"];
        $errorget = $_GET["error"];
        if ($errorget == 1) {
            $error = "File is not an image.";
        }elseif ($errorget == 2) {
            $error = "Sorry, your file is too large.";
        }elseif ($errorget == 3) {
            $error = "Sorry, only JPG, JPEG, & PNG files are allowed.";
        }elseif ($errorget == 4) {
            $error = "Sorry, there was an error adding/editing your treatment.";
        }

        echo '
        
        <div id="popup1" class="overlay">
            <div class="popup">
            <center>
                <h2>No Changes Made.</h2>
                <a class="close" href="treatment.php">&times;</a>
                <div class="content">
                    Treatment name: ' . $nameget . ' (ID: '. $idget. ') <br>
                    ' . $error . '
                </div>
                <div style="display: flex;justify-content: center;">
                    <a href="treatment.php" class="non-style-link">
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
    } elseif ($action == 'view') {
        $sqlmain = "SELECT * FROM treatment INNER JOIN admin ON treatment.aid = admin.aid WHERE treatmentid = '$id'";
        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();
    
        $treatmentid = $row["treatmentid"];
        $treatmentname = $row["treatmentname"];
        $treatmenttype = $row["treatmenttype"];
        $treatmentdesc = $row["treatmentdesc"];
        $treatmentprice = $row["treatmentprice"];
        $treatmentmax = $row["treatmentmax"];
    
        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="treatment.php">&times;</a> 
                    <div class="abc">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">
                                       Treatment Details
                                    </p>                                                                                    
                                </td>
                            </tr>

                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="treatmentname" class="form-label">Treatment Name: </label>
                                </td>
                                <td class="label-td" colspan="2">
                                    <p>' . $treatmentname . '</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="treatmentname" class="form-label">Treatment Name: </label>
                                </td>
                                <td class="label-td" colspan="2">
                                    <p>' . $treatmenttype . '</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="treatmentdesc" class="form-label">Treatment Description: </label>
                                </td>
                                <td class="label-td" colspan="2">
                                    <p>' . $treatmentdesc . '</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="treatmentprice" class="form-label">Treatment Price: </label>
                                </td>
                                <td class="label-td" colspan="2">
                                    <p>' . $treatmentprice . '</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="treatmentmax" class="form-label">Treatment Max: </label>
                                </td>
                                <td class="label-td" colspan="2">
                                    <p>' . $treatmentmax . '</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </center>
            </div>
        </div>
        ';
    }
    
}