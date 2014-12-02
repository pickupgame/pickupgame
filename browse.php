<form  method="post">
	<label for='formSport'>Select a sport</label><br>
	<select name="formSport"><option value="Select">All Games</option><option value="vb">Volleyball</option><option value="fb">Football</option><option value="sc">Soccer</option> </select>
	<input type="submit" name="formSubmit" value="Submit" >
</form>

<?php
include("/db/sql_functions.php");
	if(isset($_POST['formSubmit'])) 
	{
		$varSport = $_POST['formSport'];
		if ($varSport == 'vb')
		{
		$query = "SELECT * FROM game WHERE Sport=?";
		$rows = query("Volleyball",$query);
		}
		else if ($varSport == 'fb')
		{
		$query = "SELECT * FROM game WHERE Sport=?";
		$rows = query("Football",$query);
		}
		else if ($varSport == 'sc')
		{
		$query = "SELECT * FROM game WHERE Sport=?";
		$rows = query("Soccer",$query);
		}
		else 
		{
		$query = "SELECT * FROM game WHERE Sport LIKE ?";
		$rows = query("%",$query);
		}
		echo '<table border="1" cellpadding="1" cellspacing="1" style="width: 500px;"> <tr> <td>Game Name</td> <td>Sport</td> <td>Start Time</td> <td>Private?</td> <td>View Game</td> </tr>';
		if(!empty($rows))
			{
			foreach ($rows as $row) {
		       echo "<tr>";
		       echo "<td>".$row["GameName"]."</td>";
		       echo "<td>".$row["Sport"]."</td>";
		       echo "<td>".$row["DateAndTime"]."</td>";
		       echo "<td>".$row["Private"]."</td>";
		       echo "<td> <a href=\"index.php?page=browse&Game_ID=".$row["Game_ID"]."\">View</a></td>";
		       //index.php?page=browse&Game_ID=".$row["Game_ID"]."
		       echo "</tr>";
		   		}
			}
	   echo "</table>";

	}
?>

