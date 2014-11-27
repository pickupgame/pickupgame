<ul class="nav navbar-nav navbar-right">
	<li class="active"><a href="index.php?page=home">Home</a></li>
	<li>
		<?php 
			$status = "login";
			if(isset($_SESSION['UserID']))
			{
				$status = "logout";							
			}
			if($status == "login")
				echo "<a href='index.php?page={$status}'>{$status}</a>";	
			else
			{
				echo "<a href='{$status}.php'>{$status}</a>";
			}
		?>
	</li>
	<li><a href="index.php?page=browse">Browse</a></li>
</ul>