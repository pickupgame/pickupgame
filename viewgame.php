<?php
session_start();
include_once('db/sql_functions.php');
// error_reporting(0);

	$Game_ID = $_GET['Game_ID'];
	$gamePlayers = getGamePlayers($Game_ID);
	// echo "<pre>";
	// var_dump($gamePlayers);
	// // echo $v[0]['Name'];
	// echo "</pre>";
	$gamePlayerIDs = array();
	$playerDetails = array();
	$hostID = getHost($Game_ID);
	$hostRating = getHostRating($hostID);
	$hostData = getPlayerDetails($hostID);
	$gameExists = getGameDetails($Game_ID);
	if($gameExists)
		$gameData = $gameExists[0];

if(isset($_POST['gamePassSubmit']))
{
	$gamePassword = isset($_POST["gamePassword"]) ? $_POST[ "gamePassword" ] : "";
	if(isset($_SESSION['UserID']))
	{
		if(!empty($gamePassword))
		{
			//validate the input
			if(checkGamePassword($Game_ID, $gamePassword))
			{
				//password matches
				$_SESSION['Allowed'] = $Game_ID;

			}
			else
			{
				//password doesn't match
				echo "<p class='text-danger'>Password doesn't match. Try Again.</p>";
			}

		}
		else
		{
			echo "<p class='text-danger'>You must enter a password to view this game.</p>";
		}
	}
	else
	{
		echo "<p class='text-danger'>You must be logged in to view a private game.</p>";
	}
}
else
{
	$_SESSION['Allowed'] = 0;
}

if($gamePlayers || $hostID )
{
	if(!allowedToViewGame($Game_ID))
	{			
		?>
		<p class='text-danger'>This game is private.</p>
		<form method="POST">
			<table class="table">
				<tr>
					<td><label>Password</label></td>
					<td><input type="password" name="gamePassword"/></td>
				</tr>
				<tr>
					<td></td>
					<td><input class="btn btn-info btn-xs" type="submit" value="submit" name="gamePassSubmit"/></td>
				</tr>	
			</table>
		</form>
		<?php
	}
	else
	{			
		?>
		<div class="panel panel-info">
			<div class="panel-heading">Game Details</div>
		<table class='table table-striped'>
			<tr><th>Game Name</th><td><?="{$gameData['Name']}";?></td></tr>
			<tr><th>Sport</th><td><?="{$gameData['Sport']}";?></td></tr>
			<tr><th>Max Players</th><td><?="{$gameData['MaxPlayersNum']}";?></td></tr>
			<tr><th>Private?</th><td><?php echo ($gameData['Private'] == 1 ? 'Yes' : 'No');; ?></td></tr>
			<?php 
				//if host is viewing the page, display password to them so they can give it out if they forgot
				$gamePass = getGamePassword($_GET['Game_ID']);
				if(isHost($_SESSION['UserID'], $_GET['Game_ID']))
				{
					if($gamePass)
						echo "<tr><th>Pasword</th><td>$gamePass</td></tr>";
				}


			?>
			<tr><th>Description</th><td><?="{$gameData['Description']}";?></td></tr>
			<tr><th>DateAndTime</th><td><?="{$gameData['DateAndTime']}";?></td></tr>
			<tr><th>Latitude</th><td><?="{$gameData['Latitude']}";?></td></tr>
			<tr><th>Longitude</th><td><?="{$gameData['Longitude']}";?></td></tr>
		</table>
		</div>
		<div class="panel panel-info">
			<div class="panel-heading">Host</div>
		<table class='table table-striped '>
			<th>Name</th>
			<th>Rating</th>
			<th></th>
			<th></th>			
			<tr>
				<td><a href="index.php?page=profile&UserID=<?="{$hostData['UserID']}"?>"><?="{$hostData['Name']}";?></a></td>
				<td><?="{$hostRating}";?></td>
				<td><a href='index.php?page=browse&Game_ID=<?="$Game_ID"?>&rating=positive&HostID=<?="{$hostID}"?>'><span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span></a></td>
				<td><a href='index.php?page=browse&Game_ID=<?="$Game_ID"?>&rating=negative&HostID=<?="{$hostID}"?>'><span class='glyphicon glyphicon-thumbs-down' aria-hidden='true'></span></a></td>								
			</tr>
		</table>
		</div>

		<?php
		if($gamePlayers)
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
		?>

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
				<td><a href="index.php?page=profile&UserID=<?="{$v['UserID']}"?>"><?="{$v['Name']}"?></a></td>
				<td><?php echo getPlayerRating($v['UserID']);?></td>
				<td><a href='index.php?page=browse&Game_ID=<?="$Game_ID"?>&rating=positive&UserID=<?="{$v['UserID']}"?>'><span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span></a></td>
				<td><a href='index.php?page=browse&Game_ID=<?="$Game_ID"?>&rating=negative&UserID=<?="{$v['UserID']}"?>'><span class='glyphicon glyphicon-thumbs-down' aria-hidden='true'></span></a></td>
				<?php
				if(isset($_SESSION['UserID']) && $_SESSION['UserID'] == $hostID)
				{
					echo "<td><a class='glyphicon glyphicon-remove' href='index.php?page=browse&Game_ID={$Game_ID}&remove={$v['UserID']}'></a></td>";
				}
				?>
				</tr>

				<?php
			}
			echo "</table>";
			echo "</div>";

		}
		if(isset($_SESSION['UserID']))
		{
			if($_SESSION['UserID'] != $hostID)
			{
				if(userInGame($_SESSION['UserID'], $Game_ID))
					echo "<a class='btn btn-danger pull-right'href='index.php?page=browse&Game_ID={$Game_ID}&action=leave'>Leave Game</a>";
				if(!userInGame($_SESSION['UserID'], $Game_ID))
					echo "<a class='btn btn-info pull-right'href='index.php?page=browse&Game_ID={$Game_ID}&action=join'>Join Game</a>";
			}
			else
			{
				echo "<p class='text-success'>You are the host of this game.</p>";
			}
		}
		else
		{
			echo "<p class='text-danger'>Please login if you would like to join a game.</p>";
		}
	}
}
else
{
	echo "<p class='text-danger'>Game does not exist.";
}


?>