<!-- rateup -->

<?php
include_once('../db/sql_functions.php');
// error_reporting(E_ALL);
	$method = $_SERVER['REQUEST_METHOD'];
	if(strtolower($method) == "get")
	{
		$UserID = $_GET['UserID'];
		echo getLikes($UserID);
	}	
?>