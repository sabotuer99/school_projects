<?php 
session_start();

unset($_SESSION['message_new']);

foreach ($_POST as $field => $value)
	{
		//Check for blanks
		if ($value == "")
		{
			$blanks[] = $field;				
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
		$_SESSION['message_new'] = "The following fields are blank.
		    Please enter the required information:  ";
		foreach($blanks as $value)
		{
				$_SESSION['message_new'] .= "$value, ";		
		}
}

if(@is_array($errors)) 
{
		foreach($errors as $value)
		{
				$_SESSION['message_new'] .= $value;	
		}
		
		$_SESSION['message_new'] .= "Please try again. <br>";
}

if(isset($blanks) || @is_array($errors) ) 
{
		$_SESSION['navigate']="profile.php','profilelink";
		header('Location:index.php');			
}

	require 'db_login.php';

	//Clean data

	$patt = "/^[^\w\d\.\?!_-]$/i";
	$username_insert = preg_replace($patt, "" ,$_POST['username'], $flags = null);  
	
//	$username_insert = ucfirst(mysqli_real_escape_string($db_server, strip_tags(trim($_POST['username']))));
	$fname_insert = ucfirst(mysqli_real_escape_string($db_server, strip_tags(trim($_POST['fname']))));
	$lname_insert = ucfirst(mysqli_real_escape_string($db_server, strip_tags(trim($_POST['lname']))));
	$email_insert = mysqli_real_escape_string($db_server, strip_tags(trim($_POST['email'])));
	$gender_insert = ucfirst(mysqli_real_escape_string($db_server, strip_tags(trim($_POST['gender']))));
	$pwdHash_insert = ucfirst(mysqli_real_escape_string($db_server, strip_tags(trim($_POST['pswHash']))));
	$fbId_insert = ucfirst(mysqli_real_escape_string($db_server, strip_tags(trim($_SESSION['FbId']))));

	//Rehash password with random salt
	$salt = rand(100000000, 999999999);
	$message = $pwdHash_insert . $salt;
	$pwdHash_insert = hash("whirlpool", $message);

	$fields = array(
					'0' => 'username', 
					'1' => 'fname',
					'2' => 'lname',
					'3' => 'email', 
					'4' => 'gender', 
					'5' => 'password',
					'6' => 'fbid',
					'7' => 'salt');
	$values = array(
					'0' => $username_insert,
					'1' => $fname_insert, 
					'2' => $lname_insert, 
					'3' => $email_insert, 
					'4' => $gender_insert, 
					'5' => $pwdHash_insert, 
					'6' => $fbId_insert, 
					'7' => $salt);
	//Check for duplicate username

	$query 		= 	"SELECT COUNT(*) as matches FROM members WHERE username LIKE '".$username_insert."'";
	$result 	= 	mysqli_query($db_server, $query);

	$row = mysqli_fetch_assoc($result);

	if (!$row['matches'] == "0")
	  {
	  $errors[]="Username not available.";
	  }
	else
	  {
			//	Add new user	  
	  $today = date("Y-m-d");
	  $fields_str = implode(",", $fields);
	  $values_str = implode('","',$values);
	  $fields_str .= ",createDate";
	  $values_str .= '"'.",".'"'.$today;
	  
	  $sql  = "INSERT INTO members ";
	  $sql .= "(".$fields_str.")";
	  $sql .= " VALUES ";
	  $sql .= "(".'"'.$values_str.'"'.")";
	  
	  $result = mysqli_query($db_server, $sql) 
	  							or die("Couldn't execute insert query: ".$sql);
	  							
	  $_SESSION['auth'] = TRUE;
	  $_SESSION['logname'] = $username_insert;
	  header('Location:index.php');		
	  }

if(@is_array($errors) ) 
{
		$_SESSION['navigate']="profile.php','profilelink";
		header('Location:index.php');			
}

?>