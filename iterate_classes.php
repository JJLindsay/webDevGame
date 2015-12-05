<?php
	error_reporting(-1);
	include('connection.php');

	mysqli_query($dbc, "TRUNCATE TABLE iterative_teams"); //DELETES EVERY THING IN THE TABLE EXCEPT COLUMNS
	
	$query1 = 'SELECT *';
	$query1 .= ' FROM teamcode';
	$result1 = mysqli_query($dbc, $query1);
	$num_rows1 = mysqli_num_rows($result1);
	
	$row1 = mysqli_fetch_assoc($result1);  //give me this row
	$first_user = $row1['tag'];
	
	$query2 = 'SELECT *';
	$query2 .= ' FROM teamcode';
	$result2 = mysqli_query($dbc, $query2);
	//$num_rows2 = mysqli_num_rows($result2);
	
	//$row2 = mysqli_fetch_assoc($result2);  //give me this row
	//$second_user = $row2['tag'];
	
	$index = 1;
	$inner_index = 1;
	mysqli_query($dbc, "INSERT INTO iterative_teams(id,member1) VALUES ($index, '$first_user')");
	//mysqli_query($dbc, "COMMIT");
	
	while ($index <= $num_rows1)
	{
		echo "$inner_index ::";
		echo "$index !!";
		$row2 = mysqli_fetch_assoc($result2);  //give me this row
		$second_user = $row2['tag'];
	
		if ($first_user == $second_user)
		{
			//echo "YES equal<br/>";
			$row2 = mysqli_fetch_assoc($result2);  //give me this row or NULL
			$second_user = $row2['tag'];
			
			//echo "$first_user";
			
			$query3 = "SELECT *";
			$query3 .= " FROM iterative_teams";
			$query3 .= " WHERE member1 = '$first_user'";
			$result3 = mysqli_query($dbc, $query3);  //returns object or FALSE on failure
			
			
			//$num_rows3 = mysqli_num_rows($result3);
			
			if ($row2 != NULL && $result3 != false)
			{
				//echo "Searching for: $second_user";
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
					//echo "$second_user inside Y!";
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
				
				
				//$values = array_values($row);
				//$second_user = $values['tag'];
				//$member2 = $second_user;
			}
			/*$values = array_values($row);
			$second_user = $values['tag'];
			$member3 = $second_user;
			
			$values = array_values($row);
			$second_user = $values['tag'];
			$member4 = $second_user;
			
			$query .= 'INSERT INTO iterative_teams(id, member1, member2, member3, member4)';
			$query .= ' VALUES($id, $first_user,$member2, $member3, $member4)';
			*/
		}
		else
		{
			//echo "Searching for2: $second_user <br/>";
			$query3 = "SELECT *";
			$query3 .= " FROM iterative_teams";
			$query3 .= " WHERE member1 = '$second_user'";
			$result3 = mysqli_query($dbc, $query3); //returns object or FALSE on failure
			
			$row3 = mysqli_fetch_assoc($result3);  //give me this row or NULL
			
			if ($result3 != False && ($row3['member2'] == NULL || $row3['member3'] == NULL || $row3['member4'] == NULL)) //there is an open slot on this team
			{
				//echo "Searching for2.5: $second_user <br/>";
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
				}			
			}
			else //there is no open slot on second user but first user may be on second user's team.
			{
				echo "Searching for3: $second_user <br/>";
				//$row3 = mysqli_fetch_assoc($result3);  //give me this row or NULL
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
			
			/*
			$row3 = mysqli_fetch_assoc($result3);  //give me this row
			
			
			
			if ($row3['member2']==$first_user)
			{
				$column = "member2";
			}
			elseif($row3['member3']==$first_user)
			{
				$column = "member3";
			}
			elseif ($row3['member4']==$first_user)
			{
				$column = "member4";
			}
			
								$query3 = "UPDATE iterative_teams";
						$query3 = " SET $column = '$second_user'";
						$query3 = " WHERE member1 = '$first_user'";
						$result3 = mysqli_query($dbc, $query3);
			*/		
		}
		
				
		$inner_index++;
		
		if ($inner_index > $num_rows1)
		{
			$inner_index = 1;
			$index++;
			
			$row1 = mysqli_fetch_assoc($result1);  //give me this row for first user
			$first_user = $row1['tag'];
			
			$query2 = 'SELECT *';
			$query2 .= ' FROM teamcode';
			$result2 = mysqli_query($dbc, $query2);	

			if ($index <= $num_rows1)
			mysqli_query($dbc, "INSERT INTO iterative_teams(id,member1) VALUES ($index, '$first_user')");			
		}
	}
	
		include('insert_iterate_game_table.php');
	
?>