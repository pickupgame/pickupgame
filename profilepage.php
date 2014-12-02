<?php
session_start();
include('db/sql_functions.php');
$_SESSION['UserID']=3;
if(isset($_SESSION['UserID']))
{
	$userID=$_SESSION['UserID'];
	$result=getUserInfo($userID);
	$name=$result["Name"];
	$age=$result["Age"];
	$username=$result["UserName"];
	$imageLocation=$result["ImageLocation"];
	?>
	<table>
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
				print("<th>{$HostRating}/{$TotalHostRates} ({$TotalHostRates} votes)</th>");
			print("</tr>");
			print("<tr>");
				print("<th>Player Rating</th>");
				print("<th>{$PlayerRating}/{$TotalPlayerRates} ({$TotalPlayerRates} votes)</th>");
			print("</tr>");
		print("</thead>");
	print("</table>");
	print("<a href='index.php?page=editprofile'>Edit Profile Information</a><br>");
	getUpcomingGames($userID);
}
else
{
	?>
	<p>You are not logged in! Please click the login button to login and visit your profile</p>
	<?php
}


?>