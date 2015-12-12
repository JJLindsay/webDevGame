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
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$course = $_POST['course'];
			$section = $_POST['section'];
			$password = $_POST['pwd'];
			$id = $_POST['id'];
			$userTag = $_POST['userTag'];
				
			//returns true or false for update
			$result = mysqli_query($dbc, "UPDATE users SET first_name = '$fname', last_name = '$lname', 
			course = '$course', section = '$section', pw = '$password' where id = $id");
			if (!$result)
			{
				print "Error - the query could not be executed: <br/>" . mysqli_error($dbc);
				exit;
			}
			
			if ($userTag != NULL && (strtolower(substr($userTag,0,1)) == 'r' || strtolower(substr($userTag,0,1)) == 'y' || strtolower(substr($userTag,0,1)) == 'b'))
			{
				if (strtolower(substr($userTag,0,1)) == 'r')
				{				
					$usrgroup = "red";
				}
				elseif (strtolower(substr($userTag,0,1)) == 'b')
				{				
					$usrgroup = "blue";
				}	
				elseif (strtolower(substr($userTag,0,1)) == 'y')
				{				
					$usrgroup = "yellow";
				}
				
				
				$result = mysqli_query($dbc, "SELECT * FROM teamcode WHERE user_group = '$usrgroup'");
				$num_rows = mysqli_num_rows($result);
				//$num_rows++;
				
				$i=0;
				while ($i < 5)
				{
					$tag = ucfirst($usrgroup)."-".$num_rows++;
					$result = mysqli_query($dbc, "SELECT * FROM teamcode WHERE tag = '$tag'");
					echo $tag;
					if(mysqli_affected_rows($dbc) < 1)
					{
						$result = mysqli_query($dbc, "UPDATE teamcode SET tag = '$tag', user_group = '$usrgroup' where users_id = $id");
						break;
					}
					$i++;
				}
				
				/*
				if (preg_match('/[1-99]/', $userTag))
				{
					$tag = $userTag;
					$result = mysqli_query($dbc, "UPDATE teamcode SET tag = '$tag', user_group = '$usrgroup' where users_id = $id");
				}
				else{
					$tag = ucfirst($usrgroup)."-".$num_rows;
					$result = mysqli_query($dbc, "UPDATE teamcode SET tag = '$tag', user_group = '$usrgroup' where users_id = $id");					
				}*/
			}
						
			//if everything was ok:
			if(mysqli_affected_rows($dbc) == 1)
			{
				//Ok message confirmation:
				echo "Great. This account has been updated. <br/>";
				echo '<a href="editgame.php">Return to tables</a>';
			}else{
				echo "The account could not be changed due to a system error. <br/>";
				echo '<a href="editgame.php">Return to tables</a>';
			}
			
			mysqli_query($dbc, "COMMIT");
			//3. ALWAYS CLOSE A DATABASE AFTER USING IT.
			mysqli_close($dbc); //dbc is for connection.php
		?>
	</div>
</body>
</html>