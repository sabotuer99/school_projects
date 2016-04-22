<?php 
session_start();
if($_SESSION['auth']==1) {
	$_SESSION['navigate']="share.php','sharelink";
	require_once 'shareIdea.php';
}
else {
	echo "<span class='grid_20' id='pleaselogin'>Please log in to share ideas!</span>";
	}
	
?>