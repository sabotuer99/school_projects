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

				$purifier = new HTMLPurifier();	
				$clean_title = $purifier->purify(urldecode($_POST['title'])); 
		
				if(!(isset($_SESSION['lsncrsid']) && isset($_SESSION['lsntype']))) 
				{	
					$clean_crsid = $purifier->purify(urldecode($_POST['crsid'])); 
					$clean_lsntype	= $purifier->purify(urldecode($_POST['lsntype']));
					$_SESSION['lsncrsid'] = $clean_crsid;
					$_SESSION['lsntype'] = $clean_lsntype;		
		 		}
		 		else 
		 		{
		 			$clean_crsid = $_SESSION['lsncrsid'];
					$clean_lsntype = $_SESSION['lsntype'];
				}

				/********************************************************
					.
				*********************************************************/								
				require_once '../db_login.php'; 
				
				$index_sql = 'SELECT MAX(viewindex) AS a FROM lessons WHERE crsid = "'.$clean_crsid.'"';				
				$result = 	mysqli_query($db_server, $index_sql) or die("Couldn't execute insert query: <br>".$index_sql." error:". mysqli_error($db_server));											
				$fetch_index = mysqli_fetch_assoc($result);				
				$view_index = $fetch_index['a'] + 1;
				
				$today = date("Y-m-d");
				
				$sql .= "INSERT INTO lessons (crsid, createDate, viewindex, lsntype, lsntitle) VALUES	".'("'.$clean_crsid.'","'.$today.'","'.$view_index.'","'.$clean_lsntype.'","'.$clean_title.'")';		
				$result = 	mysqli_query($db_server, $sql) or die("Couldn't execute insert query: <br>".$sql." error:". mysqli_error($db_server));											
				$clean_lsnid = mysqli_insert_id($db_server);
				
				$lsnpath = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/courses/'.$clean_crsid.'/'.$clean_lsnid;		
				
				/*die ($clean_deptid);*/
				/********************************************************
					write the directory if it doesn't exist
				*********************************************************/	
   				if(!file_exists($lsnpath)) 
					{
						mkdir($lsnpath);	
						chmod($lsnpath, 0777);
						mkdir($lsnpath.'/source/');
						chmod($lsnpath.'/source/', 0777);
						mkdir($lsnpath.'/thumbs/');	
						chmod($lsnpath.'/thumbs/', 0777);						
					}		
					else 
					{ 			
						die('did not write directory '); 		
					}			

						
		$_SESSION['create_lesson_option'] = 'add_description';
		$_SESSION['lsnid'] = $clean_lsnid;
		$_SESSION['lsntitle'] = $clean_title;
		/*unset($_SESSION['lsncrsid']);*/
		unset($_SESSION['lsntype']);	
		
		break;
		/********************************************************
			end case 'createnew'...
			
			
			case 'cancel' is simple, just unset all the relevant
			session variables.
			
		*********************************************************/			
		case 'cancel':
					unset($_SESSION['lsncrsid']);
					unset($_SESSION['lsntype']);
					unset($_SESSION['create_lesson_option']);	

		break;
		/********************************************************
			end case 'cancel'...
			
			
			case 'add_description' gets the rich formatted html from 
			tinymce and writes it to a file in the directory that should 
			have already been created.
			
		*********************************************************/				
		case 'add_description':		
				$lsncrsid = $_SESSION['lsncrsid'];
				$lsnid = $_SESSION['lsnid'];							
				$lsnpath = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/courses/'.$lsncrsid.'/'.$lsnid;
		
				if(isset($_POST['stuff']) && file_exists($lsnpath)) 
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
					$file = 'Lesson_'.$lsnid.'.php';
					
					$filename = $lsnpath.'/'.$file ;		
					
					$handle = fopen($filename, "w+");
					fwrite($handle, $stuff);
					fclose($handle);
					
					unset($_SESSION['lsncrsid']);
					unset($_SESSION['lsnid']);
					unset($_SESSION['lsntype']);
					unset($_SESSION['create_lesson_option']);	
					
				}		
		
		die();
		break;
		/********************************************************
			end case 'add_description'...
	
			case "createform" just sets session variable 
			'create_college_option'
		*********************************************************/			

		case "createassign":
		case "createlesson":
				$purifier = new HTMLPurifier();	
			 	$_SESSION['lsncrsid'] = $purifier->purify(urldecode($_POST['crsid']));		
			 	$_SESSION['lsn_opt'] = $opt;
				$_SESSION['create_lesson_option'] = 'createform';
				die();
		break;
		/********************************************************
			end case 'createform'...
			
			begin case 'delete'
		*********************************************************/		
		case "delete":

				/* Grab lesson and course ids, build path to folder */
				$purifier = new HTMLPurifier();	
		 		$clean_lsnid = $purifier->purify(urldecode($_POST['lsnid']));	
		 		$clean_crsid = $purifier->purify(urldecode($_POST['crsid']));	
		 		if($clean_lsnid=='') 
		 		{
		 			die('Whoops, something went wrong with the delete function...');
		 		}	

				$lsnpath = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/courses/'.$clean_crsid.'/'.$clean_lsnid;
						
				/*********************************************************
					Grab dbok and fsok values and create SESSION versions 
					if dbok == true, get lesson id number 'lsnid' 
				*********************************************************/
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
				

				/* Check file system for existing sub folders if path exists */
				/* I'm pretty sure this code is unnecessary*/			
