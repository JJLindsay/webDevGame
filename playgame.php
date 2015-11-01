<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Prisoner's Dilemma</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link href='https://fonts.googleapis.com/css?family=Lora' rel='stylesheet' type='text/css'>
	<link href="css/stylesheet.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link href="css/custom.css" rel="stylesheet">
</head>

<body>
	<?php
		include('connection.php');
		include('session.php');
		//include('useronline.php');
		
							
	?>
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
				<a class="navbar-brand" href="index.html">Prisoner's Dilemma</a>
			</div>

			<!-- Collect the nav links and other content for toggling -->
			<div class="collapse navbar-collapse" id="collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="index.php">Home</a></li>
					<li><a href="useronline.php">Who's Online</a></li>
					<li class="active"><a href="playgame.html">Play Game</a></li>
					<li><a href="#">Check Score</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="profilepage.php">My Profile</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</header><!-- end Navigation Bar -->	
	
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-2 top-margin" >
				<h3>Prisoner's Dilemma Game Play</h3>
				<br/>
				<div class="row">
					<div class="col-sm-3 col-md-3 col-lg-3">
						<div id="totalScore">
							Total score: 100
						</div>
						<div id="previousScore">
							Previous score: 5
						</div>
					</div>
					<div class="col-sm-9 col-md-9 col-lg-9">
						<div id="gameScreen">
							<!-- <canvas id="myCanvas" style="border:1px solid #000000; background-color:lightgrey;">
							</canvas> -->
						</div>
						<div class="btn-group btn-group-justified">
							<div class="btn-group">
								<input type="submit" class="btn btn-primary" name="BtnCop" value="COOPERATE" />
							</div>
							<div class="btn-group">
								<button class="btn btn-primary" name="BtnDef">DEFECT</button>
							</div>
						</div>
						<br/>
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
							<input type="submit" name="Submit" value="COOPERATE" />
						</form>
						<br/>
						<?php
							//if (isset($_POST['Submit'])) 
							//{
								
								// Updates user choice for current user to 1	
								//$update_user_choice=mysql_query("UPDATE scores SET user_choice='1' WHERE id = '$login_id'",$connection);
								
														
									//			echo "yey";
									
							//}
						?>
						
						
						<div class="list-group" id="gameContacts">
							<b>Current Dilemmas</b>
							
							<button type="button" class="list-group-item" id="dilemmas">
								<span style="color:white;background-color:blue;border-radius: 5px;padding:0% 1%;"><?php echo "You: ".$login_id; ?></span>
								<span class="glyphicon glyphicon-flag customBadgeAct"></span>
							</button>

							<button type="button" class="list-group-item" id="dilemmas">
								<span style="color:white;background-color:black;border-radius: 5px;padding:0% 1%;">Black-04</span>
							</button>

							<button type="button" class="list-group-item" id="dilemmas">
								<span style="color:white;background-color:red;border-radius: 5px;padding:0% 1%;">
									<?php
										//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
										
										$query=mysql_connect("localhost","root","");
											mysql_select_db("zillionsparks_db",$query);
											if(isset($_GET['id']))
											{
												$id=$_GET['id'];
												$query1=mysql_query("select * from users where id='$id'");
												$query2=mysql_fetch_array($query1);
												echo "Your Partner: ".$query2['id'];
												 
											}
									?>
								</span>
								<span class="glyphicon glyphicon-flag customBadgeAct"></span>
							</button>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script type=" src=js/myscript.js"></script>
	<script src="js/zsparks.js"></script>
</body>
</html>
