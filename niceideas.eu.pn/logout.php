<?php
		session_start();
		unset($_SESSION['id']);
		unset($_SESSION['username']);
		unset($_SESSION['firstlast']);
		unset($_SESSION['password']);
		unset($_SESSION['oauth_provider']);
		unset($_SESSION['auth']);
		unset($_SESSION['FbId']);
		unset($_SESSION['FbFirst']);
		unset($_SESSION['FbLast']);
		unset($_SESSION['FbEmail']);
		unset($_SESSION['FbSex']);
		  
		    
		header("Location:index.php") ;    
?>
