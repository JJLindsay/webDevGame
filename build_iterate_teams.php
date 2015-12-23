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

	mysqli_query($dbc, "TRUNCATE TABLE iterative_teams"); //DELETES EVERY THING IN THE TABLE EXCEPT COLUMNS
	mysqli_query($dbc, "TRUNCATE TABLE added_iterate_classes"); //DELETES EVERY THING IN THE TABLE EXCEPT COLUMNS
	
	if (!empty($_GET['checked']))
	{
		$allclasses = $_GET['checked'];
		$arr_classes = explode("|", $allclasses);
		list($course, $section) = explode(",", $arr_classes[0], 2);
		$whereclause = "( SELECT id FROM users WHERE (course = '".$course."' AND section = ".$section.")";
		mysqli_query($dbc, "INSERT INTO added_iterate_classes(id, course, section) VALUES (1,'$course', $section)");
		
		for($i = 1; $i < count($arr_classes)-1; $i++)
		{
			list($course, $section) = explode(",", $arr_classes[$i], 2);
			mysqli_query($dbc, "INSERT INTO added_iterate_classes(id, course, section) VALUES ($i+1,'$course', $section)");
			
			$whereclause .= "OR (course = '".$course."' AND section = ".$section.")";		
		}
		$whereclause .= ")";
		
		$query1 = 'SELECT *';
		$query1 .= ' FROM teamcode';
		$query1 .= ' WHERE users_id IN ';
		$query1 .= $whereclause;
		//echo $query1;
		$result1 = mysqli_query($dbc, $query1);
		$num_rows1 = mysqli_num_rows($result1);
		
		$row1 = mysqli_fetch_assoc($result1);  //give me this row
		$first_user = $row1['tag'];
		
		$query2 = 'SELECT *';
		$query2 .= ' FROM teamcode';
		$query2 .= ' WHERE users_id IN ';
		$query2 .= $whereclause;
		$result2 = mysqli_query($dbc, $query2);
		
		$index = 1;
		$inner_index = 1;
		mysqli_query($dbc, "INSERT INTO iterative_teams(id,member1) VALUES ($index, '$first_user')");
		
		while ($index <= $num_rows1)
		{
			$row2 = mysqli_fetch_assoc($result2);  //give me this row
			$second_user = $row2['tag'];
		
			if ($first_user == $second_user)
			{
				$row2 = mysqli_fetch_assoc($result2);  //give me this row or NULL
				$second_user = $row2['tag'];
				
				$query3 = "SELECT *";
				$query3 .= " FROM iterative_teams";
				$query3 .= " WHERE member1 = '$first_user'";
				$result3 = mysqli_query($dbc, $query3);  //returns object or FALSE on failure
				
				if ($row2 != NULL && $result3 != false)
				{
					if (substr($second_user, 0,1) == 'R')
					{
						$query3 = "SELECT *";
						$query3 .= " FROM iterative_teams";
						$query3 .= " WHERE member1 = '$first_user' AND ( member2 LIKE 'R%' OR member3 LIKE 'R%' OR member4 LIKE 'R%')";
						$result3 = mysqli_query($dbc, $query3); //returns object or FALSE on failure
						
						$row3 = mysqli_fetch_assoc($result3);  //give me this row or NULL
						if ($row3 == NULL) //there is no row with R so proceed
						{
							$query3 = "SELECT *";
							$query3 .= " FROM iterative_teams";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);
							
							$row3 = mysqli_fetch_assoc($result3);
							
							if ($row3['member2']==NULL)
							{
								$column = "member2";
							}
							elseif($row3['member3']==NULL)
							{
								$column = "member3";
							}
							else
							{
								$column = "member4";
							}
							$query3 = "UPDATE iterative_teams";
							$query3 .= " SET $column = '$second_user'";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);
						}
					}
					elseif (substr($second_user, 0,1) == 'B')
					{
						$query3 = "SELECT *";
						$query3 .= " FROM iterative_teams";
						$query3 .= " WHERE member1 = '$first_user' AND ( member2 LIKE 'B%' OR member3 LIKE 'B%' OR member4 LIKE 'B%')";
						$result3 = mysqli_query($dbc, $query3);
						
						$row3 = mysqli_fetch_assoc($result3);  //give me this row
						if ($row3 == NULL) //there is no row with R so proceed
						{
							$query3 = "SELECT *";
							$query3 .= " FROM iterative_teams";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);
							
							$row3 = mysqli_fetch_assoc($result3);
							
							if ($row3['member2']==NULL)
							{
								$column = "member2";
							}
							elseif($row3['member3']==NULL)
							{
								$column = "member3";
							}
							else
							{
								$column = "member4";
							}
							$query3 = "UPDATE iterative_teams";
							$query3 .= " SET $column = '$second_user'";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);
						}				
					}
					elseif (substr($second_user, 0,1) == 'Y')
					{
						$query3 = "SELECT *";
						$query3 .= " FROM iterative_teams";
						$query3 .= " WHERE member1 = '$first_user' AND ( member2 LIKE 'Y%' OR member3 LIKE 'Y%' OR member4 LIKE 'Y%')";
						$result3 = mysqli_query($dbc, $query3);
						
						$row3 = mysqli_fetch_assoc($result3);  //give me this row
						if ($row3 == NULL) //there is no row with Y so proceed
						{
							$query3 = "SELECT *";
							$query3 .= " FROM iterative_teams";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);
							
							$row3 = mysqli_fetch_assoc($result3);
							
							if ($row3['member2']==NULL)
							{
								$column = "member2";
							}
							elseif($row3['member3']==NULL)
							{
								$column = "member3";
							}
							else
							{
								$column = "member4";
							}
							$query3 = "UPDATE iterative_teams";
							$query3 .= " SET $column = '$second_user'";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);
						}				
					}
				}
			}
			else
			{
				$query3 = "SELECT *";
				$query3 .= " FROM iterative_teams";
				$query3 .= " WHERE member1 = '$second_user'";
				$result3 = mysqli_query($dbc, $query3); //returns object or FALSE on failure
				
				$row3 = mysqli_fetch_assoc($result3);  //give me this row or NULL
				
				if ($result3 != False && ($row3['member2'] == NULL || $row3['member3'] == NULL || $row3['member4'] == NULL)) //there is an open slot on this team
				{
					if (substr($second_user, 0,1) == 'R')  //if older user/established team owner
					{
						$query3 = "SELECT *";
						$query3 .= " FROM iterative_teams";
						$query3 .= " WHERE member1 = '$first_user' AND ( member2 LIKE 'R%' OR member3 LIKE 'R%' OR member4 LIKE 'R%')";
						$result3 = mysqli_query($dbc, $query3); //returns object or FALSE on failure
						
						$firsts_initial = substr($first_user, 0,1);
						
						$query4 = "SELECT *";
						$query4 .= " FROM iterative_teams";
						$query4 .= " WHERE member1 = '$second_user' AND ( member2 LIKE '$firsts_initial%' OR member3 LIKE '$firsts_initial%' OR member4 LIKE '$firsts_initial%')";
						$result4 = mysqli_query($dbc, $query4); //returns object or FALSE on failure
						
						$row3 = mysqli_fetch_assoc($result3);  //give me this row or NULL
						$row4 = mysqli_fetch_assoc($result4);  //give me this row or NULL
						
						if ($row3 == NULL && $row4 == NULL) //they both are in need of the other
						{					
							$query3 = "SELECT *";
							$query3 .= " FROM iterative_teams";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);
							
							$row3 = mysqli_fetch_assoc($result3);
							
							if ($row3['member2']==NULL)
							{
								$column = "member2";
							}
							elseif($row3['member3']==NULL)
							{
								$column = "member3";
							}
							else
							{
								$column = "member4";
							}
							$query3 = "UPDATE iterative_teams";
							$query3 .= " SET $column = '$second_user'";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);
							
							//this is necessary to update the team of the 2nd user that already existed but had a vacancy.
							$query3 = "SELECT *";
							$query3 .= " FROM iterative_teams";
							$query3 .= " WHERE member1 = '$second_user'";
							$result3 = mysqli_query($dbc, $query3);
							
							$row3 = mysqli_fetch_assoc($result3);
							
							if ($row3['member2']==NULL)
							{
								$column = "member2";
							}
							elseif($row3['member3']==NULL)
							{
								$column = "member3";
							}
							else
							{
								$column = "member4";
							}
							$query3 = "UPDATE iterative_teams";
							$query3 .= " SET $column = '$first_user'";
							$query3 .= " WHERE member1 = '$second_user'";
							$result3 = mysqli_query($dbc, $query3);					
						}
						//the second user had no vacancy on its team BUT it does have first user in its team so first user must add second user to its team
						elseif ($row3 == NULL && ($row4['member2'] == $first_user || $row4['member3'] == $first_user || $row4['member4'] == $first_user))
						{
							$query3 = "SELECT *";
							$query3 .= " FROM iterative_teams";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);
							
							$row3 = mysqli_fetch_assoc($result3);
							
							if ($row3['member2']==NULL)
							{
								$column = "member2";
							}
							elseif($row3['member3']==NULL)
							{
								$column = "member3";
							}
							else
							{
								$column = "member4";
							}
							$query3 = "UPDATE iterative_teams";
							$query3 .= " SET $column = '$second_user'";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);							
						}
					}
					elseif (substr($second_user, 0,1) == 'B')
					{
						$query3 = "SELECT *";
						$query3 .= " FROM iterative_teams";
						$query3 .= " WHERE member1 = '$first_user' AND ( member2 LIKE 'B%' OR member3 LIKE 'B%' OR member4 LIKE 'B%')";
						$result3 = mysqli_query($dbc, $query3); //returns object or FALSE on failure
						
						$firsts_initial = substr($first_user, 0,1);
						
						$query4 = "SELECT *";
						$query4 .= " FROM iterative_teams";
						$query4 .= " WHERE member1 = '$second_user' AND ( member2 LIKE '$firsts_initial%' OR member3 LIKE '$firsts_initial%' OR member4 LIKE '$firsts_initial%')";
						$result4 = mysqli_query($dbc, $query4); //returns object or FALSE on failure
						
						$row3 = mysqli_fetch_assoc($result3);  //give me this row or NULL
						$row4 = mysqli_fetch_assoc($result4);  //give me this row or NULL
						
						if ($row3 == NULL && $row4 == NULL) //they both are in need of the other
						{					
							$query3 = "SELECT *";
							$query3 .= " FROM iterative_teams";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);
							
							$row3 = mysqli_fetch_assoc($result3);
							
							if ($row3['member2']==NULL)
							{
								$column = "member2";
							}
							elseif($row3['member3']==NULL)
							{
								$column = "member3";
							}
							else
							{
								$column = "member4";
							}
							$query3 = "UPDATE iterative_teams";
							$query3 .= " SET $column = '$second_user'";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);
							
							//this is necessary to update the team of the 2nd user that already existed but had a vacancy.
							$query3 = "SELECT *";
							$query3 .= " FROM iterative_teams";
							$query3 .= " WHERE member1 = '$second_user'";
							$result3 = mysqli_query($dbc, $query3);
							
							$row3 = mysqli_fetch_assoc($result3);
							
							if ($row3['member2']==NULL)
							{
								$column = "member2";
							}
							elseif($row3['member3']==NULL)
							{
								$column = "member3";
							}
							else
							{
								$column = "member4";
							}
							$query3 = "UPDATE iterative_teams";
							$query3 .= " SET $column = '$first_user'";
							$query3 .= " WHERE member1 = '$second_user'";
							$result3 = mysqli_query($dbc, $query3);					
						}		
						//the second user had no vacancy on its team BUT it does have first user in its team so first user must add second user to its team
						elseif ($row3 == NULL && ($row4['member2'] == $first_user || $row4['member3'] == $first_user || $row4['member4'] == $first_user))
						{
							$query3 = "SELECT *";
							$query3 .= " FROM iterative_teams";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);
							
							$row3 = mysqli_fetch_assoc($result3);
							
							if ($row3['member2']==NULL)
							{
								$column = "member2";
							}
							elseif($row3['member3']==NULL)
							{
								$column = "member3";
							}
							else
							{
								$column = "member4";
							}
							$query3 = "UPDATE iterative_teams";
							$query3 .= " SET $column = '$second_user'";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);							
						}						
					}
					elseif (substr($second_user, 0,1) == 'Y')
					{
						$query3 = "SELECT *";
						$query3 .= " FROM iterative_teams";
						$query3 .= " WHERE member1 = '$first_user' AND ( member2 LIKE 'Y%' OR member3 LIKE 'Y%' OR member4 LIKE 'Y%')";
						$result3 = mysqli_query($dbc, $query3); //returns object or FALSE on failure
						
						$firsts_initial = substr($first_user, 0,1);
						
						$query4 = "SELECT *";
						$query4 .= " FROM iterative_teams";
						$query4 .= " WHERE member1 = '$second_user' AND ( member2 LIKE '$firsts_initial%' OR member3 LIKE '$firsts_initial%' OR member4 LIKE '$firsts_initial%')";
						$result4 = mysqli_query($dbc, $query4); //returns object or FALSE on failure
						
						$row3 = mysqli_fetch_assoc($result3);  //give me this row or NULL
						$row4 = mysqli_fetch_assoc($result4);  //give me this row or NULL
						
						if ($row3 == NULL && $row4 == NULL) //they both are in need of the other
						{					
							$query3 = "SELECT *";
							$query3 .= " FROM iterative_teams";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);
							
							$row3 = mysqli_fetch_assoc($result3);
							
							if ($row3['member2']==NULL)
							{
								$column = "member2";
							}
							elseif($row3['member3']==NULL)
							{
								$column = "member3";
							}
							else
							{
								$column = "member4";
							}
							$query3 = "UPDATE iterative_teams";
							$query3 .= " SET $column = '$second_user'";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);
							
							//this is necessary to update the team of the 2nd user that already existed but had a vacancy.
							$query3 = "SELECT *";
							$query3 .= " FROM iterative_teams";
							$query3 .= " WHERE member1 = '$second_user'";
							$result3 = mysqli_query($dbc, $query3);
							
							$row3 = mysqli_fetch_assoc($result3);
							
							if ($row3['member2']==NULL)
							{
								$column = "member2";
							}
							elseif($row3['member3']==NULL)
							{
								$column = "member3";
							}
							else
							{
								$column = "member4";
							}
							$query3 = "UPDATE iterative_teams";
							$query3 .= " SET $column = '$first_user'";
							$query3 .= " WHERE member1 = '$second_user'";
							$result3 = mysqli_query($dbc, $query3);					
						}
						//the second user had no vacancy on its team BUT it does have first user in its team so first user must add second user to its team
						elseif ($row3 == NULL && ($row4['member2'] == $first_user || $row4['member3'] == $first_user || $row4['member4'] == $first_user))
						{
							$query3 = "SELECT *";
							$query3 .= " FROM iterative_teams";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);
							
							$row3 = mysqli_fetch_assoc($result3);
							
							if ($row3['member2']==NULL)
							{
								$column = "member2";
							}
							elseif($row3['member3']==NULL)
							{
								$column = "member3";
							}
							else
							{
								$column = "member4";
							}
							$query3 = "UPDATE iterative_teams";
							$query3 .= " SET $column = '$second_user'";
							$query3 .= " WHERE member1 = '$first_user'";
							$result3 = mysqli_query($dbc, $query3);							
						}
					}			
				}
				else //there is no open slot on second user but first user may be on second user's team.
				{
					if ($row3['member2'] == $first_user || $row3['member3'] == $first_user || $row3['member4'] == $first_user)
					{
						$query3 = "SELECT *";
						$query3 .= " FROM iterative_teams";
						$query3 .= " WHERE member1 = '$first_user'";
						$result3 = mysqli_query($dbc, $query3);
						
						$row3 = mysqli_fetch_assoc($result3);
						
						if ($row3['member2']==NULL)
						{
							$column = "member2";
						}
						elseif($row3['member3']==NULL)
						{
							$column = "member3";
						}
						else
						{
							$column = "member4";
						}
						$query3 = "UPDATE iterative_teams";
						$query3 .= " SET $column = '$second_user'";
						$query3 .= " WHERE member1 = '$first_user'";
						$result3 = mysqli_query($dbc, $query3);
					}
				}	
			}
								
			$inner_index++;
			//this is used to move to next first user, reset the second user, and insert new first user
			if ($inner_index > $num_rows1)
			{
				$inner_index = 1;
				$index++;
				
				$row1 = mysqli_fetch_assoc($result1);  //give me this row for first user
				$first_user = $row1['tag'];
				
				$query2 = 'SELECT *';
				$query2 .= ' FROM teamcode';
				$query2 .= ' WHERE users_id IN ';
				$query2 .= $whereclause;
				$result2 = mysqli_query($dbc, $query2);	

				if ($index <= $num_rows1)
				mysqli_query($dbc, "INSERT INTO iterative_teams(id,member1) VALUES ($index, '$first_user')");			
			}
		}		
		include('create_iterate_matches.php');
		
		//Ok message confirmation:
		echo "<div id='message'>";
		echo "Great. The iterative groups have been set. <br/>";
		echo '<a href="editgame.php">Return to tables</a>';
		echo "</div>";
	}
	else
	{
		echo "<div id='message'>";
		echo "No checkboxes where checked.<br/>Everyone was removed from Iterative Play.<br/>Please Refresh Random Play.<br/>";
		echo '<a href="editgame.php">Return to tables</a>';
		echo "</div>";
	}
	include('iterate.php');
	
	mysqli_query($dbc, "COMMIT");
	//3. ALWAYS CLOSE A DATABASE AFTER USING IT.
	mysqli_close($dbc); //dbc is for connection.php
?>
</body>
</html>