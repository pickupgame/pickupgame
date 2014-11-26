<?php
	session_start();
	include('db/sql_functions.php');
	// Password & Description can be null (Everything else cannot)

	$GameName = isset($_POST["GameName"]) ? $_POST["GameName"] : "";
	$Sport = isset($_POST["Sport"]) ? $_POST["Sport"] : "";
	$MaxPlayersNum = isset($_POST["MaxPlayersNum"]) ? $_POST["MaxPlayersNum"] : "";
	$Password = isset($_POST["Password"]) ? $_POST["Password"] : "";
	$Description = isset($_POST["Description"]) ? $_POST["Description"] : "";
	$Private = 0;
	$DateAndTime = "2014-11-07 00:00:00";	// Need to decide how we are grabbing this and storing in database. Exists as DateTime datatype in Database (Date Picker?)
	$Longitude = 15;					   
	$Latitude = 12;							// Pulled coordinates stored here from Google Maps
	$iserror = false;
	$Host_ID = (isset($_SESSION["UserID"]) ? $_SESSION["UserID"] : "");			// Current user's session ID
	$get_sports = getSports();				// Gets all sports from database to fill in dropdown

	//ensure that all fields have been filled in correctly
	if(isset($_POST["submit"]))
	{
	    if ($GameName == "") {
	        $iserror = true;
	        print "<p>You must enter in a game name.</p>";
	    } 

	    if($Latitude == "" && $Longitude == "")
	    {
	    	$iserror = true;
	    	print "<p>You must choose a location.</p>";
	    }

	    if($Password != "")
	    {
	    	$Private = 1;
	    }


		if(!$iserror)
		{
			HostGame($GameName, $Sport, $MaxPlayersNum, $DateAndTime, $Password, $Private, $Host_ID, $Description, $Latitude, $Longitude);
			print "You are now the host of a game.";
			
		}

	}

	echo "<h1>Game Details</h1>";
	echo "<form method = 'post' action='index.php?page=hostgame'> Name: <input type='text' name='GameName' id='GameName'>";
	echo "<br>Sport: <select name = 'Sport' id = 'Sport'>";
		foreach($get_sports as $setsports)
		{
			print "<option value = '" . $setsports["SportName"] . "'>" . $setsports["SportName"] . "</option>";
		}

	echo "</select>";
	echo "<br>Players:<input type = 'number' name = 'MaxPlayersNum' min = '1' max = '11' id = 'MaxPlayersNum'>";
	echo "<br>Password:<input type = 'password' name = 'Password' id = 'Password'>";
	echo "<br>Description: <input type = 'text' name = 'Description' id = 'Description'>";
	echo "<br><input type='submit' name='submit' value = 'Host Game'></form>";
	echo "<button type = 'button'>Cancel</button>";


?>
