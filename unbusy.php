<?php
    require_once('connection.php');
    require_once('session.php');
    $busy = $_POST['busy'];
    $sql = "UPDATE users SET busy=$busy WHERE id='$login_id'";
    $dbc->query($sql); 
?>