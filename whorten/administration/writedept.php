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
		
			if((isset($_POST['name']) && isset($_POST['abbr'])) || (isset($_SESSION['dname']) && isset($_SESSION['dabbr']))) 
			{

				if(!(isset($_SESSION['dname']) && isset($_SESSION['dabbr']))) 
				{	
					$purifier = new HTMLPurifier();	
			 		$clean_abbr = substr(strtoupper($purifier->purify(urldecode($_POST['abbr']))),0,4);
					$clean_name = $purifier->purify(urldecode($_POST['name'])); 		
					$_SESSION['dname'] = $clean_name;
					$_SESSION['dabbr'] = $clean_abbr;		
		 		}
		 		else 
		 		{
		 			$clean_name = $_SESSION['dname'];
					$clean_abbr = $_SESSION['dabbr'];
				}

				/********************************************************
					check that abbreviation is unique, get cid number.
				*********************************************************/								
				require_once '../db_login.php'; 
				$query = 'SELECT * FROM departments WHERE dabbr="'.$clean_abbr.'"';							
				$result = 	mysqli_query($db_server, $query) or die("Couldn't execute query: <br>".$query." error:". mysqli_error($db_server));
				if(mysqli_num_rows($result)==0)
				{					
					$query = "INSERT INTO departments ( dname , dabbr , cid ) VALUES (".'"'. $clean_name .'","'. $clean_abbr .'","'. $_SESSION['deptcid'] .'")';
					$result = 	mysqli_query($db_server, $query) or die("Couldn't execute insert query: <br>".$query." error:". mysqli_error($db_server));
					$clean_deptid = mysqli_insert_id($db_server);
					$_SESSION['deptid'] = $clean_deptid;
						
				}				
				else 
				{	
					unset($_SESSION['dname']);								
					unset($_SESSION['dabbr']);
					die('Abbreviation must be unique!');				
				}
							
				$deptpath = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/depts/'.$clean_deptid;
				/*die ($clean_deptid);*/
				/********************************************************
					write the directory if it doesn't exist
				*********************************************************/	
					if(!file_exists($deptpath)) 
					{
						mkdir($deptpath);	
						chmod($deptpath, 0777);
						mkdir($deptpath.'/source/');
						chmod($deptpath.'/source/', 0777);
						mkdir($deptpath.'/thumbs/');	
						chmod($deptpath.'/thumbs/', 0777);						
					}		
					else 
					{ 			
						die('did not write directory '); 		
					}			

				}		
		$_SESSION['create_dept_option'] = 'add_description';
		
		break;
		/********************************************************
			end case 'createnew'...
			
			
			case 'cancel' is simple, just unset all the relevant
			session variables.
			
		*********************************************************/			
		case 'cancel':
					unset($_SESSION['dname']);
					unset($_SESSION['dabbr']);
					unset($_SESSION['deptid']);
					unset($_SESSION['create_dept_option']);	
					unset($_SESSION['deptcid']);

		break;
		/********************************************************
			end case 'cancel'...
			
			
			case 'add_description' gets the rich formatted html from 
			tinymce and writes it to a file in the directory that should 
			have already been created.
			
		*********************************************************/				
		case 'add_description':		

	 			$clean_name = $_SESSION['dname'];
				$clean_abbr = $_SESSION['dabbr'];
				$clean_deptid = $_SESSION['deptid'];
			
				$deptpath = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/depts/'.$clean_deptid;
		
				if(isset($_POST['stuff']) && file_exists($deptpath)) 
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
					$file = $clean_deptid.'_description.php';
					
					$filename = $deptpath.'/'.$file ;		
					
					$handle = fopen($filename, "w+");
					fwrite($handle, $stuff);
					fclose($handle);
					
					unset($_SESSION['dname']);
					unset($_SESSION['dabbr']);
					unset($_SESSION['deptid']);
					unset($_SESSION['create_dept_option']);
					unset($_SESSION['deptcid']);
					
				}		
		
		break;
		/********************************************************
			end case 'add_description'...
	
			case "createform" just sets session variable 
			'create_college_option'
		*********************************************************/			

		case "createform":
				$purifier = new HTMLPurifier();	
			 	$_SESSION['deptcid'] = $purifier->purify(urldecode($_POST['cid']));		
				$_SESSION['create_dept_option'] = 'createform';
		break;
		/********************************************************
			end case 'createform'...
			
			begin case 'delete'
		*********************************************************/		
		case "delete":

				/* Grab abbreviation, build path to folder */
				$purifier = new HTMLPurifier();	
		 		$clean_deptid = substr(strtoupper($purifier->purify(urldecode($_POST['dbid']))),0,3);	
		 		if($clean_deptid=='') 
		 		{
		 			die('Whoops, something went wrong with the delete function...');
		 		}	
				$_SESSION['deptid'] = $clean_deptid;		
				$deptpath = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/depts/'.$clean_deptid;
						
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
				

				/* Check file system for existing sub folders if path exists */			
				if(file_exists($deptpath))
				{
					$folders = scandir($deptpath);
					for($i = 0; $i < count($folders); $i++ ) 
					{
						/*echo $folders[$i];*/
						if( is_dir($deptpath.'/'.$folders[$i]) && !($folders[$i]=='.' || $folders[$i]=='..' || $folders[$i]=='source'  || $folders[$i]=='thumbs' )) 
						{ 
						$dept_folders[] = $folders[$i];
						}
					}	
				}
				else 
				{
					$_SESSION['fsok'] = false;
				}				
				
				/* checks database for existing courses in this department, if dependencies exist, die */
				if( $_SESSION['dbok'] )
				{
					require_once '../db_login.php'; 	
					$query = "SELECT * FROM courses WHERE did ='".$clean_deptid."';";
					$result = 	mysqli_query($db_server, $query) or die("Couldn't execute query: <br>".$query." error:". mysqli_error($db_server));
					/*die ("Rows in result: ".mysqli_num_rows($result));*/
					if(mysqli_num_rows($result) > 0)
					{
						unset($_SESSION['deptid']);
						die("cannot delete department, ".mysqli_num_rows($result)." dependant courses in database!");					
					}			
				}
				
				/* Check if college folder contains any department folders. If yes, die */				
	 			if(count($dept_folders) > 0 )
				{
						unset($_SESSION['deptid']);
						die("cannot delete department, must delete all ".count($dept_folders)." courses first!");
				}					
				else /* Department has no courses, OK to delete. */
 				{
					
					/* if dbok == true, delete the database entry */
					if( $_SESSION['dbok'] ) 
					{
						require_once '../db_login.php'; 	
						$query = 'DELETE FROM departments WHERE did LIKE "'.$clean_deptid.'"';
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
								unset($_SESSION['deptid']);
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
						unlinkRecursive($deptpath);
					}
				}
			
			unset($_SESSION['deptid']);
			/*die('Not implemented yet, sucka!');*/

		break;
		/********************************************************
			end case 'delete'...
			
			begin case 'modify'
		*********************************************************/			
		case "modify":
				$purifier = new HTMLPurifier();	
			 	$_SESSION['deptcid'] = $purifier->purify(urldecode($_POST['cid']));	


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
				

				/* If session variable deptid isn't set, set it now. if it is set, drop value into variable */
				if(!(isset($_SESSION['deptid']))) 
				{	
					$purifier = new HTMLPurifier();	
			 		$clean_deptid = $purifier->purify(urldecode($_POST['dbid']));		
					$_SESSION['deptid'] = $clean_deptid;		
		 		}
		 		else 
		 		{
					$clean_deptid = $_SESSION['deptid'];
				}	
				
				/* if dbok, then look up abbr and name, else set both to '' */
				if( $_SESSION['dbok'] ) 
				{
					require_once '../db_login.php'; 	
					$query = 'SELECT * FROM departments WHERE did="'.$clean_deptid.'"';
					$result = 	mysqli_query($db_server, $query) or die("Couldn't execute insert query: <br>".$query." error:". mysqli_error($db_server));
					$fetch_result = mysqli_fetch_assoc($result);
					$_SESSION['dname'] = $fetch_result['dname']; 
					$_SESSION['dabbr'] = $fetch_result['dabbr'];
				}
				else
				{
					$_SESSION['dname'] = '';	
					$_SESSION['dabbr'] = '';			
				}
					
				$_SESSION['create_dept_option'] = 'modify';
		break;
		/********************************************************
			end case 'modify'...	
			
			begin case 'modifycommit'
		*********************************************************/			
		case "modifycommit":
		 	$old_name = $_SESSION['dname'];
			$old_abbr = $_SESSION['dabbr'];	
			
			$purifier = new HTMLPurifier();	
		 	$_SESSION['deptcid'] = $purifier->purify(urldecode($_POST['cid']));				
						
			if((isset($_POST['name']) && isset($_POST['abbr'])) && isset($_SESSION['deptid']) ) 
			{

				$purifier = new HTMLPurifier();	
		 		$clean_abbr = substr(strtoupper($purifier->purify(urldecode($_POST['abbr']))),0,4);
				$clean_name = $purifier->purify(urldecode($_POST['name'])); 	
				$clean_deptid = $_SESSION['deptid'];
				$_SESSION['dname'] = $clean_name;
				$_SESSION['dabbr'] = $clean_abbr;		


				$deptpath = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/depts/'.$clean_deptid;
				/********************************************************
					if fsok = false, the directory is missing and we can 
					just go ahead and write it
				*********************************************************/	
				if(!$_SESSION['fsok']) 
				{
					if(!file_exists($deptpath)) 
					{
						mkdir($deptpath);	
						chmod($deptpath, 0777);
						mkdir($deptpath.'/source/');
						chmod($deptpath.'/source/', 0777);
						mkdir($deptpath.'/thumbs/');	
						chmod($deptpath.'/thumbs/', 0777);						
					}		
					else 
					{ 			
						echo 'did not write directory '; 		
					}
				}
				elseif($clean_abbr != $old_abbr) 
				{
					/*  DONT NEED, FS NOT BASED ON ABBR ANY MORE
					if(!file_exists($deptpath)) 	
					{
						rename($oldpath, $deptpath);
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
						$query = "INSERT INTO departments ( dname , dabbr , cid ) VALUES (".'"'. $clean_name .'","'. $clean_abbr .'","'. $_SESSION['deptcid'] .'")';
						$result = 	mysqli_query($db_server, $query) or die("Couldn't execute insert query: <br>".$query." error:". mysqli_error($db_server));											
				}
				else  /*if($clean_abbr != $old_abbr || $clean_name != $old_name) */
				{
					require_once '../db_login.php'; 	
					$query = "SELECT * FROM departments WHERE dabbr='". $clean_abbr."';";
					$result = 	mysqli_query($db_server, $query) or die("Couldn't execute insert query: <br>".$query." error:". mysqli_error($db_server));											
											
					
					if(mysqli_num_rows($result)==0 || $clean_abbr == $old_abbr) 	
					{
						$query = "UPDATE departments SET dname='". $clean_name ."' , dabbr='". $clean_abbr ."' WHERE did='".$clean_deptid."';";
						$result = 	mysqli_query($db_server, $query) or die("Couldn't execute update query: <br>".$query." error:". mysqli_error($db_server));											
					}
					else 
					{ 			
						die('did not alter database entry'); 		
					}				
				}						
			}		
		$_SESSION['create_dept_option'] = 'mod_description';
	
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