<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="menu">
    <table>
        <tr>
            <td style="padding:10px" colspan="2">
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

        <tr class="menu-row">
            <td class="menu-btn menu-icon-dashbord <?php echo $current_page == 'index.php' ? 'menu-active menu-icon-dashbord-active' : ''; ?>">
                <a href="index.php" class="non-style-link-menu <?php echo $current_page == 'index.php' ? 'non-style-link-menu-active' : ''; ?>">
                    <div><p class="menu-text">Dashboard</p></div>
                </a>
            </td>
        </tr>
        <tr class="menu-row">
            <td class="menu-btn menu-icon-doctor <?php echo $current_page == 'accounts.php' ? 'menu-active menu-icon-doctor-active' : ''; ?>">
                <a href="accounts.php" class="non-style-link-menu <?php echo $current_page == 'accounts.php' ? 'non-style-link-menu-active' : ''; ?>">
                    <div><p class="menu-text">Accounts</p></div>
                </a>
            </td>
        </tr>
        <tr class="menu-row">
            <td class="menu-btn menu-icon-request <?php echo $current_page == 'request-m-i.php' ? 'menu-active menu-icon-request-active' : ''; ?>">
                <a href="request-m-i.php" class="non-style-link-menu <?php echo $current_page == 'request-m-i.php' ? 'non-style-link-menu-active' : ''; ?>">
                    <div><p class="menu-text">Skincare Products</p></div>
                </a>
            </td>
        </tr>
        <tr class="menu-row">
            <td class="menu-btn menu-icon-request <?php echo $current_page == 'request-m-s.php' ? 'menu-active menu-icon-request-active' : ''; ?>">
                <a href="request-m-s.php" class="non-style-link-menu <?php echo $current_page == 'request-m-s.php' ? 'non-style-link-menu-active' : ''; ?>">
                    <div><p class="menu-text">Treatment Products</p></div>
                </a>
            </td>
        </tr>
    </table>
</div>