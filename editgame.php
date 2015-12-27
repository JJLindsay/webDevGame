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
		<hr/>
				<Button type="button" class="btn btn-lg btn-danger" id="dumpSemesterData" style="position:relative; left:40%;" >
					Dump Semester Data
				</button>		
		<div>
			<?php
				echo "<table align='center' border=1 cellspace='3' cellpadding='3' width='75%'>
				<h3><span style=\"width: 50%; margin: 0% 12.5%\" class=\"label label-success\">Edit Users</span></h3>
				<tr>
					<th align='left'><b>Edit</b></th>
					<th align='left'><b>Delete</b></th>
					<th align='left'><b>User Tag</b></th>
					<th align='left'><b>Full Name</b></th>
					<th align='left'><b>Course</b></th>
					<th align='left'><b>Section</b></th>
				</tr>";

				$r = mysqli_query($dbc, "SELECT * FROM users u JOIN teamcode tc ON u.id = tc.users_id ORDER BY course, section");
				while ($row = mysqli_fetch_array($r))
				{
					echo 
					"<tr>
					<td>
						<a href='edit_user.php?id=".$row['id']."&fname=".$row['first_name']."&lname=".$row['last_name']."&course=".$row['course']."&pwd=".$row['pw']."&section=".$row['section']."&group=".$row['user_group']."'>Edit</a>
					</td>
					<td>
						<a href='delete_user.php?id=".$row['id']."&fname=".$row['first_name']."&lname=".$row['last_name']."&course=".$row['course']."&section=".$row['section']."'>Delete</a>
					</td>
					<td>".
						$row["tag"]
					."</td>
					<td>".
						$row["first_name"]." ".$row["last_name"]
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
				<h3><span style=\"width: 50%; margin: 0% 12.5%\" class=\"label label-success\">Current Iterative Groups</span><small><a href='iterative_limit.php'>Set Round Limit</a></small></h3>
				<tr>
					<th align='left'><b>Group Number</b></th>
					<th align='left'><b>Group of User</b></th>				
					<th align='left'><b>Group Member 02</b></th>					
					<th align='left'><b>Group Member 03</b></th>
					<th align='left'><b>Group Member 04</b></th>										
				</tr>";

				$r = mysqli_query($dbc, "SELECT * FROM iterative_teams");
				while ($row = mysqli_fetch_array($r))
				{
					echo 
					"<tr>
					<td>".
						$row["id"]
					."</td>
					<td>".
						$row["member1"]
					."</td>
					<td>".
						$row["member2"]
					."</td>
					<td>".
						$row["member3"]
					."</td>
					<td>".
						$row["member4"]
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
				<h3><span style=\"width: 50%; margin: 0% 12.5%\" class=\"label label-success\">Current Random Groups</span><small><a href='random_limit.php'>Set Round Limit</a></small></h3> 
				<tr>
					<th align='left'><b>Group Number</b></th>
					<th align='left'><b>Group Member 01</b></th>				
					<th align='left'><b>Group Member 02</b></th>					
					<th align='left'><b>Group Member 03</b></th>									
				</tr>";

				$whereclause = "(SELECT id FROM users WHERE (course, section) NOT IN (SELECT course, section FROM added_iterate_classes))";
				$rnd_groups = mysqli_query($dbc, "SELECT DISTINCT random_group FROM teamcode WHERE users_id IN ".$whereclause." ORDER BY random_group");
				$rnd_count = mysqli_num_rows($rnd_groups); //how many 
				$rnd_group = mysqli_fetch_array($rnd_groups); //who are they								
				echo $rnd_group['random_group'];
				$r = mysqli_query($dbc, "SELECT * FROM teamcode WHERE users_id IN ".$whereclause." AND random_group = ".$rnd_group['random_group']);
				$i = 0;
				
				//check that players are in the random table first!
				$random_table_populated = mysqli_query($dbc, "SELECT * FROM random_game");
				if (mysqli_num_rows($random_table_populated) > 0)
					while ($i < $rnd_count)
					{
						echo 
						"<tr>
						<td>".
							$i
						."</td>";
						while ($row = mysqli_fetch_array($r))
						{
							echo "<td>".
								$row["tag"]
							."</td>";
						}
						echo "</tr>";
						
						//call the next group and then call all users in that group
						$rnd_group = mysqli_fetch_array($rnd_groups); //who are they
						$r = mysqli_query($dbc, "SELECT * FROM teamcode WHERE users_id IN ".$whereclause." AND random_group = ".$rnd_group['random_group']);				
						$i++;
					}
				echo '</table>';
			?>
		</div>		
		
		<div>
			<?php
				echo "<table align='center' border=1 cellspace='3' cellpadding='3' width='75%'>
				<h3><span style=\"width: 50%; margin: 0% 12.5%\" class=\"label label-success\">Edit Courses</span></h3>
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
		<br/><br/>
		
			
			<h3><span style="width: 50%; margin: 0% 12.5%" class="label label-success">Select Courses to Play Iterative</span></h3>

			
	<div style="width: 50%; margin: 0% 11.5%">			
		<?php
			echo "";
			$unchecked_classes = mysqli_query($dbc, "SELECT course_and_number, section FROM course  WHERE (course_and_number, section) NOT IN (SELECT course, section FROM added_iterate_classes)");
			$checked_classes = mysqli_query($dbc, "SELECT course, section FROM added_iterate_classes WHERE (course, section) IN (SELECT course_and_number, section FROM course)");

			$count = 0;
				while ($checked_class = mysqli_fetch_array($checked_classes))
				{
					echo 
					"
					<div class=\"col-lg-6\">
						<div class=\"input-group\">
						  <span class=\"input-group-addon\">
							<input type=\"checkbox\" name='course' value='".$checked_class["course"].",".$checked_class["section"]."' checked>
						  </span>
						  <input type=\"text\" class=\"form-control\" readonly value='".$checked_class["course"]." Section ".$checked_class["section"]."'>
						</div>
					  </div> 
					";		

					if ($count == 1)
					{
						echo "<br/><br/>";
						$count=0;
					}
					else
						$count++;					
				}
				while ($unchecked_class = mysqli_fetch_array($unchecked_classes))
				{
					echo 
					"
					<div class=\"col-lg-6\">
						<div class=\"input-group\">
						  <span class=\"input-group-addon\">
							<input type=\"checkbox\" name='course' value='".$unchecked_class["course_and_number"].",".$unchecked_class["section"]."' >
						  </span>
						  <input type=\"text\" class=\"form-control\" readonly value='".$unchecked_class["course_and_number"]." Section ".$unchecked_class["section"]."'>
						</div>
					  </div> 
					";
					
					if ($count == 1)
					{
						echo "<br/><br/>";
						$count=0;
					}
					else
						$count++;					
				}					
		?>
				<br/>
				<br/><br/>
				<Button type="button" class="btn btn-lg btn-warning" id="updateIterative" style="position:relative; left:61%;" >
					Refresh Iterative Teams
				</button>
				<br/>
				<button type="button" class="btn btn-lg btn-success" id="updateRandom" style="position:relative; left:61%; margin: 1% 0%">
					Refresh Random Teams 
				</button><br/>
				<div style="width:50%; margin:-1% auto; position:relative; left:35%;">
				(<span style="color:red;">Unchecked</span> classes will play random)	
				</div>		
			</div>
		</div>		
	</div>	

	<?php
		mysqli_query($dbc, "COMMIT");
		mysqli_close($dbc); //always close the connection for security
	?>
</body>
</html>