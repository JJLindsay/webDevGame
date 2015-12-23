<?php
	include('connection.php');

	// We don't want web bots altering our stats:
	if(is_bot()) die();

	$stringIp = $_SERVER['REMOTE_ADDR'];
	$intIp = ip2long($stringIp);

	// Checking whether the visitor is already marked as being online:
	$inDB = mysql_query("SELECT 1 FROM users WHERE ip=".$intIp);

	if(!mysql_num_rows($inDB))
	{
		// This user is not in the database, so we must fetch
		// the geoip data and insert it into the online table:

		if($_COOKIE['geoData'])
		{
			// A "geoData" cookie has been previously set by the script, so we will use it

			// Always escape any user input, including cookies:
			list($city,$countryName,$countryAbbrev) = explode('|',mysql_real_escape_string(strip_tags($_COOKIE['geoData'])));
		}
		else
		{
			// Making an API call to Hostip:

			$xml = file_get_contents('http://api.hostip.info/?ip='.$stringIp);

			$city = get_tag('gml:name',$xml);
			$city = $city[1];

			$countryName = get_tag('countryName',$xml);
			$countryName = $countryName[0];

			$countryAbbrev = get_tag('countryAbbrev',$xml);
			$countryAbbrev = $countryAbbrev[0];

			// Setting a cookie with the data, which is set to expire in a month:
			setcookie('geoData',$city.'|'.$countryName.'|'.$countryAbbrev, time()+60*60*24*30,'/');
		}

		mysql_query("	INSERT INTO users (ip)
						VALUES(".$intIp.")");
	}
	else
	{
		// If the visitor is already online, just update the dt value of the row:
		mysql_query("UPDATE users SET date=NOW() WHERE ip=".$intIp);
	}

	// Removing entries not updated in the last 10 minutes:
	mysql_query("DELETE FROM users WHERE date<SUBTIME(NOW(),'0 0:10:0')");

	// Counting all the online visitors:
	list($totalOnline) = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM users"));

	// Outputting the number as plain text:
	echo $totalOnline;

	mysqli_query($dbc, "COMMIT");
	//3. ALWAYS CLOSE A DATABASE AFTER USING IT.
	mysqli_close($dbc); //dbc is for connection.php

?>