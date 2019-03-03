<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

require_once "../Models/Database.php";
require_once "../helpers/subscriptionmanagement.php";

//if (!isset($_POST["data_url"])) {
//    header ("Location: index.php");
//}

$username = $_GET["company"];
$url = $_GET["dataurl"];

if (isset($_POST["company_name"])) {
    $company_name = $_POST["company_name"];
} else {
    header("Location: index.php");
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
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet'
          type='text/css'>
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
        <!-- Search box -->
        <form class="templatemo-search-form" action="searchresult.php" method="get">
            <div class="input-group">
                <button type="submit" class="fa fa-search"></button>
                <input type="text" class="form-control" placeholder="Search" name="term">
            </div>
        </form>
        <div class="mobile-menu-icon">
            <i class="fa fa-bars"></i>
        </div>
        <nav class="templatemo-left-nav">
            <ul>
                <li><a href="index.php"><i class="fa fa-home fa-fw"></i>Dashboard</a></li>
                <li><a href="subscriptions.php"><i class="fa fa-file fa-fw"></i>Files</a></li>
                <li><a href="preferences.php"><i class="fa fa-sliders fa-fw"></i>Preferences</a></li>
                <li><a href="logout.php"><i class="fa fa-eject fa-fw"></i>Sign Out</a></li>
            </ul>
        </nav>
    </div>
    <!-- Main content -->
    <div class="templatemo-content col-1 light-gray-bg">

        <div class="templatemo-content-container">
            <div class="templatemo-flex-row flex-content-row">
                <div class="templatemo-content-widget white-bg col-2">
                    <h2 class="templatemo-inline-block">Subscription Details</h2>
                    <hr>
                    <h4><strong>Subscription Name: </strong> <?php echo $_POST["sub_name"]; ?></h4>
                    <h4><strong>Subscription Description: </strong> <?php echo $_POST["sub_description"]; ?></h4>
                    <h4><strong>API Key: </strong> <?php echo getApiKey($_SESSION["username"], $url) ?></h4>
                    <h4><strong>JSON Data URL: </strong> <a target="_blank" href="getdata.php?key=<?php echo getApiKey($_SESSION["username"], $url); ?>&dataurl=<?php echo $url; ?>">Link</a></h4><hr>
                    <?php echo "<a href='../Controllers/developerunsubscribe.php?data_source_url={$url}&developer_username={$_SESSION["username"]}&company_username={$username}' class='templatemo-blue-button' style='background-color: red'><strong>Unsubscribe</strong></a>";?>
                    <?php echo "<a href='sampleData.php?dataurl={$url}&company={$username}' class='templatemo-blue-button' ><strong>Get Sample Data</strong></a>";
                    ?>
                </div>
            </div>


            <footer class="text-right">
                <p>Copyright &copy; 2019 NMDH</p>
            </footer>
        </div>
    </div>
</div>

<!-- JS -->
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>      <!-- jQuery -->
<script type="text/javascript" src="js/templatemo-script.js"></script>      <!-- Templatemo Script -->
<script>
    $(document).ready(function () {
        // Content widget with background image
        var imageUrl = $('img.content-bg-img').attr('src');
        $('.templatemo-content-img-bg').css('background-image', 'url(' + imageUrl + ')');
        $('img.content-bg-img').hide();
    });
</script>
</body>
</html>