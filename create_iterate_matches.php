<?php
	include('connection.php');
	error_reporting(-1);

	mysqli_query($dbc, "TRUNCATE TABLE iterative_game"); //DELETES EVERY THING IN THE TABLE EXCEPT COLUMNSS

	$groups = mysqli_query($dbc, "SELECT  * FROM iterative_teams ");  //produces red, blue, yellow
	$num_groups = mysqli_num_rows($groups);  //how many rows in the table
	$row1 = mysqli_fetch_assoc($groups);  //give me this row

	$insert_id = 1;
	
	//output the values of the fields in the rows
	for ($row_num = 0; $row_num <  $num_groups; $row_num++)
	{
		$member1 = $row1['member1'];
		$member2 = $row1['member2'];
		$member3 = $row1['member3'];
		$member4 = $row1['member4'];

		$num_group_players = 4;
		
		if($member1 != null && $member2 != null)
		{
			$result = mysqli_query($dbc, "SELECT * FROM iterative_game WHERE player1 LIKE '$member1' AND player2 LIKE '$member2' OR (player1 LIKE '$member2' AND player2 LIKE '$member1')");
			
			if ($result == false)
			{
				mysqli_query($dbc, "INSERT INTO iterative_game (id, p1, P2) VALUES ($insert_id, '$member1','$member2')");
				mysqli_query($dbc, "COMMIT");
				$insert_id++;
			}							
		}
		if($member1 != null && $member3!= null)
		{
			$result = mysqli_query($dbc, "SELECT * FROM iterative_game WHERE player1 LIKE '$member1' AND member3 LIKE '$member2' OR (player1 LIKE '$member3' AND player2 LIKE '$member1')");
			
			if ($result == false)
			{
				mysqli_query($dbc, "INSERT INTO iterative_game (id, p1, P2) VALUES ($insert_id, '$member1','$member3')");
				mysqli_query($dbc, "COMMIT");
				$insert_id++;
			}				
		}
		if($member1 != null && $member4 != null)
		{
			$result = mysqli_query($dbc, "SELECT * FROM iterative_game WHERE player1 LIKE '$member1' AND player2 LIKE '$member4' OR (player1 LIKE '$member4' AND player2 LIKE '$member1')");
			
			if ($result == false)
			{
				mysqli_query($dbc, "INSERT INTO iterative_game (id, p1, P2) VALUES ($insert_id, '$member1','$member4')");
				mysqli_query($dbc, "COMMIT");
				$insert_id++;
			}				
		}	
		
		$row1 = mysqli_fetch_assoc($groups);  //give me this row
	}
	
	//3. ALWAYS CLOSE A DATABASE AFTER USING IT.
	mysqli_close($dbc); //dbc is for connection.php
?>