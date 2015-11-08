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
		error_reporting(-1);
		//session_start(); // Starting Session 
		include('connection.php');
		include('session.php');
		include('functions.php');
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
							Total score: <?php echo highscore($_SESSION['login_id'])?>pts
						</div>
						<div id="previousScore">
							Previous score:
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

						
						
						<div class="list-group" id="gameContacts">
							<b>Current Dilemmas</b>
							<!--LOOP  set the id and collect the score against id-->
							
							
							<?php
							
								$db = mysqli_connect("localhost", "root", "", "zillionsparks_db");							
								$query = "SELECT *";
								$query .= " FROM dilemmas";
								$query .= " WHERE p1 IN (SELECT tag";
								$query .= " FROM teamcode";
								$query .= " WHERE users_id=".$_SESSION['login_id'].")";
								
								$result=mysqli_query($db, $query);
								
								
								//$result = mysqli_query($db, $query);																				
								
								if ($result) 
								{
									//get the number of rows within the result (or database) 
								$num_rows = mysqli_num_rows($result);
									
									
									
									//success
									//$row = mysqli_fetch_assoc($query);
									$row = $result->fetch_assoc();  //get the contents of the row.
									
									//loop through
									for ($index = 0; $index <  $num_rows; $index++)
									{
										
										 ?>
										<button type='button' class='list-group-item' id='dilemmas' onclick='recent_game_score(<?php echo $row['p1_score']?>)'>
											<span style='color:white;background-color:blue;border-radius: 5px;padding:0% 1%;'><?php echo $row['p2']?></span>
											<span class='glyphicon glyphicon-flag customBadgeAct'></span>
										</button>
										 <?php
										 
										 //$row['p2']
										
										$row = $result->fetch_assoc();  //get the contents of the next row.
									}
								}
								
								
								$query = "SELECT *";
								$query .= " FROM dilemmas";
								$query .= " WHERE p2 LIKE (SELECT tag";
								$query .= " FROM teamcode";
								$query .= " WHERE users_id=".$_SESSION['login_id'].")";
								
								$result = mysqli_query($db, $query);
								
								
								
								if ($result)
								{
									//get the number of rows within the result (or database) 
								$num_rows = mysqli_num_rows($result); 
																					
									
									//success
									$row = $result->fetch_assoc();  //get the contents of the row.
									
									//loop through
									for ($index = 0; $index <  $num_rows; $index++)
									{
									
										 ?>
										<button type='button' class='list-group-item' id='dilemmas' onclick='recent_game_score(<?php echo $row['p2_score']?>)'>
											<span style='color:white;background-color:blue;border-radius: 5px;padding:0% 1%;'><?php echo $row['p1']?></span>
											<span class='glyphicon glyphicon-flag customBadgeAct'></span>
										</button>
										 <?php
										 
										 //$row['p1']
										
										$row = $result->fetch_assoc();  //get the contents of the next row.
									}
								}								
								else
								{
									//failure
									die("Database query failed.");
								}
								
							?>
							
							<button type="button" class="list-group-item" id="dilemmas" onclick="recent_game_score()">
								<span style="color:white;background-color:blue;border-radius: 5px;padding:0% 1%;">Blue-01</span>
								<span class="glyphicon glyphicon-flag customBadgeAct"></span>
							</button>

							<button type="button" class="list-group-item" id="dilemmas">
								<span style="color:white;background-color:black;border-radius: 5px;padding:0% 1%;">Black-04</span>
							</button>

							<button type="button" class="list-group-item" id="dilemmas">
								<span style="color:white;background-color:red;border-radius: 5px;padding:0% 1%;">Red-01</span>
								<span class="glyphicon glyphicon-flag customBadgeAct"></span>
							</button>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

<?php
	//3. ALWAYS CLOSE A DATABASE AFTER USING IT.
	mysqli_close($dbc); //dbc is for connection.php
?>	
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script type=" src=js/myscript.js"></script>
	<script src="js/zsparks.js"></script>
	<script src="functions.php"></script>
	
	<script type="text/javascript">

		function recent_game_score($score)
		{
			document.getElementById("previousScore").innerHTML='Prev. Score: ' + $score;
		}
		
	</script>
	
</body>
</html>
