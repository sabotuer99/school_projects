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

<div id="runscript">	

	<script type="text/javascript" >
/********************************************************
	This section configures TinyMCE
*********************************************************/	
		tinymce.init({
		    selector: "div.fulledit",
			  theme : "modern",
		    plugins: [
		        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
		        "searchreplace wordcount visualblocks visualchars code fullscreen",
		        "insertdatetime media nonbreaking save table contextmenu directionality",
		        "emoticons template paste textcolor" /*responsivefilemanager"*/
		    ],
		    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
		    toolbar2: "link image | print preview media | forecolor backcolor",
		    image_advtab: true,
		    templates: [
		        {title: 'Test template 1', content: 'Test 1'},
		        {title: 'Test template 2', content: 'Test 2'}
		    ],
		    
			external_filemanager_path:"/filemanager/",
			filemanager_title:"Responsive Filemanager" ,
			external_plugins: { "filemanager" : "/filemanager/plugin.min.js"},
			
			relative_urls : false,
			remove_script_host : true,
			document_base_url : "http://<?php echo $_SERVER['SERVER_NAME'] ?>"			
		});	
	</script>	

	<script type="text/javascript" >
/********************************************************
	This section appends the admin javascript file 
	to the website head
*********************************************************/		
		var head= document.getElementsByTagName('head')[0];
		var script= document.createElement('script');
		script.type= 'text/javascript';
		script.src= '/contributors/contrib.js';
		head.appendChild(script);
	</script>	
	
</div>

<?php 
/********************************************************
	if the option variable is not set, use the default 
	case. otherwise, use the given option variable
*********************************************************/	
if(!isset($_SESSION['create_lesson_option'])) 
{
	$option = 'DEFAULT';
}
else 
{
	$option = $_SESSION['create_lesson_option'];
}

