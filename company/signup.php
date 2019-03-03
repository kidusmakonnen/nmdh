<!DOCTYPE html>
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
	          <div class="square"></div>
                <h1>Multi Purpose Data Hosting</h1> <h2>(Company Signup)</h2>
	        </header>
	       
	        <!--Company Signup form BELOW-->






	        <form action="../Controllers/companysignup.php" class="templatemo-login-form" method="post">
	        	<div class="form-group">
	        		<div class="input-group">
		        		<div class="input-group-addon"><i class="fa fa-user fa-fw"></i></div>	        		
		              	<input type="text" class="form-control" placeholder="Company Name" name="company_name">
		          	</div>	
	        	</div>
                <div class="form-group">
	        		<div class="input-group">
		        		<div class="input-group-addon"><i class="fa fa-at fa-fw"></i></div>
		              	<input type="text" class="form-control" placeholder="Username" name="company_username">
		          	</div>
	        	</div>
	        	<div class="form-group">
	        		<div class="input-group">
		        		<div class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></div>
		              	<input type="text" class="form-control" placeholder="Email" name="company_email">
		          	</div>	
	        	</div>
	        	<div class="form-group">
	        		<div class="input-group">
		        		<div class="input-group-addon"><i class="fa fa-key fa-fw"></i></div>	        		
		              	<input type="password" class="form-control" placeholder="******" name="company_password">           
		          	</div>	
	        	</div>
	        	<div class="form-group">                   
                    <label class="control-label" for="inputNote">Short Description About Company</label>
                    <textarea class="form-control" id="inputNote" rows="3" name="company_description"></textarea>
                </div>
				<div class="form-group">
					<button type="submit" class="templatemo-blue-button width-100">Sign Up</button>
				</div>
	        </form>
		</div>








		<div class="templatemo-content-widget templatemo-login-widget templatemo-register-widget white-bg">
			<p>Already have an Account? <strong><a href="login.php" class="blue-text">Sign In</a></strong></p>
		</div>
	</body>
</html>