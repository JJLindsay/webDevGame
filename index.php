<!DOCTYPE html>
<html>
<head>
<title>Prisoner's Dilemma</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link href='https://fonts.googleapis.com/css?family=Lora' rel='stylesheet' type='text/css'>
	<link href="css/stylesheet.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/custom.css" rel="stylesheet">
	
</head>
<body class="indexbody">

<!-- Navigation Bar begin -->
	<header class="navbar navbar-default">
		<div class="container-fluid">
			<!-- Brand/Logo and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse" aria-expanded="false">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Prisoner's Dilemma</a>
			</div>

			<!-- Collect the nav links and other content for toggling -->
			<div class="collapse navbar-collapse" id="collapse">
				<ul class="nav navbar-nav navbar-right">
					<li class="active"><a href="index.html">Home</a></li>
				</ul>
			</div><!--.navbar-collapse -->
		</div><!--.container-fluid -->
	</header><!--Navigation Bar -->
	<center><h1 id="zsname">ZillionSparks presents<br/></h1></center>

    <div class="container"><div class="jumbotron" id="indexjumbo"><!-- jumbotron are assumed to cover the entire 12 columns and don't need the sm lg xs etc-->
        <center><h1 class="indextitle"><span class="label label-default">Prisoner's Dilemma</span></h1>
    	<br/>
	
	<form class="form-horizontal" id='indexform' role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	
	<?php

		include('loginnn.php'); // Includes Login Script
		//include('status.php'); // updates user's online_status to 1
		if(isset($_SESSION['login_user'])){
			header("location:profilepage.php");
			include('session.php');
			$update_status_query = mysql_query("UPDATE users SET online_status='1' WHERE usernames='$user_check'", $connection);
		}
	
	?>
		
		<div class="form-group">
		  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			<span style="color:black;"><b><?php echo $error; ?></b></span>
			<input type="text" name="username" class="form-control" id="username" placeholder="Enter username" />
		  </div>
		</div>
		<div class="form-group">
		  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">          
			<input type="password" name="password" class="form-control" id="pwd" placeholder="Enter password" />
		  </div>
		</div>
		<div class="form-group">
		   <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			<button type="submit" name="submit" class="btn btn-primary btn-lg indexbtn" >Login</button>
			<button type="submit" id="regPagebtn" class="btn btn-primary btn-lg indexbtn2" >Register</button>
			
		   </div>
		</div>
	</form>	
		</center>
    </div></div>
	
		
	<center><div class="container">
		<div class="jumbotron">
			<p>Prisoner's Dilemma is a web-based game designed by ZillionSparks.<br/>    
			This website comes in handy when you need to review lessons from your biology course.<br/>     
			It is also great for expanding your knowledge of biology and competing with friends to help enhance your learning experience.</p>      
		</div>
	</div></center>

<!--Creates footer with navigation to repositroy-->
	<div class="container">
		<p class="pull-left">			
			<a href="https://github.com/JJLindsay/webDevGame"> ZillionSparks</a>
			&copy 2015                    
		</p>
	</div>
		
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script type=" src=js/myscript.js"></script>
	<script src="js/zsparks.js"></script>
</body>
</html>