<?php
	include('session.php');
?>
<!doctype html>
<html>
<head>
	<!--<meta charset="utf-8">-->
	<title>Prisoner's Dilemma</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link href='https://fonts.googleapis.com/css?family=Lora' rel='stylesheet' type='text/css'>
	<link href="css/stylesheet.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/custom.css" rel="stylesheet">
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
				<a class="navbar-brand" href="index.html">Prisoner's Dilemma</a>
			</div>

			<!-- Collect the nav links and other content for toggling -->
			<div class="collapse navbar-collapse" id="collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="index.php">Home</a></li>
					<li><a href="useronline.html">Who's Online</a></li>
					<li><a href="playgame.html">Play Game</a></li>
					<li><a href="">Check Score</a></li>
					<li class="dropdown active">
						<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="profile.php">My Profile</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</header><!--  end Navigation Bar -->

	<!-- Profile Table begin-->
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-2 top-margin" >


				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Profile</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-3 col-md-3 col-lg-3" align="center">
								<div class="outerContainer red">
									<div class="innerContainer"><br><?php echo $login_id; ?>
									</div>
								</div> 
							</div>
							<div class="col-sm-9 col-md-9 col-lg-9 "> 
								<table class="table table-user-information">
									<tbody>
										<tr>
											<td>Name</td>
											<td><?php echo $login_session. " ".$login_lname; ?></td>
										</tr>
										<tr>
											<td>Username</td>
											<td><?php echo $login_uname; ?></a></td>
										</tr>
										<tr>
											<td>Email</td>
											<td><?php echo $login_session_email; ?></a></td>
										</tr>	
									</tbody>
								</table>
								<button type="button" class="btn btn-default dropdown-toggle btn-warning" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float:right" id="editbtn">
									<i class="glyphicon glyphicon-edit"></i> Edit Profile
								</button>
								<!-- a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning" style="float:right"><i class="glyphicon glyphicon-edit"></i> Edit Profile</a -->

							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div><!-- end Profile Table -->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type=" src=js/myscript.js"></script>
<script src="js/zsparks.js"></script>
</body>
</html>
