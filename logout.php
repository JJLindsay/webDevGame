<?php
//session_start();
include('session.php');
if(session_destroy()) // Destroying All Sessions
{
			//echo "You've gone offline now!";
			$update_status_query = mysql_query("UPDATE users SET online_status='0' WHERE usernames='$user_check'", $connection);
			/*$ses_sql=mysql_query("SELECT * from users where usernames='$user_check'", $connection);
			$row = mysql_fetch_assoc($ses_sql);
		
		//Checks if user is online or not (for online users, the online_status = 1)		
			if ($row['online_status'] == 0) 
			{
				echo "Your Offline status has been updated!!";
			}
				else 
			{
				echo "Your offline status has not been updated. Check your database, refresh your table, or check your code again";
			}*/

	
		
	// TAKES YOU TO INDEX.PHP if the session is destroyed
	header("Location: index.php"); // Redirecting To Home Page
}
?>