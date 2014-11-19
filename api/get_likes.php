<!-- rateup -->

<?php

include('../db/sql_functions.php');
// error_reporting(E_ALL);
	$method = $_SERVER['REQUEST_METHOD'];
	if(strtolower($method) == "get")
	{
		$UserID = $_GET['UserID'];

		$db = new mysqli('127.0.0.1', 'root', '', 'pickupgame');

		if($db)
		{

			$sql = "select * from hostratinggame where PlayerEvaluated=?";
			$query = query($UserID, $sql);
			if($query)
			{
				echo count($query);
			}
			else
			{
				echo "failed query";
			}
			
		}
		else
		{
			//db connect failed
			echo "DB Connection Failed";
		}
	}

	
?>