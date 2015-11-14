<?php
	error_reporting(-1);
	include('connection.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sign up- ZillionSparks</title>
        <meta charset="utf-8"/>
        <title>Prisoner's Dilemma</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet"/>
        <link href="css/stylesheet.css" rel="stylesheet"/>
        <link href="css/custom.css" rel="stylesheet"/>
        <script language="JavaScript" src="js/val.js" type="text/javascript"></script>	
    </head>
    <body class="registerbody">
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
                    <a class="navbar-brand" href="index.php">Prisoner's Dilemma</a>
                </div>
                <!-- Collect the nav links and other content for toggling -->
                <div class="collapse navbar-collapse" id="collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">Home</a></li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </header>
        <!--  end Navigation Bar -->
        <div class="left">
        </div>
        <div class="right">
            <div class="border_form">
			<div id='myForm_errorloc'> </div>
                <form id="myForm" action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <p class="p_signUp_attributes">Registeration Form</p>
					<!--PHP Code-->
		<?php
	include('connection.php');
	$fnameErr = $lnameErr = $emailErr1 = $emailErr2 = $userErr = $passErr1 = $passErr2 = $emptyErr = "";
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$fname     = $_POST['FirstName'];
		$lname     = $_POST['LastName'];
		$email1    = $_POST['Email'];
		$email2    = $_POST['ReEmail'];
		$users     = $_POST['Username'];
		$password1 = $_POST['Password'];
		$password2 = $_POST['RePassword'];
		$Course	   = $_POST['CourseName'];
		$Section   = $_POST['Section'];
		
		
		
		//if values are not empty, proceed to store them in the database
		
		if (!empty($fname) && !empty($lname) && !empty($email1) && !empty($email2) && !empty($users) && !empty($password1) && !empty($password2)) {
			//echo "<h4> No Field is empty! </h4>";
			
			if ((!filter_var($email1, FILTER_VALIDATE_EMAIL) === false) && (!filter_var($email2, FILTER_VALIDATE_EMAIL) === false)) {
				//echo "<h4> Emails are valid as well!</h4>";
				
				if($password1 == $password2) {
					//echo "<h4> Passwords also match!! </h4>";
						
					mysqli_query($dbc, "INSERT INTO users(usernames, first_name, last_name, email, confirmed_email, course, section, pw, confirmed_pw) 
            VALUES ('$users', '$fname', '$lname', '$email1', '$email2', '$Course', '$Section', '$password1', '$password2')");
					
					
					
					//SET TEAMCODE ID's
					$max = mysqli_query($dbc, "SELECT * FROM teamcode WHERE users_id = (SELECT MAX(users_id) FROM teamcode)");  
					$num_rows = mysqli_num_rows($max);  
					$row = $max->fetch_assoc();  //gets the first one
					/* 
					loop through each group:
					turns true/false. Success actually returns a mysqli_result object 
					*/
					
					if ($num_rows == 1)
					{
						$values = array_values($row);  //splits the fetched row contents into an array
						
						$id = $values[0];
						$id = $id +1;
						
						$group = $values[2];
						if ($group == 'yellow')
							$group = 'red';
						else if ($group == 'red')
							$group = 'blue';
						else
							$group = 'red';

						$tag = strtoupper(substr($group,0,1)) . $id;
						
						
						mysqli_query($dbc, "INSERT INTO teamcode(users_id, tag, user_group) VALUES ($id,'$tag','$group')");  //sets the total score to 0 on registration
						mysqli_query($dbc, "INSERT INTO totals(users_id, totalscore) VALUES ($id, 0)");  //sets the total score to 0 on registration
					}
							
							
					
					
			
					//"SELECT tag,user_group FROM teamcode WHERE id = (SELECT MAX(id) FROM teamcode)";
					
					//echo "<h4> User Data inserted Successfully, Everything Worked Fine!</h4>";
					header('Location:index.php');
				}

			}

		} else
		if (empty($fname)){
			$fnameErr = "First name is required";
		} else
		if (empty($lname)){
			$lnameErr = "Last name is required";
		} else
		if (empty($email1)){
			$emailErr1 = "Email is required";
		} else
		if (empty($email2)){
			$emailErr2 = "Re-typed Email is required";
		} else
		if (empty($users)){
			$userErr = "User name is required";
		} else
		if (empty($password1)){
			$passErr1 = "Password is required";
		} else
		if (empty($password2)){
			$passErr2 = "Re-typed Password is required";
		} else {
			$emptyErr = "Please complete the form...";
		}

	}

	?>					
					<span class="error"> <?php  echo $emptyErr; ?></span>
					<!--PHP Ends HERE-->
                    <select class = "dropdown_1" style="margin-left: 10px; margin-top: 10px; height:30px">
                        <option>Mr</option>
                        <option>Ms</option>
                        <option>Mrs</option>
                        <option>Miss</option>
                        <option>Dr</option>
                    </select>
                    <label> <input type="text" name="FirstName" id="fname" placeholder="First Name" size="18px" style="margin-top: 10px; margin-left: 10px; height:30px"/> </label> 
						<span class="error"> <?php  echo $fnameErr; ?></span>
					<label> <input type="text" name="LastName" id="lname" placeholder="Last Name" size="19px" style="margin-top: 10px; margin-left: 10px; height:30px"/> </label> <br>
						<span class="error"> <?php  echo $lnameErr; ?></span>
					<label>	<input type="text" name="Email" id="email1" placeholder="E-mail" size="55px" style="margin-left: 10px; margin-top: 10px; height:30px" /> </label>
						<span class="error"> <?php  echo $emailErr1; ?></span>
					<label> <input type="text" name="ReEmail" id="email2" placeholder="Confirm E-mail" size="55px" style="margin-left: 10px; margin-top: 10px; height:30px" /> </label>
						<span class="error"> <?php  echo $emailErr2; ?></span>
					<label> <input type="text" name="Username" id="uname" placeholder="Username" size="55px" style="margin-left: 10px; margin-top: 10px; height:30px" /> </label>
						<span class="error"> <?php  echo $userErr; ?></span>	
					<label> <input type="password" name="Password" id="pass1"  placeholder="New Password" size="55px" style="margin-left: 10px; margin-top: 10px; height:30px" /> </label>
						<span class="error"> <?php  echo $passErr1; ?></span>
					<label> <input type="password" name="RePassword" id="pass2" placeholder="Confirm Password" size="55px" style="margin-left: 10px; margin-top: 10px; height:30px" /> </label>
						<span class="error"> <?php  echo $passErr2; ?></span>
					<label style="margin-top:10px; font-size:1.2em">&nbsp;&nbsp;<strong>Current Course & Section</strong></label><br><select class = "dropdown_1" name="CourseName" style="margin-left: 10px; margin-top: 10px; height:30px">
                        <option>Course</option>
						<option>BIOL1999</option>
                        <option>CHEM1212</option>
                        <option>BIOL1201</option>
                        <option>BIOL4800</option>
                        <option>BIOL2111</option>
                    </select>
					<select class = "dropdown_1" name="Section" style="margin-left: 10px; margin-top: 10px; height:30px">
                        <option>Section</option>
						<option>01</option>
                        <option>02</option>
                        <option>03</option>
                        <option>04</option>
                        <option>05</option>
						<option>06</option>
                        <option>07</option>
                        <option>08</option>
                        <option>09</option>
                        <option>10</option>
                    </select>	
						
					<div style="font-size:14px; margin-left: 10px; margin-top: 10px">
                        <p>By clicking Sign Up, you agree to our 
                            <a href="" target="" rel="nofollow">Terms</a> 
                            and that you have read our <a href=" " target="" rel="nofollow">Data Policy</a>, 
                            including our <a href=" " target="" rel="nofollow">Cookie Use</a>.
                        </p>
                    </div>
                    <div style="margin-top:10px; margin-left: 10px">
                        <!--type="submit" removed for demo purposes for type=button-->
						<button style="background-color:green; height:40px; width:150px;  -moz-border-radius: 15px;
                            -webkit-border-radius: 15px;
                            border: 3px solid #009900;
                            padding: 5px;" name="websubmit" id="completeregistrationbtn">
                        <span style="color:white; font-weight:bold">Register</span>
                        </button>
                    </div>
            </div>
            </form>
        </div>
        <footer style="margin-top: 60px; margin-left:10px; margin-bottom:5px">ZillionSparks &copy; 2015</footer>
        <!-- javascript -->
        <script src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/zsparks.js"></script>
        <script language="Javascript" type="text/javascript">
            var frmvalidator  = new Validator("myForm");
            	frmvalidator.EnableOnPageErrorDisplaySingleBox();
            	frmvalidator.EnableMsgsTogether();
            	frmvalidator.addValidation("FirstName","req","Please enter your First Name");
            	frmvalidator.addValidation("FirstName","maxlen=60",	"Max length for Name is 60");
            	frmvalidator.addValidation("FirstName","alpha_s","First Name can contain alphabetic chars only");
            	frmvalidator.addValidation("LastName","req","Please enter your Last Name");
            	frmvalidator.addValidation("LastName","maxlen=60",	"Max length for Name is 60");
            	frmvalidator.addValidation("LastName","alpha_s","Last Name can contain alphabetic chars only");
            	frmvalidator.addValidation("Email","maxlen=80");
            	frmvalidator.addValidation("Email","req");
            	frmvalidator.addValidation("Email","email");
            	frmvalidator.setAddnlValidationFunction(DoCustomEmailVerification);
            	frmvalidator.addValidation("Username","maxlen=15");
            	frmvalidator.addValidation("Username","req");
				frmvalidator.addValidation("ReEmail","maxlen=80");
            	frmvalidator.addValidation("ReEmail","req");
            	frmvalidator.addValidation("ReEmail","email");
				frmvalidator.addValidation("Password","maxlen=15");
            	frmvalidator.addValidation("Password","req");
            	frmvalidator.addValidation("Password","password");
            	frmvalidator.setAddnlValidationFunction(DoCustomValidation);
            	frmvalidator.addValidation("RePassword","maxlen=15");
            	frmvalidator.addValidation("RePassword","req");
            	frmvalidator.addValidation("RePassword","password");
        </script>
    </body>
</html>