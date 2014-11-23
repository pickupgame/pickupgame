<!-- ForgotPasswordGetUserName.php-->
<?php
session_start();
include('db/sql_functions.php');
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
			header('Location: SecurityQuestionAndAnswer.php');
			die();
		}
		else
		{
			$username_notexist=true;
		}
	}
}
print("<h1>Forgot Password</h1>");
print( "<form method = 'post' action = 'ForgotPasswordGetUserName.php' id= 'submission'>");
print("<div><label>Username:</label><input type = 'text' name = 'Username' value = {$Username}></div>");
if($formerrors["Usernameerror"])
{
	print("<p class = 'error'>Please enter a Username that begins with letter first</p>");
}
if($username_notexist)
{
	print("<p class = 'error'>The Username Does not Exist</p>");
}
print( "<p class = 'head'><input type = 'submit' name = 'submit' value = 'Answer Security Questions'>   </form>");
print("<form action= 'login.php'>");
print("<input type = 'submit' value='Return To Login'></p>");
print("</form>");
?>