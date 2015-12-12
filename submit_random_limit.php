<!doctype html>
<html>
<head>
<?php
	error_reporting(-1);
	include('connection.php');
?>
    <meta charset="utf-8">
    <title>Prisoner's Dilemma</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/stylesheet.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
	
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/zsparks.js"></script>
	<style>
		#message 
		{
			width: 50%;
			margin: 2% 40%;
		}
	</style>	
</head>
<body>

	<!-- Navigation Bar begin-->
	<header class="navbar navbar-default">
		<div class="container-fluid">
			<!-- Brand/Logo and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse" aria-expanded="false">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">Prisoner's Dilemma</a>
			</div>

			<!-- Collect the nav links and other content for toggling -->
			<div class="collapse navbar-collapse" id="collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="index.php">Home</a></li>
					<li class="active"><a href="editgame.php">Edit Game</a></li>
					<li ><a href="administration.php">Check Scores</a></li>
					<li class="dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="profilepage.php">My Profile</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</header><!--  end Navigation Bar -->
	
	<div id='message'>
		<?php
			//get the query
			$limit = $_POST['limit'];
				
			//returns true or false for update
			$result = mysqli_query($dbc, "SELECT * FROM random_game");
			$count = mysqli_num_rows($result);
			$i = 1;	
				
			if (!$result)
			{
				print "Error - the query could not be executed: <br/>" . mysqli_error($dbc);
				exit;
			}
			else
			{				
				while($i <= $count)
				{
					$rndNum = rand(1, $limit); //values are inclusive	
					$result = mysqli_query($dbc, "UPDATE random_game SET round_limit =".$rndNum." WHERE id=".$i);
					$i++;
				}
			}
							
			//if everything was ok:
			if(mysqli_affected_rows($dbc) == 1)
			{
				//Ok message confirmation:
				echo "Great. The range limit for Random games has been set. <br/>";
				echo '<a href="editgame.php">Return to tables</a>';
			}else{
				echo "The range limit for Random games could not be set due to a system error. <br/>";
				echo '<a href="editgame.php">Return to tables</a>';
			}
			
			mysqli_query($dbc, "COMMIT");
			//3. ALWAYS CLOSE A DATABASE AFTER USING IT.
			mysqli_close($dbc); //dbc is for connection.php
		?>
	</div>
</body>
</html>