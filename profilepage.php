<?php
session_start();
include_once('db/sql_functions.php');
if(isset($_GET['UserID']) && checkifUserExists($_GET['UserID']))
{
	$userID=$_GET['UserID'];
	$result=getUserInfo($userID);
	$name=$result["Name"];
	$age=$result["Age"];
	$username=$result["UserName"];
	$imageLocation=$result["ImageLocation"];
	?>
	<table class='table table-striped'>
		<thead>
			<tr>
				<th rowspan = "5">
				<?php
				if($imageLocation==null||$imageLocation=="")
				{
			  		print("<img src= 'http://kystmuseetnorveg.no/wp-content/themes/museetmidt-avd/images/default-profile-img.jpg' alt= 'Profile Picture' width=200 height=200>");
				}
				else
				{
			  		print("<img src= '{$imageLocation}' alt= 'Profile Picture' width=200 height=200>");
				}
				print("</th>");
				print("<th>Name:</th>");
				print("<th>{$name}</th>");
			print("</tr>");
			print("<tr>");
				print("<th>Age:</th>");
				print("<th>{$age}</th>");
			print("</tr>");
			print("<tr>");
				print("<th>UserName:</th>");
				print("<th>{$username}</th>");
			print("</tr>");
			print("<tr>");
				print("<th>Host Rating:</th>");
				$HostRating=getHostRating($userID);
				$TotalHostRates=getLikes($userID);
				$PlayerRating=getPlayerRating($userID);
				$TotalPlayerRates=getTotalRatingsAsPlayer($userID);
				print("<th>{$HostRating}/{$TotalHostRates} ({$TotalHostRates} vote(s))</th>");
			print("</tr>");
			print("<tr>");
				print("<th>Player Rating</th>");
				print("<th>{$PlayerRating}/{$TotalPlayerRates} ({$TotalPlayerRates} vote(s))</th>");
			print("</tr>");
		print("</thead>");
	print("</table>");
	if(isset($_SESSION['UserID']) AND $_SESSION['UserID'] == $userID)
		print("<a class='btn btn-info btn-xs' href='index.php?page=profile&UserID=$userID&action=editprofile'>Edit Profile Information</a><br>");
	// getUpcomingGames($userID);
}
else
{
	if(isset($_SESSION['UserID']))
	{
		echo "<p class='text-danger'>User does not exist.</p>";
	}
	else
	{
		
	}
}


?>