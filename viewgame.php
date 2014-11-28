<?php
session_start();
include_once('/db/sql_functions.php');
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
		
		$hostID = getHost($Game_ID);
		$hostRating = getHostRating($hostID);
		$hostData = getPlayerDetails($hostID);
		$gameExists = getGameDetails($Game_ID);
		if($gameExists)
			$gameData = $gameExists[0];

		?>
		<div class="panel panel-info">
			<div class="panel-heading">Game Details</div>
		<table class='table table-striped'>
			<tr><th>Game Name</th><td><?="{$gameData['Name']}";?></td></tr>
			<tr><th>Sport</th><td><?="{$gameData['Sport']}";?></td></tr>
			<tr><th>Max Players</th><td><?="{$gameData['MaxPlayersNum']}";?></td></tr>
			<tr><th>Private?</th><td><?php echo ($gameData['Private'] == 1 ? 'Yes' : 'No');; ?></td></tr>
			<tr><th>Description</th><td><?="{$gameData['Description']}";?></td></tr>
			<tr><th>DateAndTime</th><td><?="{$gameData['DateAndTime']}";?></td></tr>
			<tr><th>Latitude</th><td><?="{$gameData['Latitude']}";?></td></tr>
			<tr><th>Longitude</th><td><?="{$gameData['Longitude']}";?></td></tr>
		</table>
		</div>
		<div class="panel panel-info">
			<div class="panel-heading">Host</div>
		<table class='table table-striped'>
			<th>Name</th>
			<th>Rating</th>
			<th></th>
			<th></th>			
			<tr>
				<td><?="{$hostData['Name']}";?></td>
				<td><?="{$hostRating}";?></td>
				<td><a href='index.php?rating=positive&HostID=<?="{$hostID}"?>'><span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span></a></td>
				<td><a href='index.php?rating=negative&HostID=<?="{$hostID}"?>'><span class='glyphicon glyphicon-thumbs-down' aria-hidden='true'></span></a></td>								
			</tr>
		</table>
		</div>
		<div class="panel panel-info">
			<div class="panel-heading">Players</div>
		<table class='table table-striped'>
		<th>Name</th>
		<th>Rating</th>
		<th></th>
		<th></th>
		<?php
		foreach($playerDetails as $k=>$v)
		{
		?>
			<tr>
			<td><?="{$v['Name']}"?></td>
			<td><?php echo getPlayerRating($v['UserID']);?></td>
			<td><a href='index.php?rating=positive&UserID=<?="{$v['UserID']}"?>'><span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span></a></td>
			<td><a href='index.php?rating=negative&UserID=<?="{$v['UserID']}"?>'><span class='glyphicon glyphicon-thumbs-down' aria-hidden='true'></span></a></td>
			<?php
			if(isset($_SESSION['UserID']) && $_SESSION['UserID'] == $hostID)
				echo '<td><span class="glyphicon glyphicon-remove"></span></td>';
			?>
			</tr>

		<?php
		}
		echo "</table>";
		echo "</div>";
	}
	else
	{
		echo "Game does not exist.";
	}
	

?>