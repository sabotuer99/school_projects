<?php 
session_start();
if($_SESSION['auth']!=1) {
	$_SESSION['navigate']="home.php','homelink";
	header("Location:index.php");
	}
	else {
		require_once 'db_login.php';
	}
	
?>