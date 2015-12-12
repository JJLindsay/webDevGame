<?php
	//GAME HISTORY TEST using coop/defect buttons: This file is called by zsparks submitChoice()
	include('connection.php');
	include('session.php');
	error_reporting(-1);

	echo $_SESSION['login_id'];
	echo $_SESSION["opponent_tag"];
	
	
	//IS THE USER PLAYING ITERATIVE OR RANDOM?
	$query = "SELECT *";
	$query .= " FROM added_iterate_classes";
	$query .= " WHERE (course, section) = ";
	$query .= "( SELECT course, section";
	$query .= " FROM users";
	$query .= " WHERE id = ".$_SESSION['login_id']." )";
	
	$result = mysqli_query($dbc, $query);
	$rows = mysqli_num_rows($result);
	if ($rows == 1)  //USER'S CLASS IS PLAYING ITERATIVE
	{
		$opponent = mysqli_query($dbc, "SELECT users_id FROM teamcode WHERE tag LIKE '".$_SESSION['opponent_tag']."'");
		$opponent_id = $opponent->fetch_assoc();
		$oppon_id = $opponent_id['users_id'];
	
		//get the right row in iterative_game
		$query = "SELECT *";
		$query .= " FROM iterative_game";
		$query .= " WHERE p2 LIKE (SELECT tag FROM teamcode WHERE users_id = ". $_SESSION['login_id'] .")";
		$query .= " AND p1 LIKE '".$_SESSION['opponent_tag']."'";
		
		$result = mysqli_query($dbc, $query);
		$rows = mysqli_num_rows($result);
		if ($rows == 1)
		{
			//echo "NEVER entered!";
				$row = $result->fetch_assoc();  //get the contents of the row.
				if (!is_null($row['p1_choice'])) //if the opponent has already made a decision
				{
					//coop(player kept quiet) is 0, defect(player spoke up) is 1
					if ($_GET["decision"] == 0 && $row['p1_choice'] == 0)
					{
						$query = "UPDATE iterative_game SET p2_score = 3 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE iterative_game SET p1_score = 3 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE iterative_game SET p1_choice = null, p2_choice = null where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						
						//update total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+3;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);		

						//update opponent total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+3;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);							
						
						$query = "INSERT INTO history (player1, player2, player1_choice, player2_choice) 
						VALUES ('".$row['p1'] ."','".$row['p2']."','coop','coop')";
						$result = mysqli_query($dbc, $query);						
						
						//reduce game round limit
						$round_query = "SELECT round_limit FROM iterative_game WHERE id =". $row['id'];
						$round_result = mysqli_query($dbc, $round_query);		
						$round_row = $round_result->fetch_assoc();  //get the contents of the row.	
						$reduced_limit = intval($round_row['round_limit'])-1;
						$query = "UPDATE iterative_game SET round_limit = ".$reduced_limit." WHERE id =". $row['id'];
						$result = mysqli_query($dbc, $query);							
					}
					elseif ($_GET["decision"] == 0 && $row['p1_choice'] == 1)
					{
						$query = "UPDATE iterative_game SET p2_score = 0 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE iterative_game SET p1_score = 5 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE iterative_game SET p1_choice = null, p2_choice = null where id =". $row['id'];
						$result = mysqli_query($dbc, $query);												
						
						//update opponent total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+5;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);							
						
						$query = "INSERT INTO history (player1, player2, player1_choice, player2_choice) 
						VALUES ('".$row['p1'] ."','".$row['p2']."','defect','coop')";
						$result = mysqli_query($dbc, $query);
						
						//reduce game round limit
						$round_query = "SELECT round_limit FROM iterative_game WHERE id =". $row['id'];
						$round_result = mysqli_query($dbc, $round_query);		
						$round_row = $round_result->fetch_assoc();  //get the contents of the row.	
						$reduced_limit = intval($round_row['round_limit'])-1;
						$query = "UPDATE iterative_game SET round_limit = ".$reduced_limit." WHERE id =". $row['id'];
						$result = mysqli_query($dbc, $query);					
					}
					elseif ($_GET["decision"] == 1 && $row['p1_choice'] == 0)
					{
						$query = "UPDATE iterative_game SET p2_score = 5 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE iterative_game SET p1_score = 0 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE iterative_game SET p1_choice = null, p2_choice = null where id =". $row['id'];
						$result = mysqli_query($dbc, $query);						
						
						//update total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+5;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);							
						
						$query = "INSERT INTO history (player1, player2, player1_choice, player2_choice) 
						VALUES ('".$row['p1'] ."','".$row['p2']."','coop','defect')";
						$result = mysqli_query($dbc, $query);
						
						//reduce game round limit
						$round_query = "SELECT round_limit FROM iterative_game WHERE id =". $row['id'];
						$round_result = mysqli_query($dbc, $round_query);		
						$round_row = $round_result->fetch_assoc();  //get the contents of the row.	
						$reduced_limit = intval($round_row['round_limit'])-1;
						$query = "UPDATE iterative_game SET round_limit = ".$reduced_limit." WHERE id =". $row['id'];
						$result = mysqli_query($dbc, $query);						
					}
					elseif ($_GET["decision"] == 1 && $row['p1_choice'] == 1)
					{
						$query = "UPDATE iterative_game SET p2_score = 1 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE iterative_game SET p1_score = 1 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE iterative_game SET p1_choice = null, p2_choice = null where id =". $row['id'];
						$result = mysqli_query($dbc, $query);						
						
						//update total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+1;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);		

						//update opponent total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+1;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);							
						
						$query = "INSERT INTO history (player1, player2, player1_choice, player2_choice) 
						VALUES ('".$row['p1'] ."','".$row['p2']."','defect','defect')";
						$result = mysqli_query($dbc, $query);
						
						//reduce game round limit
						$round_query = "SELECT round_limit FROM iterative_game WHERE id =". $row['id'];
						$round_result = mysqli_query($dbc, $round_query);		
						$round_row = $round_result->fetch_assoc();  //get the contents of the row.	
						$reduced_limit = intval($round_row['round_limit'])-1;
						$query = "UPDATE iterative_game SET round_limit = ".$reduced_limit." WHERE id =". $row['id'];
						$result = mysqli_query($dbc, $query);						
					}
					else{echo "There's been an error with player_choice";}
				}else{
					$query = "UPDATE iterative_game SET p2_choice =". $_GET['decision'] ." where id =". $row['id'];
					$result = mysqli_query($dbc, $query);		
				}
		}
		else
		{
			//get the right row in iterative_game
			$query = "SELECT *";
			$query .= " FROM iterative_game";
			$query .= " WHERE p1 LIKE (SELECT tag FROM teamcode WHERE users_id =". $_SESSION['login_id'] .")";
			$query .= " AND p2 LIKE '".$_SESSION['opponent_tag']."'";
			//$query .=
			$result = mysqli_query($dbc, $query);

			$rows = mysqli_num_rows($result);
			if ($rows == 1)
			{
				//echo "entered!" . $_GET["decision"];
				$row = $result->fetch_assoc();  //get the contents of the row.
				if (!is_null($row['p2_choice']))  //opponent has already made a decision
				{
					//coop is 0, defect is 1
					if ($_GET["decision"] == 0 && $row['p2_choice'] == 0)
					{
						$query = "UPDATE iterative_game SET p1_score = 3 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE iterative_game SET p2_score = 3 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE iterative_game SET p1_choice = null, p2_choice = null where id =". $row['id'];
						$result = mysqli_query($dbc, $query);		

						//update total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+3;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);		

						//update opponent total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+3;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);							
						
						$query = "INSERT INTO history (player1, player2, player1_choice, player2_choice) 
						VALUES ('".$row['p1'] ."','".$row['p2']."','coop','coop')";
						$result = mysqli_query($dbc, $query);
						
						//reduce game round limit
						$round_query = "SELECT round_limit FROM iterative_game WHERE id =". $row['id'];
						$round_result = mysqli_query($dbc, $round_query);		
						$round_row = $round_result->fetch_assoc();  //get the contents of the row.	
						$reduced_limit = intval($round_row['round_limit'])-1;
						$query = "UPDATE iterative_game SET round_limit = ".$reduced_limit." WHERE id =". $row['id'];
						$result = mysqli_query($dbc, $query);						
					}
					elseif ($_GET["decision"] == 0 && $row['p2_choice'] == 1)
					{
						$query = "UPDATE iterative_game SET p1_score = 0 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE iterative_game SET p2_score = 5 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE iterative_game SET p1_choice = null, p2_choice = null where id =". $row['id'];
						$result = mysqli_query($dbc, $query);						
						
						//update opponent total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+5;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);							
						
						$query = "INSERT INTO history (player1, player2, player1_choice, player2_choice) 
						VALUES ('".$row['p1'] ."','".$row['p2']."','coop','defect')";
						$result = mysqli_query($dbc, $query);
						
						//reduce game round limit
						$round_query = "SELECT round_limit FROM iterative_game WHERE id =". $row['id'];
						$round_result = mysqli_query($dbc, $round_query);		
						$round_row = $round_result->fetch_assoc();  //get the contents of the row.	
						$reduced_limit = intval($round_row['round_limit'])-1;
						$query = "UPDATE iterative_game SET round_limit = ".$reduced_limit." WHERE id =". $row['id'];
						$result = mysqli_query($dbc, $query);						
					}
					elseif ($_GET["decision"] == 1 && $row['p2_choice'] == 0)
					{
						$query = "UPDATE iterative_game SET p1_score = 5 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE iterative_game SET p2_score = 0 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE iterative_game SET p1_choice = null, p2_choice = null where id =". $row['id'];
						$result = mysqli_query($dbc, $query);		

						//update total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+5;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);							
						
						$query = "INSERT INTO history (player1, player2, player1_choice, player2_choice) 
						VALUES ('".$row['p1'] ."','".$row['p2']."','defect','coop')";
						$result = mysqli_query($dbc, $query);
						
						//reduce game round limit
						$round_query = "SELECT round_limit FROM iterative_game WHERE id =". $row['id'];
						$round_result = mysqli_query($dbc, $round_query);		
						$round_row = $round_result->fetch_assoc();  //get the contents of the row.	
						$reduced_limit = intval($round_row['round_limit'])-1;
						$query = "UPDATE iterative_game SET round_limit = ".$reduced_limit." WHERE id =". $row['id'];
						$result = mysqli_query($dbc, $query);						
					}
					elseif ($_GET["decision"] == 1 && $row['p2_choice'] == 1)
					{
						$query = "UPDATE iterative_game SET p1_score = 1 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE iterative_game SET p2_score = 1 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE iterative_game SET p1_choice = null, p2_choice = null where id =". $row['id'];
						$result = mysqli_query($dbc, $query);			

						//update total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+1;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);				

						//update opponent total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+1;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);							
						
						$query = "INSERT INTO history (player1, player2, player1_choice, player2_choice) 
						VALUES ('".$row['p1'] ."','".$row['p2']."','defect','defect')";
						$result = mysqli_query($dbc, $query);
						
						//reduce game round limit
						$round_query = "SELECT round_limit FROM iterative_game WHERE id =". $row['id'];
						$round_result = mysqli_query($dbc, $round_query);		
						$round_row = $round_result->fetch_assoc();  //get the contents of the row.	
						$reduced_limit = intval($round_row['round_limit'])-1;
						$query = "UPDATE iterative_game SET round_limit = ".$reduced_limit." WHERE id =". $row['id'];
						$result = mysqli_query($dbc, $query);					
					}
					else{echo "There's been an error with player_choice";}
				}else{
					$query = "UPDATE iterative_game SET p1_choice =". $_GET['decision'] ." where id =". $row['id'];
					$result = mysqli_query($dbc, $query);			
				}
			}
			else
			{
				echo "We have an error reading user decision";
			}
		}
	}
	else{ //USER'S CLASS IS PLAYING RANDOM
		
		$opponent = mysqli_query($dbc, "SELECT users_id FROM teamcode WHERE tag LIKE '".$_SESSION['opponent_tag']."'");
		echo $_SESSION['opponent_tag'];
		$opponent_id = $opponent->fetch_assoc();
		$oppon_id = $opponent_id['users_id'];
		
		//get the right row in random_game
		$query = "SELECT *";
		$query .= " FROM random_game";
		$query .= " WHERE p2 LIKE (SELECT tag FROM teamcode WHERE users_id = ". $_SESSION['login_id'] .")";
		$query .= " AND p1 LIKE '".$_SESSION['opponent_tag']."'";
		
		$result = mysqli_query($dbc, $query);
		$rows = mysqli_num_rows($result);
		if ($rows == 1)
		{
			echo "NEVER entered!";
				$row = $result->fetch_assoc();  //get the contents of the row.
				if (!is_null($row['p1_choice']))  //opponent has already made a decision
				{
					//coop(player kept quiet) is 0, defect(player spoke up) is 1
					if ($_GET["decision"] == 0 && $row['p1_choice'] == 0)
					{
						$query = "UPDATE random_game SET p2_score = 3 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE random_game SET p1_score = 3 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE random_game SET p1_choice = null, p2_choice = null where id =". $row['id'];
						$result = mysqli_query($dbc, $query);		

						//update total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+3;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);		

						//update opponent total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+3;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);							
						
						$query = "INSERT INTO random_history (player1, player2, player1_choice, player2_choice) 
						VALUES ('".$row['p1'] ."','".$row['p2']."','coop','coop')";
						$result = mysqli_query($dbc, $query);
						
						//reduce game round limit
						$round_query = "SELECT round_limit FROM random_game WHERE id =". $row['id'];
						$round_result = mysqli_query($dbc, $round_query);		
						$round_row = $round_result->fetch_assoc();  //get the contents of the row.	
						$reduced_limit = intval($round_row['round_limit'])-1;
						$query = "UPDATE random_game SET round_limit = ".$reduced_limit." WHERE id =". $row['id'];
						$result = mysqli_query($dbc, $query);		
					}
					elseif ($_GET["decision"] == 0 && $row['p1_choice'] == 1)
					{
						$query = "UPDATE random_game SET p2_score = 0 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE random_game SET p1_score = 5 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE random_game SET p1_choice = null, p2_choice = null where id =". $row['id'];
						$result = mysqli_query($dbc, $query);						
						
						//update opponent total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+5;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);							
						
						$query = "INSERT INTO random_history (player1, player2, player1_choice, player2_choice) 
						VALUES ('".$row['p1'] ."','".$row['p2']."','defect','coop')";
						$result = mysqli_query($dbc, $query);
						
						//reduce game round limit
						$round_query = "SELECT round_limit FROM random_game WHERE id =". $row['id'];
						$round_result = mysqli_query($dbc, $round_query);		
						$round_row = $round_result->fetch_assoc();  //get the contents of the row.	
						$reduced_limit = intval($round_row['round_limit'])-1;
						$query = "UPDATE random_game SET round_limit = ".$reduced_limit." WHERE id =". $row['id'];
						$result = mysqli_query($dbc, $query);						
					}
					elseif ($_GET["decision"] == 1 && $row['p1_choice'] == 0)
					{
						$query = "UPDATE random_game SET p2_score = 5 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE random_game SET p1_score = 0 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE random_game SET p1_choice = null, p2_choice = null where id =". $row['id'];
						$result = mysqli_query($dbc, $query);		

						//update total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+5;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);							
						
						$query = "INSERT INTO random_history (player1, player2, player1_choice, player2_choice) 
						VALUES ('".$row['p1'] ."','".$row['p2']."','coop','defect')";
						$result = mysqli_query($dbc, $query);
						
						//reduce game round limit
						$round_query = "SELECT round_limit FROM random_game WHERE id =". $row['id'];
						$round_result = mysqli_query($dbc, $round_query);		
						$round_row = $round_result->fetch_assoc();  //get the contents of the row.	
						$reduced_limit = intval($round_row['round_limit'])-1;
						$query = "UPDATE random_game SET round_limit = ".$reduced_limit." WHERE id =". $row['id'];
						$result = mysqli_query($dbc, $query);						
					}
					elseif ($_GET["decision"] == 1 && $row['p1_choice'] == 1)
					{
						$query = "UPDATE random_game SET p2_score = 1 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE random_game SET p1_score = 1 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE random_game SET p1_choice = null, p2_choice = null where id =". $row['id'];
						$result = mysqli_query($dbc, $query);	

						//update total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+1;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);	

						//update opponent total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+1;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);							
						
						$query = "INSERT INTO random_history (player1, player2, player1_choice, player2_choice) 
						VALUES ('".$row['p1'] ."','".$row['p2']."','defect','defect')";
						$result = mysqli_query($dbc, $query);
						
						//reduce game round limit
						$round_query = "SELECT round_limit FROM random_game WHERE id =". $row['id'];
						$round_result = mysqli_query($dbc, $round_query);		
						$round_row = $round_result->fetch_assoc();  //get the contents of the row.	
						$reduced_limit = intval($round_row['round_limit'])-1;
						$query = "UPDATE random_game SET round_limit = ".$reduced_limit." WHERE id =". $row['id'];
						$result = mysqli_query($dbc, $query);						
					}
					else{echo "There's been an error with player_choice";}
				}else{
					$query = "UPDATE random_game SET p2_choice =". $_GET['decision'] ." where id =". $row['id'];
					$result = mysqli_query($dbc, $query);		
				}
		}
		else
		{
			//get the right row in random_game
			$query = "SELECT *";
			$query .= " FROM random_game";
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
						$query = "UPDATE random_game SET p1_score = 3 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE random_game SET p2_score = 3 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE random_game SET p1_choice = null, p2_choice = null where id =". $row['id'];
						$result = mysqli_query($dbc, $query);						
						
						//update total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+3;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);	

						//update opponent total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+3;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);							
						
						$query = "INSERT INTO random_history (player1, player2, player1_choice, player2_choice) 
						VALUES ('".$row['p1'] ."','".$row['p2']."','coop','coop')";
						$result = mysqli_query($dbc, $query);
						
						//reduce game round limit
						$round_query = "SELECT round_limit FROM random_game WHERE id =". $row['id'];
						$round_result = mysqli_query($dbc, $round_query);		
						$round_row = $round_result->fetch_assoc();  //get the contents of the row.	
						$reduced_limit = intval($round_row['round_limit'])-1;
						$query = "UPDATE random_game SET round_limit = ".$reduced_limit." WHERE id =". $row['id'];
						$result = mysqli_query($dbc, $query);						
					}
					elseif ($_GET["decision"] == 0 && $row['p2_choice'] == 1)
					{
						$query = "UPDATE random_game SET p1_score = 0 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE random_game SET p2_score = 5 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE random_game SET p1_choice = null, p2_choice = null where id =". $row['id'];
						$result = mysqli_query($dbc, $query);						
						
						//update opponent total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+5;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);							
						
						$query = "INSERT INTO random_history (player1, player2, player1_choice, player2_choice) 
						VALUES ('".$row['p1'] ."','".$row['p2']."','coop','defect')";
						$result = mysqli_query($dbc, $query);
						
						//reduce game round limit
						$round_query = "SELECT round_limit FROM random_game WHERE id =". $row['id'];
						$round_result = mysqli_query($dbc, $round_query);		
						$round_row = $round_result->fetch_assoc();  //get the contents of the row.	
						$reduced_limit = intval($round_row['round_limit'])-1;
						$query = "UPDATE random_game SET round_limit = ".$reduced_limit." WHERE id =". $row['id'];
						$result = mysqli_query($dbc, $query);						
					}
					elseif ($_GET["decision"] == 1 && $row['p2_choice'] == 0)
					{
						$query = "UPDATE random_game SET p1_score = 5 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE random_game SET p2_score = 0 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE random_game SET p1_choice = null, p2_choice = null where id =". $row['id'];
						$result = mysqli_query($dbc, $query);	

						//update total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+5;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);							
						
						$query = "INSERT INTO random_history (player1, player2, player1_choice, player2_choice) 
						VALUES ('".$row['p1'] ."','".$row['p2']."','defect','coop')";
						$result = mysqli_query($dbc, $query);
						
						//reduce game round limit
						$round_query = "SELECT round_limit FROM random_game WHERE id =". $row['id'];
						$round_result = mysqli_query($dbc, $round_query);		
						$round_row = $round_result->fetch_assoc();  //get the contents of the row.	
						$reduced_limit = intval($round_row['round_limit'])-1;
						$query = "UPDATE random_game SET round_limit = ".$reduced_limit." WHERE id =". $row['id'];
						$result = mysqli_query($dbc, $query);					
					}
					elseif ($_GET["decision"] == 1 && $row['p2_choice'] == 1)
					{
						$query = "UPDATE random_game SET p1_score = 1 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE random_game SET p2_score = 1 where id =". $row['id'];
						$result = mysqli_query($dbc, $query);
						$query = "UPDATE random_game SET p1_choice = null, p2_choice = null where id =". $row['id'];
						$result = mysqli_query($dbc, $query);						
						
						//update total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+1;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$_SESSION['login_id'];
						$result = mysqli_query($dbc, $query);		

						//update opponent total score 
						$query = "SELECT totalscore FROM totals WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);
						$ts = $result->fetch_assoc();  //get the contents of the row.
						$score = intval($ts['totalscore'])+1;
						$query = "UPDATE totals SET totalscore = ". $score ." WHERE users_id = ".$oppon_id;
						$result = mysqli_query($dbc, $query);							
						
						$query = "INSERT INTO random_history (player1, player2, player1_choice, player2_choice) 
						VALUES ('".$row['p1'] ."','".$row['p2']."','defect','defect')";
						$result = mysqli_query($dbc, $query);
						
						//reduce game round limit
						$round_query = "SELECT round_limit FROM random_game WHERE id =". $row['id'];
						$round_result = mysqli_query($dbc, $round_query);		
						$round_row = $round_result->fetch_assoc();  //get the contents of the row.	
						$reduced_limit = intval($round_row['round_limit'])-1;
						$query = "UPDATE random_game SET round_limit = ".$reduced_limit." WHERE id =". $row['id'];
						$result = mysqli_query($dbc, $query);					
					}
					else{echo "There's been an error with player_choice";}
				}else{
					$query = "UPDATE random_game SET p1_choice =". $_GET['decision'] ." where id =". $row['id'];
					$result = mysqli_query($dbc, $query);				
				}
			}
			else
			{
				echo "We have an error reading user decision";
			}
		}		
	}
	mysqli_query($dbc, "COMMIT");
	//3. ALWAYS CLOSE A DATABASE AFTER USING IT.
	mysqli_close($dbc); //dbc is for connection.php
?>