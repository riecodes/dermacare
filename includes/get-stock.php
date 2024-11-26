<?php
if ($_GET) {
    $id = $_GET["id"];
    $action = $_GET["action"];

    if ($action == 'add') {
        echo '

        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="stock.php">&times;</a> 
                    <div style="display: flex;justify-content: center;">
                        <div class="abc">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <form action="add-stock.php" method="POST" class="add-new-form" enctype="multipart/form-data">
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Stock.</p><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">                                                    
                                            <label for="stockid" class="form-label"> Stock For:  </label>
                                            <input type="hidden" name="aid" value="' . $userid . '">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="stockadmin" class="input-text" value="' . $username . ' " readonly required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="stockname" class="form-label">Stock Name: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="stockname" class="input-text" placeholder="Name of the stock" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="stockdesc" class="form-label">Stock Desc: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="stockdesc" class="input-text" placeholder="Stock description" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="stockprice" class="form-label">Stock Price: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="stockprice" class="input-text" placeholder="How much for the stock?" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="stockquantity" class="form-label">Stock Quantity: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="stockquantity" class="input-text" placeholder="How many stocks?" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="stockimage" class="form-label">Stock Image: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="file" name="stockimage" class="input-text" accept="image/*" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="submit" value="Add this Stock" class="login-btn btn-primary btn" name="addstock">
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
                    <a class="close" href="stock.php">&times;</a>
                    <div class="content">
                        You want to delete this record<br>(' . substr($nameget, 0, 40) . ').
                    </div>
                    <div style="display: flex;justify-content: center;">
                        <a href="delete-stock.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="stock.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
                    </div>
                </center>
            </div>
        </div>

        ';

    } elseif ($action == 'edit') {
        $sqlmain = "SELECT * FROM stock INNER JOIN admin ON stock.aid = admin.aid WHERE stockid = '$id'";
        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();

        $stockid = $row["stockid"];
        $stockname = $row["stockname"];
        $stockdesc = $row["stockdesc"];
        $stockquantity = $row["stockquantity"];
        $stockprice = $row["stockprice"];

        echo '

        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="stock.php">&times;</a> 
                    <div class="abc">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                            <form action="edit-stock.php" method="POST" class="add-new-form" enctype="multipart/form-data">
                                <tr>
                                    <td>
                                        <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">
                                            Edit Stock Details.
                                        </p>                                                                                    
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="stockname" class="form-label">Stock Name: </label>
                                    </td>
                                    <td class="label-td" colspan="2">
                        
                                        <input type="hidden" name="stockid" value="' . $stockid . '">
                                        <input type="text" name="stockname" class="input-text" placeholder="Stock Name" value="' . $stockname . '" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="stockdesc" class="form-label">Stock Desc: </label>
                                    </td>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="stockdesc" class="input-text" placeholder="Stock Desc" value="' . $stockdesc . '" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="stockprice" class="form-label">Stock Price: </label>
                                    </td>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="stockprice" class="input-text" placeholder="Stock Price" value="' . $stockprice . '" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="stockquantity" class="form-label">Stock Quantity: </label>
                                    </td>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="stockquantity" class="input-text" placeholder="Stock Quantity" value="' . $stockquantity . '" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="stockimage" class="form-label">Stock Image: </label>
                                    </td>
                                    <td class="label-td" colspan="2">                                                
                                        <input type="file" name="stockimage" class="input-text" accept="image/*">
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
                <h2>Stock Added.</h2>
                <a class="close" href="stock.php">&times;</a>
                <div class="content">
                ' . substr($nameget, 0, 40) . ' was added as a stock.<br><br>
                    
                </div>
                <div style="display: flex;justify-content: center;">
                
                <a href="stock.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
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
                    <h2>Stock Updated.</h2>
                    <a class="close" href="stock.php">&times;</a>
                    <div class="content">
                        Stock ' . $nameget . ' was updated.<br><br>
                    </div>
                    <div style="display: flex;justify-content: center;">
                    
                        <a href="stock.php" class="non-style-link">
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
            $error = "Sorry, there was an error adding/editing your stock.";
        }

        echo '
        
        <div id="popup1" class="overlay">
            <div class="popup">
            <center>
                <h2>No Changes Made.</h2>
                <a class="close" href="stock.php">&times;</a>
                <div class="content">
                    Stock name: ' . $nameget . '<br>
                    ' . $error . '
                </div>
                <div style="display: flex;justify-content: center;">
                    <a href="stock.php" class="non-style-link">
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
            $error = "Sorry, there was an error adding/editing your stock.";
        }

        echo '
        
        <div id="popup1" class="overlay">
            <div class="popup">
            <center>
                <h2>No Changes Made.</h2>
                <a class="close" href="stock.php">&times;</a>
                <div class="content">
                    Stock name: ' . $nameget . ' (ID: '. $idget. ') <br>
                    ' . $error . '
                </div>
                <div style="display: flex;justify-content: center;">
                    <a href="stock.php" class="non-style-link">
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
        $sqlmain = "SELECT * FROM stock INNER JOIN admin ON stock.aid = admin.aid WHERE stockid = '$id'";
        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();
    
        $stockid = $row["stockid"];
        $stockname = $row["stockname"];
        $stockdesc = $row["stockdesc"];
        $stockquantity = $row["stockquantity"];
        $stockprice = $row["stockprice"];
    
        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="stock.php">&times;</a> 
                    <div class="abc">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">
                                        View Stock Details
                                    </p>                                                                                    
                                </td>
                            </tr>

                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="stockname" class="form-label">Stock Name: </label>
                                </td>
                                <td class="label-td" colspan="2">
                                    <p>' . $stockname . '</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="stockdesc" class="form-label">Stock Description: </label>
                                </td>
                                <td class="label-td" colspan="2">
                                    <p>' . $stockdesc . '</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="stockprice" class="form-label">Stock Price: </label>
                                </td>
                                <td class="label-td" colspan="2">
                                    <p>' . $stockprice . '</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="stockquantity" class="form-label">Stock Quantity: </label>
                                </td>
                                <td class="label-td" colspan="2">
                                    <p>' . $stockquantity . '</p>
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