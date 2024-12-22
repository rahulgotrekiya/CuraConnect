<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title></title>
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
    $_SESSION['personal'] = array(
      'fname' => $_POST['fname'],
      'lname' => $_POST['lname'],
      'address' => $_POST['address'],
      'dob' => $_POST['dob']
    );

    print_r($_SESSION['personal']);
    header('location: create-account.php');
  }



  ?>

  <!--header end-->

  <!--signup section-->

  <section class="login-section">
    <center>
      <div class="login-block">
        <h2>Let's Get Started</h2>
        <p class="sub-text">Add Your Personal Details to Continue</p>
        <div class="login-form">
          <form action="" method="POST">
            <table border="0" style="margin: 0; padding: 0; width: 69%">
              <tr>
                <td class="label-td" colspan="2">
                  <label for="name" class="form-label">Name: </label>
                </td>
              </tr>
              <tr>
                <td class="label-td">
                  <input type="text" name="fname" class="input-text" placeholder="First Name" required />
                </td>
                <td class="label-td">
                  <input type="text" name="lname" class="input-text" placeholder="Last Name" required />
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <label for="address" class="form-label">Address: </label>
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <input type="text" name="address" class="input-text" placeholder="Address" required />
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <label for="dob" class="form-label">Date of Birth: </label>
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <input type="date" name="dob" class="input-text" required />
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2"></td>
              </tr>
              <tr>
                <td class="td-btn">
                  <input type="reset" value="Reset" class="login-btn common-light-btn" />
                </td>
                <td class="td-btn">
                  <input type="submit" value="Next" class="login-btn common-btn" />
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
            </table>
          </form>
        </div>
      </div>
    </center>
  </section>

  <!--signup section end-->

  <!--footer-->
  <?php include('includes/footer.php'); ?>
  <!--footer end-->
</body>

</html>