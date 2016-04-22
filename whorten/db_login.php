<?php  
/*$db_hostname = "WhortenTEST.db.10895460.hostedresource.com";*/
$db_hostname = "50.63.244.203";
$db_database = "WhortenTEST";
$db_username = "WhortenTEST";
$db_password = "DBPASSWORD";

		$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
	
		if(!$db_server) die("Unable to connect to database: " . mysqli_error($db_server));	
	
		/*Select database */
		mysqli_select_db($db_server, $db_database) or die("Unable to select database" . mysqli_error($db_server));
?>
