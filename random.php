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

<?php
	mysqli_query($dbc, "TRUNCATE TABLE random_game"); //DELETES EVERY THING IN THE TABLE EXCEPT COLUMNSS
	mysqli_query($dbc, "UPDATE teamcode SET random_group = "); //DELETES EVERY THING IN THE TABLE EXCEPT COLUMNS
	mysqli_query($dbc, "COMMIT");	
	if (!empty($_GET['unchecked']))
	{
		$allclasses = $_GET['unchecked'];
		$arr_classes = explode("|", $allclasses);	
		list($course, $section) = explode(",", $arr_classes[0], 2);
		$whereclause = "( SELECT id FROM users WHERE (course = '".$course."' AND section = ".$section.")";
				
		for($i = 1; $i < count($arr_classes)-1; $i++)
		{
			list($course, $section) = explode(",", $arr_classes[$i], 2);			
			$whereclause .= "OR (course = '".$course."' AND section = ".$section.")";		
		}
		$whereclause .= ")";
	
		$num_users = mysqli_query($dbc, "SELECT * FROM teamcode WHERE users_id IN ".$whereclause); 
		$tag_count = mysqli_num_rows($num_users);
		
		$fixed_result = mysqli_query($dbc, "SELECT COUNT(fixed_group) FROM teamcode WHERE users_id IN ".$whereclause); 
		$fixed_row = $fixed_result->fetch_assoc();  //fetch row.
		$fixed_content_columns = array_values($fixed_row);  //splits the row contents into an array
		$max_fixed_group = htmlspecialchars($fixed_content_columns[0]);		
		
		if ($max_fixed_group % 3 != 0)
			$max_fixed_group = ($max_fixed_group / 3) + 1;
		else
			$max_fixed_group = $max_fixed_group / 3;
		
		//how many groups to fill with 3 students
		$rndNum = rand(1, $max_fixed_group); //values are inclusive

		$p1_index = 0;
		$count = 1;
		$user_id = $num_users->fetch_assoc();  //fetch row.	
		//set the users' random group
		while ($count <= $tag_count)
		{
			$content_cols = array_values($user_id);  //splits the row contents into an array
			$id = htmlspecialchars($content_cols[0]);
			$fixed_group = htmlspecialchars($content_cols[4]);
			
			//how full is the randomly selected group (3 max)
			$group_result = mysqli_query($dbc, "SELECT users_id FROM teamcode WHERE random_group = $rndNum AND users_id IN ".$whereclause) or die('This is a random process.<br/>Some players were selected too many times. Please try again.');
			$random_group_size = mysqli_num_rows($group_result);
				
			if ($rndNum != $fixed_group && $random_group_size < 3)
			{
				//echo "$rndNum for $id and size: $random_group_size<br/>";
				mysqli_query($dbc,"UPDATE teamcode SET random_group = $rndNum WHERE users_id = $id");  //sets the total score to 0 on registration
				$count++;
				$user_id = $num_users->fetch_assoc();  //fetch row.	
			}
			elseif ($random_group_size == 2){
				//echo "$rndNum for $id and size: $random_group_size<br/>";
				mysqli_query($dbc,"UPDATE teamcode SET random_group = $rndNum WHERE users_id = $id");  //sets the total score to 0 on registration
				$count++;
				$user_id = $num_users->fetch_assoc();  //fetch row.	
			}
			$rndNum = rand(1, $max_fixed_group); //values are inclusive
		}
		mysqli_query($dbc, "COMMIT");

		//Using the new numbers assigned to teamcode, build the teams in random_game table
		//----------------------------------------------------------------------------
		
		$groups = mysqli_query($dbc, "SELECT DISTINCT random_group FROM teamcode WHERE users_id IN ".$whereclause);  //produces red, blue, green
		$num_groups = mysqli_num_rows($groups);  //returns 3
		$teamcode = $groups->fetch_assoc();  //gets the first one

		//output the values of the fields in the rows
		for ($row_num = 0; $row_num <  $num_groups; $row_num++)
		{
			$values = array_values($teamcode);  //splits the fetch row contents into an array
			$value = htmlspecialchars($values[0]);

			$group_players = mysqli_query($dbc, "SELECT tag FROM teamcode WHERE random_group LIKE '$value' AND users_id IN ".$whereclause);  //returns all the players for this team
			$group_players2 = mysqli_query($dbc, "SELECT tag FROM teamcode WHERE random_group LIKE '$value' AND users_id IN ".$whereclause);  //returns all the players for this team
			$num_group_players = mysqli_num_rows($group_players);
			$p1_index = 0;
			$p1 = $group_players->fetch_assoc();  //fetch row.
			$p2 = $group_players2->fetch_assoc();
			$p2_index = 0;
			
			$p1_values = array_values($p1);  //splits the row contents into an array
			$array_val1 = htmlspecialchars($p1_values[0]);
			$arr = array($array_val1);
			$allset = false;
			while ($p1_index < $num_group_players-1)
			{		
				$p2 = $group_players2->fetch_assoc();  //fetch row
				$p2_index++;
							
				$p1_values = array_values($p1);  //splits the row contents into an array
				$p1 = htmlspecialchars($p1_values[0]);

				while ($p2_index < $num_group_players)
				{
					if ($allset)
						$p2 = array(0 => $arr[$p2_index]);	
					
					$p2_values = array_values($p2);  //splits the row contents into an array
					$p2 = htmlspecialchars($p2_values[0]);
					mysqli_query($dbc, "INSERT INTO random_game (p1, p2) VALUES ('$p1','$p2')");
					
					if (!$allset)
						$arr[] = $p2;
										
					$p2 = $group_players2->fetch_assoc();  //fetch next row
					$p2_index++;
				}
				$allset = true;
				$p1_index++;
				$p2_index = $p1_index;
				$group_players2=$group_players;

				$p1 = array(0 => $arr[$p1_index]); //$group_players->fetch_assoc();  //fetch next row			
			}
			unset($arr);
			$teamcode = $groups->fetch_assoc();  //get the contents of the next row.
			
			mysqli_query($dbc,"UPDATE game_mode SET play_random = 1"); 
		}
		//Ok message confirmation:
		echo "<div id='message'>";
		echo "Great. The Random groups have been set. <br/>";
		echo '<a href="editgame.php">Return to tables</a>';
		echo "</div>";
	}
	else{
		echo "<div id='message'>";
		echo "No checkboxes where unchecked.<br/>No one will play Random.<br/>";
		echo '<a href="editgame.php">Return to tables</a>';
		echo "</div>";
	}
	
	mysqli_query($dbc, "COMMIT");
	//3. ALWAYS CLOSE A DATABASE AFTER USING IT.
	mysqli_close($dbc); //dbc is for connection.php	
?>

</body>
</html>