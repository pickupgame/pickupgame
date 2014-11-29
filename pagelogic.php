<?php 
	if(isset($_SESSION['UserID']))
	{
		if(isset($_GET['rating']))
		{
			include_once('rating.php');
		}
		elseif(isset($_GET['page']))
		{										
			if ($_GET['page'] == 'browse')
			{
				if (isset($_GET['Game_ID']))
				{
					include_once("viewgame.php");
					if(isset($_GET['action']))
					{
						if($_GET['action'] == 'join')
						{
							JoinGame($Game_ID, $_SESSION['UserID']);
						}
						if($_GET['action'] == 'leave')
						{
							kickPlayer($Game_ID, $_SESSION['UserID']);					
						}
					}
				}
				else
				{
					include_once("browse.php");
				}
			}
			elseif ($_GET['page'] == 'home') 
			{
				include_once("home.php");
			}
			elseif($_GET['page'] == 'hostgame')
			{
				include_once('hostgame.php');
			}
			elseif($_GET['page'] == 'login')
			{
				header('Location: ' . 'index.php?page=home');
			}
		}
		else
		{
			include_once("home.php");
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
					include_once("viewgame.php");
				}	
				else
				{
					include_once("browse.php");
				}
			}
			elseif ($_GET['page'] == 'login') {
				include_once('login.php');						
			}
			elseif ($_GET['page'] == 'logout') {
			}
			elseif ($_GET['page'] == 'register') {
				include_once('Register.php');
			}
			elseif ($_GET['page'] == 'forgot') {
				include_once('ForgotPasswordGetUserName.php');
			}
			elseif ($_GET['page'] == 'security')
			{
				include_once('SecurityQuestionAndAnswer.php');
			}
			elseif ($_GET['page'] == 'getpass')
			{
				include_once('GetPassword.php');
			}
			elseif($_GET['page'] == 'hostgame')
			{
				include_once('hostgame.php');
			}
			else
			{
				include_once('login.php');
			}
		}
		else
		{
			include_once('login.php');
		}	
	}
?>