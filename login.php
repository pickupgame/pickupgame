<?php
session_start();
$_SESSION['UserID'] = "123";
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>

