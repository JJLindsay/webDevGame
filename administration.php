<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prisoner's Dilemma</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/stylesheet.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
    <script src="js/respond.js"></script>	
</head>
<body>
<!--Add bootstrap to folder!! -->

<!--For the administrator, the system should have the following: 
b) Choose playing mode: random & iterative & set
----------------------------  NEXT STEP  ------------------------------------------------
The admin page has font issues when selecting a tab a the top. The Play mode page is missing. 
All of this information should come from the database and maybe saved in a cookie. This can be tested 
temporarily on a local server with php.
-->
<!-- jumbotron background with a table that is changeable by class and logout is possible in the top right -->


	<!-- Navigation Bar begin-->
	<header class="navbar navbar-default">
		<div class="container-fluid">
			<!-- Brand/Logo and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse" aria-expanded="false">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.html">Prisoner's Dilemma</a>
			</div>

			<!-- Collect the nav links and other content for toggling -->
			<div class="collapse navbar-collapse" id="collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="index.html">Home</a></li>
					<li><a href="selectmode.html">Select Play Mode</a></li>
					<li class="active"><a href="administration.html">Check Scores</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="profile.html">My Profile</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#">Logout</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</header><!--  end Navigation Bar -->



<div class="page-header">
  <h1>Welcome Administrator <small>TO 
  <span class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="choosecourse" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		BIOLOGY 1001<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" aria-labelledby="choosecourse">
		<li class="list-group-item">
			<span class="badge glyphicon glyphicon-minus" onclick="#">del</span>
			<a href="#">Biology</a>
		</li>
		<li class="list-group-item">
			<span class="badge glyphicon glyphicon-minus" onclick="#">del</span>
			<a href="#">Phycology</a>
		</li>
	</ul>
	</span>
	</h1>
</div>


<div>
  <img src="img/American History X-Cellent.jpg" alt="" class="img-rounded myimg" >
	<div class="bigwrapper">
	
	<h1 style="color:white;"><center>Scores by Class</center></h1>
  <div class="dropdown">
	<button class="btn btn-default dropdown-toggle" type="button" id="admindropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		Section 03<span class="caret"></span>  
	</button><button type="button" onclick=""><span class="glyphicon glyphicon-plus"></span></button>
	<ul class="dropdown-menu" aria-labelledby="admindropdown">
		<li class="list-group-item">
			<span class="badge glyphicon glyphicon-minus" onclick="#">del</span>
			<a href="#">section 01</a>
		</li>
		<li class="list-group-item">
			<span class="badge glyphicon glyphicon-minus" onclick="#">del</span>
			<a href="#">section 05</a>
		</li>
		<li class="list-group-item">
			<span class="badge glyphicon glyphicon-minus" onclick="#">del</span>
			<a href="#">section 06</a>
		</li>
		<li class="list-group-item">
			<span class="badge glyphicon glyphicon-minus" onclick="#">del</span>
			<a href="#">section 07</a>
		</li>
	</ul>
</div>
  
<div class="wrapper">
  <div class="table-responsive"><!--Add this for responsive table -->
  <!-- Table -->
  <table class="table table-hover table-bordered table-striped" border=1 id="inner">
  			<tr>
				<th>User Name</th>
				<th>Last Name</th>
				<th>First Name</th>
				<th>Score</th>
			</tr>
  <?php
  		//connect to mysql
		$db = mysqli_connect("localhost", "root", "", "students");
		if (mysqli_connect_errno())
		{
			print "Connect failed: " . mysqli_connect_error();
			exit();
		}
		
		//get the query and clean it up (delete leading and trailing
		// whitespace and remove backslashes from magic_quotes_gpc)
		
			$query = 'select * from students;';
			trim($query);
			echo $query;
			$query = stripslashes($query);
			
		//execute the query
			$result = mysqli_query($db, $query);
			if (!$result)
			{
				print "Error - the query could not be executed" . mysqli_error();
				exit;
			}
					
		//Display the results in a table
			print "<tr align = 'center'>";
						
		//get the number of rows within the result (or database) 
			$num_rows = mysqli_num_rows($result);
			
		//if there are rows in the result, put them in an html table
			if ($num_rows > 0)
			{
				$row = mysqli_fetch_assoc($result);  //give me this row
				$num_fields = mysqli_num_fields($result);		//tell me how many fields per row
			
				/*//produce the column labels
					$keys = array_keys($row);
					for ($index = 0; $index < $num_fields; $index++)
					{
						print "<th>" . $keys[$index] . "</th>";
					}*/
					print "</tr>";
						
				//output the values of the fields in the rows
					for ($row_num = 0; $row_num <  $num_rows; $row_num++)
					{
						print "<tr>";
						$values = array_values($row);
						for ($index = 0; $index < $num_fields; $index++)
						{
							$value = htmlspecialchars($values[$index]);
							print "<td>" . $value . "</td>";
						}	//* end of for ($index ...
						
						print "</tr>";
						$row = mysqli_fetch_assoc($result);  //get the contents of the next row.
					}	
			}
			else
			{
				print "There were no such rows in the table <br />";
			}
		//print "</table>";
  
  ?>
<!--
			<tr>
				<td>user1</td>
				<td>LName1</td>
				<td>FName1</td>
				<td>111</td>
			</tr>
			<tr>
				<td>user2</td>
				<td>LName2</td>
				<td>FName2</td>
				<td>102</td>
			</tr>
			<tr>
				<td>user3</td>
				<td>LName3</td>
				<td>FName3</td>
				<td>103</td>
			</tr>
			<tr>
				<td>user4</td>
				<td>LName4</td>
				<td>FName4</td>
				<td>104</td>
			</tr>
			<tr>
				<td>user5</td>
				<td>LName5</td>
				<td>FName5</td>
				<td>105</td>
			</tr>
			<tr>
				<td>user6</td>
				<td>LName6</td>
				<td>FName6</td>
				<td>106</td>
			</tr>
			<tr>
				<td>user7</td>
				<td>LName7</td>
				<td>FName7</td>
				<td>107</td>
			</tr>
			<tr>
				<td>user8</td>
				<td>LName8</td>
				<td>FName8</td>
				<td>108</td>
			</tr>
			<tr>
				<td>user9</td>
				<td>LName9</td>
				<td>FName9</td>
				<td>109</td>
			</tr>
			<tr>
				<td>user10</td>
				<td>LName10</td>
				<td>FName10</td>
				<td>110</td>
			</tr>
			<tr>
				<td>user11</td>
				<td>LName11</td>
				<td>FName11</td>
				<td>111</td>
			</tr>
			<tr>
				<td>user12</td>
				<td>LName12</td>
				<td>FName12</td>
				<td>112</td>
			</tr -->
		</table>
	 </div>
	 <!--/div>  <!-- End of responsive table -->
	 <button type="button" class="btn btn-lg btn-success" aria-haspopup="true" aria-expanded="false" id="exportbtn">
		Export to SpreadSheet
	</button>
	</div>
	</div>
	
  <!--/div-->
</div>

<!-- javascript -->
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/zsparks.js"></script>
</body>
</html>