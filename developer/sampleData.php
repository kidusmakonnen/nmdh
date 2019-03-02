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

$db = Database::getInstance();
$rows = $db->fetchData(["collection" => "nmdh.users", "mongo_query" => ["username" => $username, "data.url" => $url], "options" => ["projection" => ["data.data" => 1]]]);
//if (!isset($rows->toArray()[0])) {
//    header("Location: index.php");
//}
$row = $rows->toArray()[0];
$headers = extractHeader($row->data[0]->data[0]);


function extractHeader($data)
{
    return array_keys(json_decode(json_encode($data), true));
}

function extractValues($data)
{
    return array_values(json_decode(json_encode($data), true));
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
        <form class="templatemo-search-form" role="search">
            <div class="input-group">
                <button type="submit" class="fa fa-search"></button>
                <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
            </div>
        </form>
        <div class="mobile-menu-icon">
            <i class="fa fa-bars"></i>
        </div>
        <nav class="templatemo-left-nav">
            <ul>
                <li><a href="index.php"><i class="fa fa-home fa-fw"></i>Dashboard</a></li>
                <li><a href="subscriptions.php"><i class="fa fa-file fa-fw"></i>Files</a></li>
                <li><a href="company-manage-users.html" class="active"><i class="fa fa-users fa-fw"></i>Manage Users</a>
                </li>
                <li><a href="company-preferences.html"><i class="fa fa-sliders fa-fw"></i>Preferences</a></li>
                <li><a href="logout.php"><i class="fa fa-eject fa-fw"></i>Sign Out</a></li>
            </ul>
        </nav>
    </div>
    <!-- Main content -->
    <div class="templatemo-content col-1 light-gray-bg">

        <div class="templatemo-content-container">
            <div class="templatemo-content-widget no-padding">
                <div class="panel panel-default table-responsive">
                    <table class="table table-striped table-bordered templatemo-user-table">
                        <thead>

                        <tr>
                            <?php
                            foreach ($headers as $header) {
                                echo "<td>$header</td>";
                            }
                            ?>
                            <!--                    <td><a href="" class="white-text templatemo-sort-by"># <span class="caret"></span></a></td>-->
                            <!--                    <td><a href="" class="white-text templatemo-sort-by">First Name <span class="caret"></span></a></td>-->
                            <!--                    <td><a href="" class="white-text templatemo-sort-by">Last Name <span class="caret"></span></a></td>-->
                            <!--                    <td><a href="" class="white-text templatemo-sort-by">User Name <span class="caret"></span></a></td>-->
                            <!--                    <td><a href="" class="white-text templatemo-sort-by">Email <span class="caret"></span></a></td>-->
                            <!--                    <td>Edit</td>-->
                            <!--                    <td>Action</td>-->
                            <!--                    <td>Delete</td>-->
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $limit = 5;

                        foreach ($row->data[0]->data as $datum) {
                            $data = json_decode(json_encode($datum), true);
                            echo "<tr>";
                            foreach ($headers as $header) {
                                echo "<td>" . $data["$header"] . "</td>";
                            }
                            echo "</tr>";
                            $limit--;
                            if (!$limit) break;
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
                <?php
                if (!isUserSubscribed($_SESSION["username"], $url)) {
                    echo "<a href='../Controllers/developersubscribe.php?data_source_url={$url}&developer_username={$_SESSION["username"]}&company_username={$username}' class='templatemo-blue-button' style='background-color: green'><strong>Subscribe</strong></a>";
                } else {
                    echo "<a href='../Controllers/developerunsubscribe.php?data_source_url={$url}&developer_username={$_SESSION["username"]}&company_username={$username}' class='templatemo-blue-button' style='background-color: red'><strong>Unsubscribe</strong></a>";
                }
                ?>

            </div>


            <footer class="text-right">
                <p>Copyright &copy; 2084 Company Name
                    | Designed by <a href="http://www.templatemo.com" target="_parent">templatemo</a></p>
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