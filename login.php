<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="assets/css/style-common.css" />
</head>

<body>

  <?php

  // include header file
  include('includes/header.php');

  // include database
  include('includes/connection.php');

  session_start();

  $_SESSION['user'] = '';
  $_SESSION['usertype'] = '';

  // Set the new timezone
  date_default_timezone_set('Asia/Kolkata');
  $date = date('Y-m-d');

  $_SESSION['date'] = $date;

  if ($_POST) {
    $email = $_POST['useremail'];
    $password = $_POST['userpassword'];

    $error = '<label for="promter" class="form-label"></label>';

    $result = $database->query("select * from users where email='$email'");
    if ($result->num_rows == 1) {
      $utype = $result->fetch_assoc()['usertype'];
      if ($utype == 'p') {
        $checker = $database->query("select * from patient where pemail='$email' and ppassword='$password'");
        if ($checker->num_rows == 1) {
          //   Patient dashbord
          $_SESSION['user'] = $email;
          $_SESSION['usertype'] = 'p';

          header('location: patient/index.php');
        } else {
          $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Invalid email or password, Please try again!</label>';
        }
      } elseif ($utype == 'a') {
        $checker = $database->query("select * from admin where aemail='$email' and apassword='$password'");
        if ($checker->num_rows == 1) {
          //   Admin dashbord
          $_SESSION['user'] = $email;
          $_SESSION['usertype'] = 'a';

          header('location: admin/index.php');
        } else {
          $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Invalid email or password, Please try again!</label>';
        }
      } elseif ($utype == 'd') {
        $checker = $database->query("select * from doctor where docemail='$email' and docpassword='$password'");
        if ($checker->num_rows == 1) {
          //   doctor dashbord
          $_SESSION['user'] = $email;
          $_SESSION['usertype'] = 'd';
          header('location: doctor/index.php');
        } else {
          $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Invalid email or password, Please try again!</label>';
        }
      }
    } else {
      $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We cant found any account for this email.         </label>';
    }
  } else {
    $error = '<label for="promter" class="form-label">&nbsp;</label>';
  }

  ?>

  <!--login section-->

  <section class="login-section">
    <center>
      <div class="login-block">
        <h2>Welcome Back!</h2>
        <p class="sub-text">Login with your details to continue</p>
        <div class="login-form">
          <form action="" method="POST">
            <table border="0" style="margin: 0; padding: 0; width: 60%">
              <tr>
                <td class="label-td">
                  <label for="useremail" class="form-label">Email: </label>
                </td>
              </tr>
              <tr>
                <td class="label-td">
                  <input
                    type="email"
                    name="useremail"
                    class="input-text"
                    placeholder="Email Address"
                    required />
                </td>
              </tr>
              <tr>
                <td class="label-td">
                  <label for="userpassword" class="form-label">Password:
                  </label>
                </td>
              </tr>
              <tr>
                <td class="label-td">
                  <input
                    type="Password"
                    name="userpassword"
                    class="input-text"
                    placeholder="Password"
                    required />
                </td>
              </tr>
              <tr>
                <td colspan="2"><br><?php echo $error ?></td>
                </td>
              </tr>
              <tr>
                <td class="label-td">
                  <input
                    type="submit"
                    value="Login"
                    class="common-btn login-btn" />
                </td>
              </tr>
              <tr>
                <td>
                  <br />
                  <label for="" class="sub-text" style="font-weight: 280">Don't have an account&#63;
                  </label>
                  <a href="signup.php" class="hover-link1">Sign Up</a>
                  <br /><br /><br />
                </td>
              </tr>
            </table>
          </form>
        </div>
      </div>
    </center>
  </section>

  <!--login section end-->

  <!--footer-->
  <?php include('includes/footer.php'); ?>
  <!--footer end-->
</body>

</html>