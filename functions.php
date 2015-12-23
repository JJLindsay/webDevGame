<?php
	function highscore($users_id) 
	{
		include('connection.php');
		$result = mysqli_query($dbc, "SELECT totalscore FROM totals WHERE users_id=$users_id");
		$num_rows = mysqli_num_rows($result);
		
		if ($num_rows > 0)
		{
			$row = $result->fetch_assoc();
			return $row['totalscore'];
		}
		else
		{
			die("Database query failed.");
		}
		mysqli_query($dbc, "COMMIT");
	}
?>