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
									elseif ($_GET['page'] == 'login') {
										include('login.php');						
									}
									elseif ($_GET['page'] == 'logout') {
									}
									elseif ($_GET['page'] == 'register') {
										include('Register.php');
									}
									elseif ($_GET['page'] == 'forgot') {
										include('ForgotPasswordGetUserName.php');
									}
									elseif ($_GET['page'] == 'security')
									{
										include('SecurityQuestionAndAnswer.php');
									}
									elseif ($_GET['page'] == 'getpass')
									{
										include('GetPassword.php');
									}
									elseif($_GET['page'] == 'hostgame')
									{
										include('hostgame.php');
									}
									else
									{
										include('login.php');
									}
								}
								else
								{
									include('login.php');
								}	
							}
						?>