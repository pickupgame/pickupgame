<?php
//home page
include_once('db/sql_functions.php');

generateSportsTabs();


if(isset($_SESSION['UserID']))
{
	$user = getPlayerDetails($_SESSION['UserID']);
	echo "<br><br>";
	echo "Welcome, {$user['UserName']}!<br>";
	$hostGames = getHostGames($user['UserID']);
	$playerGames = getPlayerGames($user['UserID']);


echo "<div role='tabpanel' id='hostjoined'>";
echo '<ul class="nav nav-tabs" role="tablist">';


echo "<div class='panel panel-default'>";
echo "<div class='panel-heading'>Hosted Games</div>";
echo "<div class='panel-body'>";
if($hostGames)
{
	displayGames($hostGames, 'Host');
}
else
{
	echo "You are not a host. You have no hosted games. <br>";	
}
echo "<div class='pull-left'><a class='btn btn-info btn-xs' href='index.php?page=hostgame'>Host a Game</a></div>";
echo "</div>";
echo "</div>";



echo "<div class='panel panel-default'>";
echo "<div class='panel-heading'>Joined Games</div>";
echo "<div class='panel-body'>";
if($playerGames)
{
	displayGames($playerGames, 'Player');
}
else
{
	echo "<br><br><p>You have not joined any games.</p>";	
	echo "<a class='btn btn-info btn-xs' href='index.php?page=browse'>Browse Games</a>";
}
echo "</div>";
echo "</div>";

echo "</ul>";
echo "</div>";

}

?>


