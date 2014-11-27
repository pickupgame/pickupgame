<?php
//home page
include('db/sql_functions.php');

$user = getPlayerDetails($_SESSION['UserID']);

echo "Welcome {$user['UserName']}!";

?>
