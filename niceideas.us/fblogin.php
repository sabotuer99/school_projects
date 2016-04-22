<?php
session_start();

require_once 'db_login.php';

if(isset($_POST['FbId'])){

$_SESSION['FbId'] = $_POST['FbId'];
$_SESSION['FbFirst'] = ucwords($_POST['FbFirst']);
$_SESSION['FbLast'] = ucwords($_POST['FbLast']);
$_SESSION['FbEmail'] = $_POST['FbEmail'];
$_SESSION['FbSex'] = ucwords($_POST['FbSex']);
$fbid = $_POST['FbId'];

$getUser_sql = 'SELECT * FROM members WHERE fbid="'.$fbid.'"';
$getUser = mysqli_query($db_server, $getUser_sql);
$getUser_result = mysqli_fetch_assoc($getUser);
$getUser_RecordCount = mysqli_num_rows($getUser);

if($getUser_RecordCount < 1)	{ 
		$_SESSION['linkFb']=TRUE;
		echo "createlink";
		} 
elseif(!isset($_SESSION['auth'])) { 
		$_SESSION['username']=ucfirst(strtolower($getUser_result['username']));
		$_SESSION['firstlast']=$getUser_result['fname']." ".$getUser_result['lname'];
		$_SESSION['id']=$getUser_result['id'];
   $_SESSION['auth']=TRUE;
		echo "reload";
		}
else { echo "default"; }
}
?>
