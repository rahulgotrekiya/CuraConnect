<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient - CuraConnect</title>
    <link rel="icon" href="../assets/images/fav.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/patient.css">
    <link rel="stylesheet" href="../assets/css/style-common.css">
</head>

<body>
    <?php
    include("../includes/connection.php");

    session_start();

    if (isset($_SESSION['user'])) {
        if (($_SESSION['user']) == '' or $_SESSION['usertype'] != 'a') {
            header('location: ../login.php');
        } else {
            $useremail = $_SESSION['user'];
        }
    } else {
        header('location: ../login.php');
    }

    // import database

    ?>
    <center>

        <div class="container">
            <table border="0" class="profile-container">
                <tr>
                    <td width="30%" style="padding-left:20px">
                        <img src="../assets/images/user.png" alt="" width="100%" style="border-radius:50%">
                    </td>
                    <td>
                        <p class="profile-title">Administrator</p>
                        <p class="profile-subtitle">admin@edoc.com</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <a href="../logout.php"><input type="button" value="Log out" class="login-btn common-light-btn logout-btn btn-primary-soft"></a>
                    </td>
                </tr>
            </table>
        </div>
    </center>
</body>

</html>