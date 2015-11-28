<?php
	$mysqli = new mysqli("localhost","root","", "zillionsparks_db");

	function highscore($users_id) 
	{
		$result = $GLOBALS['mysqli']->query("SELECT totalscore FROM totals WHERE users_id=$users_id");

		if ($result) 
		{
			$row = $result->fetch_assoc();
			return $row['totalscore'];
		}
		else
		{
			die("Database query failed.");
		}
	}
?>