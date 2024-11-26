<?php

if ($_GET) {
    $id = $_GET["id"];
    $action = $_GET["action"];

    //////////////////////////// DROP /////////////////////////////////////

    if ($action == 'drop') {
        $nameget = $_GET["name"];
        echo '
        <div id="popup1" class="overlay">
                <div class="popup">
                <center>
                    <h2>Are you sure?</h2>
                    <a class="close" href="request-m-i.php">&times;</a>
                    <div class="content">
                        You want to delete this record<br>(' . substr($nameget, 0, 40) . ').
                        
                    </div>
                    <div style="display: flex;justify-content: center;">
                        <a href="delete-request-m-i.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="request-m-i.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
                    </div>
                </center>
        </div>
        </div>
        ';

        //////////////////////////// EDIT /////////////////////////////////////

    } elseif ($action == 'edit') {
        $sqlmain = "SELECT *
                    FROM request 
                    INNER JOIN admin ON request.aid = admin.aid
                    INNER JOIN product ON request.productid = product.productid
                    WHERE requestid = '$id'";

        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();
        $requestid = $row["requestid"];
        $productname = $row["productname"];
        $aname = $row["aname"];
        $requestdate = $row["requestdate"];
        $requestquantity = $row["requestquantity"];
        $status = $row["status"];

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
                        <a class="close" href="request-m-i.php">&times;</a> 
                        <div class="abc">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <tr>

                                    <td class="label-td" colspan="2">' . $errorlist[$error_1] . '</td>
                                    
                                </tr>
                                <tr>

                                    <td>
                                        <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">
                                            Edit Request Details.
                                        </p>                                                                                    
                                    </td>

                                </tr>

                                
                                <tr>
                                    
                                    <td class="label-td" colspan="2">
                                        <label for="productname" class="form-label">Product Name: </label>
                                    </td>
                                    <td class="label-td" colspan="2">
                                    <form action="edit-request-m-i.php" method="POST" class="add-new-form">
                                    <input type="hidden" name="requestid" value="' . $requestid . '">
                                        <input type="text" name="productname" class="input-text" placeholder="Product Name" value="' . $productname . '" readonly>
                                    </td>
                                    
                                </tr>
                                <tr>

                                    <td class="label-td" colspan="2">
                                        <label for="aname" class="form-label">Admin Name: </label>                                                
                                    </td>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="aname" class="input-text" placeholder="Admin Name" value="' . $aname . '" readonly>
                                    </td>

                                </tr>                                        
                                <tr>

                                    <td class="label-td" colspan="2">
                                        <label for="aname" class="form-label">Request Quantity: </label>                                                
                                    </td>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="requestquantity" class="input-text" placeholder="Request Quantity" value="' . $requestquantity . '" >
                                    </td>

                                </tr> 
                                <tr>

                                    <td class="label-td" colspan="2">
                                        <label for="aname" class="form-label">Request Date: </label>                                                
                                    </td>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="requestdate" class="input-text" placeholder="Request Date" value="' . $requestdate . '" readonly>
                                    </td>

                                </tr> 
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="status" class="form-label">Status</label>
                                    </td>
                                    <td class="label-td" colspan="2">
                                        <select name="status" class="box">';

            // Get the status of the current request
            $list11 = $database->query(
                "SELECT status FROM request WHERE requestid = '$id'"
            );

            // Define the possible enum values
            $status_options = ['Pending', 'Approved', 'Denied'];

            // Loop through each request and its status
            for ($y = 0; $y < $list11->num_rows; $y++) {
                $row00 = $list11->fetch_assoc();
                $current_status = $row00["status"];  // Current status of the request
                $id00 = $row00["requestid"];  // Request ID

                // Echo the opening of the select tag
                '. <option value=""></option>. ';
                foreach ($status_options as $status) {
                    // Check if the current status matches the enum option
                    $selected = ($current_status == $status) ? 'selected' : '';
                    echo "<option value='$status' $selected>$status</option>";
                }
            }

            echo '

                                        </select>
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
                                </tr>
                            </table>
                        </div>
                    </center>
                    <br><br>
                    </div>
                </div>
                ';
        }
    } elseif ($action == 'edited') {
        $id = $_GET["id"];
        $nameget = $_GET["name"];
        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                <br><br><br><br>
                <h2>Edit Successfully!</h2>
                <a class="close" href="request-m-i.php">&times;</a>
                <div class="content">
                    Request ID: ' . $id . ' (' . substr($nameget, 0, 40) . ') has been successfully edited. 
                </div>
                <div style="display: flex;justify-content: center;">
                    <a href="request-m-i.php" class="non-style-link">
                        <button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                            <font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font>
                        </button>
                    </a>
                </div>
                <br><br>
                </center>
            </div>
        </div> 
        ';
    };
};
