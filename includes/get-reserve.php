<?php
if ($_GET) {
    $id = $_GET["id"];
    $action = $_GET["action"];

    if ($action == 'add') {
        echo '

        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="reserve.php">&times;</a> 
                    <div style="display: flex;justify-content: center;">
                        <div class="abc">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <form action="add-reserve.php" method="POST" class="add-new-form" enctype="multipart/form-data">
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Reserve.</p><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">                                                    
                                            <label for="reserveid" class="form-label"> Reserve For Branch:  </label>
                                            <input type="hidden" name="aid" value="' . $userid . '">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="reserveadmin" class="input-text" value="' . $username . '" readonly><br>
                                        </td>
                                    </tr>
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
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="productid" class="form-label">Select a Product: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <select name="productid" id="" class="box" >
                                                ';

                                                    $list11 = $database->query (
                                                    "SELECT * FROM product 
                                                     INNER JOIN admin ON product.aid = admin.aid 
                                                     WHERE product.aid = '$userid' 
                                                     ORDER BY productname ASC;
                                                    
                                                    ");

                                                    for ($y = 0; $y < $list11->num_rows; $y++) {
                                                        $row00 = $list11->fetch_assoc();
                                                        $sn = $row00["productname"];
                                                        $id00 = $row00["productid"];
                                                        echo "<option value=" . $id00 . ">$sn</option><br/>";
                                                    }

                                                echo'
                                            </select><br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="pickupdate" class="form-label">Pickup Date: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="date" name="pickupdate" class="input-text" min="' . date('Y-m-d') . '" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="reservequantity" class="form-label">Reserve Quantity: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="reservequantity" class="input-text" placeholder="Reserve Quantity" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="submit" value="Add this Reserve" class="login-btn btn-primary btn" name="addreserve">
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
                    <a class="close" href="reserve.php">&times;</a>
                    <div class="content">
                        You want to delete this record<br>(' . substr($nameget, 0, 40) . ').
                    </div>
                    <div style="display: flex;justify-content: center;">
                        <a href="delete-reserve.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="reserve.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
                    </div>
                </center>
            </div>
        </div>

        ';

    }  elseif ($action == 'added') {
        $nameget = $_GET["name"];
        echo '

        <div id="popup1" class="overlay">
            <div class="popup">
            <center>
                <h2>Reserve Added.</h2>
                <a class="close" href="reserve.php">&times;</a>
                <div class="content">
                ' . substr($nameget, 0, 40) . ' was added as a reserve.<br><br>
                    
                </div>
                <div style="display: flex;justify-content: center;">
                
                <a href="reserve.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                <br><br><br><br>
                </div>
            </center>
            </div>
        </div>

        ';

    } elseif ($action == 'edit') {
        $nameget = $_GET["name"];
        echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="reserve.php">&times;</a>
                        <div class="content">
                            You want to mark this reserve as done<br><br>
                            Product Name: &nbsp;<b>' . htmlspecialchars($nameget) . '</b><br>
                        </div>
                        <div style="display: flex;justify-content: center;">
                            <a href="reserve.php?id=' . htmlspecialchars($id) . '&action=confirm_edit&name=' . htmlspecialchars($nameget) . '" class="non-style-link">
                                <button class="btn-primary btn" style="display: flex; justify-content: center; align-items: center; margin: 10px; padding: 10px;">
                                    <font class="tn-in-text">&nbsp;Yes&nbsp;</font>
                                </button>
                            </a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="reserve.php" class="non-style-link">
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
        $reserveid = $_GET["id"];
        $nameget = $_GET["name"];
        $sqlmain = "UPDATE reserve SET status='Done' WHERE reserveid='$reserveid'";
        if ($database->query($sqlmain) === TRUE) {
            echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                            <h2>Record updated successfully</h2>
                            <a class="close" href="reserve.php">&times;</a>
                            <div class="content">
                                The reserve for <b>' . htmlspecialchars($nameget) . '</b> has been marked as done.
                            </div>
                            <div style="display: flex;justify-content: center;">
                                <a href="reserve.php" class="non-style-link">
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