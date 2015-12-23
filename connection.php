<?php
//define variables
error_reporting(-1);
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "zillionsparks_db";

//making the connection to mysql
$dbc = mysqli_connect($hostname, $username, $password, $dbname) OR die("could not connect to database, ERROR: ".mysqli_connect_error());
?>
