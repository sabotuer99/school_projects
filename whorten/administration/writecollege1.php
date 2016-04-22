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

	if(isset($_POST['opt'])) 
	{
		$purifier = new HTMLPurifier();	
		$opt =  $purifier->purify(urldecode($_POST['opt']));


	/********************************************************
		This switch statement runs various code to manage
		file system and database entries for colleges
	*********************************************************/
		switch($opt) 
		{

		/********************************************************
			case 'createnew', write directory and database entries
			for new college.
			
			if name and abbr were posted, purify them and save
			to SESSION, if SESSION variable are already set, then
			they are clean and the variables can be set with them
		*********************************************************/
		case 'createnew':
		
			if((isset($_POST['name']) && isset($_POST['abbr'])) || (isset($_SESSION['cname']) && isset($_SESSION['cabr']))) 
			{

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

				/********************************************************
					check that abbreviation is unique, get cid number.
				*********************************************************/								
				require_once '../db_login.php'; 
				$query = 'SELECT * FROM colleges WHERE cabbr="'.$clean_abbr.'"';							
				$result = 	mysqli_query($db_server, $query) or die("Couldn't execute query: <br>".$query." error:". mysqli_error($db_server));
				if(mysqli_num_rows($result)==0)
				{					
					$query = "INSERT INTO colleges ( cname , cabbr ) VALUES (".'"'. $clean_name .'","'. $clean_abbr .'")';
					$result = 	mysqli_query($db_server, $query) or die("Couldn't execute insert query: <br>".$query." error:". mysqli_error($db_server));
					$clean_dbid = mysqli_insert_id($db_server);
					$_SESSION['dbid'] = $clean_dbid;
						
				}				
				else 
				{	
					unset($_SESSION['cname']);								
					unset($_SESSION['cabr']);
					die('Abbreviation must be unique!');				
				}
							
				$collpath = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/colleges/'.$clean_dbid;
				/*die ($clean_dbid);*/
				/********************************************************
					write the directory if it doesn't exist
				*********************************************************/	
					if(!file_exists($collpath)) 
					{
						mkdir($collpath);	
						chmod($collpath, 0777);
						mkdir($collpath.'/source/');
						chmod($collpath.'/source/', 0777);
						mkdir($collpath.'/thumbs/');	
						chmod($collpath.'/thumbs/', 0777);						
					}		
					else 
					{ 			
						die('did not write directory '); 		
					}			

				}		
		$_SESSION['create_college_option'] = 'add_description';
		
		break;
		/********************************************************
			end case 'createnew'...
			
			
			case 'cancel' is simple, just unset all the relevant
			session variables.
			
		*********************************************************/			
		case 'cancel':
					unset($_SESSION['cname']);
					unset($_SESSION['cabr']);
					unset($_SESSION['dbid']);
					unset($_SESSION['create_college_option']);	

		break;
		/********************************************************
			end case 'cancel'...
			
			
			case 'add_description' gets the rich formatted html from 
			tinymce and writes it to a file in the directory that should 
			have already been created.
			
		*********************************************************/				
		case 'add_description':		

	 			$clean_name = $_SESSION['cname'];
				$clean_abbr = $_SESSION['cabr'];
				$clean_dbid = $_SESSION['dbid'];
			
				$collpath = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/colleges/'.$clean_dbid;
		
				if(isset($_POST['stuff']) && file_exists($collpath)) 
				{
					$purifier = new HTMLPurifier();

					/* If magic quotes is enabled, use stripslashes, otherwise don't */
					if (get_magic_quotes_gpc())  
					{
						$stuff = $purifier->purify(stripslashes(urldecode($_POST['stuff'])));
					}
					else 
					{
						$stuff = $purifier->purify((urldecode($_POST['stuff'])));						
					}
					/*		
					echo $stuff;					
					*/
					$file = $clean_dbid.'_description.php';
					
					$filename = $collpath.'/'.$file ;		
					
					$handle = fopen($filename, "w+");
					fwrite($handle, $stuff);
					fclose($handle);
					
					unset($_SESSION['cname']);
					unset($_SESSION['cabr']);
					unset($_SESSION['dbid']);
					unset($_SESSION['create_college_option']);
					
				}		
		
		break;
		/********************************************************
			end case 'add_description'...
	
			case "createform" just sets session variable 
			'create_college_option'
		*********************************************************/			

		case "createform":
				$_SESSION['create_college_option'] = 'createform';
		break;
		/********************************************************
			end case 'createform'...
			
			begin case 'delete'
		*********************************************************/		
		case "delete":

				/* Grab abbreviation, build path to folder */
				$purifier = new HTMLPurifier();	
		 		$clean_dbid = substr(strtoupper($purifier->purify(urldecode($_POST['dbid']))),0,3);		
				$_SESSION['dbid'] = $clean_dbid;		
				$collpath = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/colleges/'.$clean_dbid;
						
				/*********************************************************
					Grab dbok and fsok values and create SESSION versions 
					if dbok == true, get college id number 'cid' 
				*********************************************************/
				if( isset($_POST['dbok']) ? $_POST['dbok'] == 1 : false ) 
				{
					$_SESSION['dbok'] = true;
					/* OBSOLETE
					require_once '../db_login.php'; 	
					$query = 'SELECT * FROM colleges WHERE cabbr LIKE "'.$clean_abbr.'"';
					$result = 	mysqli_query($db_server, $query) or die("Couldn't execute SELECT query: <br>".$query." error:". mysqli_error($db_server));
					$fetch_result = mysqli_fetch_assoc($result);
					$cid = $fetch_result['cid'];			*/	
				}
				else 
				{
					$_SESSION['dbok'] = false;
				}	
				
				if( isset($_POST['fsok']) ? $_POST['fsok'] == 1 : false ) 
				{
					$_SESSION['fsok'] = true;
				}
				else 
				{
					$_SESSION['fsok'] = false;
				}	
				

				/* Check file system for existing department sub folders */			
				$folders = scandir($collpath);
				for($i = 0; $i < count($folders); $i++ ) 
				{
					if( strlen($folders[$i])==4) 
					{ 
					$dept_folders[] = $folders[$i];
					}
				}	
				
				/* checks database for existing departments in this college, if dependencies exist, die */
				if( $_SESSION['dbok'] )
				{
					require_once '../db_login.php'; 	
					$query = "SELECT * FROM departments WHERE cid ='".$clean_dbid."';";
					$result = 	mysqli_query($db_server, $query) or die("Couldn't execute query: <br>".$query." error:". mysqli_error($db_server));
					/*die ("Rows in result: ".mysqli_num_rows($result));*/
					if(mysqli_num_rows($result) > 0)
					{
						unset($_SESSION['dbid']);
						die("cannot delete college, ".mysqli_num_rows($result)." dependant departments in database!");					
					}			
				}
				
				/* Check if college folder contains any department folders. If yes, die */				
	 			if(count($dept_folders) > 0 )
				{
						unset($_SESSION['dbid']);
						die("cannot delete college, must delete all ".count($dept_folders)." departments first!");
				}					
				else /* College has no departments, OK to delete. */
 				{
					
					/* if dbok == true, delete the database entry */
					if( $_SESSION['dbok'] ) 
					{
						require_once '../db_login.php'; 	
						$query = 'DELETE FROM colleges WHERE cid LIKE "'.$clean_dbid.'"';
						$result = 	mysqli_query($db_server, $query) or die("Couldn't execute DELETE query: <br>".$query." error:". mysqli_error($db_server));
					}
					/********************************************************
						if fsok == false, the directory is missing and we can 
						just go ahead and ignore it
					*********************************************************/				
					if( $_SESSION['fsok'] ) 
					{
						/* Define recursive delete function */
						function unlinkRecursive($dir) 
						{ 
						   if(!$dh = @opendir($dir)) 
						   { 
								unset($_SESSION['dbid']);
						   	die("error opening directory"); 
						   } 
						   while (false !== ($obj = readdir($dh))) 
						   { 
								if($obj == '.' || $obj == '..') 
								{ 
									continue; 
								} 
								
								if (!@unlink($dir . '/' . $obj)) 
								{ 
									unlinkRecursive($dir.'/'.$obj, true); 
								} 
						   } 
						
						   closedir($dh); 
						    
					      @rmdir($dir); 
						}
						
						/* Call above function to delete the college */
						unlinkRecursive($collpath);
					}
				}
			
			unset($_SESSION['dbid']);
			/*die('Not implemented yet, sucka!');*/

		break;
		/********************************************************
			end case 'delete'...
			
			begin case 'modify'
		*********************************************************/			
		case "modify":
				/* Grab dbok and fsok values and create SESSION versions */
				if( isset($_POST['dbok']) ? $_POST['dbok'] == 1 : false ) 
				{
					$_SESSION['dbok'] = true;
				}
				else 
				{
					$_SESSION['dbok'] = false;
				}	
				
				if( isset($_POST['fsok']) ? $_POST['fsok'] == 1 : false ) 
				{
					$_SESSION['fsok'] = true;
				}
				else 
				{
					$_SESSION['fsok'] = false;
				}		
				

				/* If session variable dbid isn't set, set it now. if it is set, drop value into variable */
				if(!(isset($_SESSION['dbid']))) 
				{	
					$purifier = new HTMLPurifier();	
			 		$clean_dbid = substr(strtoupper($purifier->purify(urldecode($_POST['dbid']))),0,3);		
					$_SESSION['dbid'] = $clean_dbid;		
		 		}
		 		else 
		 		{
					$clean_dbid = $_SESSION['dbid'];
				}	
				
				/* if dbok, then look up abbr and name, else set both to '' */
				if( $_SESSION['dbok'] ) 
				{
					require_once '../db_login.php'; 	
					$query = 'SELECT * FROM colleges WHERE cid="'.$clean_dbid.'"';
					$result = 	mysqli_query($db_server, $query) or die("Couldn't execute insert query: <br>".$query." error:". mysqli_error($db_server));
					$fetch_result = mysqli_fetch_assoc($result);
					$_SESSION['cname'] = $fetch_result['cname']; 
					$_SESSION['cabr'] = $fetch_result['cabbr'];
				}
				else
				{
					$_SESSION['cname'] = '';	
					$_SESSION['cabr'] = '';			
				}
					
				$_SESSION['create_college_option'] = 'modify';
		break;
		/********************************************************
			end case 'modify'...	
			
			begin case 'modifycommit'
		*********************************************************/			
		case "modifycommit":
		 	$old_name = $_SESSION['cname'];
			$old_abbr = $_SESSION['cabr'];				
			if((isset($_POST['name']) && isset($_POST['abbr'])) && isset($_SESSION['dbid']) ) 
			{

				$purifier = new HTMLPurifier();	
		 		$clean_abbr = substr(strtoupper($purifier->purify(urldecode($_POST['abbr']))),0,3);
				$clean_name = $purifier->purify(urldecode($_POST['name'])); 	
				$clean_dbid = $_SESSION['dbid'];
				$_SESSION['cname'] = $clean_name;
				$_SESSION['cabr'] = $clean_abbr;		


				$collpath = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/colleges/'.$clean_dbid;
				/*$oldpath =  $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/colleges/'.$old_abbr;*/
				/********************************************************
					if fsok = false, the directory is missing and we can 
					just go ahead and write it
				*********************************************************/	
				if(!$_SESSION['fsok']) 
				{
					if(!file_exists($collpath)) 
					{
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
				elseif($clean_abbr != $old_abbr) 
				{
					/*  DONT NEED, FS NOT BASED ON ABBR ANY MORE
					if(!file_exists($collpath)) 	
					{
						rename($oldpath, $collpath);
					}
					else 
					{ 			
						die('did not rename directory, already exists!'); 		
					}		
					*/		
				}
				/********************************************************
					end file system modification code, 
					
					begin database modification code
				*********************************************************/	
				if(!$_SESSION['dbok']) 
				{
						require_once '../db_login.php'; 	
						$query = "INSERT INTO colleges ( cname , cabbr ) VALUES (".'"'. $clean_name .'","'. $clean_abbr .'")';
						$result = 	mysqli_query($db_server, $query) or die("Couldn't execute insert query: <br>".$query." error:". mysqli_error($db_server));											
				}
				else  /*if($clean_abbr != $old_abbr || $clean_name != $old_name) */
				{
					require_once '../db_login.php'; 	
					$query = "SELECT * FROM colleges WHERE cabbr='". $clean_abbr."';";
					$result = 	mysqli_query($db_server, $query) or die("Couldn't execute insert query: <br>".$query." error:". mysqli_error($db_server));											
											
					
					if(mysqli_num_rows($result)==0 || $clean_abbr == $old_abbr) 	
					{
						$query = "UPDATE colleges SET cname='". $clean_name ."' , cabbr='". $clean_abbr ."' WHERE cid='".$clean_dbid."';";
						$result = 	mysqli_query($db_server, $query) or die("Couldn't execute update query: <br>".$query." error:". mysqli_error($db_server));											
					}
					else 
					{ 			
						die('did not alter database entry'); 		
					}				
				}						
			}		
		$_SESSION['create_college_option'] = 'mod_description';
	
		break;
		/********************************************************
			end case 'modifycommit'
		*********************************************************/	
		}
	}
	else 
	{
		echo 'No option set';		
	}
}
else 
{
	echo 'Not Authorized';
}
?>