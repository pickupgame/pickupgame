<ul class="nav navbar-nav navbar-right">
	<li class="active"><a href="index.php?page=home">Home</a></li>
	<?php 
		$status = "login";
		$profile = "profile";
		if(isset($_SESSION['UserID']))
		{
			$status = "logout";
			$profile = "editprofile";
		}
		if($status == "login")
		{
			echo "<li><a href='index.php?page={$status}'>{$status}</a></li>";
			echo "<li><a href='index.php?page={$profile}'>Profile</a></li>";
		}
		elseif($status == 'logout')
		{
			echo "<li><a href='{$status}.php'>{$status}</a></li>";
			echo "<li><a href='index.php?page=profile&UserID={$_SESSION['UserID']}'>Profile</a></li>";
			echo "<li><a href='index.php?page=hostgame'>Host a Game</a></li>";
		}
	?>
	<li><a href="index.php?page=browse">Browse</a></li>
</ul>