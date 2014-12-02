<!-- SecurityQuestionAndAnswer.php-->
<?php
session_start();
include_once('db/sql_functions.php');
$UserID = isset($_SESSION["UserIDforSecurityQuestion"]) ? $_SESSION[ "UserIDforSecurityQuestion" ] : "";
$SecurityQuestion= getSecurityQuestion($UserID);
$SecurityAnswer = isset($_POST["SecurityAnswer"]) ? $_POST[ "SecurityAnswer" ] : "";
$iserror=false;
$formerrors = array("SecurityAnswererror"=> false);
$SecurityAnswerIncorrect=false;
if ( isset($_POST["submit"]))
{
	if ($SecurityAnswer == "")
	{
		$formerrors ["SecurityAnswererror"] = true;
		$iserror=true;
	}
	if (!$iserror)
	{
		if(getSecurityAnswer($UserID)==$SecurityAnswer)
		{
			$_SESSION["UserIDforPasswordGet"]=$UserID;
			header('Location: index.php?page=getpass');
			die();
		}
		else
		{
			$SecurityAnswerIncorrect=true;
		}
	}
}
print("<h1>Forgot Password</h1>");
print("<h2>Enter Security Answer</h2>");
print( "<form method = 'post' id= 'submission'>");
print("<table class='table'><tr><td><label>Question:</label></td><td><input type = 'text' name = '' value = '");
print(htmlspecialchars($SecurityQuestion, ENT_QUOTES));
print("'disabled></td></tr></table>");
print("<table class='table'><tr><td><label>Answer:</label></td><td><input type = 'text' name = 'SecurityAnswer' value = {$SecurityAnswer}></td></tr></table>");
if($formerrors["SecurityAnswererror"])
{
	print("<p class = 'error'>Please enter a Security Answer</p>");
}
if($SecurityAnswerIncorrect)
{
	print("<p class = 'error'>The Security Question and Answer Do Not Match: Please Try Again</p>");
}
print( "<p class = 'head'><input class='btn btn-info btn-xs' type = 'submit' name = 'submit' value = 'Validate'>   </form>");
print("<form action= 'index.php?page=security'>");
print("<input class='btn btn-warning btn-xs' type = 'submit' value='Return To Login'></p>");
print("</form>");
?>