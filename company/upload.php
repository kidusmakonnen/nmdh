<!DOCTYPE html>
<?php
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
            <div class="square"></div>
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
                <li><a href="upload.php" class="active"><i class="fa fa-file fa-fw"></i>Upload Data</a></li>
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
                    <h2 class="templatemo-inline-block">Upload A File</h2>
                    <hr>
                    <p>Upload data in CSV format</p>
                    <div class="templatemo-content-widget white-bg">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <form action="../Controllers/companyinsertdoc.php" method="post" enctype="multipart/form-data">
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 form-group">
                                            <label for="inputFirstName">Data Name</label>
                                            <input type="text" class="form-control" name="data_name"
                                                   placeholder="e.g. Daily Weather Report" required>
                                        </div>
                                        <div class="col-lg-6 col-md-6 form-group">
                                            <label for="inputLastName">URL</label>
                                            <input type="text" class="form-control" name="data_url"
                                                   placeholder="URL" required>
                                        </div>
                                        <div class="col-lg-12 form-group">
                                            <label class="control-label" for="inputNote">Data Description</label>
                                            <textarea class="form-control" name="data_description" rows="3" required></textarea>
                                        </div>
                                    </div>

                                    <label class="control-label templatemo-block">File Input</label>
                                    <!-- <input type="file" name="fileToUpload" id="fileToUpload" class="margin-bottom-10"> -->
                                    <input type="file" name="file" id="fileToUpload" class="filestyle"
                                           data-buttonName="btn-primary" data-buttonBefore="true" data-icon="false" required>
                                    <p>Maximum upload size is 5 MB.</p>
                                    <p>
                                        <input type="submit" name="submit" value="Upload File"/>
                                </form>
                                </p>
                            </div>
                        </div>
                    </div>
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