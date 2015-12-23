<!DOCTYPE html>
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
		include('connection.php');
		include('session.php');
		include('functions.php');						
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
				<a class="navbar-brand" href="index.php">Prisoner's Dilemma</a>
			</div>

			<!-- Collect the nav links and other content for toggling -->
			<div class="collapse navbar-collapse" id="collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="index.php">Home</a></li>
					<li><a href="useronline.php">Who's Online</a></li>
					<li class="active"><a href="playgame.php">Play Game</a></li>
					<li><a href="playgame_live.php">Play Game Live</a></li>
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
	
		<div>
		<img src='img/holdingcell.jpg' class='img-rounded myimg' style="opacity:.37;"/> 
		<div class='bigwrapper'> 
	
	<div class="container" style="margin: 0% -45%">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-2 top-margin" >
				<h3 style="background-color:#bbb; width:39%; border: 1.5px solid black"><b>The Prisoner's Dilemma...</b></h3>
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
						<div id="gameScreen" style="color:white; position:center;">
							<h4 style="text-align: center;"><br/><br/>Your partners in crime are below, will you betray them or 
							remain silent? Select each one to decide. Your actions will not be shared.<br/>
								<h3 style="text-align: center;">Points:</h3>
								<h4 style="text-align: center;">silent - silent<br/>
							     3  -  3<br/>
							silent - betray<br/>
							     0  -  5<br/>
								 betray - betray<br/>
							     1  -  1</h4><h3>
								 <small style="margin: 0% 20%">Selecting a partner displays your last score.</small>
						</div>
						<div class="btn-group btn-group-justified">
							<div class="btn-group">
								<button class="btn btn-primary" id="btnCoop" submitChoice="0">Remain Silent <!--(Don't Speak)--></button>
							</div>
							<div class="btn-group">
								<button class="btn btn-primary" id="btnBetray" submitChoice="1">Betray <!--(Spill the Beans)--></button>
							</div>
						</div>
						<br/>

						<div class="list-group" id="gameContacts">
							<b>Current Dilemmas</b>
							<!--LOOP  set the id and collect the score against id-->
							<?php
								//IS THE USER PLAYING ITERATIVE OR RANDOM?
								$query = "SELECT *";
								$query .= " FROM added_iterate_classes";
								$query .= " WHERE (course, section) = ";
								$query .= "( SELECT course, section";
								$query .= " FROM users";
								$query .= " WHERE id = ".$_SESSION['login_id']." )";
								
								$result = mysqli_query($dbc, $query);
								$rows = mysqli_num_rows($result);
								if ($rows == 1)  //USER'S CLASS IS PLAYING ITERATIVE
								{												
									$query = "SELECT *";
									$query .= " FROM iterative_game";
									$query .= " WHERE p1 IN (SELECT tag";
									$query .= " FROM teamcode";
									$query .= " WHERE users_id=".$_SESSION['login_id'].")";
								}
								else  //USER'S CLASS IS PLAYING RANDOM
								{						
									$query = "SELECT *";
									$query .= " FROM random_game";
									$query .= " WHERE p1 IN (SELECT tag";
									$query .= " FROM teamcode";
									$query .= " WHERE users_id=".$_SESSION['login_id'].")";																
								}
								$result=mysqli_query($dbc, $query);
																
								if ($result) 
								{
									//get the number of rows within the result (or database) 
									$num_rows = mysqli_num_rows($result);
									
									$row = $result->fetch_assoc();  //get the contents of the row.
									
									for ($index = 0; $index <  $num_rows; $index++)
									{						
										//sets which button color to use
										//get the group color of p1 if play random is false
										//else get random group color of p1 if play random is true
										
										$query = "SELECT *";
										$query .= " FROM teamcode";
										$query .= " WHERE tag LIKE '".$row['p2']."'";
										
										$teamcode_result = mysqli_query($dbc, $query);
										$getColor = $teamcode_result->fetch_assoc();  //get the contents of the row.								
										$color = $getColor['user_group'];
										
										//sets which button to use
										//if p1_score !null and p2_score is Null
										if (!is_null($row['p2_choice']) && is_null($row['p1_choice']) && $row['round_limit'] > 0)
										{
											 ?>
											<button type='button' class='list-group-item' id='dilemmas' onclick='recent_game_score(<?php echo $row['p1_score']?>, "<?php echo $row['p2'] ?>")'>
												<span style='color:white;background-color:<?php echo $color ?>;border-radius: 5px;padding:0% 1%;'><?php echo $row['p2']?></span>
												<span class='glyphicon glyphicon-flag customBadgeAct'></span>
											</button>
											<?php
										}
										elseif ($row['round_limit'] > 0)
										{		
											?>
											<button type='button' class='list-group-item' id='dilemmas' onclick='recent_game_score(<?php echo $row['p1_score']?>, "<?php echo $row['p2'] ?>" )'>
												<span style='color:white;background-color:<?php echo $color ?>;border-radius: 5px;padding:0% 1%;'><?php echo $row['p2']?></span>
											</button>										
											<?php
										}
										$row = $result->fetch_assoc();  //get the contents of the row.
									}
								}						
								
								//IS THE USER PLAYING ITERATIVE OR RANDOM?
								$query = "SELECT *";
								$query .= " FROM added_iterate_classes";
								$query .= " WHERE (course, section) = ";
								$query .= "( SELECT course, section";
								$query .= " FROM users";
								$query .= " WHERE id = ".$_SESSION['login_id']." )";
								
								$result = mysqli_query($dbc, $query);
								$rows = mysqli_num_rows($result);
								if ($rows == 1)  //USER'S CLASS IS PLAYING ITERATIVE
								{													
									$query = "SELECT *";
									$query .= " FROM iterative_game";
									$query .= " WHERE p2 IN (SELECT tag";
									$query .= " FROM teamcode";
									$query .= " WHERE users_id=".$_SESSION['login_id'].")";
								}
								else  //USER'S CLASS IS PLAYING RANDOM
								{						
									$query = "SELECT *";
									$query .= " FROM random_game";
									$query .= " WHERE p2 IN (SELECT tag";
									$query .= " FROM teamcode";
									$query .= " WHERE users_id=".$_SESSION['login_id'].")";																
								}								
								$result = mysqli_query($dbc, $query);
								
								if ($result)
								{
									//get the number of rows within the result (or database) 
									$num_rows = mysqli_num_rows($result); 		
									
									//success
									$row = $result->fetch_assoc();  //get the contents of the row.
									
									//loop through
									for ($index = 0; $index <  $num_rows; $index++)
									{
										//sets which button color to use
										//get the group color of p1 if play random is false
										//else get random group color of p1 if play random is true
										
										$query = "SELECT *";
										$query .= " FROM teamcode";
										$query .= " WHERE tag LIKE '".$row['p1']."'";
										
										$teamcode_result = mysqli_query($dbc, $query);
										$getColor = $teamcode_result->fetch_assoc();  //get the contents of the row.
										
										$color = $getColor['user_group'];
										
										//sets which button to use
										if (!is_null($row['p1_choice']) && is_null($row['p2_choice']) && $row['round_limit'] > 0)
										{
											 ?>
											<button type='button' class='list-group-item' id='dilemmas' onclick='recent_game_score(<?php echo $row['p2_score']?>, "<?php echo $row['p1'] ?>")'>
												<span style='color:white;background-color:<?php echo $color ?>;border-radius: 5px;padding:0% 1%;'><?php echo $row['p1']?></span>
												<span class='glyphicon glyphicon-flag customBadgeAct'></span>
											</button>
											<?php
										}
										elseif ($row['round_limit'] > 0)
										{		
											?>
											<button type='button' class='list-group-item' id='dilemmas' onclick='recent_game_score(<?php echo $row['p2_score']?>, "<?php echo $row['p1'] ?>")'>
												<span style='color:white;background-color:<?php echo $color ?>;border-radius: 5px;padding:0% 1%;'><?php echo $row['p1']?></span>
											</button>										
											<?php
										}
										$row = $result->fetch_assoc();  //get the contents of the next row.
									}
								}								
								else
								{
									//failure
									die("Database query failed.");
								}
							?>
						</div>

					</div>
				</div>
				</div>
			</div>
			</div>
	
		</div>
	</div>

<?php
	mysqli_query($dbc, "COMMIT");
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

		function recent_game_score($score, $opponent_tag)
		{
			document.getElementById("previousScore").innerHTML='Prev. Score: ' + $score;
			
			$.ajax({
				url: "./setOpponentTag.php?opptag="+ $opponent_tag,
				success: function() {
					//alert("opponent_tag sent")
				},
			});	
		}
		
	</script>
</body>
</html>