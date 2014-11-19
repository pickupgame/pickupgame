<?php
session_start();
$_SESSION['UserID'] = "1234";
header("Location: index.php");
?>