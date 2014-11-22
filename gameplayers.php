<?php
include('/db/sql_functions.php');
// error_reporting(E_ALL);

	$Game_ID = $_GET['Game_ID'];
	$gamePlayers = getGamePlayers($Game_ID);
	// echo "<pre>";
	// var_dump($gamePlayers);
	// // echo $v[0]['Name'];
	// echo "</pre>";
	$gamePlayerIDs = array();
	$playerDetails = array();
	if($gamePlayers !== NULL)
	{
		foreach($gamePlayers as $k => $player)
		{			
			// echo "{$player['PlayerID']} <br>";
			//store ids for retrieval of personal info
			$gamePlayerIDs[$k] = $player['PlayerID'];

		}
		foreach($gamePlayerIDs as $key => $playerID)
		{
			$playerDetails[$key] = getPlayerDetails($playerID);			
		}
		
		echo "<table>";
		foreach($playerDetails as $k=>$v)
		{
			echo "<tr>";

			foreach($v as $key=> $value)
			{
				echo "<td>$value</td>";
			}

			echo "</tr>";
		}
		echo "</table>";
	}
	else
	{
		echo "Game does not exist.";
	}
	

?>