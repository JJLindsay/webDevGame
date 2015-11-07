<?php
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
//$connection = mysql_connect("localhost", "root", "");
// Selecting Database
//$db = mysql_select_db("zillionsparks_db", $connection);
$mysqli = new mysqli("localhost","root","", "zillionsparks_db");
session_start();// Starting Session
// Storing Session
$user_check=$_SESSION['login_user'];  //what is this trying to do???

// SQL Query To Fetch Complete Information Of User
//$ses_sql=mysql_query("SELECT * from users where usernames='$user_check'", $connection);
$result = $mysqli->query("SELECT * from users where usernames='$user_check'");
$row = $result->fetch_assoc();
$login_id=$row['id'];
//$login_status=$row['online_status'];  //this should be one by default and UPDATE query to set online to 1 is needed...possible problems tho
$login_session =$row['first_name'];
$login_lname=$row['last_name'];
$login_uname=$row['usernames'];
$login_session_email=$row['email'];
$course=$row['course'];
$section=$row['section'];

$_SESSION['login_id'] = $login_id;

if(!isset($login_session)){
	//mysql_close($connection); // Closing Connection
	mysqli_close($mysqli);
	//header('Location: index.php'); // Redirecting To Home Page
}
?>