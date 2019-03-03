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
            "data.description" => 1]]])->toArray()[0];
        $company = new Company($datum->company_username);
        $company->setName($res->company_name);

        $data_src = new DataSource($company);
        $data_src->setName($res->data[0]->name);
        $data_src->setDescription($res->data[0]->description);
        $data_src->setUrl($datum->url);
        $data_source_list[] = $data_src;
    }
    $developer->setSubscription($data_source_list);
}
?>
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
    <link href="jqvmap/jqvmap.css" media="screen" rel="stylesheet" type="text/css" /> 
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
            <li><a href="subscriptions.php" class="active"><i class="fa fa-building fa-fw"></i>Subscription</a></li>
            <li><a href="preferences.php"><i class="fa fa-sliders fa-fw"></i>Preferences</a></li>
            <li><a href="login.php"><i class="fa fa-eject fa-fw"></i>Sign Out</a></li>
          </ul>  
        </nav>
      </div>
      <!-- Main content --> 
      <div class="templatemo-content col-1 light-gray-bg">
          <div class="templatemo-top-nav-container">
              <h1>Subscriptions</h1>
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
          </div>



          <footer class="text-right">
              <p>Copyright &copy; 2019 NMDH</p>
          </footer>
        </div>
      </div>
    </div>
    
    <!-- JS -->
    <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>      <!-- jQuery -->
    <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script> <!--  jQuery Migrate Plugin -->
    <script type="text/javascript" src="js/templatemo-script.js"></script>      <!-- Templatemo Script -->
    <script type="text/javascript" src="jqvmap/jquery.vmap.js"></script>
    <script type="text/javascript" src="jqvmap/maps/jquery.vmap.world.js"></script>
    <script type="text/javascript" src="jqvmap/data/jquery.vmap.sampledata.js"></script>
    <script src="jqvmap/maps/continents/jquery.vmap.africa.js" type="text/javascript"></script>
    <script src="jqvmap/maps/continents/jquery.vmap.asia.js" type="text/javascript"></script>
    <script src="jqvmap/maps/continents/jquery.vmap.australia.js" type="text/javascript"></script>
    <script src="jqvmap/maps/continents/jquery.vmap.europe.js" type="text/javascript"></script>
    <script src="jqvmap/maps/continents/jquery.vmap.north-america.js" type="text/javascript"></script>
    <script src="jqvmap/maps/continents/jquery.vmap.south-america.js" type="text/javascript"></script>
    <script src="jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
    <script type="text/javascript">
      
      function drawMaps(){
        $('#vmap_world').vectorMap({
          map: 'world_en',
          backgroundColor: '#ffffff',
          color: '#333',
          hoverOpacity: 0.7,
          selectedColor: '#666666',
          enableZoom: true,
          showTooltip: true,
          values: sample_data,
          scaleColors: ['#C8EEFF', '#006491'],
          normalizeFunction: 'polynomial'
        });
        $('#vmap_africa').vectorMap({
          map: 'africa_en',
          backgroundColor: '#ffffff',
          color: '#333333',
          hoverOpacity: 0.7,
          selectedColor: '#666666',
          enableZoom: true,
          showTooltip: true,
          values: sample_data,
          scaleColors: ['#C8EEFF', '#006491'],
          normalizeFunction: 'polynomial'
        }); 
        $('#vmap_asia').vectorMap({
          map: 'asia_en',
          backgroundColor: '#ffffff',
          color: '#333333',
          hoverOpacity: 0.7,
          selectedColor: '#666666',
          enableZoom: true,
          showTooltip: true,
          values: sample_data,
          scaleColors: ['#C8EEFF', '#006491'],
          normalizeFunction: 'polynomial'
        });
        $('#vmap_australia').vectorMap({
          map: 'australia_en',
          backgroundColor: '#ffffff',
          color: '#333333',
          hoverOpacity: 0.7,
          selectedColor: '#666666',
          enableZoom: true,
          showTooltip: true,
          values: sample_data,
          scaleColors: ['#C8EEFF', '#006491'],
          normalizeFunction: 'polynomial'
        });
        $('#vmap_europe').vectorMap({
          map: 'europe_en',
          backgroundColor: '#ffffff',
          color: '#333333',
          hoverOpacity: 0.7,
          selectedColor: '#666666',
          enableZoom: true,
          showTooltip: true,
          values: sample_data,
          scaleColors: ['#C8EEFF', '#006491'],
          normalizeFunction: 'polynomial'
        });
        $('#vmap_northamerica').vectorMap({
          map: 'north-america_en',
          backgroundColor: '#ffffff',
          color: '#333333',
          hoverOpacity: 0.7,
          selectedColor: '#666666',
          enableZoom: true,
          showTooltip: true,
          values: sample_data,
          scaleColors: ['#C8EEFF', '#006491'],
          normalizeFunction: 'polynomial'
        });
        $('#vmap_southamerica').vectorMap({
          map: 'south-america_en',
          backgroundColor: '#ffffff',
          color: '#333333',
          hoverOpacity: 0.7,
          selectedColor: '#666666',
          enableZoom: true,
          showTooltip: true,
          values: sample_data,
          scaleColors: ['#C8EEFF', '#006491'],
          normalizeFunction: 'polynomial'
        });
        $('#vmap_usa').vectorMap({
          map: 'usa_en',
          enableZoom: true,
          showTooltip: true,
          selectedRegion: 'MO'
        });  
      } // end function drawMaps

      $(document).ready(function() {

        if($.browser.mozilla) {
          //refresh page on browser resize
          // http://www.sitepoint.com/jquery-refresh-page-browser-resize/
          $(window).bind('resize', function(e)
          {
            if (window.RT) clearTimeout(window.RT);
            window.RT = setTimeout(function()
            {
              this.location.reload(false); /* false to get page from cache */
            }, 200);
          });      
        } else {
          $(window).resize(function(){
            drawMaps();
          });  
        }
        
        drawMaps();

      });
    </script>
  </body>
</html>