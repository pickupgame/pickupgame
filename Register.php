<!-- Register.php-->
<?php
print("<h2>Registration Information</h2>");
include('db/sql_functions.php');
session_start();
$name = isset($_POST["name"]) ? $_POST[ "name" ] : "";
$age = isset($_POST["age"]) ? $_POST[ "age" ] : "";
$username = isset($_POST["username"]) ? $_POST[ "username" ] : "";
$password = isset($_POST["password"]) ? $_POST[ "password" ] : "";
$securityquestion = isset($_POST["securityquestion"]) ? $_POST[ "securityquestion" ] : "";
$securityanswer = isset($_POST["securityanswer"]) ? $_POST[ "securityanswer" ] : "";
$imagelocation = isset($_POST["imagelocation"]) ? $_POST[ "imagelocation" ] : "";
$iserror = false;
$useridalreadyexist = false;
$formerrors = array("nameerror"=> false,"ageerror"=> false,"usernameerror"=>false,"passworderror"=>false,
					"securityquestionerror"=>false,"securityanswererror"=>false,"imagelocationerror"=>false);
$inputlist = array("name"=> "Name","age"=> "Age","username"=>"User Name","password"=>"Password",
					"securityquestion"=>"Security Question","securityanswer"=>"Security Answer","imagelocation"=>"Profile Image URL (Optional)");
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
	if($username == "" || (!(preg_match("/[A-z][a-zA-Z0-9@.]*$/",$username))))
	{
		$formerrors ["usernameerror"] = true;
		$iserror = true;
	}
	if($password == "")
	{
		$formerrors ["passworderror"] = true;
		$iserror = true;
	}
	if($securityquestion == "")
	{
		$formerrors ["securityquestionerror"] = true;
		$iserror = true;
	}
	if($securityanswer == "")
	{
		$formerrors ["securityanswererror"] = true;
		$iserror = true;
	}
	if($formerrors ["usernameerror"] == false)
	{
		if(CheckifUserNameExist($username))
		{
			$formerrors ["usernameerror"]=true;
			$useridalreadyexist=true;
			$iserror=true;
		}
	}
	if(!$iserror)
	{
		InsertNewUser($name, $age, $username, $password, $securityquestion, $securityanswer, $imagelocation);
		print("<p><span class = 'success'>YOU HAVE SUCCESSFULLY REGISTERED</span></p>");	
		print("<p>Please select the following link to the login page where you can successfully register</p>");	
		print("<form action= 'index.php?page=login'>");
		print("<input type = 'submit' value='Return To Login'></p>");
		print("</form>");
		die();
	}
}
print("<form method = 'post' id= 'submission'>");
print("<table class=change>");
foreach($inputlist as $inputname => $inputalt )
{
	print("<tr>");
	print("<th class='test'>{$inputalt}:</th>");
	print("<th class= 'test'><input type = ");
	if ($inputalt=="Password")
	{
		print("'password' name = '$inputname' value = '".$$inputname."'>");
	}
	else
	{
		print("'text' name = '$inputname' value = '".$$inputname."'>");
	}
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
if ($useridalreadyexist)
{
	print ("<p class = 'error'>User Name Already Exist</p>");
}
print( "<p class = 'head'><input type = 'submit' name = 'submit' value = 'Register'></p></form>");
print("<a href='index.php?page=login'>Return to Login</a><br>");
?>