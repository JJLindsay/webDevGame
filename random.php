<?php
include('connection.php');
error_reporting(-1);

mysqli_query($dbc, "TRUNCATE TABLE dilemmas"); //DELETES EVERY THING IN THE TABLE EXCEPT COLUMNSS

//assuming only 3 group colors
$arr = array(
    0 => "green",
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
	
	mysqli_query($dbc,"UPDATE teamcode SET random_group = '$arr[$rndNum]' WHERE users_id = $id");  //sets the total score to 0 on registration
	$rndNum = rand(0, 2); //values are inclusive
}


//The following code will empty dilemmas and repopulate it with random groups
//----------------------------------------------------------------------------
mysqli_query($dbc, "TRUNCATE TABLE dilemmas"); //DELETES EVERY THING IN THE TABLE EXCEPT COLUMNSS

$groups = mysqli_query($dbc, "SELECT DISTINCT random_group FROM teamcode");  //produces red, blue, green
$num_groups = mysqli_num_rows($groups);  //returns 3
$teamcode = $groups->fetch_assoc();  //gets the first one
/* 
loop through each group:
turns true/false. Success actually returns a mysqli_result object 
*/


//output the values of the fields in the rows
for ($row_num = 0; $row_num <  $num_groups; $row_num++)
{
	$values = array_values($teamcode);  //splits the fetch row contents into an array
	
	$value = htmlspecialchars($values[0]);
	//i have this select stmt result
	//fetch assoc
	//get fields using array values method
	//print
	//fetch the next select stmt result

	$group_players = mysqli_query($dbc, "SELECT tag FROM teamcode WHERE random_group LIKE '$value'");  //returns all the players for this team
	$group_players2 = mysqli_query($dbc, "SELECT tag FROM teamcode WHERE random_group LIKE '$value'");  //returns all the players for this team
	$num_group_players = mysqli_num_rows($group_players);
	$p1_index = 0;
	$p1 = $group_players->fetch_assoc();  //fetch row.
	$p2 = $group_players2->fetch_assoc();
	$p2_index = 0;
	
	$p1_values = array_values($p1);  //splits the row contents into an array
	$array_val1 = htmlspecialchars($p1_values[0]);
	$arr = array($array_val1);
	$allset = false;
	while ($p1_index < $num_group_players-1)
	{		
		$p2 = $group_players2->fetch_assoc();  //fetch row
		$p2_index++;
					
		$p1_values = array_values($p1);  //splits the row contents into an array
		$p1 = htmlspecialchars($p1_values[0]);

		while ($p2_index < $num_group_players)
		{
			if ($allset)
				$p2 = array(0 => $arr[$p2_index]);	
			
			$p2_values = array_values($p2);  //splits the row contents into an array
			$p2 = htmlspecialchars($p2_values[0]);
			echo "('$p1','$p2')<br/>";
			mysqli_query($dbc, "INSERT INTO dilemmas (p1, P2) VALUES ('$p1','$p2')");
			mysqli_query($dbc, "COMMIT");
			
			if (!$allset)
				$arr[] = $p2;
			
			
			$p2 = $group_players2->fetch_assoc();  //fetch next row
			$p2_index++;
		}
		$allset = true;
		$p1_index++;
		$p2_index = $p1_index;
		$group_players2=$group_players;

		$p1 = array(0 => $arr[$p1_index]); //$group_players->fetch_assoc();  //fetch next row			
	}
	unset($arr);
	$teamcode = $groups->fetch_assoc();  //get the contents of the next row.
}
?>