<?php
if ($_GET) {
    $id = $_GET["id"];
    $action = $_GET["action"];

    if ($action == 'add') {
        echo '

        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="skincare.php">&times;</a> 
                    <div style="display: flex;justify-content: center;">
                        <div class="abc">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <form action="add-skincare.php" method="POST" class="add-new-form" enctype="multipart/form-data">
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Skincare.</p><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">                                                    
                                            <label for="skincareid" class="form-label"> Skincare For:  </label>
                                            <input type="hidden" name="aid" value="' . $userid . '">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="skincareadmin" class="input-text" value="' . $username . '" readonly><br>
                                        </td>
                                    </tr>
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
                                            <label for="skincarequantity" class="form-label">Skincare Quantity: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="skincarequantity" class="input-text" placeholder="Skincare Quantity" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="submit" value="Add this Skincare" class="login-btn btn-primary btn" name="addskincare">
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
                    <a class="close" href="skincare.php">&times;</a>
                    <div class="content">
                        You want to delete this record<br>(' . substr($nameget, 0, 40) . ').
                    </div>
                    <div style="display: flex;justify-content: center;">
                        <a href="delete-skincare.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="skincare.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
                    </div>
                </center>
            </div>
        </div>

        ';

    } elseif ($action == 'edit') {
        $sqlmain = "SELECT * FROM skincare INNER JOIN admin ON skincare.aid = admin.aid WHERE skincareid = '$id'";
        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();        
        $skincareid = $row["skincareid"];
        $productid = $row["productid"];
        $skincarequantity = $row["skincarequantity"];
        $aname = $row["aname"];

        // get productname using productid
        $sql = "SELECT * FROM product WHERE productid = '$productid'";
        $result = $database->query($sql);
        $row2 = $result->fetch_assoc();
        $productname = $row2["productname"];

        echo '

        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="skincare.php">&times;</a> 
                    <div class="abc">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                            <form action="edit-skincare.php" method="POST" class="add-new-form" enctype="multipart/form-data">
                                <tr>
                                    <td>
                                        <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">
                                            Edit Skincare Details.
                                        </p>
                                        <br>
                                        <p style="padding: 0;margin: 0;text-align: left;font-size: 20px;font-weight: 500;">
                                            Product Name: ' . $productname . '
                                        </p>                               
                                        <input type="hidden" name="aid" value="' . $userid . '">
                                        <br>                                                       
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="skincarename" class="form-label">Skincare ID: </label>
                                    </td>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="skincareid" class="input-text" value="'. $skincareid . ' (Auto Generated)" readonly>                               
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="productid" class="form-label">Product ID: </label>
                                    </td>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="productid" class="input-text" value="'. $productid . '" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="skincarequantity" class="form-label">Skincare Quantity: </label>
                                    </td>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="skincarequantity" class="input-text" value="'. $skincarequantity . '">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding: 20px 0;">
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
                <h2>Skincare Added.</h2>
                <a class="close" href="skincare.php">&times;</a>
                <div class="content">
                ' . substr($nameget, 0, 40) . ' was added as a skincare.<br><br>
                    
                </div>
                <div style="display: flex;justify-content: center;">
                
                <a href="skincare.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
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
                    <h2>Skincare Updated.</h2>
                    <a class="close" href="skincare.php">&times;</a>
                    <div class="content">
                        Skincare ' . $nameget . ' was updated.<br><br>
                    </div>
                    <div style="display: flex;justify-content: center;">
                    
                        <a href="skincare.php" class="non-style-link">
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
            $error = "Sorry, there was an error adding/editing your skincare.";
        }

        echo '
        
        <div id="popup1" class="overlay">
            <div class="popup">
            <center>
                <h2>No Changes Made.</h2>
                <a class="close" href="skincare.php">&times;</a>
                <div class="content">
                    Skincare name: ' . $nameget . '<br>
                    ' . $error . '
                </div>
                <div style="display: flex;justify-content: center;">
                    <a href="skincare.php" class="non-style-link">
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
            $error = "Sorry, there was an error adding/editing your skincare.";
        }

        echo '
        
        <div id="popup1" class="overlay">
            <div class="popup">
            <center>
                <h2>No Changes Made.</h2>
                <a class="close" href="skincare.php">&times;</a>
                <div class="content">
                    Skincare name: ' . $nameget . ' (ID: '. $idget. ') <br>
                    ' . $error . '
                </div>
                <div style="display: flex;justify-content: center;">
                    <a href="skincare.php" class="non-style-link">
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
    } 
}