<?php
session_start();
//Always place this code at the top of the Page

$_SESSION['navigate']="profile.php','profilelink";


		
		if($_SESSION['auth']==1 && !$_SESSION['linkFB']==TRUE) {		
			require 'editprofile.php';
			}
		else {
			require 'linkfb.php';
		 }
		
?>
	