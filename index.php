<?php 
error_reporting(E_ALL);
session_start();
$profile['UserID'] = "1235";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
	<title>Pickup Game &copy;</title>
	<link rel="stylesheet" type="text/css" href="main.css" title="main">
</head>
<body>
	[body]
	<div id="container">
		[container]
		<div id="map">
			[map goes here]
		</div>
		<div id="header">
			[header]
			<div id="logo">
				[logo]
			</div>

			<div id="navigation">
				<!-- navigation -->
				<ul>
					<li><a href="index.php?page=home">Home</a></li>
					<li>
						<?php 
							$status = "login";
							if(isset($_SESSION['UserID']))
							{
								$status = "logout";							
							}
							echo "<a href='{$status}.php'>{$status}</a>";
						?>
					</li>
					<li><a href="index.php?page=browse">Browse</a></li>
				</ul>
			</div>

		</div>

		<div id="content">
			[content]
			<div id="dynamic_content">
				<p>[dynamic]</p>
				<div id="dynamic_left">
					[dynamic left]
					<div id="rateUserUp">
						<?php 
						if(isset($profile['UserID']))
						{
							include('rateuser.php');
						}
					?>
					</div>
				</div>
				<div id="dynamic_right">
					[dynamic right]
				</div>
			</div>
		</div>

		<div id="right">
			[right]
			<div id="calendar">
				[calendar goes here]
			</div>
		</div>

		<div id="footer">
			[footer]
		</div>
	</div>

</body>
</html>