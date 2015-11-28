<?php
	//GAME HISTORY TEST using coop/defect buttons: This file is called by zsparks submitChoice()
	include('connection.php');
	include('session.php');
	error_reporting(-1);

	echo $_SESSION['login_id'];
	echo $_SESSION["opponent_tag"];
	
	//get the right row in dilemmas
	$query = "SELECT *";
	$query .= " FROM dilemmas";
	$query .= " WHERE p2 LIKE (SELECT tag FROM teamcode WHERE users_id = ". $_SESSION['login_id'] .")";
	$query .= " AND p1 LIKE '".$_SESSION['opponent_tag']."'";
	
	$result = mysqli_query($dbc, $query);
	$rows = mysqli_num_rows($result);
	if ($rows == 1)
	{
		echo "NEVER entered!";
			$row = $result->fetch_assoc();  //get the contents of the row.
			if (!is_null($row['p1_choice']))
			{
				//coop(player kept quiet) is 0, defect(player spoke up) is 1
				if ($_GET["decision"] == 0 && $row['p1_choice'] == 0)
				{
					$query = "UPDATE dilemmas SET p2_score = 3 where id =". $row['id'];
					$result = mysqli_query($dbc, $query);
					$query = "UPDATE dilemmas SET p1_score = 3 where id =". $row['id'];
					$result = mysqli_query($dbc, $query);
					
					$query = "INSERT INTO history (player1, player2, player1_choice, player2_choice) 
					VALUES ('".$row['p1'] ."','".$row['p2']."','coop','coop')";
					$result = mysqli_query($dbc, $query);
				}
				elseif ($_GET["decision"] == 0 && $row['p1_choice'] == 1)
				{
					$query = "UPDATE dilemmas SET p2_score = 0 where id =". $row['id'];
					$result = mysqli_query($dbc, $query);
					$query = "UPDATE dilemmas SET p1_score = 5 where id =". $row['id'];
					$result = mysqli_query($dbc, $query);
					
					$query = "INSERT INTO history (player1, player2, player1_choice, player2_choice) 
					VALUES ('".$row['p1'] ."','".$row['p2']."','defect','coop')";
					$result = mysqli_query($dbc, $query);
				}
				elseif ($_GET["decision"] == 1 && $row['p1_choice'] == 0)
				{
					$query = "UPDATE dilemmas SET p2_score = 5 where id =". $row['id'];
					$result = mysqli_query($dbc, $query);
					$query = "UPDATE dilemmas SET p1_score = 0 where id =". $row['id'];
					$result = mysqli_query($dbc, $query);
					
					$query = "INSERT INTO history (player1, player2, player1_choice, player2_choice) 
					VALUES ('".$row['p1'] ."','".$row['p2']."','coop','defect')";
					$result = mysqli_query($dbc, $query);
				}
				elseif ($_GET["decision"] == 1 && $row['p1_choice'] == 1)
				{
					$query = "UPDATE dilemmas SET p2_score = 1 where id =". $row['id'];
					$result = mysqli_query($dbc, $query);
					$query = "UPDATE dilemmas SET p1_score = 1 where id =". $row['id'];
					$result = mysqli_query($dbc, $query);
					
					$query = "INSERT INTO history (player1, player2, player1_choice, player2_choice) 
					VALUES ('".$row['p1'] ."','".$row['p2']."','defect','defect')";
					$result = mysqli_query($dbc, $query);
				}
				else{echo "There's been an error with player_choice";}
			}

			$query = "UPDATE dilemmas SET p2_choice =". $_GET['decision'] ." where id =". $row['id'];
			$result = mysqli_query($dbc, $query);		
	}
	else
	{
		//get the right row in dilemmas
		$query = "SELECT *";
		$query .= " FROM dilemmas";
		$query .= " WHERE p1 LIKE (SELECT tag FROM teamcode WHERE users_id =". $_SESSION['login_id'] .")";
		$query .= " AND p2 LIKE '".$_SESSION['opponent_tag']."'";
		//$query .=
		$result = mysqli_query($dbc, $query);

		$rows = mysqli_num_rows($result);
		if ($rows == 1)
		{
			echo "entered!" . $_GET["decision"];
			$row = $result->fetch_assoc();  //get the contents of the row.
			if (!is_null($row['p2_choice']))
			{
				//coop is 0, defect is 1
				if ($_GET["decision"] == 0 && $row['p2_choice'] == 0)
				{
					$query = "UPDATE dilemmas SET p1_score = 3 where id =". $row['id'];
					$result = mysqli_query($dbc, $query);
					$query = "UPDATE dilemmas SET p2_score = 3 where id =". $row['id'];
					$result = mysqli_query($dbc, $query);
					
					$query = "INSERT INTO history (player1, player2, player1_choice, player2_choice) 
					VALUES ('".$row['p1'] ."','".$row['p2']."','coop','coop')";
					$result = mysqli_query($dbc, $query);
				}
				elseif ($_GET["decision"] == 0 && $row['p2_choice'] == 1)
				{
					$query = "UPDATE dilemmas SET p1_score = 0 where id =". $row['id'];
					$result = mysqli_query($dbc, $query);
					$query = "UPDATE dilemmas SET p2_score = 5 where id =". $row['id'];
					$result = mysqli_query($dbc, $query);
					
					$query = "INSERT INTO history (player1, player2, player1_choice, player2_choice) 
					VALUES ('".$row['p1'] ."','".$row['p2']."','coop','defect')";
					$result = mysqli_query($dbc, $query);
				}
				elseif ($_GET["decision"] == 1 && $row['p2_choice'] == 0)
				{
					$query = "UPDATE dilemmas SET p1_score = 5 where id =". $row['id'];
					$result = mysqli_query($dbc, $query);
					$query = "UPDATE dilemmas SET p2_score = 0 where id =". $row['id'];
					$result = mysqli_query($dbc, $query);
					
					$query = "INSERT INTO history (player1, player2, player1_choice, player2_choice) 
					VALUES ('".$row['p1'] ."','".$row['p2']."','defect','coop')";
					$result = mysqli_query($dbc, $query);
				}
				elseif ($_GET["decision"] == 1 && $row['p2_choice'] == 1)
				{
					$query = "UPDATE dilemmas SET p1_score = 1 where id =". $row['id'];
					$result = mysqli_query($dbc, $query);
					$query = "UPDATE dilemmas SET p2_score = 1 where id =". $row['id'];
					$result = mysqli_query($dbc, $query);
					
					$query = "INSERT INTO history (player1, player2, player1_choice, player2_choice) 
					VALUES ('".$row['p1'] ."','".$row['p2']."','defect','defect')";
					$result = mysqli_query($dbc, $query);
				}
				else{echo "There's been an error with player_choice";}
			}

			$query = "UPDATE dilemmas SET p1_choice =". $_GET['decision'] ." where id =". $row['id'];
			$result = mysqli_query($dbc, $query);			
		}
		else
		{
			echo "We have an error reading user decision";
		}
	}
	
	//3. ALWAYS CLOSE A DATABASE AFTER USING IT.
	mysqli_close($dbc); //dbc is for connection.php
?>