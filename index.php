<?php 
error_reporting(E_ALL);
session_start();
// $profile['UserID'] = "1234";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
	<title>Pickup Game &copy;</title>
	<link rel="stylesheet" type="text/css" href="main.css" title="main">

<script src="javascript/jquery-1.11.1.js"></script>
</head>
<body>
<script>
$(function(){
	<?php
	//This area changes the display of the page depending on what is included in the URL.
		if(isset($_GET['page']))
		{
			if($_GET['page'] == 'browse')
			{
				
				echo "$('#dynamic_right').toggle();";
				echo "$('#dynamic_left').css('width', '940px');";
			}
			if($_GET['page'] == 'browse')
			{
				//display search results with " " as parameter
				// echo "$('#dynamic_left').load('browse.php');";
				if(isset($_GET['Game_ID']))
				{
					//browsing a game
					//only js we need is to hide the divs that arent necessary
					// echo "$('#dynamic_left').load('gameplayers.php', { Game_ID : '{$_GET['Game_ID']}' });";
				}
			}	
		}
	?>
})
</script>
	[body]
	
	<div id="container">
		[container]
		<div id="map">
			[map goes here]
		</div>
		<div id="header">
			[header]<br>
			<div id="logo">
				[logo]
			</div>

			<div id="navigation">
				<!-- navigation -->
				<?php include('nav.php'); ?>
			</div>
		<div id="clear"></div>
		</div>

		<div id="content">
			[content]
			<div id="dynamic_content">
				<p>[dynamic]</p>
				<div id="dynamic_left">
					<!-- [dynamic left] -->					
					<?php 
						if(isset($_SESSION['UserID']))
						{
							if(isset($_GET['page']))
							{							
								if ($_GET['page'] == 'browse')
								{
									if (isset($_GET['Game_ID']))
									{
										include("gameplayers.php");
									}
									else
									{
										include("browse.php");
									}
								}

								if ($_GET['page'] == 'home') 
								{
									include("home.php");
								}
							}
						}
						else
						{
							if(isset($_GET['page']))
							{							
								if ($_GET['page'] == 'browse')
								{
									if (isset($_GET['Game_ID']))
									{
										include("gameplayers.php");
									}	
									else
									{
										include("browse.php");
									}
								}
								else
								{
									include('loginform.php');
								}
							}
							else
							{
								include('loginform.php');
							}	
						}
					?>
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