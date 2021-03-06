<?php 
/********************************************************
	This section checks to make sure the path to the 
	include file exists, then drops it in
*********************************************************/
session_start();
$path = $_SERVER['DOCUMENT_ROOT'].'/includes';
if(file_exists($path)) 
{
	$baseroot = "";
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/includes.php';	
}
else 
{
	$baseroot = "/whorten";
	require_once $_SERVER['DOCUMENT_ROOT'].'/whorten/includes/includes.php';	
}
//End include code
?>

<?php 
if(isset($_SESSION['auth']) ? $_SESSION['auth']==1 : false) 
{
	if(isset($_POST['create']) || isset($_SESSION['create'])) 
	{

		if($_POST['create'] != 'FALSE') 
		{
			$_SESSION['create']	=	true;		
					
			if((isset($_POST['name']) && isset($_POST['abbr'])) || (isset($_SESSION['cname']) && isset($_SESSION['cabr']))) 
			{
	
				/********************************************************
					if name and abbr were posted, purify them and save
					to SESSION, if SESSION variable are already set, then
					they are clean and the variables can be set with them
				*********************************************************/
				if(!(isset($_SESSION['cname']) && isset($_SESSION['cabr']))) 
				{	
					$purifier = new HTMLPurifier();	
			 		$clean_abbr = substr(strtoupper($purifier->purify(urldecode($_POST['abbr']))),0,3);
					$clean_name = $purifier->purify(urldecode($_POST['name'])); 		
					$_SESSION['cname'] = $clean_name;
					$_SESSION['cabr'] = $clean_abbr;		
		 		}
		 		else 
		 		{
		 			$clean_name = $_SESSION['cname'];
					$clean_abbr = $_SESSION['cabr'];
				}
			
				$collpath = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/colleges/'.$clean_abbr;
				

				/********************************************************
					if description was passed AND directory has been 
					created, then write description to file
				*********************************************************/			
				if(isset($_POST['stuff']) && file_exists($collpath)) 
				{
					$purifier = new HTMLPurifier();
					$stuff = $purifier->purify(urldecode($_POST['stuff']));				
					
					$file = $clean_abbr.'_description.php';
					
					$filename = $collpath.'/'.$file ;		
					
					$handle = fopen($filename, "x+");
					fwrite($handle, $stuff);
					fclose($handle);
					
					unset($_SESSION['cname']);
					unset($_SESSION['cabr']);
					unset($_SESSION['create']);
					
				}
				else 
				{ 	
				/********************************************************
					...otherwise, write the directory if it doesn't exist
				*********************************************************/	
					if(!file_exists($collpath)) 
					{
						require_once '../db_login.php'; 	
						$query = "INSERT INTO colleges ( cname , cabbr ) VALUES (".'"'. $clean_name .'","'. $clean_abbr .'")';
						$result = 	mysqli_query($db_server, $query) or die("Couldn't execute insert query: <br>".$query." error:". mysqli_error($db_server));
						mkdir($collpath);	
						chmod($collpath, 0777);
						mkdir($collpath.'/source/');
						chmod($collpath.'/source/', 0777);
						mkdir($collpath.'/thumbs/');	
						chmod($collpath.'/thumbs/', 0777);						
					}		
					else 
					{ 			
						echo 'did not write directory '; 		
					}			

				}

			}
		}
		else 
		{ /* 'create' is set and equal to FALSE, cancel all session variables.*/
					unset($_SESSION['cname']);
					unset($_SESSION['cabr']);
					unset($_SESSION['create']);						
		}
	}
}
else 
{
	echo 'Not Authorized';
}
?>