<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

require_once "../Models/Database.php";

//if (!isset($_POST["data_url"])) {
//    header ("Location: index.php");
//}

$username = $_SESSION["username"];
$url = $_GET["dataurl"];

$db = Database::getInstance();
$rows = $db->fetchData(["collection" => "nmdh.users", "mongo_query" => ["data.url" => $url], "options" => ["projection" => ["data.name" => 1, "data.data" => 1, "data.published" => 1]]]);
$row = $rows->toArray()[0];

$published = $row->data[0]->published;
$name = $row->data[0]->name;

//die(var_dump($row->data[0]->published));
if (!isset($row)) {
    header("Location: index.php");
}
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
    <link href="../Includes/datatables.min.css" rel="stylesheet">

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
                <li><a href="upload.php"><i class="fa fa-file fa-fw"></i>Upload Data</a></li>
                <li><a href="manageusers.php"><i class="fa fa-users fa-fw"></i>Manage Users</a>
                </li>
                <li><a href="preferences.php"><i class="fa fa-sliders fa-fw"></i>Preferences</a></li>
                <li><a href="logout.php"><i class="fa fa-eject fa-fw"></i>Sign Out</a></li>
            </ul>
        </nav>
    </div>
    <!-- Main content -->
    <div class="templatemo-content col-1 light-gray-bg">
        <div class="templatemo-top-nav-container">
            <h1><?php echo $name;
                echo $published ? " <hr><h3 style='background-color: green; color: white; padding: 5px; display: inline;'><strong>Published</strong></h3>" : " <hr><h3 style='background-color: darkorange; color: white; padding: 5px; display: inline;'><strong>Unpublished</strong></h3>"; ?></h1>
        </div>

        <div class="templatemo-content-container">
            <div class="templatemo-content-widget  white-bg col-2">
                <h2>Data</h2>
                <hr>
                <div class="panel panel-default table-responsive">
                    <table class="table table-striped table-bordered templatemo-user-table" id="sample-data">
                        <thead>

                        <tr>
                            <?php
                            foreach ($headers as $header) {
                                echo "<td>$header</td>";
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($row->data[0]->data as $datum) {
                            $data = json_decode(json_encode($datum), true);
                            echo "<tr>";
                            foreach ($headers as $header) {
                                echo "<td>" . $data["$header"] . "</td>";
                            }
                            echo "</tr>";
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
                <?php echo "<a href='../Controllers/removedata.php?dataurl={$url}' class='templatemo-blue-button' style='background-color: #f02525'><strong>Delete Data</strong></a>"; ?>
                <?php
                if ($published) {
                    echo "<a href='../Controllers/publish.php?dataurl={$url}&unpublish=1' class='templatemo-blue-button' style='background-color: darkorange'><strong>Unpublish</strong></a>";
                } else {
                    echo "<a href='../Controllers/publish.php?dataurl={$url}' class='templatemo-blue-button' style='background-color: green'><strong>Publish</strong></a>";
                }
                ?>
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
<script type="text/javascript" src="../Includes/datatables.min.js"></script>
<script>
    $(document).ready(function () {
        // Content widget with background image
        var imageUrl = $('img.content-bg-img').attr('src');
        $('.templatemo-content-img-bg').css('background-image', 'url(' + imageUrl + ')');
        $('img.content-bg-img').hide();
    });

    $(document).ready(function () {
        $('#sample-data').DataTable();
    });
</script>
</body>
</html>