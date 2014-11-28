<?php
include_once('db/sql_functions.php');
	//figure out if rating host or player
	if(isset($_GET['HostID']))
	{
		//host
		if($_GET['rating'] == 'positive')
		{
			$errorString = insertHostRating($_GET['HostID'], $_SESSION['UserID'], 1);
			if($errorString != FALSE)
			{
				echo "Successfully rated the host.";
			}
		}
		elseif($_GET['rating'] == 'negative')
		{
			$errorString = insertHostRating($_GET['HostID'], $_SESSION['UserID'], 0);
			if($errorString != FALSE)
			{
				echo "Successfully rated the host.";
			}
		}
	}
	elseif(isset($_GET['UserID']))
	{
		//player
		//host
		if($_GET['rating'] == 'positive')
		{
			$errorString = insertPlayerRating($_GET['UserID'], $_SESSION['UserID'], 1);
			if($errorString != FALSE)
			{
				echo "Successfully rated the player.";
			}

		}
		elseif($_GET['rating'] == 'negative')
		{
			$errorString = insertPlayerRating($_GET['UserID'], $_SESSION['UserID'], 0);
			if($errorString != FALSE)
			{
				echo "Successfully rated the player.";
			}

		}
	}
?>