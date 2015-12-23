<?php
	include('connection.php');
	error_reporting(-1);

	$query = "SELECT *";
	$query .= " FROM game_mode";

	$game_mode_result = mysqli_query($dbc, $query);
	$getMode = $game_mode_result->fetch_assoc();  //get the contents of the row.

	$play_random = $getMode['play_random'];

	mysqli_query($dbc, "COMMIT");
	//3. ALWAYS CLOSE A DATABASE AFTER USING IT.
	mysqli_close($dbc); //dbc is for connection.php
?>