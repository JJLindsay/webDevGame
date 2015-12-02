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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"> </script>
</head>

<body>
	<?php
		include('connection.php');
		include('session.php');	
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
					<li><a href="playgame.php">Play Game</a></li>
					<li class="active"><a href="playgame_live.php">Play Game Live</a></li>
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
    			    <aside class="col-xs-12 col-md-4">
    			    	<div class="col-xs-12">
    			    		<h3><span class="label label-success col-xs-12">Total Score: 
    			    			<span class="badge" id="badge-s">
    			    				<?=$score?>
    			    			</span>
    			    		</h3><br>
    			    		<h3><span class="label label-primary col-xs-12">Session Score: 
    			    			<span class="badge" id="badge-sc">
    			    				0
    			    			</span>
    			    		</h3><br>
    			    		<h3><span class="label label-warning col-xs-12">Previous Score: 
    			    			<span class="badge" id="badge-ps">
    			    				<?=$score?>
    			    			</span>
    			    		</h3><br>
    			    		<!--h3><span class="label label-danger col-xs-12">Average score: 
    			    			<span class="badge" id="badge-as">
    			    				?=$score/$gplayed?>
    			    			</span>
    			    		</h3-->
    			    	</div>
    			    </aside>
    			    <div class="col-xs-12 col-md-8" id="game_inside">
    			    	<?php
    			    	    include_once('game_inside.php');
    			    	?>
    			    </div>
			    </div>
			</div>
		</div>
	</div>
	
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script>
        $(document).ready(function(){
            function get_data(){
    	        $('#game_inside').load('game_inside.php');
            }
            setInterval(function(){ get_data(); }, 1000);
            ion.sound({
                sounds: [
                    {name: "door_bell"},
                    {name: "door_bump"},
                    {name: "glass"},
                    {name: "light_bulb_breaking"},
                    {name: "bell_ring"}
                ],
                volume: 0.7,
                path: "sounds/",
                preload: true
            });

        });

    </script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="js/zsparks.js"></script>
	<script src="js/ion.sound.min.js"></script>	
	</body>
</html>