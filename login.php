<!-- Login.php-->
<?php
session_start();
include('sql_functions.php');
$Username = isset($_POST["Username"]) ? $_POST[ "Username" ] : "";
$Password = isset($_POST["Password"]) ? $_POST[ "Password" ] : "";
$iserror=false;
$username_password_mismatch=false;
$formerrors = array("Usernameerror"=> false,"Passworderror" => false);
if ( isset($_POST["submit"]))
{
	if ($Username == "" || (!(preg_match("/[A-z]{1}[A-z0-9_]*$/",$Username))))
	{
		$formerrors ["Usernameerror"] = true;
		$iserror=true;
	}
	if ($Password == "" )
	{
		$formerrors ["Passworderror"] = true;
		$iserror=true;
	}
	if (!$iserror)
	{
		if($Password==getPassword($Username))
		{

			print("<p><span class = 'success'>YOU HAVE SUCCESSFULLY LOGGED INTO THE SYSTEM!</span></p>");
			print("<p><span class = 'success'>Please click the link below to continue to use our system</span></p>");
			print("<form action= 'http://google.com'>");
			print("<input type = 'submit' value='Continue'>");
			print("</form>");
			$_SESSION["UserID"]=getUserID($Username);
			die();
		}
		else
		{
			$username_password_mismatch=true;
		}
	}

}
print("<h1>Login</h1>");
print( "<form method = 'post' action = 'login.php' id= 'submission'>");
print("<div><label>Username:</label><input type = 'text' name = 'Username' value = {$Username}></div>");
print("<div><label>Password:</label><input type = 'password' name = 'Password' value = {$Password}></div>");
if($formerrors["Usernameerror"])
{
	print("<p class = 'error'>Please enter a Username that begins with letter first</p>");
}
if($formerrors["Passworderror"])
{
	print("<p class = 'error'>Please enter a Password into the Password Field</p>");
}
if($username_password_mismatch)
{
	print("<p class = 'error'>The username and passwords do not match in our system</p>");
}
print( "<p class = 'head'><input type = 'submit' name = 'submit' value = 'Login'></p></form>");
print("<form action= 'ForgotPasswordGetUserName.php'>");
print("<input type = 'submit' value='Forgot Password'>");
print("</form>");
print("<form action= 'Register.php'>");
print("<input type = 'submit' value='Register'>");
print("</form>");
?>