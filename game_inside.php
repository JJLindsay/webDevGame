<?php
    include('connection.php');
    include('session.php');
    $avg = (($gplayed!=0) AND ($score!=0)) ? $score/$gplayed : 0;
    $avg = round($avg,2);
    function switch_de($num){
        switch ($num){
            case 0:
                $ad = "Nothing";
                break;
            case 1:
                $ad = "Cooperate";
                break;
            case 2:
                $ad = "Defect";
                break;
        }
        return $ad;
    }
    function switch_class($num){
        switch ($num){
            case 0:
                $ad = "warning";
                break;
            case 1:
                $ad = "success";
                break;
            case 2:
                $ad = "danger";
                break;
        }
        return $ad;
    }
    function sum_score($num){
        $cs = 0;
        $os = 0;
        $nums = explode(';', $num);
        foreach ($nums as $n){
            switch ($n){
                case 11:
                    $cs += 3;
                    $os += 3;
                    break;
                case 22:
                    $cs += 1;
                    $os += 1;
                    break;
                case 12:
                    $cs += 1;
                    $os += 5;
                    break;
                case 21:
                    $cs += 5;
                    $os += 1;
                    break;
                case 01:
                case 02:
                    $cs -= 10;
                    $os += 10;
                    break;
                case 10:
                case 20:
                    $cs += 10;
                    $os -= 10;
                    break;
            }
        }
        return $cs.";".$os.";".$num;
    }
    function show_game($id){
    	include('connection.php');
    	include('session.php');
    	$sql = "SELECT * FROM games WHERE id='$id'";
    	$query = $dbc->query($sql);
    	$fetch = $query->fetch_assoc();
    	$id = $fetch['id'];
    	$p1 = $fetch['player1'];
    	$p2 = $fetch['player2'];
        $status = $fetch['status'];
        $actual = $status+1;
        $actual = ($actual > 5) ? 5 : $actual;
        $ra = $fetch['round'.$actual];
    	$ti = $fetch['time'];
    	$cp = ($p1 == $login_id) ? $p1 : $p2;
    	$op = ($p1 != $login_id) ? $p1 : $p2;
		if($actual > 1){
            $check = $actual-1;
            $sql = "SELECT round$check FROM games WHERE id='$id'";
            $query = $dbc->query($sql);
            $fetch = $query->fetch_assoc();
            if($fetch['round'.$check]=="0-0"){
                $sql = "UPDATE games SET status=status-1 WHERE id='$id'";
                $dbc->query($sql);
            }
        }
        $cpd = ($p1 == $login_id) ? substr($ra,0,1) : substr($ra,2,1);
        $opd = ($p1 != $login_id) ? substr($ra,0,1) : substr($ra,2,1);
        if(($ra == "0-0") AND ($cpd) AND ($opd)){
            $sql = "UPDATE games SET status=status-1 WHERE id='$id'";
            $dbc->query($sql);
        }
        switch ($cpd){
            case 0:
                $ad = "Nothing";
                break;
            case 1:
                $ad = "Cooperate";
                break;
            case 2:
                $ad = "Defect";
                break;
        }
		//get user color and tag
    	$query = "SELECT * FROM teamcode WHERE users_id='$cp'";
    	$result = $dbc->query($query);
    	$user = $result->fetch_assoc();
    	$tag = $user['tag'];
		$user_piece = explode("-", $tag);
		//get user color and tag
    	$query = "SELECT * FROM teamcode WHERE users_id='$op'";
    	$result = $dbc->query($query);
    	$opponent = $result->fetch_assoc();
    	$tag = $opponent['tag'];
		$opponent_piece = explode("-", $tag);

    	$t2 = time();
    	$tr = $ti-$t2;
    	if($tr <= 0){
    	    $sql = "UPDATE games SET status=6 WHERE id='$id'";
    	    $dbc->query($sql);
            if($cpd == 0){
                $sql = "UPDATE users SET score=score-10 WHERE id='$cp'";
                $query = $dbc->query($sql);
                $sql = "UPDATE users SET score=score+10 WHERE id='$op'";
                $query = $dbc->query($sql);
                $sql = "UPDATE users SET busy=1 WHERE id='$cp'";
                $dbc->query($sql);
            } 
            if($opd == 0){
                $sql = "UPDATE users SET score=score-10 WHERE id='$op'";
                $query = $dbc->query($sql);
                $sql = "UPDATE users SET score=score+10 WHERE id='$cp'";
                $query = $dbc->query($sql);
                $sql = "UPDATE users SET busy=1 WHERE id='$op'";
                $dbc->query($sql);
            }
            echo "<script>
                $('document').ready(function(){
                    ion.sound.play('door_bump');
                });
            </script>";
    	}
        elseif( ($opd!=0) AND ($cpd!=0) ){
            $sql = "SELECT status FROM games WHERE id='$id'";
            $query = $dbc->query($sql);
            $fetch = $query->fetch_assoc();
            $st = $fetch['status']+1;
            if($st != 5){
                $rr = $cpd.$opd;
                switch ($rr){
                    case 11:
                        $sql1= "UPDATE users SET score=score+3 WHERE id='$cp'";
                        $sql2= "UPDATE users SET score=score+3 WHERE id='$op'";
                        $sound = "glass";
                        break;
                    case 22:
                        $sql1= "UPDATE users SET score=score+1 WHERE id='$cp'";
                        $sql2= "UPDATE users SET score=score+1 WHERE id='$op'";
                        $sound = "light_bulb_breaking";
                        break;
                    case 12:
                        $sql1= "UPDATE users SET score=score+1 WHERE id='$cp'";
                        $sql2= "UPDATE users SET score=score+5 WHERE id='$op'";
                        $sound = "light_bulb_breaking";
                        break;
                    case 21:
                        $sql1= "UPDATE users SET score=score+5 WHERE id='$cp'";
                        $sql2= "UPDATE users SET score=score+1 WHERE id='$op'";
                        $sound = "bell_ring";
                        break;
                }
                echo "<script>
                    $('document').ready(function(){
                        ion.sound.play('$sound');
                    });
                </script>";
                $dbc->query($sql1);
                $dbc->query($sql2);
            }
            $sql = "UPDATE games SET status=status+1 WHERE id='$id'";
            $dbc->query($sql);
        } 
		else 
		{			
			$query=mysqli_query($dbc,"SELECT id FROM users WHERE course='$course' AND section=$section");	
			$result = mysqli_num_rows($query);
			$group= round($result / 3);	//10
			$doublegroup= $group + $group;	//20					
			$query1=mysqli_query($dbc,"SELECT rank FROM users WHERE id='$cp'");
			$fetchrankrow=$query1->fetch_assoc(); //fetch for $cp
			$resultrank=$fetchrankrow['rank']; // rank for $cp
			
			$query2=mysqli_query($dbc,"SELECT rank FROM users WHERE id='$op'");
			$fetchrankrow1=$query2->fetch_assoc(); //fetch for $op
			$resultrank1=$fetchrankrow1['rank']; // rank for $op
			
			// Assigned Group to current players
			if($resultrank <= $group) {
				$cpp = "<span style='color:white;background-color:".$user_piece[0].";border-radius: 5px;padding:0% 1%;'>"."PLAYER "."R-".$user_piece[1]."</span>";
			} else if (($resultrank > $group && $resultrank <= $doublegroup)) {
				$cpp = "<span style='color:white;background-color:".$user_piece[0].";border-radius: 5px;padding:0% 1%;'>"."PLAYER "."G-".$user_piece[1]."</span>";
			} else {
				$cpp = "<span style='color:white;background-color:".$user_piece[0].";border-radius: 5px;padding:0% 1%;'>"."PLAYER "."B-".$user_piece[1]."</span>";
			}
			// Assigned Group to Opponent
			if($resultrank1 <= $group) {
				$opp = "<span style='color:white;background-color:".$opponent_piece[0].";border-radius: 5px;padding:0% 1%;'>"."PLAYER "."R-".$opponent_piece[1]."</span>";
			} else if (($resultrank1 > $group && $resultrank1 <= $doublegroup)) {
				$opp = "<span style='color:white;background-color:".$opponent_piece[0].";border-radius: 5px;padding:0% 1%;'>"."PLAYER "."G-".$opponent_piece[1]."</span>";
			} else {
				$opp = "<span style='color:white;background-color:".$opponent_piece[0].";border-radius: 5px;padding:0% 1%;'>"."PLAYER "."B-".$opponent_piece[1]."</span>";
			}
				
				//Display Who's Versus Who when Both players are available to play
				echo "<h3 class='text-center'>".$cpp."<br>"."<div style='margin:5px'>"." VS "."</div>".$opp."<small>"."	<br>"."(Round ".$actual." )"."</small>"."</h3>";
		
		   
				if($cpd == 0){
					echo "<div class='buttons col-xs-12 col-md-8 col-md-offset-2'>
							<div class='btn-group btn-group-justified' role='group' aria-label='decision'>
								<a id='cooperate' class='btn_co btn btn-success'>Cooperate</a>
								<a id='defect' class='btn_de btn btn-warning'>Defect</a>
								<input type='hidden' id='game_id' value='$id'>
							</div>
					</div>";
				}
				echo "<div class='decision col-xs-12 col-md-8 col-md-offset-2'>
						<h4 class='text-center'>Your decision: $ad</h4>
				</div>";
				echo "<div class='timer col-xs-8 col-xs-offset-2 col-md-6 col-md-offset-4'>
					<span class='glyphicon glyphicon-time'></span> $tr
				</div>";
				echo "<script>
					$('document').ready(function(){
						ion.sound.play('door_bell');";
						?>
						setTimeout('ion.sound.destroy("door_bell")',3000);
						<?php
				echo "
					});
				</script>";
        }
        $sql = "SELECT * FROM games WHERE id='$id'";
        $query = $dbc->query($sql);
        $fetch = $query->fetch_assoc();
        /* ROUND 1 */
        $ra1 = $fetch['round1'];
        $cpd1 = ($p1 == $login_id) ? substr($ra1,0,1) : substr($ra1,2,1);
        $opd1 = ($p1 != $login_id) ? substr($ra1,0,1) : substr($ra1,2,1);
        /* ROUND 2 */
        $ra2 = $fetch['round2'];
        $cpd2 = ($p1 == $login_id) ? substr($ra2,0,1) : substr($ra2,2,1);
        $opd2 = ($p1 != $login_id) ? substr($ra2,0,1) : substr($ra2,2,1);
        /* ROUND 3 */
        $ra3 = $fetch['round3'];
        $cpd3 = ($p1 == $login_id) ? substr($ra3,0,1) : substr($ra3,2,1);
        $opd3 = ($p1 != $login_id) ? substr($ra3,0,1) : substr($ra3,2,1);
        /* ROUND 4 */
        $ra4 = $fetch['round4'];
        $cpd4 = ($p1 == $login_id) ? substr($ra4,0,1) : substr($ra4,2,1);
        $opd4 = ($p1 != $login_id) ? substr($ra4,0,1) : substr($ra4,2,1);
        /* ROUND 5 */
        $ra5 = $fetch['round5'];
        $cpd5 = ($p1 == $login_id) ? substr($ra5,0,1) : substr($ra5,2,1);
        $opd5 = ($p1 != $login_id) ? substr($ra5,0,1) : substr($ra5,2,1);
        
        echo "<table class='table table-striped'>
            <tr>
                <th>Round</th>
                <th>Your decision</th>
                <th>Partner decision</th>
            </tr>";
            if($status > 0){
                echo "<tr>
                    <td>One</td>
                    <td class='".switch_class($cpd1)."'>".switch_de($cpd1)."</td>
                    <td class='".switch_class($opd1)."'>".switch_de($opd1)."</td>
                </tr>";
            }
            if($status > 1){
                echo "<tr>
                    <td>Two</td>
                    <td class='".switch_class($cpd2)."'>".switch_de($cpd2)."</td>
                    <td class='".switch_class($opd2)."'>".switch_de($opd2)."</td>
                </tr>";
            }
            if($status > 2){
                echo "<tr>
                    <td>Three</td>
                    <td class='".switch_class($cpd3)."'>".switch_de($cpd3)."</td>
                    <td class='".switch_class($opd3)."'>".switch_de($opd3)."</td>
                </tr>";
            }
            if($status > 3){
                echo "<tr>
                    <td>Four</td>
                    <td class='".switch_class($cpd4)."'>".switch_de($cpd4)."</td>
                    <td class='".switch_class($opd4)."'>".switch_de($opd4)."</td>
                </tr>";
            }
            if($status > 4){
                echo "<tr>
                    <td>Five</td>
                    <td class='".switch_class($cpd5)."'>".switch_de($cpd5)."</td>
                    <td class='".switch_class($opd5)."'>".switch_de($opd5)."</td>
                </tr>";
            }
        echo "</table>";
        if($status == 5){
            $sql = "UPDATE games SET status=6 WHERE id='$id'";
            $dbc->query($sql);
        }
        $sql = "SELECT * FROM games WHERE id='$id'";
        $query = $dbc->query($sql);
        $fetch = $query->fetch_assoc();
        $p1 = $fetch['player1'];
        $op = ($p1 != $login_id) ? $p1 : $fetch['player2'];
        /* ROUND 1 */
        $ra1 = $fetch['round1'];
        $cpd1 = ($p1 == $login_id) ? substr($ra1,0,1) : substr($ra1,2,1);
        $opd1 = ($p1 != $login_id) ? substr($ra1,0,1) : substr($ra1,2,1);
        /* ROUND 2 */
        $ra2 = $fetch['round2'];
        $cpd2 = ($p1 == $login_id) ? substr($ra2,0,1) : substr($ra2,2,1);
        $opd2 = ($p1 != $login_id) ? substr($ra2,0,1) : substr($ra2,2,1);
        /* ROUND 3 */
        $ra3 = $fetch['round3'];
        $cpd3 = ($p1 == $login_id) ? substr($ra3,0,1) : substr($ra3,2,1);
        $opd3 = ($p1 != $login_id) ? substr($ra3,0,1) : substr($ra3,2,1);
        /* ROUND 4 */
        $ra4 = $fetch['round4'];
        $cpd4 = ($p1 == $login_id) ? substr($ra4,0,1) : substr($ra4,2,1);
        $opd4 = ($p1 != $login_id) ? substr($ra4,0,1) : substr($ra4,2,1);
        /* ROUND 5 */
        $ra5 = $fetch['round5'];
        $cpd5 = ($p1 == $login_id) ? substr($ra5,0,1) : substr($ra5,2,1);
        $opd5 = ($p1 != $login_id) ? substr($ra5,0,1) : substr($ra5,2,1);

        $cpd1 = ($opd1 == 0) ? 0 : $cpd1;
        $cpd2 = ($opd2 == 0) ? 0 : $cpd2;
        $cpd3 = ($opd3 == 0) ? 0 : $cpd3;
        $cpd4 = ($opd4 == 0) ? 0 : $cpd4;
        $cpd5 = ($opd5 == 0) ? 0 : $cpd5;

        $opd1 = ($cpd1 == 0) ? 0 : $opd1;
        $opd2 = ($cpd2 == 0) ? 0 : $opd2;
        $opd3 = ($cpd3 == 0) ? 0 : $opd3;
        $opd4 = ($cpd4 == 0) ? 0 : $opd4;
        $opd5 = ($cpd5 == 0) ? 0 : $opd5;


        $scores =  sum_score($cpd1.$opd1.";".$cpd2.$opd2.";".$cpd3.$opd3.";".$cpd4.$opd4.";".$cpd5.$opd5);
        $scores = explode(";", $scores);
        $sessionscore = $scores[0];
        $previousscore = $score-$sessionscore;
        echo "<script>
            $('#badge-s').html($score);
            $('#badge-sc').html($sessionscore);
            $('#badge-ps').html($previousscore);
        </script>";
    }
    $sql = "SELECT id FROM users WHERE online_status=1 AND busy=0 AND id!='$login_id' ORDER BY rand()";
    $query = $dbc->query($sql);
    if((!$query->num_rows) AND (!$busy)){
        echo "<div class='col-xs-12 text-center'>
    	There are not players
        <div class='alert alert-info'>You will be notified with a sound when a round starts</div>
        </div>"; 
        echo "<script>
            $('#badge-s').html($score);
            $('#badge-sc').html(0);
            $('#badge-ps').html($score);
        </script>";
    } 
    elseif(!$busy)
    {
    	$id = $query->fetch_assoc();
    	$id = $id['id'];
        if($query->num_rows > 1){
            $sql = "SELECT * FROM games WHERE player1='$login_id' OR player2='$login_id' ORDER BY id DESC LIMIT 1";
            $query = $dbc->query($sql);
            $fetch = $query->fetch_assoc();
            if( ($fetch['player1'] == $id) OR ($fetch['player2'] == $id)){
                $sql = "SELECT id FROM users WHERE online_status=1 AND busy=0 AND id!='$login_id' AND id!='$id' ORDER BY rand() LIMIT 1";
                $query = $dbc->query($sql);
                $fetch = $query->fetch_assoc();
                $id = $fetch['id'];
            }
        }
    	/* Make players busy */
    	$sql = "UPDATE users SET busy=1 WHERE id='$id' OR id='$login_id'";
    	$query = $dbc->query($sql);
    	/* Create game */
    	$time = time()+120;
    	$sql = "INSERT INTO games (player1,player2,time) VALUES ('$id','$login_id','$time')";
    	$query = $dbc->query($sql);
    	/* Get id from game */
    	$sql = "SELECT id FROM games WHERE (player1='$login_id' OR player2='$login_id') AND (status!=6)";
    	$query = $dbc->query($sql);
    	$fetch = $query->fetch_assoc();
    	$id = $fetch['id'];
    	/* Show game */
    	if($query->num_rows){show_game($id);}
    }
    elseif($busy){
    	/* Get game id */
    	$sql = "SELECT * FROM games WHERE (player1='$login_id' OR player2='$login_id') AND (status!=6)";
    	$query = $dbc->query($sql);
    	$fetch = $query->fetch_assoc();
    	$id = $fetch['id'];
    	/* show game */
    	if($query->num_rows){show_game($id);}else{
            echo "<div class='col-xs-12 text-center'>
                Marked as BUSY!
                <button class='btn btn-info btn_unbusy btn-lg btn-block'>Click here if you are ready to play!</button>
            </div>";
            echo "<script>
                $('#badge-s').html($score);
                $('#badge-sc').html(0);
                $('#badge-ps').html($score);
                $('#badge-as').html($avg);
            </script>";
        }
    }
