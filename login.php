<?php
  session_start();
  // include database
  include('includes/connection.php');
  include_once('includes/functions.php');

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
      $utype = $result->fetch_assoc()['type'];
      $user = getUserByEmail($database, $email, $utype);
      
      $is_valid = false;
      $redirect_url = '';
      
      if ($user) {
          if ($utype == 'p' && $user['ppassword'] == $password) {
              $is_valid = true;
              $redirect_url = 'patient/index.php';
          } elseif ($utype == 'a' && $user['apassword'] == $password) {
              $is_valid = true;
              $redirect_url = 'admin/index.php';
          } elseif ($utype == 'd' && $user['docpassword'] == $password) {
              $is_valid = true;
              $redirect_url = 'doctor/index.php';
          }
      }

      if ($is_valid) {
          $_SESSION['user'] = $email;
          $_SESSION['usertype'] = $utype;
          header('location: ' . $redirect_url);
          exit();
      } else {
          $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Invalid email or password, Please try again!</label>';
      }
    } else {
      $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We cant found any account for this email.         </label>';
    }
  } else {
    $error = '<label for="promter" class="form-label">&nbsp;</label>';
  }
?>
<!doctype html>
<html lang="en">

<head>
    <?php $pageTitle='Login'; include('includes/head.php'); ?>
</head>

<body>

    <?php
    // include header file
    include('includes/header.php');
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
                                    <input type="email" name="useremail" class="input-text" placeholder="Email Address"
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
                                    <input type="Password" name="userpassword" class="input-text" placeholder="Password"
                                        required />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><br><?php echo $error ?></td>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td">
                                    <input type="submit" value="Login" class="common-btn login-btn" />
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