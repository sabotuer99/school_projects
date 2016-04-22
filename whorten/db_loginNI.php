<?php  // login.php
//$db_hostname = "fdb4.freehostingeu.com";
//$db_database = "1250984_ni";
//$db_username = "1250984_ni";
//$db_password = "sentry5";

$db_hostname = "NiceIdeasDB.db.10895460.hostedresource.com";
$db_database = "NiceIdeasDB";
$db_username = "NiceIdeasDB";
$db_password = "DBPASSWORD";

		$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
	
		if(!$db_server) die("Unable to connect to database: " . mysql_error());	
	
		//Select database
		mysqli_select_db($db_server, $db_database) or die("Unable to select database" . mysql_error());
?>
