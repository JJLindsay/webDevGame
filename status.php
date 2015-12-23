<?php 
include('session.php');

	function is_session_started()
	{
		if ( php_sapi_name() !== 'cli' ) {
			if ( version_compare(phpversion(), '5.4.0', '>=') ) {
				return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
			} else {
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		return FALSE;
	}

	// checks if the session has started which means user has logged in (signed in, using his id-password)
	if ( is_session_started() === TRUE ) 
	{
			if(!session_destroy()) 
			{
				
				echo "You're online!!";
				session_start(); NOT NEEDED SO COMMENTED OUT
				Follwing query updates the column online_status = 1 if the user has logged in*/
				$update_status_query = mysql_query("UPDATE users SET online_status='1' WHERE usernames='$user_check'", $connection);
			
				$ses_sql=mysql_query("SELECT * from users where usernames='$user_check'", $connection);
				$row = mysql_fetch_assoc($ses_sql);
			
				//Checks if user is online or not (for online users, the online_status = 1)		
				if ($row['online_status'] == 1) 
				{
					echo "Your Online status has been updated!!";
				}
			}			
			else 
			{
				echo "Your online status has not been updated. Check your database, refresh your table, or check your code again";
			}			
	}
	else 
	{
		echo "You're still offline!";
	}

	mysqli_query($dbc, "COMMIT");
	//3. ALWAYS CLOSE A DATABASE AFTER USING IT.
	mysqli_close($dbc); //dbc is for connection.php
?>