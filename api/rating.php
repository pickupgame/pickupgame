<!-- rateup -->

<?php

include('../db/sql_functions.php');
// error_reporting(E_ALL);
	$method = $_SERVER['REQUEST_METHOD'];
	if(strtolower($method) == "post")
	{
		$player_evaluated = $_POST['player_evaluated'];
		$player_rater = $_POST['player_rater'];
		$rating = $_POST['rating'];


		$db = new mysqli('127.0.0.1', 'root', '', 'pickupgame');

		if($db)
		{
			$query = insertHostRating($player_evaluated, $player_rater, $rating);
			if($query)
			{
				$sql = "select * from userprofile where UserID=?";
				$query = query($player_evaluated, $sql);

				echo json_encode($query);
				
			}
			else
			{
				//query failed
				echo "query failed nub";
			}
		}
		else
		{
			//db connect failed
			echo "DB Connection Failed";
		}
	}

	
?>