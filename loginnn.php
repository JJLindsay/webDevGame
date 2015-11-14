<?php
/*PURPOSE:
	This file handles the initial login and stores the users
	If the user doesn't exist in the db an error is sent to the user
*/
error_reporting(-1);
//session_start(); // Starting Session //BETTER TO START SESSION AT THE START OF EVERY PAGE
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
	if (empty($_POST['username']) || empty($_POST['password'])) {
		$error = "Username and Password are required fields*";
	}
	else
	{
		// Define $username and $password
		$username=$_POST['username'];
		$password=$_POST['password'];
		// Establishing Connection with Server by passing server_name, user_id and password as a parameter
		//$connection = mysql_connect("localhost", "root", "");  //already have dbc
		// To protect MySQL injection for Security purpose
		$username = stripslashes($username);
		$password = stripslashes($password);
		$username = mysqli_real_escape_string($dbc, $username);
		$password = mysqli_real_escape_string($dbc, $password);
		// Selecting Database
		//$db = mysql_select_db("zillionsparks_db", $connection);  //CONNECTIN.PHP did this
		// SQL query to fetch information of registerd users and finds user match.
		//$query = mysql_query("select * from users where pw='$password' AND usernames='$username'", $connection);
		$result=mysqli_query($dbc, "select first_name from users where pw='$password' AND usernames='$username'"); //THE REPLACEMENT FOR mysql_query
		$rows = mysqli_num_rows($result);
		if ($rows == 1) {
			$_SESSION['login_user']=$username; // Initializing Session
			
			//stores the name to see if its the admin
			$fnames = $result->fetch_assoc(); 
			$fname = array_values($fnames);  //splits the fetch row contents into an array			
			$adminname = htmlspecialchars($fname[0]);
			$_SESSION['admin_name'] = $adminname;
				//header("location: profile.php"); // Redirecting To Other Page
		} else {
			$error = "Username or Password is invalid";
		}
		//mysql_close($connection); // Closing Connection  //closed in index so not needed
	}
}

?>