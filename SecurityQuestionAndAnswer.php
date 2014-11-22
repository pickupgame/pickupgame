<!-- SecurityQuestionAndAnswer.php-->
<?php
session_start();
include('sql_functions.php');
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
		print(getSecurityAnswer($UserID));
		if(getSecurityAnswer($UserID)==$SecurityAnswer)
		{
			$_SESSION["UserIDforPasswordGet"]=$UserID;
			header('Location: GetPassword.php');
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
print( "<form method = 'post' action = 'SecurityQuestionAndAnswer.php' id= 'submission'>");
print("<div><label>Question:</label><input type = 'text' name = '' value = '");
print(htmlspecialchars($SecurityQuestion, ENT_QUOTES));
print("' disabled></div>");
print("<div><label>Answer:</label><input type = 'text' name = 'SecurityAnswer' value = {$SecurityAnswer}></div>");
if($formerrors["SecurityAnswererror"])
{
	print("<p class = 'error'>Please enter a Security Answer</p>");
}
if($SecurityAnswerIncorrect)
{
	print("<p class = 'error'>The Security Question and Answer Do Not Match: Please Try Again</p>");
}
print( "<p class = 'head'><input type = 'submit' name = 'submit' value = 'Validate'>   </form>");
print("<form action= 'login.php'>");
print("<input type = 'submit' value='Return To Login'></p>");
print("</form>");
?>