/*				if(file_exists($lsnpath))
				{
					$folders = scandir($lsnpath);
					for($i = 0; $i < count($folders); $i++ ) 
					{
						if( is_dir($lsnpath.'/'.$folders[$i]) && !($folders[$i]=='.' || $folders[$i]=='..' || $folders[$i]=='source'  || $folders[$i]=='thumbs' )) 
						{ 
						$lsn_folders[] = $folders[$i];
						}
					}	
				}
				else 
				{
					$_SESSION['fsok'] = false;
				}				
*/
				
				/* checks database for submitted assignments of this course, if dependencies exist, change status to "obsolete" rather than delete */
/*				if( $_SESSION['dbok'] )
				{
					require_once '../db_login.php'; 	
					$query = "SELECT * FROM courses WHERE did ='".$clean_deptid."';";
					$result = 	mysqli_query($db_server, $query) or die("Couldn't execute query: <br>".$query." error:". mysqli_error($db_server));
					/*die ("Rows in result: ".mysqli_num_rows($result));*/
/*					if(mysqli_num_rows($result) > 0)
					{
						unset($_SESSION['deptid']);
						die("cannot delete department, ".mysqli_num_rows($result)." dependant courses in database!");					
					}			
				}
				
				/* Check if college folder contains any department folders. If yes, die */				
/*	 			if(count($dept_folders) > 0 )
				{
						unset($_SESSION['deptid']);
						die("cannot delete department, must delete all ".count($dept_folders)." courses first!");
				}					
				else /* Department has no courses, OK to delete. */
/* 				{
					
					/* if dbok == true, delete the database entry */
					if( $_SESSION['dbok'] ) 
					{
						require_once '../db_login.php'; 	
						$query = 'DELETE FROM lessons WHERE lsnid LIKE "'.$clean_lsnid.'"';
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
						unlinkRecursive($lsnpath);
					}
				
			

			/*die('Not implemented yet, sucka!');*/

		break;
		/********************************************************
			end case 'delete'...
			
			begin case 'modify'
		*********************************************************/			
		case "modify":
				/* Grab lesson and course ids, build path to folder */
				$purifier = new HTMLPurifier();	
		 		$_SESSION['lsnid'] = $purifier->purify(urldecode($_POST['lsnid']));	
		 		$_SESSION['lsncrsid'] = $purifier->purify(urldecode($_POST['crsid']));	
		 		$_SESSION['lsntype'] = $purifier->purify(urldecode($_POST['typenum']));
		 		$_SESSION['lsntype_name'] = $purifier->purify(urldecode($_POST['type']));
		 		
				$clean_lsnid = $_SESSION['lsnid'];

