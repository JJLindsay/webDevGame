<?php
/*PURPOSE:
	This file retrieves all user information once its proven they 
	have successfully logged in.
*/

error_reporting(-1);
session_start(); // Starting Session 
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$mysqli = new mysqli("localhost","root","", "zillionsparks_db");
// Storing Session
$user_check=$_SESSION['login_user'];  

$result = $mysqli->query("SELECT * from users where usernames='$user_check'");
$row = $result->fetch_assoc();
$login_id=$row['id'];
$login_session =$row['first_name'];
$login_lname=$row['last_name'];
$login_uname=$row['usernames'];
$login_session_email=$row['email'];
$course=$row['course'];
$section=$row['section'];

$_SESSION['login_id'] = $login_id;

$result2 = $mysqli->query("SELECT user_group from teamcode where users_id='$login_id'");
$row2 = $result2->fetch_assoc();
$login_teamcolor = $row2['user_group'];
if(!isset($login_session))
{
	mysqli_close($mysqli);
	//header('Location: index.php'); // Redirecting To Home Page
}
?>