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
					<li><a href="profilepage.php">Home</a></li>
					<li class="active"><a href="useronline.php">Who's Online</a></li>
					<li><a href="playgame.php">Play Game</a></li>
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

	<!-- list of users online -->
	<?php
		include('connection.php');
		include('session.php');
		echo "<spam style ='margin-left:10px'>Not ".$login_session." ".$login_lname." ? We would appreciate if you "."<a style='text-decoration:none' href='logout.php'><strong> bug off </strong></a> ". "  right away!</span>";
		$online_users_query="SELECT * from users WHERE online_status='1'";
		$offline_users_query="SELECT * from users WHERE online_status='0'";
		$result = $dbc -> query($online_users_query);
		$result1 = $dbc -> query($offline_users_query);
		if ($result -> num_rows > 0) 
		{

	?>
	
	<div class="container">
		<div class="user-list">
			<ul class="list-unstyled">

				<li>
				<?php while ($row = $result->fetch_assoc()) 
						{
					
							if (($row['id']) != $login_id) {
								echo "&nbsp;"."<div class='outerContainer green'>".
									"<div class='innerContainer'>"."<a href='playgame.php?id=".$row['id']."' style='color:white'>".$row['id']."</a>"."<br />".
									"</div>".
									"</div>";
								
							}
						} 
		}
				?>
				</li>
				<li>
					<?php
					if ($result1 -> num_rows > 0) {
						while ($row = $result1->fetch_assoc()) 
						{
						echo "&nbsp;"."<div class='outerContainer red'>".
							"<div class='innerContainer'>" .$row['id']."<br />".
							"</div>".
						"</div>";
						}
					}		
					?>
				</li>
			</ul>
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
</body>
</html>
