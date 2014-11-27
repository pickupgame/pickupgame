<?php 
error_reporting(E_ALL);
session_start();
// $profile['UserID'] = "1234";
?>
<!DOCTYPE html>
<html>
<head>
	<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
	<title>Pickup Game &copy;</title>
	<link rel="stylesheet" type="text/css" href="main.css" title="main">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

<script src="javascript/jquery-1.11.1.js"></script>
<script src="js/bootstrap.min.js"></script>

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
	
	<div class="navbar navbar-inverse navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php">PickUpGame</a>
				<button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse navHeaderCollapse">
				<?php include('nav.php'); ?>
			</div>

		</div>
	</div>


	<div class="container" role="main">

	<div class="row">
		<div class="jumbotron col-sm-8 text-center">
			<h1>Find and join sports locally!</h1>
			<a class="btn btn-default">Get Started Now!</a>
		</div>
		<div class="col-sm-4">
			<iframe id="map-canvas" width="300" height="300" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/view?zoom=12&center=42.3223%2C-83.1763&key=AIzaSyCmc2khtUV2DTgUpcyYjpHLXrLE_YMVl_s"></iframe>
		</div>
	</div>
	

		<div class="row">
			<div class="col-sm-8">
				<div class="panel panel-default">
				  <div class="panel-body">
				    <?php include('pagelogic.php'); ?>
				  </div>
				  <div class="panel-footer">Panel footer</div>
				</div>				
			</div>
			<div class="col-sm-4">
				stuff on the right
			</div>
		</div>

	</div>


	<div class="navbar navbar-inverse navbar-fixed-bottom">

		<div class="container">

			<p class="navbar-text pull-left">Site Built by Derp</p>
			<a class="navbar-btn btn btn-danger pull-right">Subscribe on Youtube</a>

		</div>

	</div>
</body>
</html>                                  		

</body>
</html>
