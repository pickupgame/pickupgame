<?php
//home page
include('db/sql_functions.php');

$user = getPlayerDetails($_SESSION['UserID']);

echo "Welcome {$user['UserName']}!<br>";
$hostGames = getHostGames($user['UserID']);
$playerGames = getPlayerGames($user['UserID']);

if($hostGames)
{
	displayGames($hostGames, 'Host');
}
else
{
	echo "You are not a host. You have no hosted games. <br>";	
}




if($playerGames)
{
	displayGames($playerGames, 'Player');
}
else
{
	echo "You have not joined any games.";	
}

?>
