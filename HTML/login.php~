<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="cache-control" content="no-cache"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="../CSS/pure-min.css"/>
		<link rel="stylesheet" type="text/css" href="../CSS/normalize.css"/>
		<link rel="stylesheet" type="text/css" href="../CSS/login.css"/>
		<title>HUM-login</title>

	<!--[if lte IE 8]>
		<link rel="stylesheet" href="/combo/1.18.13?/css/layouts/side-menu-old-ie.css">
	    <![endif]-->
    	<!--[if gt IE 8]><!-->
    	<!--<![endif]-->
	<!--[if lt IE 9]>
    	<script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js"></script>
	 <![endif]-->

	<script>
	(function(i,s,o,g,r,a,m)
	{i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	 	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	 })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-41480445-1', 'purecss.io');
	ga('send', 'pageview');
	</script>

	</head>
	<body>
		<?php include dbconnect.php ?>
    	<?php
		   
		   if($_SERVER["REQUEST_METHOD"] == "POST") {
		      // username and password sent from form 
		      
		      $myusername = mysqli_real_escape_string($db,$_POST['usnm']);
		      $mypassword = mysqli_real_escape_string($db,$_POST['pswd']); 
		      
		      $sql = "SELECT * FROM user_info WHERE username = '$myusername' and password = '$mypassword'";
		      $result = mysqli_query($db,$sql);
		      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		      $active = $row['active'];
		      
		      $count = mysqli_num_rows($result);
		      
		      // If result matched $myusername and $mypassword, table row must be 1 row
				
		      if($count == 1) {
		         //session_register("myusername");
		         //$_SESSION['login_user'] = $myusername;
		         
		         header("location: welcome.php");
		      }else {
		         echo "Your Login Name or Password is invalid";
		      }
		   }
		?>
	<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="../index.html">HUM</a>

            <ul class="pure-menu-list">
	 <li class="pure-menu-item"><a href="#" class="pure-menu-link">Chores</a></li>

                <li class="pure-menu-item"><a href="#" class="pure-menu-link">Tasks</a></li>

                <li class="pure-menu-item"><a href="#" class="pure-menu-link">Events</a></li>

                <li class="pure-menu-item"><a href="#" class="pure-menu-link">Schedule</a></li>

                <li class="pure-menu-item"><a href="#" class="pure-menu-link">Settings</a></li>

                <li class="pure-menu-item"><a href="#" class="pure-menu-link">Log Out</a></li>
            </ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h1>Home Utilities Manager</h1>
            <h2>An application housing all your home management needs. </h2>
        </div>
	<div class="content">
		<form id="LogIn" method="POST" action="">
			<fieldset>
				<legend> Log In </legend>

				<label for="username"> User name: <em>*</em> </label>
				<input type="text" id="username" name="usnm" autofocus required>
				<br/>
				<br/>
				<label for="password"> Password: (Must contain 6 or more characters and at least one number)
					<em>*</em>
				</label>
				<input type="password" id="password" name="pswd" pattern="(?=.*\d).{6,}"required>
				<br/>
				<br/>
			</fieldset>

			<p><input type="submit" value="Log In"></p>

		</form>

		<div class="signup">
			Don't have an account?
			<a href="./signup.php"> Sign up </a>
		</div>
	</div>
	<script src="./ui.js"></script>

	</body>
</html>
