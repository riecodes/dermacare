<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="menu">
    <table>
        <tr>
            <td>
                <table border="0" class="profile-container">
                    <tr>
                        <td width="30%" style="padding-left:20px">
                            <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                        </td>
                        <td style="padding:0px;margin:0px;">
                            <p class="profile-title"><?php echo substr($username, 0, 22) ?></p>
                            <p class="profile-subtitle"><?php echo substr($useremail, 0, 22) ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a href="../logout.php"><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <div class="abc scroll">
            
            <tr class="menu-row">
                <td class="menu-heading">
                    <p class="title-text">General</p>
                    <span class="menu-line"></span>
                </td>
            </tr>

            <tr class="menu-row">
                <td class="menu-btn menu-icon-dashbord <?php echo $current_page == 'index.php' ? 'menu-active menu-icon-dashbord-active' : ''; ?>">
                <a href="index.php" class="non-style-link-menu <?php echo $current_page == 'index.php' ? 'non-style-link-menu-active' : ''; ?>">
                        <div><p class="menu-text">Dashboard</p></div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-doctor <?php echo $current_page == 'doctors.php' ? 'menu-active menu-icon-doctor-active' : ''; ?>">
                    <a href="doctors.php" class="non-style-link-menu <?php echo $current_page == 'doctors.php' ? 'non-style-link-menu-active' : ''; ?>">
                        <div><p class="menu-text">Therapists</p></div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-appointment <?php echo $current_page == 'appointment.php' ? 'menu-active menu-icon-appointment-active' : ''; ?>">
                    <a href="appointment.php" class="non-style-link-menu <?php echo $current_page == 'appointment.php' ? 'non-style-link-menu-active' : ''; ?>">
                        <div><p class="menu-text">Appointment</p></div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-reserve <?php echo $current_page == 'reserve.php' ? 'menu-active menu-icon-reserve-active' : ''; ?>">
                    <a href="reserve.php" class="non-style-link-menu <?php echo $current_page == 'reserve.php' ? 'non-style-link-menu-active' : ''; ?>">
                        <div><p class="menu-text">Reserved Products</p></div>
                    </a>
                </td>
            </tr>

            <tr class="menu-row">
                <td class="menu-heading">
                    <p class="title-text">Posting to Mobile</p>
                    <span class="menu-line"></span>
                </td>
            </tr>

            <tr class="menu-row">
                <td class="menu-btn menu-icon-schedule <?php echo $current_page == 'schedule.php' ? 'menu-active menu-icon-schedule-active' : ''; ?>">
                    <a href="schedule.php" class="non-style-link-menu <?php echo $current_page == 'schedule.php' ? 'non-style-link-menu-active' : ''; ?>">
                        <div><p class="menu-text">Schedule Treatments</p></div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-reserve <?php echo $current_page == 'skincare.php' ? 'menu-active menu-icon-reserve-active' : ''; ?>">
                    <a href="skincare.php" class="non-style-link-menu <?php echo $current_page == 'skincare.php' ? 'non-style-link-menu-active' : ''; ?>">
                        <div><p class="menu-text">Available Skincare</p></div>
                    </a>
                </td>
            </tr>       


            <tr class="menu-row">
                <td class="menu-heading">
                    <p class="title-text">Adding Stocks</p>
                    <span class="menu-line"></span>
                </td>
            </tr>
            <tr class="menu-row">
                <td  class="menu-btn menu-icon-treatment <?php echo $current_page == 'treatment.php' ? 'menu-active menu-icon-treatment-active' : ''; ?>">
                    <a  href="treatment.php" class="non-style-link-menu <?php echo $current_page == 'treatment.php' ? 'non-style-link-menu-active' : ''; ?>">
                        <div><p class="menu-text">Treatments</p></div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-stockroom <?php echo $current_page == 'stock.php' ? 'menu-active menu-icon-stockroom-active' : ''; ?>">
                    <a href="stock.php" class="non-style-link-menu <?php echo $current_page == 'stock.php' ? 'non-style-link-menu-active' : ''; ?>">
                        <div><p class="menu-text">Treatment Product</p></div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-inventory <?php echo $current_page == 'inventory.php' ? 'menu-active menu-icon-inventory-active' : ''; ?>">
                    <a href="inventory.php" class="non-style-link-menu <?php echo $current_page == 'inventory.php' ? 'non-style-link-menu-active' : ''; ?>">
                        <div><p class="menu-text">Skincare Product</p></div>
                    </a>
                </td>
            </tr>

            <tr class="menu-row">
                <td class="menu-heading">
                    <p class="title-text">Request Products</p>
                    <span class="menu-line"></span>
                </td>
            </tr>

            <tr class="menu-row">
                <td class="menu-btn menu-icon-request <?php echo $current_page == 'request-i.php' ? 'menu-active menu-icon-request-active' : ''; ?>">
                    <a href="request-i.php" class="non-style-link-menu <?php echo $current_page == 'request-i.php' ? 'non-style-link-menu-active' : ''; ?>">
                        <div><p class="menu-text">Request Skincare Products</p></div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-request <?php echo $current_page == 'request-s.php' ? 'menu-active menu-icon-request-active' : ''; ?>">
                    <a href="request-s.php" class="non-style-link-menu <?php echo $current_page == 'request-s.php' ? 'non-style-link-menu-active' : ''; ?>">
                        <div><p class="menu-text">Request Treatment Products</p></div>
                    </a>
                </td>
            </tr>
        </div>
    </table>
</div>