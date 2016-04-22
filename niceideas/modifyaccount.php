<?php 
session_start();

if($_SESSION['auth']!=1) {
	$_SESSION['navigate']="home.php','homelink";
	header("Location:index.php");
	}

require_once 'db_login.php';

$user = strtoupper($_SESSION['username']);
$psw = ucfirst(mysqli_real_escape_string($db_server, strip_tags(trim($_POST['oldpwdHash']))));

$_SESSION['editMsg'] = "";

$getSalt_sql = 'SELECT salt FROM members WHERE UPPER(username)="'. $user .'"';
$getSalt = mysqli_query($db_server, $getSalt_sql);
$salt = mysqli_fetch_assoc($getSalt);


$message = $psw . $salt['salt'];
$psw = hash("whirlpool", $message);
$getUser_sql = 'SELECT * FROM members WHERE UPPER(username)="'. $user . '" AND password= "' . $psw . '"';
$getUser = mysqli_query($db_server, $getUser_sql);
$getUser_result = mysqli_fetch_assoc($getUser);
$getUser_RecordCount = mysqli_num_rows($getUser);

if($getUser_RecordCount < 1)	{ 
		$_SESSION['editMsg'] = 'Invalid Password'; //. $getUser_sql;
		$_SESSION['navigate']="profile.php','profilelink";
		header("Location:index.php");
		} 


unset($_SESSION['editMsg']);

foreach ($_POST as $field => $value)
	{
		//Check for blanks
		if ($value == "" && $field != "pswHash")
		{
			if($field != "oldpwdHash") 
			{
			$blanks[] = $field;	
			}
			else 
			{
			$blanks[] = "Current Password";	
			}
						
		}		
		
		//Validate
		if(!empty($value)) 
		{
			if(preg_match("/fname/i", $field) || preg_match("/lname/i", $field) ) 
			{
				if(!preg_match("/^[A-Za-z' -]{1,50}$/", $value)) 
				{
					$errors[]="$value is not a valid name.";
				}
			}
			
			if(preg_match("/pswHash/i", $field) ) 
			{
				if(!preg_match("/^[a-f0-9]{128}$/", $value)) 
				{
					$errors[]="$value is not a valid hash.";
				}
			}
			
			if(preg_match("/email/i", $field)) 
			{
				if(!preg_match("/^.+@.+\\..+$/", $value)) 
				{
					$errors[]="$value is not a valid email address.";
				}
			}	
			
			if(preg_match("/username/i", $field)) 
			{
				$usrlength = strlen($value);
				$patt = "/^[\w\d\.\?!_-]{".$usrlength."}$/i";
				if(!preg_match($patt, $value)) 
				{
					$errors[]="$value is not a valid username. $usrlength $patt";
				}
			}				
						
		}		
	}

if(isset($blanks))
{
		$_SESSION['editMsg'] = "The following fields are blank.
		    Please enter the required information:  ";
		foreach($blanks as $value)
		{
				$_SESSION['editMsg'] .= "$value, ";		
		}
}

if(@is_array($errors)) 
{
		foreach($errors as $value)
		{
				$_SESSION['editMsg'] .= $value;	
		}
		
		$_SESSION['editMsg'] .= "Please try again. <br>";
}

if(isset($blanks) || @is_array($errors) ) 
{
		$_SESSION['navigate']="profile.php','profilelink";
		header('Location:index.php');			
}

	require 'db_login.php';

	//Clean data

	$patt = "/^[^\w\d\.\?!_-]$/i";
	$username_insert = preg_replace($patt, "" ,$_POST['usernameClean'], $flags = null);  
	
//	$username_insert = ucfirst(mysqli_real_escape_string($db_server, strip_tags(trim($_POST['username']))));
	$fname_insert = ucfirst(mysqli_real_escape_string($db_server, strip_tags(trim($_POST['fname']))));
	$lname_insert = ucfirst(mysqli_real_escape_string($db_server, strip_tags(trim($_POST['lname']))));
	$email_insert = mysqli_real_escape_string($db_server, strip_tags(trim($_POST['email'])));
	$gender_insert = ucfirst(mysqli_real_escape_string($db_server, strip_tags(trim($_POST['gender']))));

	if($_POST['pswHash']!="") 
	{
		$pwdHash_insert = ucfirst(mysqli_real_escape_string($db_server, strip_tags(trim($_POST['pswHash']))));
	}
	else 
	{	
		$pwdHash_insert = ucfirst(mysqli_real_escape_string($db_server, strip_tags(trim($_POST['oldpwdHash']))));	
	}	
		
//	$fbId_insert = ucfirst(mysqli_real_escape_string($db_server, strip_tags(trim($_SESSION['FbId']))));

	//Rehash password with random salt
	$salt = rand(100000000, 999999999);
	$message = $pwdHash_insert . $salt;
	$pwdHash_insert = hash("whirlpool", $message);

/*
	$fields = array(
					'0' => 'username', 
					'1' => 'fname',
					'2' => 'lname',
					'3' => 'email', 
					'4' => 'gender', 
					'5' => 'password',
					'6' => 'salt');
//				'7' => 'fbid');
	$values = array(
					'0' => $username_insert,
					'1' => $fname_insert, 
					'2' => $lname_insert, 
					'3' => $email_insert, 
					'4' => $gender_insert, 
					'5' => $pwdHash_insert, 
					'6' => $salt);
//				'7' => $fbId_insert);
	//Check for duplicate username
*/

	$query 		= 	"SELECT COUNT(*) as matches FROM members WHERE username LIKE '".$username_insert."'";
	$result 	= 	mysqli_query($db_server, $query);

	$row = mysqli_fetch_assoc($result);

	if (!$row['matches'] == "0" && (strtoupper($username_insert) != strtoupper($_SESSION['username'])))
	  {
	  $errors[]="Username not available.";
	  }
	else
	  {
			//	MODIFY USER	  
	  $today = date("Y-m-d");
	  /*
	  $fields_str = implode(",", $fields);
	  $values_str = implode('","',$values);
	  $fields_str .= ",createDate";
	  $values_str .= '"'.",".'"'.$today;
	  */
	  
	  $sql  = "UPDATE members SET ";
	  $sql .= "username = ".'"'.$username_insert.'", ';
	  $sql .= "fname = ".'"'.$fname_insert.'", ';
	  $sql .= "lname = ".'"'.$lname_insert.'", ';
	  $sql .= "email = ".'"'.$email_insert.'", ';
	  $sql .= "gender = ".'"'.$gender_insert.'", ';
	  $sql .= "password = ".'"'.$pwdHash_insert.'", ';
	  $sql .= "salt = ".'"'.$salt.'" ';
	  $sql .= " WHERE UPPER(username) LIKE '". strtoupper($_SESSION['username']) ."'";
	  $_SESSION['DEBUG']=$sql;
	  
	  $result = mysqli_query($db_server, $sql) 
	  							or die("Couldn't execute insert query: ".$sql);
	  							
		$_SESSION['auth']=TRUE;
		$_SESSION['fname']=$fname_insert;
		$_SESSION['lname']=$lname_insert;
		$_SESSION['email']=$email_insert;
		$_SESSION['gender']=$gender_insert;
		$_SESSION['firstlast']=$fname_insert." ".$lname_insert;
		$_SESSION['username']=$username_insert;
	  header('Location:index.php');		
	  }

if(@is_array($errors) ) 
{
		$_SESSION['DEBUG']= implode(",", $errors);
		$_SESSION['navigate']="profile.php','profilelink";
		header('Location:index.php');			
}

?>