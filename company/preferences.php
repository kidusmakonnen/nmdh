<!DOCTYPE html>
<?php
/**
 * User: kidus
 * Date: 3/3/19
 * Time: 2:32 PM
 */
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Multi Purpose Data Hosting</title>
    <meta name="description" content="">
    <meta name="author" content="templatemo">
    <!--
Visual Admin Template
    http://www.templatemo.com/preview/templatemo_455_visual_admin
    -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/templatemo-style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>
    <!-- Left column -->
    <div class="templatemo-flex-row">
      <div class="templatemo-sidebar">
        <header class="templatemo-site-header">
          <h1>Multi Purpose Data Hosting</h1>
        </header>
        <div class="profile-photo-container">
          <img src="images/profile-photo.jpg" alt="Profile Photo" class="img-responsive">
          <div class="profile-photo-overlay"></div>
        </div>

        <div class="mobile-menu-icon">
            <i class="fa fa-bars"></i>
          </div>
        <nav class="templatemo-left-nav">
            <ul>
                <li><a href="index.php"><i class="fa fa-home fa-fw"></i>Dashboard</a></li>
                <li><a href="upload.php"><i class="fa fa-file fa-fw"></i>Upload Data</a></li>
                <li><a href="preferences.php" class="active"><i class="fa fa-sliders fa-fw"></i>Preferences</a></li>
                <li><a href="logout.php"><i class="fa fa-eject fa-fw"></i>Sign Out</a></li>
            </ul>
        </nav>
      </div>
      <!-- Main content -->
      <div class="templatemo-content col-1 light-gray-bg">

        <div class="templatemo-content-container">
          <div class="templatemo-content-widget white-bg">
            <h2 class="margin-bottom-10">Preferences</h2>
            <p>Update your information</p>
              <?php
              if (isset($_GET['success'])) {
                  echo "<div class='alert alert-success'><strong>Success!</strong> Password updated successfully.</div>";
              } elseif (isset($_GET['error'])) {
                  echo "<div class='alert alert-danger'><strong>Error!</strong> Wrong Password Entered</div>";
              } elseif (isset($_GET['matchError'])) {
                  echo "<div class='alert alert-danger'><strong>Error!</strong> Passwords Do Not Match</div>";
              }
              ?>

              <form action="../Controllers/updateuser.php" class="templatemo-login-form" method="post" enctype="multipart/form-data">
              <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputCurrentPassword">Current Password</label>
                    <input type="password" class="form-control" id="inputCurrentPassword" name="password" placeholder="">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputNewPassword">New Password</label>
                    <input type="password" class="form-control" name="newPassword" id="inputNewPassword">
                </div>
              </div>
                <div class="row form-group">
                    <div class="col-lg-6 col-md-6 form-group">
                        <label for="inputConfirmNewPassword">Confirm New Password</label>
                        <input type="password" class="form-control" name="newPassword2" id="inputConfirmNewPassword">
                    </div>
                </div>

              <div class="form-group">
                <button type="submit" class="templatemo-blue-button">Update</button>
                <button type="reset" class="templatemo-white-button">Reset</button>
              </div>
            </form>
          </div>
            <footer class="text-right">
                <p>Copyright &copy; 2019 NMDH</p>
            </footer>
        </div>
      </div>
    </div>

    <!-- JS -->
    <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>        <!-- jQuery -->
    <script type="text/javascript" src="js/bootstrap-filestyle.min.js"></script>  <!-- http://markusslima.github.io/bootstrap-filestyle/ -->
    <script type="text/javascript" src="js/templatemo-script.js"></script>        <!-- Templatemo Script -->
  </body>
</html>