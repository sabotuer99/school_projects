<?php
session_start();
/**********************************************************
       CODE TO MAKE RELOADS AND DIRECT LINKS BEHAVE
***********************************************************/

if(!isset($_GET['ajax'])) {
		$navtarget = urlencode(substr($_SERVER['PHP_SELF'],1));
   header('Location: /index.php?navtarget='.$navtarget);
	 }
if($_GET['ajax']!='TRUE') {
		$navtarget = urlencode(substr($_SERVER['PHP_SELF'],1));
   header('Location: /index.php?navtarget='.$navtarget);
	 }

/**********************************************************
       CHECK IS USER IS AUTHORIZED, IF NOT SEND 'HOME'
***********************************************************/
if($_SESSION['auth']!=true || $_SESSION['perm_Contributor']!=true) {
	$navtarget = urlencode('home/home.php');
	?>
	You must be logged in and possess specific permission to view this page. Redirecting in <span id="countdown">5</span>
	<div id="runscript">
		<script type="text/javascript">
			
				var timer = 5,
				    el = document.getElementById('countdown');
				
				(function t_minus() {
				    'use strict';
				    el.innerHTML = timer--;
				    if (timer >= 0) {
				        setTimeout(function () {
				            t_minus();
				        }, 1000);
				    } else {
				        // do stuff, countdown has finished.  
				        navigate('home/home.php'); 
				    } 
				}());  
		</script>
	</div> 	
	
	<?php  
   die();   
	}  
/********************************************************** 
       END VALIDATION, BEGIN CONTENT
***********************************************************/ 	
?>