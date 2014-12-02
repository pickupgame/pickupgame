<!-- Login.php-->
<?php
// session_start();
include_once('db/sql_functions.php');
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
			$_SESSION["UserID"]=getUserID($Username);
			// die();
			header('Location: index.php?page=home');
			//hide the login stuff since already logged in.
			//die wont work here since index.php contains everything
			echo "<div id='loginform' class='hide'>";
		}
		else
		{
			$username_password_mismatch=true;
			echo "<div id='loginform'>";
		}
	}

}

print("<h1>Login</h1>");
print("<form method = 'post' id= 'submission'>");
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

print( "<p class = 'head'><input class='btn btn-info'  type = 'submit' name = 'submit' value = 'Login'></p></form>");
print("<a class='btn btn-warning btn-xs' href='index.php?page=forgot'>Forgot Password</a>");
print("<a class='btn btn-success btn-xs' href='index.php?page=register'>Register</a>");
print("</form>");

?>
