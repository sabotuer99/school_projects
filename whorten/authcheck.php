<?php
session_start();
/**********************************************************
       CHECK IS USER IS AUTHORIZED, IF NOT SEND 'HOME'
***********************************************************/

/*First, check for folder level permissions */
$folder = substr($_SERVER['PHP_SELF'],1,strpos($_SERVER['PHP_SELF'], '/', $offset = 1)-1);
$noperm = false;

if($folder == 'contributors') 
{
	$noperm = $_SESSION['auth']!=true || $_SESSION['perm_Contributor']!=true;
}

if($folder == 'mywhorten') 
{
	$noperm = $_SESSION['auth']!=true;
	
	/* Create permission exception so that rubric sim works right */
	if("/mywhorten/submitmarks.php" == $_SERVER['PHP_SELF']) 
	{
			$noperm = $_POST['subID'] != 'sim';
	}
}

if($folder == 'administration') 
{
	$noperm = $_SESSION['auth']!=true || $_SESSION['perm_Admin']!=true;
}

/*If user is not authorized to view this page, send them 'home'*/
if($noperm) {
	$navtarget = urlencode('home/home.php');
	
	if (isset($_SESSION['auth']) ? !$_SESSION['auth']==true : true) 
	{
		session_unset();
		session_destroy();
		session_write_close();
		setcookie(session_name(),'',0,'/');
		session_regenerate_id(true); 
	}
	
	?>
	You must be logged in and possess specific permission to view this page. Redirecting in <span id="countdown">5</span>
	<div id="runscript">
		<script type="text/javascript" >
			reloadNav();
			login('default');
		</script>
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
				        /* do stuff, countdown has finished.   */
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