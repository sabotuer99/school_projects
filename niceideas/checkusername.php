<?php 
session_start();

//get the q parameter from URL
$q=strtoupper($_GET["q"]);

if($q == strtoupper($_SESSION['username'])) 
{
			$response="That's you!";	
}
else
{
			require 'db_login.php';
			$query = 	"SELECT COUNT(*) as matches FROM members WHERE UPPER(username) LIKE '".$q."'";
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
}

//output the response
echo $response;
?>