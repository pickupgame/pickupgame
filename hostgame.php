<?php
	session_start();
	include_once('db/sql_functions.php');
	// Password & Description can be null (Everything else cannot)

	$GameName = isset($_POST["GameName"]) ? $_POST["GameName"] : "";
	$Sport = isset($_POST["Sport"]) ? $_POST["Sport"] : "";
	$MaxPlayersNum = isset($_POST["MaxPlayersNum"]) ? $_POST["MaxPlayersNum"] : "";
	$Password = isset($_POST["Password"]) ? $_POST["Password"] : "";
	$Description = isset($_POST["Description"]) ? $_POST["Description"] : "";
	$Private = 0;
	$DateAndTime = isset($_POST["dateandtime"]) ? $_POST["dateandtime"] : "";	// Need to decide how we are grabbing this and storing in database. Exists as DateTime datatype in Database (Date Picker?)
	$Longitude = isset($_POST["longitude"]) ? $_POST["longitude"] : "";					   
	$Latitude = isset($_POST["latitude"]) ? $_POST["latitude"] : "";;							// Pulled coordinates stored here from Google Maps
	$iserror = false;
	$Host_ID = (isset($_SESSION["UserID"]) ? $_SESSION["UserID"] : "");			// Current user's session ID
	$get_sports = getSports();				// Gets all sports from database to fill in dropdown

	//ensure that all fields have been filled in correctly
	if(isset($_POST["submit"]))
	{
		echo "<pre>";
		var_dump($_POST);
		echo "</pre>";
	    if ($GameName == "") {
	        $iserror = true;
	        print "<p class='text-danger'>You must enter in a game name.</p>";
	    } 

	    if($Latitude == "" && $Longitude == "")
	    {
	    	$iserror = true;
	    	print "<p class='text-danger'>You must choose a location.</p>";
	    }

	    if($Password != "")
	    {
	    	$Private = 1;
	    }


		if(!$iserror)
		{
			HostGame($GameName, $Sport, $MaxPlayersNum, $DateAndTime, $Password, $Private, $Host_ID, $Description, $Latitude, $Longitude);
			print "<p class='text-success'>You are now the host of a game.</p>";			
		}
	}

	echo "<h1>Game Details</h1>";
	echo "<form method = 'post' action='index.php?page=hostgame'>";
	echo "<table class='table'>";
	echo "<tr><td><label>Name:</label></td><td><input class='form-control' type='text' name='GameName' id='GameName'></td></tr>";
	echo "<tr><td><label>Sport:</label></td><td><select class='form-control' name = 'Sport' id = 'Sport'>";
		foreach($get_sports as $setsports)
		{
			print "<option value = '" . $setsports["SportName"] . "'>" . $setsports["SportName"] . "</option>";
		}

	echo "</select></td></tr>";
	echo "<tr><td><label>Players:</label></td><td><input class='form-control' type = 'number' name = 'MaxPlayersNum' min = '1' max = '11' id = 'MaxPlayersNum'></td></tr>";
	echo "<tr><td><label>Password:</label></td><td><input class='form-control' type = 'password' name = 'Password' id = 'Password'></td></tr>";
	echo "<tr><td><label>Date and Time:</label></td><td>";

?>
<div class='input-group date' id='datetimepicker1'>
    <input type='text' class="form-control" name='dateandtime' />
    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
    </span>
</div>
<?php
	


	echo "</td></tr>";
	echo "<tr><td><label>Description:</label></td><td><textarea class='form-control' rows='4' cols='50' name = 'Description' id = 'Description'></textarea></td></tr>";
	?>
	<tr>
		<td><label>Location:</label></td>
		<td>
			<fieldset class="gllpLatlonPicker">
				<div class="gllpMap">Google Maps</div>
				<label>Latitude:</label><input type="text" class="gllpLatitude" value="42.318449" name='latitude'/>
				<label>Longitude:</label><input type="text" class="gllpLongitude" value="-83.233202" name='longitude'/>
				<input type="hidden" class="gllpZoom" value="15"/>
				<input type="button" class="gllpUpdateButton btn btn-warning btn-xs" value="update map">
			</fieldset>
		</td>
	</tr>
	</table>
	<?php
	echo "<input class='btn btn-info pull-right' type='submit' name='submit' value = 'Submit Game'></form>";
	


?>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker();
    });
</script>
