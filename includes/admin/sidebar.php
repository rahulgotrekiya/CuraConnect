<div class="menu">
    <table class="menu-container" border="0">
        <tr>
            <td style="padding:10px" colspan="2">
                <table border="0" class="profile-container">
                    <tr>
                        <td width="30%" style="padding-left:20px">
                            <img src="../assets/images/dp.jpg" alt="" width="100%" style="border-radius:50%">
                        </td>
                        <td>
                            <p class="profile-title">Administrator</p>
                            <p class="profile-subtitle">
                                <?php echo shortenString($useremail ?? 'admin@edoc.com', 22); ?>
                            </p>
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
            <td
                class="menu-btn menu-icon-dashbord <?php echo $activePage === 'dashboard' ? 'menu-active menu-icon-dashbord-active' : ''; ?>">
                <a href="index.php"
                    class="non-style-link-menu <?php echo $activePage === 'dashboard' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">Dashboard</p>
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
                        <p class="menu-text">Doctors</p>
                    </div>
                </a>
            </td>
        </tr>
        <tr class="menu-row">
            <td
                class="menu-btn menu-icon-schedule <?php echo $activePage === 'schedule' ? 'menu-active menu-icon-schedule-active' : ''; ?>">
                <a href="schedule.php"
                    class="non-style-link-menu <?php echo $activePage === 'schedule' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">Schedule</p>
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
                        <p class="menu-text">Appointment</p>
                    </div>
                </a>
            </td>
        </tr>
        <tr class="menu-row">
            <td
                class="menu-btn menu-icon-patient <?php echo $activePage === 'patients' ? 'menu-active menu-icon-patient-active' : ''; ?>">
                <a href="patients.php"
                    class="non-style-link-menu <?php echo $activePage === 'patients' ? 'non-style-link-menu-active' : ''; ?>">
                    <div>
                        <p class="menu-text">Patients</p>
                    </div>
                </a>
            </td>
        </tr>
    </table>
</div>