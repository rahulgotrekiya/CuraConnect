<div class="menu">
    <table class="menu-container" border="0">
        <tr>
            <td style="padding:10px" colspan="2">
                <table border="0" class="profile-container">
                    <tr>
                        <td width="30%" style="padding-left:20px">
                            <img src="../assets/images/user.png" alt="" width="100%" style="border-radius:50%">
                        </td>
                        <td>
                            <p class="profile-title"><?php echo shortenString($username, 13); ?></p>
                            <p class="profile-subtitle"><?php echo shortenString($useremail, 22); ?></p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a href="../logout.php"><input type="button" value="Log out"
                                    class="login-btn common-light-btn btn logout-btn btn-primary-soft"></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="menu-row">
            <td
                class="menu-btn menu-icon-home <?php echo $activePage === 'dashboard' ? 'menu-active menu-icon-home-active' : ''; ?>">
                <a href="index.php"
                    class="non-style-link-menu <?php echo $activePage === 'dashboard' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">Home</p>
                    </div>
                </a>
            </td>
        </tr>
        <tr class="menu-row">
            <td
                class="menu-btn menu-icon-doctor <?php echo $activePage === 'doctors' ? 'menu-active menu-icon-doctor-active' : ''; ?>">
                <a href="doctors.php"
                    class="non-style-link-menu <?php echo $activePage === 'doctors' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">All Doctors</p>
                    </div>
                </a>
            </td>
        </tr>
        <tr class="menu-row">
            <td
                class="menu-btn menu-icon-session <?php echo $activePage === 'schedule' ? 'menu-active menu-icon-session-active' : ''; ?>">
                <a href="schedule.php"
                    class="non-style-link-menu <?php echo $activePage === 'schedule' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">Scheduled Sessions</p>
                    </div>
                </a>
            </td>
        </tr>
        <tr class="menu-row">
            <td
                class="menu-btn menu-icon-appoinment <?php echo $activePage === 'appointment' ? 'menu-active menu-icon-appoinment-active' : ''; ?>">
                <a href="appointment.php"
                    class="non-style-link-menu <?php echo $activePage === 'appointment' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">My Bookings</p>
                    </div>
                </a>
            </td>
        </tr>
        <tr class="menu-row">
            <td
                class="menu-btn menu-icon-settings <?php echo $activePage === 'settings' ? 'menu-active menu-icon-settings-active' : ''; ?>">
                <a href="settings.php"
                    class="non-style-link-menu <?php echo $activePage === 'settings' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">Settings</p>
                    </div>
                </a>
            </td>
        </tr>
    </table>
</div>