<?php
session_start();
include('db/sql_functions.php');
if(isset($_SESSION['UserID']))
{
	$userID=$_SESSION['UserID'];
	$result=getUserInfo($userID);
	$name = isset($_POST["name"]) ? $_POST[ "name" ] : $result["Name"];
	$age = isset($_POST["age"]) ? $_POST[ "age" ] : $result["Age"];
	$iserror = false;
	$imagelocation = isset($_POST["imagelocation"]) ? $_POST[ "imagelocation" ] :$result["ImageLocation"];
	$formerrors = array("nameerror"=> false,"ageerror"=> false,"imagelocationerror"=>false);
	$inputlist = array("name"=> "Name","age"=> "Age","imagelocation"=>"Profile Image URL (Optional)");
	if ( isset($_POST["submit"]))
	{
		if($name == "" || (!(preg_match("/^[A-z- ]+$/",$name))))
		{
			$formerrors ["nameerror"] = true;
			$iserror = true;
		}
		if($age == "" || (!(preg_match("/^[0-9]+$/",$age))))
		{
			$formerrors ["ageerror"] = true;
			$iserror = true;
		}
		if(!$iserror)
		{
			UpdateUserInfo($userID, $name, $age, $imagelocation);
			print("<p><span class = 'success'>YOU HAVE SUCCESSFULLY CHANGED YOUR PROFILE INFORMATION</span></p>");	
			print("<p>Please select the following link to ");	
			print("<a href='index.php?page=profilepage'>Return to Profile Page</a></p>");
			die();
		}
	}
	print( "<form method = 'post' action = 'editprofile.php' id= 'submission'>");
	print("<table class=change>");
	foreach($inputlist as $inputname => $inputalt )
	{
		print("<tr>");
		print("<th class='test'>{$inputalt}:</th>");
		print("<th class= 'test'><input type = ");
		print("'text' name = '$inputname' value = '".$$inputname."'>");
		if ($formerrors[($inputname)."error"] == true )
		{
			print("<span class = 'error'>*</span>");
		}
		print("</th>");
		print("</tr>");
	}
	print("</table>");

	if ($iserror)
	{
		print ("<p class = 'error'>Please fix the following areas marked by an *");
	}
	print( "<p class = 'head'><input type = 'submit' name = 'submit' value = 'Save Profile Information'></p></form>");
	print("<a href='index.php?page=profile'>Return to Profile Page: Changes will not be submitted</a><br>");
}
else
{
	?>
	<p class='text-danger'>You are not logged in! Please login to edit your profile</p>
	<?php
}
?>