/*
		 		if($clean_lsnid=='') 
		 		{
		 			die('Whoops, something went wrong with the delete function...');
		 		}	



				;
*/

				/* Grab dbok and fsok values and create SESSION versions */
				if( isset($_POST['dbok']) ? $_POST['dbok'] == 1 : false ) 
				{
					$_SESSION['dbok'] = true;
					/*  Get lesson title from database   */
					
					require_once '../db_login.php'; 	
					$query = 'SELECT * FROM lessons WHERE lsnid LIKE "'.$clean_lsnid.'"';
					$result = 	mysqli_query($db_server, $query) or die("Couldn't execute DELETE query: <br>".$query." error:". mysqli_error($db_server));
					$fetch_result = mysqli_fetch_assoc($result);
					$_SESSION['lsntitle'] = $fetch_result['lsntitle'];
				}
				else 
				{
					$_SESSION['dbok'] = false;
					$_SESSION['lsntitle'] = "";
				}	
				
				if( isset($_POST['fsok']) ? $_POST['fsok'] == 1 : false ) 
				{
					$_SESSION['fsok'] = true;
				}
				else 
				{
					$_SESSION['fsok'] = false;
				}		
				
								
				
				
					
				$_SESSION['create_lesson_option'] = 'modify';

		break;
		/********************************************************
			end case 'modify'...	
			
			begin case 'modifycommit'
		*********************************************************/			
		case "modifycommit":
	

				$purifier = new HTMLPurifier();	
				$clean_lsnid = 	$purifier->purify(urldecode($_POST['lsnid']));	
		 		$clean_crsid = 	$purifier->purify(urldecode($_POST['crsid']));
				$clean_lsntype = 	$purifier->purify(urldecode($_POST['type']));		
				$clean_title =		$purifier->purify(urldecode($_POST['title']));
				
				
				$_SESSION['lsnid']= $clean_lsnid;
				$_SESSION['lsncrsid']= $clean_crsid;
				
				$_SESSION['lsntype'] = $clean_lsntype;
				
				require_once '../db_login.php';
				$query = 'SELECT * FROM lesson_types WHERE lsntype = "'.$clean_lsntype.'"';
				$result = 	mysqli_query($db_server, $query) or die("Couldn't execute SELECT query: ".$query." error:". mysqli_error($db_server));
				$fetch_result = mysqli_fetch_assoc($result);
				
				$_SESSION['lsntype_name'] = $fetch_result['typename'];
				
				$lsnpath = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/courses/'.$clean_crsid.'/'.$clean_lsnid;
				/********************************************************
					if fsok = false, the directory is missing and we can 
					just go ahead and write it
				*********************************************************/	
				if(!$_SESSION['fsok']) 
				{
					if(!file_exists($lsnpath)) 
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
/*				elseif($clean_abbr != $old_abbr) 
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
/*				}
				/********************************************************
					end file system modification code, 
					
					begin database modification code
				*********************************************************/	
				if(!$_SESSION['dbok']) 
				{
					require_once '../db_login.php'; 
					
					$index_sql = 'SELECT MAX(viewindex) AS a FROM lessons WHERE crsid = "'.$clean_crsid.'"';				
					$result = 	mysqli_query($db_server, $index_sql) or die("Couldn't execute insert query: <br>".$index_sql." error:". mysqli_error($db_server));											
					$fetch_index = mysqli_fetch_assoc($result);					
					$view_index = $fetch_index['a'] + 1;
					
					$today = date("Y-m-d");
					
					$sql .= "INSERT INTO lessons (crsid, createDate, viewindex, lsntype, lsntitle) VALUES	".'("'.$clean_crsid.'","'.$today.'","'.$view_index.'","'.$clean_lsntype.'","'.$clean_title.'")';		
					$result = 	mysqli_query($db_server, $sql) or die("Couldn't execute insert query: <br>".$sql." error:". mysqli_error($db_server));											
				}
				else  /*if($clean_abbr != $old_abbr || $clean_name != $old_name) */
				{
					require_once '../db_login.php'; 	
					$query = "UPDATE lessons SET lsntype='". $clean_lsntype ."' , lsntitle='". $clean_title ."' WHERE lsnid='".$clean_lsnid."';";
					$result = 	mysqli_query($db_server, $query) or die("Couldn't execute update query: <br>".$query." error:". mysqli_error($db_server));											
			
				}						
					
		$_SESSION['create_lesson_option'] = 'mod_description';
	
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