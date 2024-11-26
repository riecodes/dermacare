<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="menu">
    <table class="menu-container" border="0">
        <tr>
            <td style="padding:10px" colspan="2">
                <table border="0" class="profile-container">
                    <tr>
                        <td width="30%" style="padding-left:20px">
                            <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                        </td>
                        <td style="padding:0px;margin:0px;">
                            <p class="profile-title"><?php echo substr($username, 0, 22); ?>..</p>
                            <p class="profile-subtitle"><?php echo substr($useremail, 0, 22); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a href="../logout.php">
                                <input type="button" value="Log out" class="logout-btn btn-primary-soft btn">
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="menu-row">
            <td class="menu-btn menu-icon-home <?php echo $current_page == 'index.php' ? 'menu-active menu-icon-home-active' : ''; ?>">
                <a href="index.php" class="non-style-link-menu <?php echo $current_page == 'index.php' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">Home</p>
                    </div>
                </a>
            </td>
        </tr>

        <tr class="menu-row">
            <td class="menu-btn menu-icon-doctor <?php echo $current_page == 'doctors.php' ? 'menu-active menu-icon-doctor-active' : ''; ?>">
                <a href="doctors.php" class="non-style-link-menu <?php echo $current_page == 'doctors.php' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">All Therapists</p>
                    </div>
                </a>
            </td>
        </tr>

        <tr class="menu-row">
            <td class="menu-btn menu-icon-session <?php echo $current_page == 'schedule.php' ? 'menu-active menu-icon-session-active' : ''; ?>">
                <a href="schedule.php" class="non-style-link-menu <?php echo $current_page == 'schedule.php' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">Scheduled Sessions</p>
                    </div>
                </a>
            </td>
        </tr>

        <tr class="menu-row">
            <td class="menu-btn menu-icon-appointment <?php echo $current_page == 'appointment.php' ? 'menu-active menu-icon-appointment-active' : ''; ?>">
                <a href="appointment.php" class="non-style-link-menu <?php echo $current_page == 'appointment.php' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">My Appointments</p>
                    </div>
                </a>
            </td>
        </tr>

        <tr class="menu-row">
            <td class="menu-btn menu-icon-settings <?php echo $current_page == 'settings.php' ? 'menu-active menu-icon-settings-active' : ''; ?>">
                <a href="settings.php" class="non-style-link-menu <?php echo $current_page == 'settings.php' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">Settings</p>
                    </div>
                </a>
            </td>
        </tr>
    </table>
</div>
