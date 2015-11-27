<!doctype html>
<html>
<head>
	<?php
		error_reporting(-1);
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
		#formbox 
		{
			width: 50%;
			margin: 2% 5%;
		}
		
		#title
		{
			width: 50%;
			margin: 2% 2%;
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

	<h1 id='title'>Make your changes below</h1>
	<?php
		$id = $_GET['id'];
		
		echo "<form id='formbox' action='submit_edit_course.php' method='post'>
			 <p>ID: <input type='text' name= 'id' size='20' maxlength='3' readonly value='".$_GET['id']."'/></p>
			 <p>Course: <input type='text' name= 'course' size='10' maxlength='50' value='".$_GET['course']."'/></p>	
			 <p>Section: <input type='text' name= 'section' size='2' maxlength='50' value='".$_GET['section']."'/></p>
			
			 <p><input type='submit' name='Apply Changes' value='Submit' /></p>	   
			 </form>";
	?>	
</body>
</html>
