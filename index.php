<!DOCTYPE html>


<html>
	<head>
		<meta charset = "utf-8">
		<link rel = "stylesheet" type= "text/css" href = "index.css">
		<title>Registration Form</title>
	</head>
	<body>
		<script type='text/javascript'>

		function appear() 
		{ 
		    document.getElementById('Change').style.display="inline";
		}
		</script>
		<form METHOD="LINK" ACTION="studentregistrationlist.php">
			<INPUT TYPE="submit" VALUE="Click here to see the Current Student List">
		</form>
		<h2> Registration Information</h2>
		<form method = 'post' action = "<?php echo $_SERVER['PHP_SELF']; ?>">
		<input id = "Change" style = "display:none" type = 'submit' name = 'yes' value = 'Yes, Change My Time'>
		</form>
		<?php
		session_start();
		// variables used in script
		$username = "jrussr42";
		$password = "12345678";
		$hostname = "jasonrussell435db.cmkzt5hznaki.us-east-1.rds.amazonaws.com:3306"; 
		$databasename = "umdregistration"; 
		$portnum=3306;
		$umid = isset($_POST["umid"]) ? $_POST[ "umid" ] : "";
		$fname = isset($_POST["fname"]) ? $_POST[ "fname" ] : "";
		$lname = isset($_POST["lname"]) ? $_POST[ "lname" ] : "";
		$projname = isset($_POST["projname"]) ? $_POST[ "projname" ] : "";
		$email = isset($_POST["email"]) ? $_POST[ "email" ] : "";
		$phone = isset($_POST["phone"]) ? $_POST[ "phone" ] : "";
		$timeslot = isset($_POST["timeslot"]) ? $_POST[ "timeslot" ] : "";
		$action = isset($_POST["action"]) ? $_POST[ "action" ] : "";
		$iserror = false;
		$duplicaterequest=false;
		$formerrors = array("umiderror"=> false,"fnameerror"=> false,"lnameerror"=>false,"projnameerror"=>false,
							"emailerror"=>false,"phoneerror"=>false,"timesloterror"=>false);
		$inputlist = array( "umid" => "UMID", "fname" => "First Name", "lname" => "Last Name", 
							"projname" => "Project", "email"=> "Email", "phone" => "Phone");


		$database = mysql_connect($hostname, $username, $password) 
		 or die("Unable to connect to MySQL");

		//select a database to work with
		$selected = mysql_select_db($databasename,$database) 
		  or die("Could not select examples");
		  print($action);
		if(isset($_POST["yes"]))
		{
			$query = "UPDATE regsection SET SeatsRemaining = SeatsRemaining + 1 WHERE DateAndTime = '".mysql_real_escape_string($_SESSION["previoustimeslot"])."'";
			if( !( $result=mysql_query($query, $database)))
			{
				print ("<p>Could not execute query!</p>");
				die(mysql_error());
			}
			$query = "UPDATE regsection SET SeatsRemaining = SeatsRemaining - 1 WHERE DateAndTime = '".mysql_real_escape_string($_SESSION["timeslot"])."'";
			if( !( $result=mysql_query($query, $database)))
			{
				print ("<p>Could not execute query!</p>");
				die(mysql_error());
			}
			$changingtimeumid=$_SESSION["umid"];
			$query = "UPDATE student SET TimeSlot = '".mysql_real_escape_string($_SESSION["timeslot"])."' WHERE UMID='$changingtimeumid'";
			if( !( $result=mysql_query($query, $database)))
			{
				print ("<p>Could not execute query!</p>");
				die(mysql_error());
			}
			print("<p><span class = 'success'>You Have successfully changed your Registration Time</span></p>");
			unset($_POST["yes"]);
		}
		if ( isset($_POST["submit"]))
		{
			if($umid == "" || (!(preg_match("/^[0-9]{8}$/",$umid))))
			{
				$formerrors ["umiderror"] = true;
				$iserror = true;
			}
			if($fname == "" || (!(preg_match("/^[A-z-]+$/",$fname))))
			{
				$formerrors ["fnameerror"] = true;
				$iserror = true;
			}
			if($lname == "" || (!(preg_match("/^[A-z-]+$/",$lname))))
			{
				$formerrors ["lnameerror"] = true;
				$iserror = true;
			}
			if($projname == "")
			{
				$formerrors ["projnameerror"] = true;
				$iserror = true;
			}
			if($email == ""|| (!(preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/",$email))))
			{
				$formerrors ["emailerror"] = true;
				$iserror = true;
			}
			if( !preg_match("/[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone))
			{
				$formerrors ["phoneerror"] = true;
				$iserror = true;
			}
			if($timeslot == "")
			{
				$formerrors ["timesloterror"] = true;
				$iserror = true;
			}
			if(!$iserror)
			{
				$_SESSION["umid"]=$umid;
				$_SESSION["fname"]=$fname;
				$_SESSION["lname"]=$lname;
				$_SESSION["phone"]=$phone;
				$_SESSION["email"]=$email;
				$_SESSION["projname"]=$projname;
				$_SESSION["timeslot"]=$timeslot;
				$result = mysql_query("SELECT UMID, TimeSlot FROM student WHERE UMID = '$umid'");
				while ($row = mysql_fetch_array($result))
				{
					$temp=$row{'UMID'};
					$previoustimeslot=$row{'TimeSlot'};
					$duplicaterequest= true;
					$_SESSION["previoustimeslot"]=$row{'TimeSlot'};
				}
				if(!$duplicaterequest)
				{
					$query = "INSERT INTO student (UMID, FName, LName, PTitle, Email, Phone, TimeSlot) ".
							 "VALUES ('$umid', '$fname', '$lname', '$projname', '$email', '" .mysql_real_escape_string( $phone )."', '".mysql_real_escape_string( $timeslot)."')";
					if( !( $result=mysql_query($query, $database)))
					{
						print ("<p>Could not execute query!</p>");
						die(mysql_error());
					}

					$query = "UPDATE regsection SET SeatsRemaining = SeatsRemaining - 1 WHERE DateAndTime = '".mysql_real_escape_string($timeslot)."'";
					if( !( $result=mysql_query($query, $database)))
					{
						print ("<p>Could not execute query!</p>");
						die(mysql_error());
					}
				}
			}
		}
		print( "<form method = 'post' action = 'index.php' id= 'submission'>");
		if(!$iserror&&!$duplicaterequest&& (isset($_POST["submit"])))
		{
			print("<p><span class = 'success'>YOU HAVE SUCCESSFULLY REGISTERED FOR YOUR COURSE</span></p>");
		}
		if ( isset($_POST["submit"])&&$duplicaterequest)
		{
			foreach($inputlist as $inputname => $inputalt )
			{
				print("<div><label>$inputalt:</label><input type = 'text' name = '$inputname' value = '".$$inputname."' disabled>");
				if ($formerrors[($inputname)."error"] == true )
				{
					print("<span class = 'error'>*</span>");
				}
				print("</div>");
			}
		}
		else
		{
			foreach($inputlist as $inputname => $inputalt )
			{
				print("<div><label>$inputalt:</label><input type = 'text' name = '$inputname' value = '".$$inputname."'>");
				if ($formerrors[($inputname)."error"] == true )
				{
					print("<span class = 'error'>*</span>");
				}
				print("</div>");
			}
		}
		if ($iserror)
		{
			print ("<p class = 'error'>Please fix the following areas marked by an *");
		}
		if ($formerrors[ "phoneerror"])
		{
			print ("<p class = 'error'>Phone must be in the form 333-333-3333");
		}
		if ($formerrors[ "emailerror"])
		{
			print ("<p class = 'error'>Email must be in the form john@company.com");
		}
		if ($formerrors[ "timesloterror"])
		{
			print ("<p class = 'error'>There are no Timeslots left to choose from");
		}


		//connection to the database
		if( !( $result= mysql_query("SELECT * FROM regsection")))
					{
						print ("<p>Could not execute query!</p>");
						die(mysql_error());
					}
		//fetch tha data from the database 
		$counter=0;
		while ($row = mysql_fetch_array($result)) 
		{
			$timeslotarray[$counter]=$row{'DateAndTime'};
			$seatsremainingarray[$counter]=$row{'SeatsRemaining'};
			$counter++;
		}
		if ( isset($_POST["submit"])&&$duplicaterequest)
		{
			print( "<p>Which Registration Time Would You Like?</p>
				<select name = 'timeslot' disabled>");
		}
		else
		{
			print( "<p>Which Registration Time Would You Like?</p>
				<select name = 'timeslot'>");
		}
		
		foreach(array_combine($timeslotarray, $seatsremainingarray) as $currenttimeslot => $currentseatsremaining)
		{
			if($currentseatsremaining>0)
			{
				print( "<option" .($currenttimeslot == $timeslot ?" selected>" : ">"). $currenttimeslot . "</option>");
			}
		}
		print( "</select>");
		if(!$duplicaterequest)
		{
			print( "<p class = 'head'><input type = 'submit' name = 'submit' value = 'Register'></p></form>");
		}
		else
		{
			print "<p>This UMID " . $umid . " is already registered at time " . $_SESSION["previoustimeslot"] . ". Would you like to change it to time slot " . $_SESSION["timeslot"] . "?</p>";
        print "<br><br>";
        print '<script type="text/javascript">';
        print 'appear()';
        print '</script>';
		}
		print( "<h1>The Available Class List</h1>
				<table>
					<tr>
						<th>Date and Time</th>
						<th>Seats Remaining</th>
					</tr>");
		$result = mysql_query("SELECT * FROM regsection");
		//execute the SQL query and return records
		for($counter = 0;$row = mysql_fetch_row($result);$counter++)
		{
			print( "<tr>");
			foreach($row as $key => $value)
				print("<td>$value</td>");
			print( "</tr>");
		}
		print( "</table>");

		//fetch tha data from the database 
		//while ($row = mysql_fetch_array($result)) {
		//   echo "ID:".$row{'UMID'}." Name:".$row{'FName'};
		//}
		//close the connection
		mysql_close($database);
		?>
	</body>
</html>