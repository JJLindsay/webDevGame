<?php
include('connection.php');
error_reporting(-1);

mysqli_query($dbc, "TRUNCATE TABLE dilemmas"); //DELETES EVERY THING IN THE TABLE EXCEPT COLUMNSS
//there must be another column that sets random

//assuming only 3 group colors
$arr = array(
    0 => "yellow",
	1 => "red",
    2 => "blue",
);
$rndNum = rand(0, 2); //values are inclusive

$num_users = mysqli_query($dbc, "SELECT COUNT(tag) FROM teamcode"); 
	$row = $num_users->fetch_assoc();  //fetch row.
	$content_columns = array_values($row);  //splits the row contents into an array
	$tag_count = htmlspecialchars($content_columns[0]);

$users_ids = mysqli_query($dbc, "SELECT users_id FROM teamcode"); 

$p1_index = 0;

//set the users' random group
for ($count = 1; $count <= $tag_count; $count++)
{
	$user_id = $users_ids->fetch_assoc();  //fetch row.	
	$content_cols = array_values($user_id);  //splits the row contents into an array
	$id = htmlspecialchars($content_cols[0]);
	
	mysqli_query($dbc,"INSERT INTO teamcode(random_group) VALUES ('$arr[$rndNum]') WHERE user_id = '$id'");  //sets the total score to 0 on registration
	$rndNum = rand(0, 2); //values are inclusive
}
?>