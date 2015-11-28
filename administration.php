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
					<li><a href="editgame.php">Edit Game</a></li>
					<li class="active"><a href="administration.php">Check Scores</a></li>
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
	  <h1>Welcome Administrator <small>TO 
	  <span class="dropdown">
	  <button class="btn btn-default dropdown-toggle" type="button" id="choosecourse" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
			All Courses<span class="caret"></span>
		</button>
		<ul class="dropdown-menu" aria-labelledby="choosecourse">
			<li class="list-group-item">
				<form method = "POST" action = "<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
					<button style="background-color:#ddd; color:black" type = "submit" class="btn btn-default">All Courses</button>
				</form>
			</li>
			<?php
				$query = 'SELECT DISTINCT course, section FROM users WHERE course IS NOT NULL && SECTION IS NOT NULL;';
				
				//execute the query
				$result = mysqli_query($dbc, $query);
								
				//get the number of rows within the result (or database) 
				$num_rows = mysqli_num_rows($result);
				//if there are rows in the result, put them in an html table
				if ($num_rows > 0)
				{
					$row = $result->fetch_assoc();  //get the contents of the row.
					//output the values of the fields in the rows
					for ($row_num = 0; $row_num <  $num_rows; $row_num++)
					{
						?>
						<li class='list-group-item'>					
							<form method = "POST" action = "<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
								<input type = "hidden" name = "course" value = "<?php echo $row["course"] ?>" />
								<input type = "hidden" name = "section" value = "<?php echo $row["section"] ?>" />  <!-- this triggers that we've been here once-->
								<button style="background-color:#ddd; color:black" type = "submit" class="btn btn-default"><?php echo $row["course"]." Section ".$row["section"] ?></button>
							</form>
						</li>
						<?php
						$row = $result->fetch_assoc();  //get the contents of the row.
					}
				}
				?>
				<li class='list-group-item'>					
					<form method = "POST" action = "<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
						<input type = "hidden" name = "course" value = "history"/>
						<button style="background-color:#ddd; color:black" type = "submit" class="btn btn-default">History</button>
					</form>
				</li>
		<?php
		echo "</ul> ".
		"</span> ".
		"</h1> ".
	"</div> ".


	"<div> ".
		"<img src='img/American History X-Cellent.jpg' alt='' class='img-rounded myimg' /> ".
		"<div class='bigwrapper'> ".
			
			"<h1 style='color:white;'><center>Scores by Class</center></h1> ".

	  
			"<div class='wrapper'> ".
			  "<div class='table-responsive'> ". //<!--Add this for responsive table -->
			  "<table class='table table-hover table-bordered table-striped' border=1 id='inner'> ".
						"<tr> ";
						
					if (IsSet($_POST["course"]) && $_POST["course"] == "history")
					{
						echo
							"<th>Player 01</th> ".
							"<th>Player 02</th> ".
							"<th>Player 01 - Choice</th> ".
							"<th>Player 02 - Choice</th> ";
					}
					else
					{
						echo
							"<th>User Name</th> ".
							"<th>Last Name</th> ".
							"<th>First Name</th> ".
							"<th>Score</th> ".
							"<th>Course</th> ".
							"<th>Section</th> ";
					}
						echo "</tr> ";
					if (IsSet($_POST["course"]) && $_POST["course"] == "history")
					{
						$query = 'SELECT player1, player2, player1_choice, player2_choice FROM history';
					}	
					elseif (!IsSet($_POST["course"]) || !IsSet($_POST["section"]))
					{
							
						$query = 'select usernames, last_name, first_name, totalscore, course, section from users u join totals ts on u.id = ts.users_id;';
					}
					else{
						$query = 'select usernames, last_name, first_name, totalscore, course, section from users u join totals ts on u.id = ts.users_id WHERE course LIKE \''.
							$_POST["course"].'\' AND section LIKE \''.$_POST["section"].'\';';
					}
						trim($query);
						$query = stripslashes($query);
						
						//execute the query
						$result = mysqli_query($dbc, $query);
						if (!$result)
						{
							print "Error - the query could not be executed: <br/>" . mysqli_error($dbc);
							exit;
						}
								
						//Display the results in a table
						print "<tr align = 'center'>";
									
						//get the number of rows within the result (or database) 
						$num_rows = mysqli_num_rows($result);
						
						//if there are rows in the result, put them in an html table
						if ($num_rows > 0)
						{
							$row = mysqli_fetch_assoc($result);  //give me this row
							$num_fields = mysqli_num_fields($result);		//tell me how many fields per row

							print "</tr>";
									
								//output the values of the fields in the rows
								for ($row_num = 0; $row_num <  $num_rows; $row_num++)
								{
									print "<tr>";
									$values = array_values($row);
									for ($index = 0; $index < $num_fields; $index++)
									{
										$value = htmlspecialchars($values[$index]);
										print "<td>" . $value . "</td>";
									}	//* end of for ($index ...
									
									print "</tr>";
									$row = mysqli_fetch_assoc($result);  //get the contents of the next row.
								}	
						}
						else
						{
							print "There were no such rows in the table <br />";
						}  
			  ?>
					</table>
				 </div>
				 <button type="button" class="btn btn-lg btn-success" aria-haspopup="true" aria-expanded="false" id="exportbtn">
					Export to SpreadSheet
				</button>			
			</div>
		</div>
	</div>

	<!--There needs to be a button >
	<iframe id="txtArea1" style="display:none"></iframe>
<button id="btnExport"> EXPORT </button -->


<?php

	//3. ALWAYS CLOSE A DATABASE AFTER USING IT.
	mysqli_close($dbc);
?>
</body>
</html>