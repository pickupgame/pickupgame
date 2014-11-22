<html>
	<head>
		<meta charset = "utf-8">
		<link rel = "stylesheet" type= "text/css" href = "index.css">
		<title>Forgot Password</title>
	</head>
	<body>
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
	</body>
</html>