<?php/*
if(!isset($_GET['ajax'])) {
		$navtarget = urlencode(substr($_SERVER['PHP_SELF'],1));
   header('Location: /index.php?navtarget='.$navtarget);
	 }
if($_GET['ajax']!='TRUE') {
		$navtarget = urlencode(substr($_SERVER['PHP_SELF'],1));
   header('Location: /index.php?navtarget='.$navtarget);
	 }*/
?>

<?php
if(!isset($ajax)) {
		$navtarget = urlencode(substr($_SERVER['PHP_SELF'],1));
   header('Location: /index.php?navtarget='.$navtarget);
	 }
if($ajax!='TRUE') {
		$navtarget = urlencode(substr($_SERVER['PHP_SELF'],1));
   header('Location: /index.php?navtarget='.$navtarget);
	 }
?>