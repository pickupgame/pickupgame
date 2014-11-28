<?php
include_once('../db/sql_functions.php');
// error_reporting(E_ALL);
	$method = $_SERVER['REQUEST_METHOD'];
	if(strtolower($method) == "get")
	{
		$Game_ID = $_GET['Game_ID'];
		$gamePlayers = getGamePlayers($Game_ID);
		// echo "<pre>";
		// var_dump($gamePlayers);
		// // echo $v[0]['Name'];
		// echo "</pre>";
		$gamePlayerIDs = array();
		$playerDetails = array();
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

		echo json_encode($playerDetails);
	}	

?>