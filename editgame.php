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
    <!--<script src="js/respond.js"></script -->	
	
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/zsparks.js"></script>
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
	
	
	<div class="page-header">
	  <h1>Welcome Administrator <small>TO THE EDIT GAME MENU</small></h1>	
		<div> 
			<!--img src='img/American History X-Cellent.jpg' alt='' class='img-rounded myimg' / --> 
			<div class='bigwrapper'> 			
				<br/>
				<br/>
				Select how you wish the class to play. (Iterative play is set by default)
				<button type="button" class="btn btn-lg btn-warning" aria-haspopup="true" aria-expanded="false" id="iterationbtn">
					Iterative Play (deletes previous values)
				</button>
				<button type="button" class="btn btn-lg btn-success" aria-haspopup="true" aria-expanded="false" id="playrandombtn">
					Random Play (deletes previous values)
				</button>	
			</div>
		</div>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>		
		<div>
			<?php
				echo "<table align='center' border=1 cellspace='3' cellpadding='3' width='75%'>
				<tr>
					<th align='left'><b>Edit</b></th>
					<th align='left'><b>Delete</b></th>
					<th align='left'><b>Name</b></th>
					<th align='left'><b>Course</b></th>
					<th align='left'><b>Section</b></th>
				</tr>";

				$r = mysqli_query($dbc, "SELECT * FROM users ORDER BY course, section");
				while ($row = mysqli_fetch_array($r))
				{
					echo 
					"<tr>
					<td>
						<a href='edit_user.php?id=".$row['id']."&fname=".$row['first_name']."&lname=".$row['last_name']."&course=".$row['course']."&pwd=".$row['pw']."&section=".$row['section']."'>Edit</a>
					</td>
					<td>
						<a href='delete_user.php?id=".$row['id']."&fname=".$row['first_name']."&lname=".$row['last_name']."&course=".$row['course']."&section=".$row['section']."'>Delete</a>
					</td>
					<td>".
						$row["last_name"]." , ".$row["first_name"]
					."</td>
					<td>".
						$row["course"]
					."</td>
					<td>".
						$row["section"]
					."</td>
					</tr>";
				}
				echo '</table>';
			?>
		</div>
		<br/>
		<div>
			<?php
				echo "<table align='center' border=1 cellspace='3' cellpadding='3' width='75%'>
				<tr>
					<th align='left'><b>Edit</b></th>
					<th align='left'><b>Delete</b></th>
					<th align='left'><b>Course and Course Number</b></th>
					<th align='left'><b>Section</b></th>
				</tr>";

				$r = mysqli_query($dbc, "SELECT * FROM course  ORDER BY course_and_number, section");
				while ($row = mysqli_fetch_array($r))
				{
					echo 
					"<tr>
					<td>
						<a href='edit_course.php?id=".$row['id']."&course=".$row['course_and_number']."&section=".$row['section']."'>Edit</a>
					</td>
					<td>
						<a href='delete_course.php?id=".$row['id']."&course=".$row['course_and_number']."&section=".$row['section']."'>Delete</a>
					</td>
					<td>".
						$row["course_and_number"]
					."</td>
					<td>".
						$row["section"]
					."</td>
					</tr>";
				}
				echo '</table>';
			?>
					<br/>
				<button type="button" class="btn btn-lg btn-warning" style="position:relative; left:43%;" aria-haspopup="true" aria-expanded="false" id="addcour">
					Add Course
				</button>	
		</div>		
	</div>	

	<?php
		mysqli_close($dbc); //always close the connection for security
	?>
</body>
</html>