switch($option) 
{

/********************************************************
	For case 'createnew' we have two fields, one for 
	college name, another for abbreviation. This form
	sets up the folder structure and database entries
	before adding a description
*********************************************************/		
	case 'createform':

			$lsncrsid = $_SESSION['lsncrsid'];
			switch($_SESSION['lsn_opt']) 
			{	
				case "createlesson":
					$lsnopt = 1;
					$lsnheader = "lesson";
				break;

				case "createassign":
					$lsnopt = 2;
					$lsnheader = "assignment";
				break;
				
			}
	?>
			
			<h2>Create a new <?php echo $lsnheader ?></h2>
			
			<table summary="" >
				<tr>
					<td>	<span>Course Number: </span>	</td>
					<td>	<span id="coursenum"><?php echo $lsncrsid; ?></span> </td>				
				</tr>
				<tr>
					<td>	<span>Lesson Title: </span>	</td>
					<td>	<input type="text" id="lesson_title">	</td>				
				</tr>	
				<tr>
					<td>	<span>Create directory and database entry</span>	</td>
					<td>	
						<button class="myButton" data-lsntype="<?php echo $lsnopt ?>" data-crsid="<?php echo $lsncrsid ?>" id="prevbutton" onclick="createlesson('createnew',this)">Create</button>	
						<button class="myButton" id="cancelbutton" onclick="createlesson('cancel')">Cancel</button>	
					</td>		
				</tr>	
			</table>			
	<?php 

	break;

/********************************************************
	For case 'add_description', folders have been set up 
	already and we are going to use TinyMCE to add a 
	file with a description of the college 
*********************************************************/
	case 'add_description':
	
	$lsncrsid = $_SESSION['lsncrsid'];
	$lsnid = $_SESSION['lsnid'];
	$lsntitle = $_SESSION['lsntitle'];
	switch($_SESSION['lsn_opt']) 
	{	
		case "createlesson":
			$lsnopt = 1;
			$lsnheader = "lesson";
		break;

		case "createassign":
			$lsnopt = 2;
			$lsnheader = "assignment";
		break;
		
	}
	?>
						<h2>Create a new <?php echo $lsnheader ?></h2>
			
			<table summary="" >
				<tr>
					<td>	<span>Course Number: </span>	</td>
					<td>	<span id="crsid"><?php echo $lsncrsid; ?></span> </td>				
				</tr>	
				<tr>
					<td>	<span>ID Number: </span>	</td>
					<td>	<span id="lsnid"><?php echo $lsnid; ?></span> </td>				
				</tr>
				<tr>
					<td>	<span>Lesson Title: </span>	</td>
					<td>	<span id="lesson_title"><?php echo $lsntitle; ?>	</td>				
				</tr>	
			</table>
			</div>
			<?php 
			/********************************************************
				open a TinyMCE instance to add a description
				
				Set write folder for Responsive Filemanager
			*********************************************************/			
			$purifier = new HTMLPurifier();
			

			/*echo $_SERVER['SERVER_NAME'];*/
			
			$_SESSION['upload_dir']= '/academics/courses/'.$lsncrsid.'/'.$lsnid."/source/" ;
			$_SESSION['current_path']='../academics/courses/'.$lsncrsid.'/'.$lsnid."/source/" ;
			$_SESSION['thumbs_base_path']='../academics/courses/'.$lsncrsid.'/'.$lsnid."/thumbs/";			
		?>
			
			<div>	
				<span>Lesson Plan:</span>
				<div id="target" class="fulledit">Describe the mission, subject matter, and other characteristics of the department</div>
						<button class="myButton" id="prevbutton" onclick="createlesson('add_description',this)">Submit</button>	
						<button class="myButton" id="cancelbutton" onclick="createlesson('cancel')">Cancel</button>			
				<div id="preview"></div>
				<div id="writefileresult"></div>
			</div>	
	<?php 
	
	break;
/********************************************************
	For case 'modify', check 
*********************************************************/
	case 'modify':
	 								
			$lsncrsid = $_SESSION['lsncrsid'];
			$lsnid = $_SESSION['lsnid'];		
			$lsntitle = $_SESSION['lsntitle'];						
			$lsntype_num =	$_SESSION['lsntype'];

	?>
			<h2>Modify lesson/assignment</h2>
			
			<table summary="" >
				<tr>
					<td>	<span>Course Number: </span>	</td>
					<td>	<span id="coursenum"><?php echo $lsncrsid; ?></span> </td>				
				</tr>	
				<tr>
					<td>	<span>ID Number: </span>	</td>
					<td>	<span id="coursenum"><?php echo $lsnid; ?></span> </td>				
				</tr>
				<tr>
					<td>	<span>Lesson Title: </span>	</td>
					<td>	<input type="text" id="lesson_title" value="<?php echo $lsntitle; ?>">	</td>				
				</tr>	
				<tr>
					<td>	<span>Lesson Type: </span>	</td>
					<td>		
							<select id="lesson_type">
								<?php
										require_once '../db_login.php'; 	
										$query = 'SELECT * FROM lesson_types WHERE typename != "syllabus"';
										$result = 	mysqli_query($db_server, $query) or die("Couldn't execute DELETE query: <br>".$query." error:". mysqli_error($db_server));
										while($fetch_result = mysqli_fetch_assoc($result))
										{
											$selected = ($lsntype_num == $fetch_result['lsntype']) ? 'selected' : '';
											echo '<option '.$selected.' value="'.$fetch_result['lsntype'].'">'.$fetch_result['typename'].'</option>';	
										}
								?>							
							</select>										
					</td>				
				</tr>
				<tr>
					<td>	<span>Create directory and database entry</span>	</td>
					<td>	
						<button class="myButton" data-lsnid="<?php echo $lsnid ?>" data-crsid="<?php echo $lsncrsid ?>" id="prevbutton" onclick="createlesson('modifycommit', this)">Commit</button>	
						<button class="myButton" id="cancelbutton" onclick="createlesson('cancel')">Cancel</button>	
					</td>		
				</tr>	
			</table>		
	
	<?php 
	
	break;
/********************************************************
	For case 'delete',  
*********************************************************/
	case 'delete':
	?>
	<?php break;
/********************************************************
	For case 'mod_description', folders have been set up 
	already and we are going to use TinyMCE to add or change
	a file with a description of the college 
*********************************************************/
	case 'mod_description':
			$lsncrsid = $_SESSION['lsncrsid'];
			$lsnid = $_SESSION['lsnid'];		
			$lsntitle = $_SESSION['lsntitle'];	
			$lsntype = $_SESSION['lsntype'];
			$typename = $_SESSION['lsntype_name'];
	?>
	
			<h2>Modify lesson/assignment</h2>
			
			<table summary="" >
				<tr>
					<td>	<span>Course Number: </span>	</td>
					<td>	<span id="coursenum"><?php echo $lsncrsid; ?></span> </td>				
				</tr>	
				<tr>
					<td>	<span>ID Number: </span>	</td>
					<td>	<span id="coursenum"><?php echo $lsnid; ?></span> </td>				
				</tr>
				<tr>
					<td>	<span>Lesson Title: </span>	</td>
					<td>	<span id="lesson_title"><?php echo $lsntitle; ?>	</td>			
				</tr>	
				<tr>
					<td>	<span>Lesson Type: </span>	</td>
					<td>	<span id="type_name"><?php echo $typename; ?>	</td>				
				</tr>
			</table> 
			</div>
			<?php      
			/********************************************************
				open a TinyMCE instance to add a description
				
				Set write folder for Responsive Filemanager
			*********************************************************/			
			$_SESSION['upload_dir']= '/academics/courses/'.$lsncrsid.'/'.$lsnid."/source/" ;
			$_SESSION['current_path']='../academics/courses/'.$lsncrsid.'/'.$lsnid."/source/" ;
			$_SESSION['thumbs_base_path']='../academics/courses/'.$lsncrsid.'/'.$lsnid."/thumbs/";	

			$lsnpath = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/courses/'.$lsncrsid.'/'.$lsnid;
			$file = 'Lesson_'.$lsnid.'.php';
			$filename = $lsnpath.'/'.$file ;					
			?>
			
			<div>	
				<span>Description of College:</span>
				<div id="target" class="fulledit">
				<?php
					if(file_exists($filename)) 
					{
						include $filename;
					}
					else 
					{
						echo	'Describe the mission, subject matter, and other characteristics of the college';
					}
				?>
				</div>
				<button class="myButton" id="addstuffbutton" onclick="createlesson('add_description')">Submit</button>
				<button class="myButton" id="cancelbutton" onclick="createlesson('cancel')">Skip</button>			
				<div id="preview"></div>
				<div id="writefileresult"></div>
			</div>	
	<?php 
	
	break;
/********************************************************
	For case 'DEFAULT', display a list of existing lessons
	and buttons to add new lessons and assignments 
*********************************************************/
	default:
		
		$crs_directory = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/courses/'.$lesson_crsid;	
		$crs_folders = scandir($crs_directory);

	/* DETERMINE WHICH Course WE ARE GETTING lessons FOR */		
		if(isset($lesson_crsid)) 
		{
			$clean_crsid = $lesson_crsid;
			/*$_SESSION['dept_cid'] = $clean_dbid;*/
			/*echo $clean_crsid;*/
		}
		else 
		{
			echo ("unknown course");
			break;
		}

		/* Get directories from file system*/
		for($i = 0; $i < count($crs_folders); $i++ ) 
		{
			if( $crs_folders[$i]!='.' && $crs_folders[$i]!='..' /*strlen($folders[$i])==4*/) 
			{ 

			$fs_crsfolders[] = $crs_folders[$i];
			}
		}
	
		require_once '../db_login.php'; 	
		$query = "SELECT * FROM lessons NATURAL JOIN lesson_types WHERE crsid=".$clean_crsid;
		$result = 	mysqli_query($db_server, $query) or die("Couldn't execute query: <br>".$query." error:". mysqli_error($db_server));

		unset ($db_lsnfolders);
		unset ($db_lsntitles);
		unset ($db_lsntype);
		
		/* Get directories from database */
		while ($fetch_result = mysqli_fetch_assoc($result))
		{
			/*$db_lsnfolders[] = $fetch_result['cabbr'];*/
			$db_lsnfolders[$fetch_result['viewindex']] = $fetch_result['lsnid'];
			$db_lsntitles[$fetch_result['lsnid']] = $fetch_result['lsntitle'];
			$db_lsntype[$fetch_result['lsnid']] = $fetch_result['typename'];
			$db_lsntypenum[$fetch_result['lsnid']] = $fetch_result['lsntype'];
		}

		/* Join file system and database directory arrays 
		$combined_folders = array_unique(array_merge($fs_folders, $db_lsnfolders));*/
		if(isset($db_lsnfolders))
		{
			ksort($db_lsnfolders);
		}
		
		echo '<div >';
		echo '<table >'.
					'<tr class="tableheader">'.
						'<td>ID#</td>'.
						'<td>Title</td>'.						
						'<td>Type</td>'.
						'<td>FS</td>'.
						'<td>Action</td>'.
					'</tr>';
		if(isset($db_lsnfolders))
		{		
			foreach ($db_lsnfolders as $value)
			{
				echo '<tr>';
				echo '<td>'.$value."</td>";
				
				$lsnid = $value;
								
				if	(!in_array($value, $db_lsnfolders))	
				{
					echo '<td style="color:red">###</td>';
					echo '<td style="color:red">Not in database ###</td>';
					$dbok = 0;

				}	
				else 
				{
					echo '<td>'.$db_lsntitles[$value]."</td>";
					echo '<td>'.$db_lsntype[$value]."</td>";
					$dbok = true;
					$lsntypenum = $db_lsntypenum[$value];
				}
			
				if	(isset($fs_crsfolders) ? !in_array($value, $fs_crsfolders): true)	
				{
					echo '<td style="color:red"><img height="16px" src="/css/smallbang.png" title="Folder missing from file system"></td>';
					$fsok = 0;
				}	
				else 
				{
					echo '<td class="greentext"><img height="16px" src="/css/checkmark_small.png" title="File system check: OK"></td>';
					$fsok = true;				
				}
				
				?>
					<td>
						<button class="myButton delete" data-fsok="<?php echo $fsok ?>" data-dbok="<?php echo $dbok ?>"  data-typenum="<?php echo $lsntypenum?>" data-lsnid="<?php echo $lsnid?>" data-crsid="<?php echo $clean_crsid?>" onclick="createlesson('delete',this)" alt="Delete" title="Delete" ></button>
						<button class="myButton edit" data-fsok="<?php echo $fsok ?>" data-dbok="<?php echo $dbok ?>"  data-typenum="<?php echo $lsntypenum?>" data-lsnid="<?php echo $lsnid?>" data-crsid="<?php echo $clean_crsid?>" onclick="createlesson('modify',this)" alt="Edit" title="Edit" ></button>
					</td>
				<?php	
				echo '</tr>';	
			}
		}
		/*echo '</table>';*/
		?>
		<tfoot>
			<div>			
			<tr>
				<td colspan="999">
					<button class="myButton" data-crsid="<?php echo $clean_crsid?>" onclick="createlesson('createlesson',this)">Add Lesson</button>				
					<button class="myButton" data-crsid="<?php echo $clean_crsid?>" onclick="createlesson('createassign',this)">Add Assignment</button>	
				</td>
			</tr>
			</div>			
		</tfoot>
		</table>
		</div>
	<?php 
	
		break;
	}

?>