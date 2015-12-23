<?php
	//session_start();
	include('session.php');
	if(session_destroy()) // Destroying All Sessions
	{
		$update_status_query = mysql_query("UPDATE users SET online_status='0' WHERE usernames='$user_check'", $dbc); //changed from connection

		// TAKES YOU TO INDEX.PHP if the session is destroyed
		header("Location: index.php"); // Redirecting To Home Page
		
		mysqli_query($dbc, "COMMIT");
		//3. ALWAYS CLOSE A DATABASE AFTER USING IT.
		mysqli_close($dbc); //dbc is for connection.php	
	}
?>