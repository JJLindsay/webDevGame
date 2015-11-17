<?php
include('connection.php');
error_reporting(-1);

$query = "SELECT *";
$query .= " FROM game_mode";

$game_mode_result = mysqli_query($db, $query);
$getMode = $game_mode_result->fetch_assoc();  //get the contents of the row.

$play_random = $getMode['play_random'];
?>