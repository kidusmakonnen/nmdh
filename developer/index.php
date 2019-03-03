<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
} else {
    require_once "../Models/Database.php";
    require_once "../Models/Developer.php";
    require_once "../Models/Company.php";

    $db = Database::getInstance();
    $username = $_SESSION["username"];
    $res = $db->fetchData(["collection" => "nmdh.users", "mongo_query" => ["username" => $username]])->toArray();

    $developer = new Developer($res[0]->username, $res[0]->password);
    $subscription_data = $res[0]->subscriptions;
    $data_source_list = [];

    foreach ($subscription_data as $datum) {
        $res = $db->fetchData(["collection" => "nmdh.users", "mongo_query" => ["username" => $datum->company_username,
            "data.url" => $datum->url], "options" => ["projection" => ["_id" => 0, "company_name" => 1, "data.name" => 1,
            "data.description" => 1, "data.published"=>1]]])->toArray()[0];
            if($res->data[0]->published) {
                $company = new Company($datum->company_username);
                $company->setName($res->company_name);

                $data_src = new DataSource($company);
                $data_src->setName($res->data[0]->name);
                $data_src->setDescription($res->data[0]->description);
                $data_src->setUrl($datum->url);
                $data_source_list[] = $data_src;
            }
    }


    $developer->setSubscription($data_source_list);


    $companies = [];

    $res = $db->fetchData(["collection" => "nmdh.users", "mongo_query" => ["user_type" => 1], "options" => ["projection" => ["_id" => 0, "data.data"=>0]]]);

    foreach ($res as $r) {
        $company = new Company($r->username, NULL, $r->company_name, $r->company_description);
        $data_sources = [];
        foreach ($r->data as $datum) {
            if ($datum->published) {
                $data_source = new DataSource($company);
                $data_source->setName($datum->name);
                $data_source->setDescription($datum->description);
                $data_source->setUrl($datum->url);
                $data_sources[] = $data_source;
            }
        }
        if (!empty($data_sources)) {
            $company->setDataSources($data_sources);
            $companies[] = $company;
        }
    }
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
            <h1>National Multipurpose Data Hosting</h1>
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
                <li><a href="index.php" class="active"><i class="fa fa-home fa-fw"></i>Dashboard</a></li>
                <li><a href="subscriptions.php"><i class="fa fa-building fa-fw"></i>Subscription</a></li>
                <li><a href="preferences.php"><i class="fa fa-sliders fa-fw"></i>Preferences</a></li>
                <li><a href="logout.php"><i class="fa fa-eject fa-fw"></i>Sign Out</a></li>
            </ul>
        </nav>
    </div>
    <!-- Main content -->
    <div class="templatemo-content col-1 light-gray-bg">
        <div class="templatemo-top-nav-container">
            <h1>Dashboard</h1>
        </div>
        <div class="templatemo-content-container">
            <div class="templatemo-flex-row flex-content-row">
                <div class="templatemo-content-widget white-bg col-2">
                    <h2 class="templatemo-inline-block">Subscriptions</h2>
                    <hr>
                    <?php
                        $subscriptions = $developer->getSubscription();

                        if (empty($subscriptions)) {
                            echo "<p>You haven't subscribed to any data source.</p>";
                        } else {
                            foreach ($subscriptions as $subscription) {
                                echo "<form action='viewSubscription.php?dataurl={$subscription->getUrl()}&company={$subscription->getOwner()->getUsername()}' method='post'>";
                                echo "<input type='hidden' name='company_name' value='{$subscription->getOwner()->getUsername()}' />";
                                echo "<input type='hidden' name='sub_name' value='{$subscription->getName()}' />";
                                echo "<input type='hidden' name='sub_description' value='{$subscription->getDescription()}' />";
                                echo "<div class='templatemo-flex-row flex-content-row'><div class='templatemo-content-widget blue-bg col-2'><h2 class='templatemo-inline-block'>{$subscription->getName()}</h2><hr><p>{$subscription->getDescription()}</p><div class='form-group text-right'><a href='../Controllers/developerunsubscribe.php?data_source_url={$subscription->getUrl()}&developer_username={$_SESSION["username"]}&company_username={$subscription->getOwner()->getUsername()}' class='templatemo-blue-button' style='background-color: red'>Unsubscribe</a><button class='templatemo-white-button' type='submit'>View</button></div></div></div>";
                                echo "</form>";
                            }
                        }
                    ?>

                </div>
            </div>

            <div class="templatemo-flex-row flex-content-row">
                <div class="templatemo-content-widget white-bg col-2">
                    <h2 class="templatemo-inline-block">Latest Data By Companies</h2>
                    <hr>
                    <?php
                    foreach ($companies as $company) {
                        $data_sources = $company->getDataSources();
                        $count = count($data_sources);
                        echo "<div class='templatemo-flex-row flex-content-row'><div class='templatemo-content-widget blue-bg col-2'><h2 class='templatemo-inline-block'>{$company->getName()} ({$company->getDescription()}) </h2>";
                        foreach ($data_sources as $data_source) {
                            echo "<div class='col-1'>";
                            echo "<div class='templatemo-flex-row flex-content-row'><div class='templatemo-content-widget blue-bg col-2'><h2 class='templatemo-inline-block'>{$data_source->getName()}</h2><hr><p>{$data_source->getDescription()}</p><hr><div class='form-group text-right'><a href='sampleData.php?dataurl={$data_source->getUrl()}&company={$data_source->getOwner()->getUsername()}' class='templatemo-white-button'>View</a></div></div></div>";
                            echo "</div>";
                        }
                        echo "</div></div>";
                    }
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
<script src="js/jquery-1.11.2.min.js"></script>      <!-- jQuery -->
<script src="js/jquery-migrate-1.2.1.min.js"></script> <!--  jQuery Migrate Plugin -->
<script src="https://www.google.com/jsapi"></script> <!-- Google Chart -->
<script>
    /* Google Chart
    -------------------------------------------------------------------*/
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1.0', {'packages': ['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
            ['Mushrooms', 3],
            ['Onions', 1],
            ['Olives', 1],
            ['Zucchini', 1],
            ['Pepperoni', 2]
        ]);

        // Set chart options
        var options = {'title': 'How Much Pizza I Ate Last Night'};

        // Instantiate and draw our chart, passing in some options.
        var pieChart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));
        pieChart.draw(data, options);

        var barChart = new google.visualization.BarChart(document.getElementById('bar_chart_div'));
        barChart.draw(data, options);
    }

    $(document).ready(function () {
        if ($.browser.mozilla) {
            //refresh page on browser resize
            // http://www.sitepoint.com/jquery-refresh-page-browser-resize/
            $(window).bind('resize', function (e) {
                if (window.RT) clearTimeout(window.RT);
                window.RT = setTimeout(function () {
                    this.location.reload(false);
                    /* false to get page from cache */
                }, 200);
            });
        } else {
            $(window).resize(function () {
                drawChart();
            });
        }
    });

</script>
<script type="text/javascript" src="js/templatemo-script.js"></script>      <!-- Templatemo Script -->

</body>
</html>