?>
<script>
$('.btn_co').click(function(){
    var gid = $('#game_id').val();
    $.post( "decision.php", { id: gid, de: 1 } );
    get_data();
});
$('.btn_de').click(function(){
    var gid = $('#game_id').val();
    $.post( "decision.php", { id: gid, de: 2 } );
    get_data();
});
$('.btn_unbusy').click(function(){
    $.post( "unbusy.php", { busy: 0 } );
});
</script>
    <?php
    $sql = "SELECT * FROM games WHERE (player1='$login_id' OR player2='$login_id') AND (status=6) ORDER BY id DESC LIMIT 1";
    $query = $dbc->query($sql);
    $fetch = $query->fetch_assoc();
    $p1 = $fetch['player1'];
    $op = ($p1 != $login_id) ? $p1 : $fetch['player2'];
    /* ROUND 1 */
    $ra1 = $fetch['round1'];
    $cpd1 = ($p1 == $login_id) ? substr($ra1,0,1) : substr($ra1,2,1);
    $opd1 = ($p1 != $login_id) ? substr($ra1,0,1) : substr($ra1,2,1);
    /* ROUND 2 */
    $ra2 = $fetch['round2'];
    $cpd2 = ($p1 == $login_id) ? substr($ra2,0,1) : substr($ra2,2,1);
    $opd2 = ($p1 != $login_id) ? substr($ra2,0,1) : substr($ra2,2,1);
    /* ROUND 3 */
    $ra3 = $fetch['round3'];
    $cpd3 = ($p1 == $login_id) ? substr($ra3,0,1) : substr($ra3,2,1);
    $opd3 = ($p1 != $login_id) ? substr($ra3,0,1) : substr($ra3,2,1);
    /* ROUND 4 */
    $ra4 = $fetch['round4'];
    $cpd4 = ($p1 == $login_id) ? substr($ra4,0,1) : substr($ra4,2,1);
    $opd4 = ($p1 != $login_id) ? substr($ra4,0,1) : substr($ra4,2,1);
    /* ROUND 5 */
    $ra5 = $fetch['round5'];
    $cpd5 = ($p1 == $login_id) ? substr($ra5,0,1) : substr($ra5,2,1);
    $opd5 = ($p1 != $login_id) ? substr($ra5,0,1) : substr($ra5,2,1);
    $scores =  sum_score($cpd1.$opd1.";".$cpd2.$opd2.";".$cpd3.$opd3.";".$cpd4.$opd4.";".$cpd5.$opd5);
    $scores = explode(";", $scores);
    $cs = $scores[0];
    $os = $scores[1];
    $ca = ($cs > $os) ? "won" : "lost";
    $oa = ($os > $cs) ? "won" : "lost";
    echo "
        <div style='margin-top:50px' class='alert alert-info text-center col-xs-12 col-md-6 col-md-offset-3'>
        In your last match you $ca and got $cs points, your partner $oa and got $os points
        </div>
    ";
	
	mysqli_query($dbc, "COMMIT");
	//3. ALWAYS CLOSE A DATABASE AFTER USING IT.
	mysqli_close($dbc); //dbc is for connection.php	
    ?>
</table>