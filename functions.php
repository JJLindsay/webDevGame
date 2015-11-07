<?php
	// Establishing Connection with Server by passing server_name, user_id and password as a parameter
	//$connection = mysqli_connect("localhost", "root", "");
	// Selecting Database
	//$db = mysql_select_db("zillionsparks_db", $connection);
	$mysqli = new mysqli("localhost","root","", "zillionsparks_db");

	function highscore($users_id) 
	{
		//$query=mysql_query("SELECT totalscore FROM totals WHERE users_id=$users_id", $GLOBALS['connection']);
		$result = $GLOBALS['mysqli']->query("SELECT totalscore FROM totals WHERE users_id=$users_id");
		//if ($query) 
		if ($result) 
		{
			//success
			//$row = mysql_fetch_assoc($query);
			$row = $result->fetch_assoc();
			return $row['totalscore'];
		}
		else
		{
			//failure
			die("Database query failed.");
		}
	}
	
	
		//$doc = new DomDocument;
		// We need to validate our document before referring to the id
		//$doc->validateOnParse = true;
		//$doc->Load('playgame.php');
		
		//$doc = new DOMDocument("1.0", "utf-8");
		//$doc->loadFile('playgame.php');
			//$doc = new DomDocument;
		// We need to validate our document before referring to the id
		//$doc->validateOnParse = true;
		//$doc->Load("playgame.php");
	/*echo "$doc->ready(function()
	{
		function recent_game_score()
		{
			echo 'score';
		}
		$('#dilemmas').click(recent_game_score);
	});";
	
	
//used with the buttons to change the previous game score div
	function recent_game_score($btnId)
	{
		//$GLOBALS['connection'];
		echo "score10";
		$doc = new DomDocument;
		// We need to validate our document before referring to the id
		$doc->validateOnParse = true;
		$doc->Load('playgame.php');
				
		
		$query = "SELECT *";
		$query .= "FROM dilemmas";
		$query .= "WHERE p1 LIKE (SELECT tag";
		$query .= "FROM teamcode";
		$query .= "WHERE user_id=".$_SESSION['login_id'].")";
		
		$result=mysql_query($query, $GLOBALS['connection']);
		
		//get the number of rows within the result (or database) 
		$num_rows = mysql_num_rows($result);
		echo $result;
		if ($result) 
		{
			echo "score";
			//success
			$row = mysql_fetch_assoc($query);
			
			//loop through
			for ($row_num = 0; $row_num <  $num_rows; $row_num++)
			{
				if ($row['p2'] == $btnId)
				{
					echo $doc->getElementById('previousScore')->innerHTML="99";
				}
			}
		}
		
		$query = "SELECT *";
		$query .= "FROM dilemmas";
		$query .= "WHERE p2 LIKE (SELECT tag";
		$query .= "FROM teamcode";
		$query .= "WHERE user_id=".$_SESSION['login_id'].")";
		
		$result=mysql_query($query, $GLOBALS['connection']);
		
		if ($result) 
		{
			//success
			$row = mysql_fetch_assoc($query);
			$btnId = "B1"; //test only 
			//loop through
			if ($row['p1'] == $btnId)
			{			
				echo "The element whose id is 'php-basics' is: " . $doc->getElementById('previousScore')->innerHTML="99";
				
				
				return;
			}
		}
		
		else
		{
			//failure
			die("Database query failed.");
		}
		
		//$_SESSION['login_id'];
	}*/
	
	//works for html
	/*$dom = new DOMDocument("1.0", "utf-8");
    $dom->loadHTMLFile('YourFile.html');
    $div = $dom->getElementById('divID');

    echo $div->textContent;

    $div->setAttribute("name", "yesItWorks");*/
?>