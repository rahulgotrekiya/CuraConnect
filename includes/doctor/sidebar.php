<div class="menu">
    <table class="menu-conner" border="0">
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
                                    class="login-btn common-light-btn logout-btn btn-primary-soft btn"></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="menu-row">
            <td
                class="menu-btn menu-icon-dashbord <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'menu-active menu-icon-dashbord-active' : ''; ?>">
                <a href="index.php"
                    class="non-style-link-menu <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">Dashboard</p>
                    </div>
                </a>
            </td>
        </tr>
        <tr class="menu-row">
            <td
                class="menu-btn menu-icon-appoinment <?php echo basename($_SERVER['PHP_SELF']) === 'appointments.php' ? 'menu-active menu-icon-appoinment-active' : ''; ?>">
                <a href="appointments.php"
                    class="non-style-link-menu <?php echo basename($_SERVER['PHP_SELF']) === 'appointments.php' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">My Appointments</p>
                    </div>
                </a>
            </td>
        </tr>
        <tr class="menu-row">
            <td
                class="menu-btn menu-icon-session <?php echo basename($_SERVER['PHP_SELF']) === 'sessions.php' ? 'menu-active menu-icon-session-active' : ''; ?>">
                <a href="sessions.php"
                    class="non-style-link-menu <?php echo basename($_SERVER['PHP_SELF']) === 'sessions.php' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">My Sessions</p>
                    </div>
                </a>
            </td>
        </tr>
        <tr class="menu-row">
            <td
                class="menu-btn menu-icon-patient <?php echo basename($_SERVER['PHP_SELF']) === 'patients.php' ? 'menu-active menu-icon-patient-active' : ''; ?>">
                <a href="patients.php"
                    class="non-style-link-menu <?php echo basename($_SERVER['PHP_SELF']) === 'patients.php' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">My Patients</p>
                    </div>
                </a>
            </td>
        </tr>
        <tr class="menu-row">
            <td
                class="menu-btn menu-icon-settings <?php echo basename($_SERVER['PHP_SELF']) === 'settings.php' ? 'menu-active menu-icon-settings-active' : ''; ?>">
                <a href="settings.php"
                    class="non-style-link-menu <?php echo basename($_SERVER['PHP_SELF']) === 'settings.php' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">Settings</p>
                    </div>
                </a>
            </td>
        </tr>
    </table>
</div>