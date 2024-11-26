<?php
if ($_GET) {
    $id = $_GET["id"];
    $action = $_GET["action"];

    if ($action == 'add') {
        echo '

        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="inventory.php">&times;</a> 
                    <div style="display: flex;justify-content: center;">
                        <div class="abc">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <form action="add-inventory.php" method="POST" class="add-new-form" enctype="multipart/form-data">
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Product.</p><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">                                                    
                                            <label for="productid" class="form-label"> Product For:  </label>
                                            <input type="hidden" name="aid" value="' . $userid . '">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="productadmin" class="input-text" value="' . $username . ' " readonly required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="productname" class="form-label">Product Name: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="productname" class="input-text" placeholder="Name of the product" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="productdesc" class="form-label">Product Desc: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="productdesc" class="input-text" placeholder="Product description" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="productprice" class="form-label">Product Price: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="productprice" class="input-text" placeholder="How much for the product?" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="productquantity" class="form-label">Product Quantity: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="productquantity" class="input-text" placeholder="How many products?" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="productimage" class="form-label">Product Image: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="file" name="productimage" class="input-text" accept="image/*" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="submit" value="Add this Product" class="login-btn btn-primary btn" name="addproduct">
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
                    <a class="close" href="inventory.php">&times;</a>
                    <div class="content">
                        You want to delete this record<br>(' . substr($nameget, 0, 40) . ').
                    </div>
                    <div style="display: flex;justify-content: center;">
                        <a href="delete-inventory.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="inventory.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
                    </div>
                </center>
            </div>
        </div>

        ';

    } elseif ($action == 'edit') {
        $sqlmain = "SELECT * FROM product INNER JOIN admin ON product.aid = admin.aid WHERE productid = '$id'";
        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();

        $productid = $row["productid"];
        $productname = $row["productname"];
        $productdesc = $row["productdesc"];
        $productquantity = $row["productquantity"];
        $productprice = $row["productprice"];

        echo '

        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="inventory.php">&times;</a> 
                    <div class="abc">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                            <form action="edit-inventory.php" method="POST" class="add-new-form" enctype="multipart/form-data">
                                <tr>
                                    <td>
                                        <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">
                                            Edit Product Details.
                                        </p>                                                                                    
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="productname" class="form-label">Product Name: </label>
                                    </td>
                                    <td class="label-td" colspan="2">
                        
                                        <input type="hidden" name="productid" value="' . $productid . '">
                                        <input type="text" name="productname" class="input-text" placeholder="Product Name" value="' . $productname . '" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="productdesc" class="form-label">Product Desc: </label>
                                    </td>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="productdesc" class="input-text" placeholder="Product Desc" value="' . $productdesc . '" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="productprice" class="form-label">Product Price: </label>
                                    </td>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="productprice" class="input-text" placeholder="Product Price" value="' . $productprice . '" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="productquantity" class="form-label">Product Quantity: </label>
                                    </td>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="productquantity" class="input-text" placeholder="Product Quantity" value="' . $productquantity . '" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="productimage" class="form-label">Product Image: </label>
                                    </td>
                                    <td class="label-td" colspan="2">                                                
                                        <input type="file" name="productimage" class="input-text" accept="image/*">
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
                <h2>Product Added.</h2>
                <a class="close" href="inventory.php">&times;</a>
                <div class="content">
                ' . substr($nameget, 0, 40) . ' was added as a product.<br><br>
                    
                </div>
                <div style="display: flex;justify-content: center;">
                
                <a href="inventory.php" class="non-style-link"><button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
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
                    <h2>Product Updated.</h2>
                    <a class="close" href="inventory.php">&times;</a>
                    <div class="content">
                        Product ' . $nameget . ' was updated.<br><br>
                    </div>
                    <div style="display: flex;justify-content: center;">
                    
                        <a href="inventory.php" class="non-style-link">
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
            $error = "Sorry, there was an error adding/editing your product.";
        }

        echo '
        
        <div id="popup1" class="overlay">
            <div class="popup">
            <center>
                <h2>No Changes Made.</h2>
                <a class="close" href="inventory.php">&times;</a>
                <div class="content">
                    Product name: ' . $nameget . '<br>
                    ' . $error . '
                </div>
                <div style="display: flex;justify-content: center;">
                    <a href="inventory.php" class="non-style-link">
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
            $error = "Sorry, there was an error adding/editing your product.";
        }

        echo '
        
        <div id="popup1" class="overlay">
            <div class="popup">
            <center>
                <h2>No Changes Made.</h2>
                <a class="close" href="inventory.php">&times;</a>
                <div class="content">
                    Product name: ' . $nameget . ' (ID: '. $idget. ') <br>
                    ' . $error . '
                </div>
                <div style="display: flex;justify-content: center;">
                    <a href="inventory.php" class="non-style-link">
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
        $sqlmain = "SELECT * FROM product INNER JOIN admin ON product.aid = admin.aid WHERE productid = '$id'";
        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();
    
        $productid = $row["productid"];
        $productname = $row["productname"];
        $productdesc = $row["productdesc"];
        $productquantity = $row["productquantity"];
        $productprice = $row["productprice"];
    
        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="inventory.php">&times;</a> 
                    <div class="abc">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">
                                        Details
                                    </p>                                                                                    
                                </td>
                            </tr>

                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="productname" class="form-label">Product Name: </label>
                                </td>
                                <td class="label-td" colspan="2">
                                    <p>' . $productname . '</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="productdesc" class="form-label">Product Description: </label>
                                </td>
                                <td class="label-td" colspan="2">
                                    <p>' . $productdesc . '</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="productprice" class="form-label">Product Price: </label>
                                </td>
                                <td class="label-td" colspan="2">
                                    <p>' . $productprice . '</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="productquantity" class="form-label">Product Quantity: </label>
                                </td>
                                <td class="label-td" colspan="2">
                                    <p>' . $productquantity . '</p>
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