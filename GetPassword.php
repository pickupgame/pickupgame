<!-- GetPassword.php-->
<?php
session_start();
include('sql_functions.php');
$UserID = isset($_SESSION["UserIDforPasswordGet"]) ? $_SESSION[ "UserIDforPasswordGet" ] : "";
$Password= getPassword(getUserName($UserID));
print("<h1>Forgot Password</h1>");
print("<h3>Your Password is:</h3>");
print("<h3>{$Password}</h3>");
print("<form action= 'login.php'>");
print("<input type = 'submit' value='Return To Login'></p>");
print("</form>");
?>