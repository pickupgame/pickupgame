<?php
if(!isset($_GET['Game_ID']))
{
?>
<div>
	<table class="table">
		<th>Game</th>
		<th>Host</th>
		<th>Rating</th>
		<th>Players</th>
		<tr>
			<td><a href="index.php?page=browse&Game_ID=6">Game 6</a></td>
			<td>Random Host Name</td>
			<td><span class="text-success">5</span></td>
			<td>5/7</td>
		</tr>
	</table>
</div>
<?php } ?>
