<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION["username"])) {
    header("Location: index.php");
}
require_once "../Models/Database.php";
if (isset($_POST["submit"])) {
    $db = Database::getInstance();
    $username = $_POST["username"];
    $password = $_POST["password"];
    $res = $db->fetchData(["collection" => "nmdh.users", "mongo_query" => ["username" => $username, "password" => $password]])->toArray();
    if (empty($res)) {
        echo "Wrong username or password";
    } else {
        $_SESSION['username'] = $username;
        $_SESSION['usertype'] = 2;
        header("Location: index.php");
    };
    die();
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
	<body class="light-gray-bg">
		<div class="templatemo-content-widget templatemo-login-widget white-bg">
			<header class="text-center">
	          <h1>Multi Purpose Data Hosting</h1>
                <h3>(Developer Login)</h3>
	        </header>
            <?php
            if (isset($_GET['successSignup'])) {
                echo "<div class='alert alert-success'><strong>Success!</strong> Account created successfully. Please login.</div>";
            } elseif (isset($_GET['error'])) {
                echo "<div class='alert alert-danger'><strong>Error!</strong> Wrong Username or Password.</div>";
            }
            ?>
	        <form action="#" class="templatemo-login-form" method="post">
	        	<div class="form-group">
	        		<div class="input-group">
		        		<div class="input-group-addon"><i class="fa fa-at fa-fw"></i></div>
		              	<input type="text" class="form-control" placeholder="username" name="username">
		          	</div>	
	        	</div>
	        	<div class="form-group">
	        		<div class="input-group">
		        		<div class="input-group-addon"><i class="fa fa-key fa-fw"></i></div>	        		
		              	<input type="password" class="form-control" placeholder="******" name="password">
		          	</div>	
	        	</div>	          	
	          	<div class="form-group">
				    <div class="checkbox squaredTwo">
				        <input type="checkbox" id="c1" name="cc" />
						<label for="c1"><span></span>Remember me</label>
				    </div>				    
				</div>
				<div class="form-group">
					<button type="submit" name="submit" class="templatemo-blue-button width-100">Login</button>
				</div>
	        </form>
		</div>
		<div class="templatemo-content-widget templatemo-login-widget templatemo-register-widget white-bg">
			<p>Not a registered user yet? <strong><a href="signup.php" class="blue-text">Sign up now!</a></strong></p>
		</div>
	</body>
</html>