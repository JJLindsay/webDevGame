<?php
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection = mysql_connect("localhost", "root", "");
// Selecting Database
$db = mysql_select_db("zillionsparks_db", $connection);
session_start();// Starting Session
// Storing Session
$user_check=$_SESSION['login_user'];
// SQL Query To Fetch Complete Information Of User
$ses_sql=mysql_query("SELECT * from users where usernames='$user_check'", $connection);
$row = mysql_fetch_assoc($ses_sql);
$login_id=$row['id'];
$login_session =$row['first_name'];
$login_lname=$row['last_name'];
$login_uname=$row['usernames'];
$login_session_email=$row['email'];

if(!isset($login_session)){
	mysql_close($connection); // Closing Connection
	//header('Location: index.php'); // Redirecting To Home Page
}
?>