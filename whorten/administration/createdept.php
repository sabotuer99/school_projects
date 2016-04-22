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
		script.src= '/administration/admin.js';
		head.appendChild(script);
	</script>	
	
</div>

<?php 
/********************************************************
	if the option variable is not set, use the default 
	case. otherwise, use the given option variable
*********************************************************/	
if(!isset($_SESSION['create_dept_option'])) 
{
	$option = 'DEFAULT';
}
else 
{
	$option = $_SESSION['create_dept_option'];
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

			$deptcid = $_SESSION['deptcid'];	
	
	?>
			
			<h2>Create a new academic department</h2>
			
			<table summary="" >
				<tr>
					<td>	<span>College Number: </span>	</td>
					<td>	<span id="collegenum"><?php echo $deptcid; ?></span> </td>				
				</tr>
				<tr>
					<td>	<span>Name of Department: </span>	</td>
					<td>	<input type="text" id="deptname" data-field="deptname">	</td>				
				</tr>
				<tr>
					<td>	<span>Abbreviation (4 letters): </span>	</td>	
					<td>	<input type="text" id="deptabbr" data-field="deptabbr">	</td>						
				</tr>		
				<tr>
					<td>	<span>Create directory and database entry</span>	</td>
					<td>	
						<button class="myButton" id="prevbutton" onclick="createdeptdir('createnew')">Create</button>	
						<button class="myButton" id="cancelbutton" onclick="createdeptdir('cancel')">Cancel</button>	
					</td>		
				</tr>	
			</table>			
	<?php break;

/********************************************************
	For case 'add_description', folders have been set up 
	already and we are going to use TinyMCE to add a 
	file with a description of the college 
*********************************************************/
	case 'add_description':
	$deptcid = $_SESSION['deptcid'];
	?>
			<h2>Create a new academic department</h2>
			<div>
			<table summary="" >
				<tr>
					<td>	<span>College Number: </span>	</td>
					<td>	<span id="collegenum"><?php echo $deptcid; ?></span> </td>				
				</tr>				
				<tr>
					<td>	<span>Name of Department: </span>	</td>
						<?php		
							$purifier = new HTMLPurifier();	
							$clean_dname = $purifier->purify(urldecode($_SESSION['dname']));
						?>	
					<td>	<?php echo $clean_dname?>	</td>		
				</tr>
				<tr>
					<td>	<span>Abbreviation (4 letters): </span>	</td>
						<?php		
							$purifier = new HTMLPurifier();
			 				$clean_dabbr = substr(strtoupper($purifier->purify(urldecode($_SESSION['dabbr']))),0,4);					
						?>	
					<td>	<?php echo $clean_dabbr?>	</td>							
				</tr>
			</table>
			</div>
			<?php 
			/********************************************************
				open a TinyMCE instance to add a description
				
				Set write folder for Responsive Filemanager
			*********************************************************/			
			$purifier = new HTMLPurifier();
			$clean_deptid = $_SESSION['deptid'];

			/*echo $_SERVER['SERVER_NAME'];*/
			$_SESSION['upload_dir']= "/academics/depts/".$clean_deptid."/source/" ;
			$_SESSION['current_path']="../academics/depts/".$clean_deptid."/source/" ;
			$_SESSION['thumbs_base_path']="../academics/depts/".$clean_deptid."/thumbs/";			
		?>
			
			<div>	
				<span>Description of Academic Department:</span>
				<div id="target" class="fulledit">Describe the mission, subject matter, and other characteristics of the department</div>
				<button class="myButton" id="addstuffbutton" onclick="createdeptdir('add_description')">Submit</button>
				<button class="myButton" id="cancelbutton" onclick="createdeptdir('cancel')">Skip</button>			
				<div id="preview"></div>
				<div id="writefileresult"></div>
			</div>	
	<?php break;
/********************************************************
	For case 'modify', check 
*********************************************************/
	case 'modify':
					
			$purifier = new HTMLPurifier();	
			$clean_dname = $purifier->purify($_SESSION['dname']);
			$clean_dabbr = strtoupper($purifier->purify($_SESSION['dabbr']));				
			$deptcid = $_SESSION['deptcid'];	

	?>
			<h2>Modify academic department</h2>
			
			<table summary="" >
				<tr>
					<td>	<span>College Number: </span>	</td>
					<td>	<span id="collegenum"><?php echo $deptcid; ?></span> </td>				
				</tr>
				<tr>
					<td>	<span>Name of department: </span>	</td>
					<td>	<input type="text" id="deptname" data-field="deptname" value="<?php echo $clean_dname;?>">	</td>				
				</tr>
				<tr>
					<td>	<span>Abbreviation (4 letters): </span>	</td>	
					<td>	<input type="text" id="deptabbr" data-field="deptabbr" value="<?php echo $clean_dabbr;?>">	</td>						
				</tr>		
				<tr>
					<td>	<span>Create directory and database entry</span>	</td>
					<td>	
						<button class="myButton" id="prevbutton" onclick="createdeptdir('modifycommit')">Commit</button>	
						<button class="myButton" id="cancelbutton" onclick="createdeptdir('cancel')">Cancel</button>	
					</td>		
				</tr>	
			</table>		
	
	<?php break;
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
				$deptcid = $_SESSION['deptcid'];
	?>
			<h2>Modify academic department</h2>
			<div>
			<table summary="" >
				<tr>
					<td>	<span>College Number: </span>	</td>
					<td>	<span id="collegenum"><?php echo $deptcid; ?></span> </td>				
				</tr>
				<tr>
					<td>	<span>Name of academic department: </span>	</td>
						<?php		
							$purifier = new HTMLPurifier();	
							$clean_dname = $purifier->purify(urldecode($_SESSION['dname']));
						?>	
					<td>	<?php echo $clean_dname?>	</td>		
				</tr>
				<tr>
					<td>	<span>Abbreviation (4 letters): </span>	</td>
						<?php		
							$purifier = new HTMLPurifier();
			 				$clean_dabbr = substr(strtoupper($purifier->purify(urldecode($_SESSION['dabbr']))),0,4);					
						?>	
					<td>	<?php echo $clean_dabbr?>	</td>							
				</tr>
			</table> 
			</div>
			<?php      
			/********************************************************
				open a TinyMCE instance to add a description
				
				Set write folder for Responsive Filemanager
			*********************************************************/			
			$purifier = new HTMLPurifier();
			$clean_deptid = $_SESSION['deptid'];

			/*echo $_SERVER['SERVER_NAME'];*/
			$_SESSION['upload_dir']= "/academics/depts/".$clean_deptid."/source/" ;
			$_SESSION['current_path']="../academics/depts/".$clean_deptid."/source/" ;
			$_SESSION['thumbs_base_path']="../academics/depts/".$clean_deptid."/thumbs/";
			
 			$clean_name = $_SESSION['dname'];

			$deptpath = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/depts/'.$clean_deptid;
			$file = $clean_deptid.'_description.php';
			$filename = $deptpath.'/'.$file ;					
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
				<button class="myButton" id="addstuffbutton" onclick="createdeptdir('add_description')">Submit</button>
				<button class="myButton" id="cancelbutton" onclick="createdeptdir('cancel')">Skip</button>			
				<div id="preview"></div>
				<div id="writefileresult"></div>
			</div>	
	<?php break;
/********************************************************
	For case 'DEFAULT', display a list of existing colleges
	and a button to add a new college 
*********************************************************/
	default:
		
		$dept_directory = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/depts';	
		$dept_folders = scandir($dept_directory);

	/* DETERMINE WHICH COLLEGE WE ARE GETTING DEPARTMENTS FOR */		
		if(isset($dept_cid)) 
		{
			$purifier = new HTMLPurifier();	
			$clean_dbid = $dept_cid;
			/*$_SESSION['dept_cid'] = $clean_dbid;*/
		}
		else 
		{
			die ("unknown college");
		}

		/* Get directories from file system*/
		for($i = 0; $i < count($dept_folders); $i++ ) 
		{
			if( $dept_folders[$i]!='.' && $dept_folders[$i]!='..' /*strlen($folders[$i])==4*/) 
			{ 

			$fs_deptfolders[] = $dept_folders[$i];
			}
		}
	
		require_once '../db_login.php'; 	
		$query = "SELECT * FROM departments WHERE cid=".$clean_dbid;
		$result = 	mysqli_query($db_server, $query) or die("Couldn't execute query: <br>".$query." error:". mysqli_error($db_server));

		unset ($db_deptfolders);
		unset ($db_deptnames);
		unset ($db_deptabbr);
		
		/* Get directories from database */
		while ($fetch_result = mysqli_fetch_assoc($result))
		{
			/*$db_folders[] = $fetch_result['cabbr'];*/
			$db_deptfolders[] = $fetch_result['did'];
			$db_deptnames[$fetch_result['did']] = $fetch_result['dname'];
			$db_deptabbr[$fetch_result['did']] = $fetch_result['dabbr'];
		}

		/* Join file system and database directory arrays THIS DOESN'T WORK FOR DEPARTMENTS
		$combined_folders = array_unique(array_merge($fs_folders, $db_folders));*/
		if(isset($db_deptfolders))
		{
			asort($db_deptfolders);
		}
		
		echo '<div >';
		echo '<table >';/*.
					'<tr class="tableheader">'.
						'<td>ID#</td>'.
						'<td>Abbr.</td>'.						
						'<td>Name</td>'.
						'<td>File System</td>'.
						'<td></td>'.
					'</tr>';*/
		if(isset($db_deptfolders))
		{		
			foreach ($db_deptfolders as $value)
			{
				echo '<tr>';
				echo '<td>'.$value."</td>";
				
				if	(!in_array($value, $db_deptfolders))	
				{
					echo '<td style="color:red">###</td>';
					echo '<td style="color:red">Not in database ###</td>';
					$dbok = 0;
					$dbid = $value;
					$dbab = 0;
				}	
				else 
				{
					echo '<td>'.$db_deptabbr[$value]."</td>";
					echo '<td>'.$db_deptnames[$value]."</td>";
					$dbok = true;
					$deptid = $value;
					$dabbr = $db_deptabbr[$value];
				}
			
				if	(isset($fs_deptfolders) ? !in_array($value, $fs_deptfolders): true)	
				{
					echo '<td style="color:red">Missing</td>';
					$fsok = 0;
				}	
				else 
				{
					echo '<td class="greentext">Check OK</td>';
					$fsok = true;				
				}
				
				?>
					<td>
						<button class="myButton delete" data-fsok="<?php echo $fsok ?>" data-dbok="<?php echo $dbok ?>" data-abbr="<?php echo $dabbr?>" data-dbid="<?php echo $deptid?>" data-cid="<?php echo $clean_dbid?>" onclick="createdeptdir('delete',this)" alt="Delete" title="Delete" ></button>
						<button class="myButton edit" data-fsok="<?php echo $fsok ?>" data-dbok="<?php echo $dbok ?>" data-abbr="<?php echo $dabbr?>" data-dbid="<?php echo $deptid?>" data-cid="<?php echo $clean_dbid?>" onclick="createdeptdir('modify',this)" alt="Edit" title="Edit" ></button>
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
					<button class="myButton" id="adddept" data-cid="<?php echo $clean_dbid?>" onclick="createdeptdir('createform',this)">Add Department</button>				
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