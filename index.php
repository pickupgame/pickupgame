<?php 
error_reporting(E_ALL);
session_start();
// $profile['UserID'] = "1234";
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
	<title>Pickup Game &copy;</title>
	<link rel="stylesheet" type="text/css" href="main.css" title="main">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-gmaps-latlon-picker.css"/>
	<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css"/>
	<script type="text/javascript" src="javascript/jquery-1.11.1.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>	
	<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="js/jquery-gmaps-latlon-picker.js"></script>
	<script type="text/javascript" src="js/moment.js"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>	
</head>
<body>

<script>
$(function(){
	$('#datetimepicker2').datetimepicker({
         format: 'yyyy/MM/dd hh:mm:ss',
         language: 'en',
     });
	<?php
	//This area changes the display of the page depending on what is included in the URL.
		if(isset($_GET['page']))
		{
			echo "$('#jumbotron-map').hide();";
			echo "$('#map-low').show();";
		}
		else
		{
			echo "$('#map-low').hide();";			
		}
	?>
})
</script>
	
	<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand brand-info" href="index.php">PickUpGame</a>
				<button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse navHeaderCollapse">
				<?php include_once('nav.php'); ?>
			</div>

		</div>
	</nav>


	<div class="container" role="main">
		<?php
		if(!isset($_GET['Game_ID']))
		{
		?>
		<div id="jumbotron-map" class="row">
			<div id="jumbotron" class="jumbotron col-sm-8 text-center">
				<div class="container">
					<h1>Find and join a game locally!</h1>
					<a class="btn btn-primary" href="index.php?page=browse">Get Started Now!</a>
				</div>
			</div>
			<div class="col-sm-4 ">
				<iframe width='410px' height='320px' frameborder='0' style='border:0' scrolling='no' src='simplemap.php'></iframe>
			</div>
		</div>
		<?php
		}
		?>
	
		<div class="row">
			<div class="col-sm-8">
				<div class="panel panel-default">
				  <div class="panel-body">
				    <?php include_once('pagelogic.php'); ?>
				  </div>
				  <div class="panel-footer"></div>
				</div>				
			</div>
			<div id="map-low" class="col-sm-4">
				<?php
					if(isset($_GET['Game_ID']) AND allowedToViewGame($_GET['Game_ID']))
					{
						echo "<iframe width='410px' height='320px' frameborder='0' style='border:0' scrolling='no' src='simplemap.php?Game_ID={$_GET['Game_ID']}'></iframe>";
					}
					else
					{
						echo "<iframe width='410px' height='320px' frameborder='0' style='border:0' scrolling='no' src='simplemap.php'></iframe>";
					}
				?>
			</div>
		</div>

	</div>

	<div class="navbar navbar-inverse navbar-fixed-bottom">
		<div class="container">
			<p class="navbar-text pull-left">PickupGame &copy 2014</p>
		</div>
	</div>

</body>
</html>                                  		

</body>
</html>
