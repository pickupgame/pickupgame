<!-- ForgotPasswordGetUserName.php-->
<?php
session_start();
include_once('db/sql_functions.php');
$Username = isset($_POST["Username"]) ? $_POST[ "Username" ] : "";
$iserror=false;
$formerrors = array("Usernameerror"=> false);
$username_notexist=false;
if ( isset($_POST["submit"]))
{
	if ($Username == "" || (!(preg_match("/[A-z]{1}[A-z0-9_]*$/",$Username))))
	{
		$formerrors ["Usernameerror"] = true;
		$iserror=true;
	}
	if (!$iserror)
	{
		if(CheckifUserNameExist($Username))
		{			
			$_SESSION["UserIDforSecurityQuestion"]=getUserID($Username);
			header('Location: index.php?page=security');
			die();
		}
		else
		{
			$username_notexist=true;
		}
	}
}
print("<h1>Forgot Password</h1>");
print( "<form method = 'post' action = 'index.php?page=forgot' id= 'submission'>");
print("<div><label>Username:</label><input type = 'text' name = 'Username' value = {$Username}></div>");
if($formerrors["Usernameerror"])
{
	print("<p class = 'error'>Please enter a Username that begins with letter first</p>");
}
if($username_notexist)
{
	print("<p class = 'error'>The Username Does not Exist</p>");
}
print( "<p class = 'head'><input class='btn btn-info btn-xs' type = 'submit' name = 'submit' value = 'Answer Security Questions'>   </form>");
print("<a class='btn btn-warning btn-xs' href='index.php?page=login'>Return to Login</a><br>");

?>