<?php
include('connection.php');
error_reporting(-1);

	mysqli_query($dbc, "TRUNCATE TABLE iterative_game"); //DELETES EVERY THING IN THE TABLE EXCEPT COLUMNSS

	$teams = mysqli_query($dbc, "SELECT * FROM iterative_teams");

	while ($row = mysqli_fetch_array($teams))
	{
		
		if ($row['member2'] != null)
		{
			$exist_test = mysqli_query($dbc, "SELECT * FROM iterative_game WHERE p1 LIKE '".$row['member2']."' AND p2 LIKE '".$row['member1']."'");
			$num_rows = mysqli_num_rows($exist_test);
			if ($num_rows < 1)	
				mysqli_query($dbc, "INSERT INTO iterative_game (p1, P2) VALUES ('".$row['member1']."','".$row['member2']."')");
		}
		if ($row['member3'] != null)
		{			
			$exist_test = mysqli_query($dbc, "SELECT * FROM iterative_game WHERE p1 LIKE '".$row['member3']."' AND p2 LIKE '".$row['member1']."'");
			$num_rows = mysqli_num_rows($exist_test);
			if ($num_rows < 1)				
				mysqli_query($dbc, "INSERT INTO iterative_game (p1, P2) VALUES ('".$row['member1']."','".$row['member3']."')");
		}
		if ($row['member4'] != null)
		{			
			$exist_test = mysqli_query($dbc, "SELECT * FROM iterative_game WHERE p1 LIKE '".$row['member4']."' AND p2 LIKE '".$row['member1']."'");
			$num_rows = mysqli_num_rows($exist_test);
			if ($num_rows < 1)				
				mysqli_query($dbc, "INSERT INTO iterative_game (p1, P2) VALUES ('".$row['member1']."','".$row['member4']."')");
		}		
	}
	
	mysqli_query($dbc, "COMMIT");
?>