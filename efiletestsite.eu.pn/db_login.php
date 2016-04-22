<?php  // login.php
$db_hostname = "50.63.244.196";
$db_database = "EfileDB";
$db_username = "EfileDB";
$db_password = "Pedestrian@22";

		$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
	
		if(!$db_server) die("Unable to connect to database: " . mysqli_error($db_server));	
	
		//Select database
		mysqli_select_db($db_server, $db_database) or die("Unable to select database" . mysqli_error($db_server));
			
?>