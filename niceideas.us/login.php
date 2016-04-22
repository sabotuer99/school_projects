<?php
session_start();

switch($_POST['CurLoc']) {
	case  "home":
	$_SESSION['navigate']="home.php','homelink";
	break;
	case "share":
	$_SESSION['navigate']="share.php','sharelink";
	break;
	case "profile":
	$_SESSION['navigate']="profile.php','profilelink";
	break;
	default:
	break;
}

require_once 'db_login.php';

if(isset($_POST['userLogin']) && isset($_POST['loginPwdHash'])){

$user = strtoupper($_POST['userLogin']);
$psw = ucfirst(mysqli_real_escape_string($db_server, strip_tags(trim($_POST['loginPwdHash']))));

$_SESSION['loginMsg'] = "";

$getSalt_sql = 'SELECT salt FROM members WHERE username="'. $user .'"';
$getSalt = mysqli_query($db_server, $getSalt_sql);
$salt = mysqli_fetch_assoc($getSalt);

$message = $psw . $salt['salt'];
$psw = hash("whirlpool", $message);

//$_SESSION['loginMsg'] .= $user . " " . $salt['salt'] . " " . $psw;

$getUser_sql = 'SELECT * FROM members WHERE username="'. $user . '" AND password= "' . $psw . '"';
$getUser = mysqli_query($db_server, $getUser_sql);
$getUser_result = mysqli_fetch_assoc($getUser);
$getUser_RecordCount = mysqli_num_rows($getUser);

if($getUser_RecordCount < 1)	{ 
		$_SESSION['loginMsg'] = 'Login failed...'; //. $getUser_sql;
		header("Location:index.php");
		} 
else { 		
		$_SESSION['auth']=TRUE;
		$_SESSION['firstlast']=$getUser_result['fname']." ".$getUser_result['lname'];
		$_SESSION['id']=$getUser_result['id'];
		$_SESSION['username']=ucfirst(strtolower($user));
		header("Location:index.php");
		}
}
?>
