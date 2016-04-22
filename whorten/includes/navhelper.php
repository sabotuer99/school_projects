<?php
session_start();
/**********************************************************
       CODE TO MAKE RELOADS AND DIRECT LINKS BEHAVE
***********************************************************/

if(!isset($_GET['ajax']) && !isset($_POST['ajax'])) {
		$navtarget = urlencode(substr($_SERVER['PHP_SELF'],1));
   header('Location: /index.php?navtarget='.$navtarget);
	 }
if($_GET['ajax']!='TRUE' && $_POST['ajax']!='TRUE') {
		$navtarget = urlencode(substr($_SERVER['PHP_SELF'],1));
   header('Location: /index.php?navtarget='.$navtarget);
	 }
?>