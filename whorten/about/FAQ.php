<?php 
/********************************************************
	This section checks to make sure the path to the 
	include file exists, then drops it in
*********************************************************/
session_start();
$path = $_SERVER['DOCUMENT_ROOT'].'/includes';
if(file_exists($path)) 
{
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/includes.php';	
}
else 
{
	require_once $_SERVER['DOCUMENT_ROOT'].'/whorten/includes/includes.php';	
}
//End include code
?>

<?php 
include 'PGSsim.php';
?>