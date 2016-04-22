<?php

ob_start();

require_once 'login.php';

$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	
if(!$db_server) die("Unable to connect to database: " . mysql_error());	
	
//Select database
mysql_select_db($db_database) or die("Unable to select database" . mysql_error());

// Define $myusername and $mypassword 
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword']; 

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$tbl_name   = 'members';
$sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){

// Register $myusername, $mypassword and redirect to file "login_success.php"
$_SESSION['username'] = $myusername;
$_SESSION['password'] = $mypassword; 

}
else {
echo "Wrong Username or Password<br>";
echo "username: ";
if($mysuername==NULL) {echo 'NULL';} else {echo $myusername;}
echo " password: ";
if($mypassword==NULL) {echo 'NULL';} else {echo $mypassword;}
require "main_login.php";
}

ob_end_flush();
?>
