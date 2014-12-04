<form id ="sportform" method="post">
	<label for='formSport'>Select a sport</label><br>
	<select name="formSport"><option value="%">All Sports</option><option value="Volleyball">Volleyball</option><option value="Basketball">Basketball</option><option value="Football">Football</option><option value="Soccer">Soccer</option> </select>
	<select name="formPrivate"><option value="%">Public & Private</option><option value="0">Public</option><option value="1">Private</option></select>
	<input type="text" name="gamename" placeholder="Game Name">
	<input class='btn btn-info btn-xs' type="submit" name="formSubmit" value="Submit" >
</form>

<?php
include_once("db/sql_functions.php");
$varcount = 0;
if ($varcount == 0) 
	{
		$varcount = 1;
		$varSport = "%";
		$varPrivate = "%";
		$varName = "%";
		//echo $varSport,$varPrivate,$varName;
		$rows = browseGame($varSport,$varPrivate,$varName);

	}
if(isset($_POST['formSubmit'])) 
	{
		$varcount = $varcount + 1;
		$varSport = $_POST['formSport'];
		$varPrivate = $_POST['formPrivate'];
		$varName = $_POST['gamename'];
		if($varName == NULL)
		{
			$varName = "%";
		}
		//echo $varSport,$varPrivate,$varName;
		$rows = browseGame($varSport,$varPrivate,$varName);
	}
		echo '<table class="table table-striped"> <th>Game Name</th> <th>Sport</th> <th>Start Time</th> <th>Private?</th> <th>View Game</th>';
		if(!empty($rows))
			{
			foreach ($rows as $row) {
		       echo "<tr>";
		       echo "<td>".$row["Name"]."</td>";
		       echo "<td>".$row["Sport"]."</td>";
		       echo "<td>".$row["DateAndTime"]."</td>";
		       if ($row["Private"] == 0)
		       {
		       echo "<td> No </td>";
		   		}
		   		else
		   		{
		   		echo "<td> Yes </td>";
		   		}	
		       echo "<td> <a class='btn btn-info btn-xs' href=\"index.php?page=browse&Game_ID=".$row["Game_ID"]."\">View</a></td>";
		       //index.php?page=browse&Game_ID=".$row["Game_ID"]."
		       echo "</tr>";
		   		}
			}
	   echo "</table>";

	
?>
