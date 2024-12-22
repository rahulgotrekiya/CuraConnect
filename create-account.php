<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CuraConnect</title>
  <link href="assets/css/style.css" rel="stylesheet" />
  <link href="assets/css/style-common.css" rel="stylesheet" />
</head>

<body>

  <!--header-->

  <?php
  include('includes/header.php');
  include('includes/connection.php');

  session_start();

  $_SESSION['user'] = '';
  $_SESSION['usertype'] = '';

  // Set the new timezone
  date_default_timezone_set('Asia/Kolkata');
  $date = date('Y-m-d');

  $_SESSION['date'] = $date;

  if ($_POST) {
    $result = $database->query('select * from users');

    $fname = $_SESSION['personal']['fname'];
    $lname = $_SESSION['personal']['lname'];
    $name = $fname . ' ' . $lname;
    $address = $_SESSION['personal']['address'];
    $dob = $_SESSION['personal']['dob'];
    $email = $_POST['newemail'];
    $tele = $_POST['tele'];
    $newpassword = $_POST['newpassword'];
    $cpassword = $_POST['cpassword'];

    if ($newpassword == $cpassword) {
      $result = $database->query("select * from users where email='$email';");
      if ($result->num_rows == 1) {
        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>';
      } else {
        $database->query("insert into patient(pemail, pname, ppassword, paddress, pdob, ptel) values('$email', '$name', '$newpassword', '$address', '$dob', '$tele');");
        $database->query("insert into users values('$email','p')");

        print_r("insert into patient values($pid, '$email', '$fname', '$lname', '$newpassword', '$address', '$dob', '$tele');");
        $_SESSION['user'] = $email;
        $_SESSION['usertype'] = 'p';
        $_SESSION['username'] = $fname;

        header('Location: patient/index.php');
        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>';
      }
    } else {
      $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password does not match, Please Try again!</label>';
    }
  } else {
    // header('location: signup.php');
    $error = '<label for="promter" class="form-label"></label>';
  }

  ?>



  <!--header end-->

  <!--create account section-->

  <section class="login-section">
    <center>
      <div class="login-block">
        <h2>Let's Get Started</h2>
        <p class="sub-text">It's Okay, Now Create User Account.</p>
        <div class="login-form">
          <table border="0" style="width: 69%">
            <form action="" method="POST">
              <tr>
                <td class="label-td" colspan="2">
                  <label for="newemail" class="form-label">Email: </label>
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <input
                    type="email"
                    name="newemail"
                    class="input-text"
                    placeholder="Email Address"
                    required />
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <label for="tele" class="form-label">Mobile Number: </label>
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <input
                    type="tel"
                    name="tele"
                    class="input-text"
                    placeholder="Ex: 9123456789" />
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <label for="newpassword" class="form-label">Create New Password:
                  </label>
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <input
                    type="password"
                    name="newpassword"
                    class="input-text"
                    placeholder="New Password"
                    required />
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <label for="cpassword" class="form-label">Conform Password:
                  </label>
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <input
                    type="password"
                    name="cpassword"
                    class="input-text"
                    placeholder="Conform Password"
                    required />
                </td>
              <tr>
                <td colspan="2"><br><?php echo $error ?></td>
              </tr>
              <td class="td-btn">
                <input
                  type="reset"
                  value="Reset"
                  class="login-btn common-light-btn" />
              </td>
              <td class="td-btn">
                <input
                  type="submit"
                  value="Next"
                  class="login-btn common-btn" />
              </td>
              </tr>
              <tr>
                <td colspan="2">
                  <br />
                  <label for="" class="sub-text" style="font-weight: 280">Already have an account&#63;
                  </label>
                  <a href="login.php" class="hover-link1 non-style-link">Login</a>
                  <br /><br /><br />
                </td>
              </tr>
            </form>
          </table>
        </div>
      </div>
    </center>
  </section>

  <!--create account section end-->
</body>

</html>