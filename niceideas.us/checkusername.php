<?php 
session_start();

//get the q parameter from URL
$q=$_GET["q"];
	
	require 'db_login.php';
	$query = 	"SELECT COUNT(*) as matches FROM members WHERE username LIKE '".$q."'";
	$result = 	mysqli_query($db_server, $query);
	$hint="";
	
	$row = mysqli_fetch_assoc($result);


if ($row['matches'] == "0")
  {
  $response="Available!";
  }
else
  {
  $response="Not available, sorry...";
  }

//output the response
echo $response;
?>