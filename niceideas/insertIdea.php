<?php 
session_start();
if($_SESSION['auth']!=1) {
	$_SESSION['navigate']="home.php','homelink";
	header("Location:index.php");
	}

	require 'db_login.php';
	
unset($_SESSION['message_idea']);
$fields = array();
$values = array();


foreach ($_GET as $field => $value)
	{
		//Check for blanks
		if ($value == "" && $field!="option")
		{
			$blanks[] = $field;				
		}		
		
		if($field!="mood")
		{
		$fields[] = mysqli_real_escape_string($db_server, strip_tags(trim($field)));
				if($field!="ideatext")
				{		
						switch(strtoupper(mysqli_real_escape_string($db_server, strip_tags(trim($value))))) 
						{
							case "BOTH":
									$values[] = 2;
									break;
							case "GUY":
									$values[] = 1;
									break;
							case "GAL":
									$values[] = 0;
									break;	
							case "SAY":
									$values[] = 0;
									break;
							case "DO":
									$values[] = 1;
									break;
							case "GIFT":
									$values[] = 2;
									break;
							case "THISWEEK":
									$values[] = 0;
									break;
							case "THISMONTH":
									$values[] = 1;
									break;					
							case "THISSEASON":
									$values[] = 2;
									break;
							case "THISYEAR":
									$values[] = 3;
									break;										
							case "LIFETIME":
									$values[] = 4;
									break;	
							case "NEXTHOLIDAY":
									$values[] = 0;
									break;										
							case "BIRTHDAY":
									$values[] = 1;
									break;										
							case "ANNIVERSARY":
									$values[] = 2;
									break;										
							case "GRADUATION":
									$values[] = 3;
									break;										
							case "PROMOTION":
									$values[] = 4;
									break;										
							case "BEREAVEMENT":
									$values[] = 5;
									break;					
							case "TODAY":
									$values[] = 0;
									break;										
							case "BIGGER":
									$values[] = 1;
									break;										
							case "SPECIAL":
									$values[] = 2;
									break;								
							case "FALSE":
									$values[] = 0;
									break;										
							case "TRUE":
									$values[] = 1;
									break;																										
							default:	
							$values[] = mysqli_real_escape_string($db_server, strip_tags(trim($value)));
						 	}
			 	}
				else {
					$values[] = str_replace("\\", "", mysqli_real_escape_string($db_server, htmlspecialchars(trim($value),ENT_QUOTES)));
				}	
		}
}
	
if(isset($blanks))
{
		$_SESSION['message_idea'] = "The following fields are blank.
		    Please enter the required information:  ";
		foreach($blanks as $value)
		{
				$_SESSION['message_idea'] .= "$value, ";		
		}
}

if(isset($blanks) || @is_array($errors) ) 
{
		$_SESSION['navigate']="share.php','sharelink";
		header('Location:index.php');			
}

$mood = mysqli_real_escape_string($db_server, strip_tags(trim($_GET['mood'])));
$mood = ucfirst(strtolower($mood));

$query = 	"SELECT * FROM MOODS WHERE Mood LIKE '".$mood."'";
$result = 	mysqli_query($db_server, $query);
$row = mysqli_fetch_assoc($result);

if($row['MoodID'] > 0) {
	$mood_id = $row['MoodID'];
	$query= "UPDATE MOODS SET ideaCount = ideaCount + 1 WHERE MoodID = ".'"'.$mood_id.'"';
	$result = mysqli_query($db_server, $query) or die("Can't update mood");
}
else {
 	$query= "INSERT INTO MOODS (Mood) VALUES (".'"'.$mood.'"'.")";
	$result = mysqli_query($db_server, $query) or die("Can't insert new mood");
	
	$query = 	"SELECT * FROM MOODS WHERE Mood LIKE '".$mood."'";
	$result = 	mysqli_query($db_server, $query);
	$row = mysqli_fetch_assoc($result);
	$mood_id = $row['MoodID'];
	$query= "UPDATE MOODS SET ideaCount = ideaCount + 1 WHERE MoodId = '".$mood_id."'";
	$result = mysqli_query($db_server, $query) or die("Can't update mood: ".$query);
}

//insert idea
$today = date("Y-m-d");
$fields_str = implode(",", $fields);
$values_str = implode('","',$values);
$fields_str .= ",CREATE_DATE,mood_id,AUTHOR_ID";
$values_str .= '"'.",".'"'.$today.'"'.",".'"'.$mood_id.'"'.",".'"'.$_SESSION['id'];
  
$sql  = "INSERT INTO IDEAS ";
$sql .= "(".$fields_str.")";
$sql .= " VALUES ";
$sql .= "(".'"'.$values_str.'"'.")";
  
$result = mysqli_query($db_server, $sql) 
							or die("Couldn't execute insert query: ".$sql);

echo "Success! ";//.$sql;

?>
