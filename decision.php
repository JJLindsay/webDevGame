<?php
    require_once('connection.php');
    require_once('session.php');
    $id = $_POST['id'];
    $de = $_POST['de'];
    $sql = "SELECT * FROM games WHERE id='$id'";
    $query = $dbc->query($sql);
    $fetch = $query->fetch_assoc();
    $p1 = $fetch['player1'];
    $actual = $fetch['status'] + 1;
    $round = $fetch['round'.$actual];
    $de = ($p1 == $login_id) ? substr_replace($round,$de,0,1) : substr_replace($round,$de,2,1);
    $time = time()+120;
    $sql = "UPDATE games SET round$actual='$de',time='$time' WHERE id='$id'";
    $dbc->query($sql);
	
	mysqli_query($dbc, "COMMIT");
	//3. ALWAYS CLOSE A DATABASE AFTER USING IT.
	mysqli_close($dbc); //dbc is for connection.php
?>