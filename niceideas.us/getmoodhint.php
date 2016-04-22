<?php 
session_start();
if($_SESSION['auth']!=1) {
	$_SESSION['navigate']="home.php','homelink";
	header("Location:index.php");
	}

//get the q parameter from URL
$q=$_GET["q"];
	
	require 'db_login.php';
	$query = 	"SELECT * FROM MOODS WHERE Mood LIKE '".$q."%'";
	$result = 	mysqli_query($db_server, $query);
	$hint="";
	$response="...";
	
	for ($i=0; $row = mysqli_fetch_assoc($result); $i++)
	{	
		 if ($hint=="")
        {
        $hint=$row["Mood"];
        }
      else
        {
        $hint=$hint." , ".$row["Mood"];
   			}
	}

if ($hint == "")
  {
  $response="no suggestion";
  }
else
  {
  $response=$hint;
  }

//output the response
echo $response;
?>