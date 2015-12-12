<?php
    require_once('connection.php');
    require_once('session.php');
    $busy = $_POST['busy'];
    $sql = "UPDATE users SET busy=$busy WHERE id='$login_id'";
    $dbc->query($sql); 
	
	mysqli_query($dbc, "COMMIT");
	//3. ALWAYS CLOSE A DATABASE AFTER USING IT.
	mysqli_close($dbc); //dbc is for connection.php	
?>