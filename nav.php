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

