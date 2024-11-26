<?php

    if ($_GET) {
        $id = $_GET["id"];
        $action = $_GET["action"];
        if ($action == 'add') {
            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <a class="close" href="request-s.php">&times;</a> 
                        <div style="display: flex;justify-content: center;">
                            <div class="abc">
                                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Request.</p><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <form action="add-request-s.php" method="POST" class="add-new-form">
                                            <label for="stockid" class="form-label"> Requesting Admin:  </label>
                                            <input type="hidden" name="aid" value="' . $userid . '">                                                                                        
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="requesting admin" class="input-text" value="' . $username . ' " readonly><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="stockid" class="form-label">Select Stock: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <select name="stockid" id="" class="box" >
                                                ';

                                                    $list11 = $database->query (
                                                    "SELECT * FROM stock 
                                                     INNER JOIN admin ON stock.aid = admin.aid 
                                                     WHERE stock.aid = '$userid' 
                                                     ORDER BY stockname ASC;
                                                    
                                                    ");

                                                    for ($y = 0; $y < $list11->num_rows; $y++) {
                                                        $row00 = $list11->fetch_assoc();
                                                        $sn = $row00["stockname"];
                                                        $id00 = $row00["stockid"];
                                                        echo "<option value=" . $id00 . ">$sn</option><br/>";
                                                    }

                                                echo'
                                            </select><br><br>
                                            <input type="hidden" name="stockname" value="' . $sn . '">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="requestquantity" class="form-label">Request Quantity : </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="number" name="requestquantity" class="input-text" min="0" placeholder="How many stocks do you want to request?" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="date" class="form-label">Request Date: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="date" name="date" class="input-text" min="' . date('Y-m-d') . '" value="' . date('Y-m-d') . '" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="submit" value="Place this Request" class="login-btn btn-primary btn" name="requestsubmit">
                                        </td>
                                    </tr>
                                    </form>
                                </table>
                            </div>
                        </div>
                    </center>
                </div>
            </div>';

        } elseif ($action == 'added') {
            $id = $_GET["id"];
            $nameget = $_GET["name"];
            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                <center>
                    <h2>Request Placed.</h2>
                    <a class="close" href="request-s.php">&times;</a>
                    <div class="content">
                    ' . substr($nameget, 0, 40) . ' was requested.<br><br>
                        
                    </div>
                    <div style="display: flex;justify-content: center;">
                    
                    <a href="request-s.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                    <br><br><br><br>
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
                        <a class="close" href="request-s.php">&times;</a>
                        <div class="content">
                            You want to delete this record<br>(' . substr($nameget, 0, 40) . ').
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-request-s.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="request-s.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            ';
        } 
    }
    ?>