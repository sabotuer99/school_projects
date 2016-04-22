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
if(!isset($_SESSION['create_college_option'])) 
{
	$option = 'DEFAULT';
}
else 
{
	$option = $_SESSION['create_college_option'];
}

if(isset($_SESSION['create_dept_option'])) 
{
	unset($_SESSION['create_dept_option']);
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
	?>
			
			<h2>Create a new college</h2>
			
			<table summary="" >
				<tr>
					<td>	<span>Name of College: </span>	</td>
					<td>	<input type="text" id="collegename" data-field="colname">	</td>				
				</tr>
				<tr>
					<td>	<span>Abbreviation (3 letters): </span>	</td>	
					<td>	<input type="text" id="collegeabbr" data-field="colabbr">	</td>						
				</tr>		
				<tr>
					<td>	<span>Create directory and database entry</span>	</td>
					<td>	
						<button class="myButton" id="prevbutton" onclick="createcolldir('createnew')">Create</button>	
						<button class="myButton" id="cancelbutton" onclick="createcolldir('cancel')">Cancel</button>	
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
	?>
			<h2>Create a new college</h2>
			<div>
			<table summary="" >
				<tr>
					<td>	<span>Name of College: </span>	</td>
						<?php		
							$purifier = new HTMLPurifier();	
							$clean_cname = $purifier->purify(urldecode($_SESSION['cname']));
						?>	
					<td>	<?php echo $clean_cname?>	</td>		
				</tr>
				<tr>
					<td>	<span>Abbreviation (3 letters): </span>	</td>
						<?php		
							$purifier = new HTMLPurifier();
			 				$clean_abbr = substr(strtoupper($purifier->purify(urldecode($_SESSION['cabr']))),0,3);					
						?>	
					<td>	<?php echo $clean_abbr?>	</td>							
				</tr>
			</table>
			</div>
			<?php 
			/********************************************************
				open a TinyMCE instance to add a description
				
				Set write folder for Responsive Filemanager
			*********************************************************/			
/*			$purifier = new HTMLPurifier();
 			$clean_abbr = substr(strtoupper($purifier->purify(urldecode($_SESSION['cabr']))),0,3);
			$_SESSION['upload_dir']= "/academics/colleges/".$clean_abbr."/source/" ;	
			/* $descpath = */		
			$purifier = new HTMLPurifier();
			$clean_dbid = $_SESSION['dbid'];

			/*echo $_SERVER['SERVER_NAME'];*/
			$_SESSION['upload_dir']= "/academics/colleges/".$clean_dbid."/source/" ;
			$_SESSION['current_path']="../academics/colleges/".$clean_dbid."/source/" ;
			$_SESSION['thumbs_base_path']="../academics/colleges/".$clean_dbid."/thumbs/";			
		
		?>
			
			<div>	
				<span>Description of College:</span>
				<div id="target" class="fulledit">Describe the mission, subject matter, and other characteristics of the college</div>
				<button class="myButton" id="addstuffbutton" onclick="createcolldir('add_description')">Submit</button>
				<button class="myButton" id="cancelbutton" onclick="createcolldir('cancel')">Skip</button>			
				<div id="preview"></div>
				<div id="writefileresult"></div>
			</div>	
	<?php break;
/********************************************************
	For case 'modify', check 
*********************************************************/
	case 'modify':
					
			$purifier = new HTMLPurifier();	
			$clean_cname = $purifier->purify($_SESSION['cname']);
			$clean_abbr = strtoupper($purifier->purify($_SESSION['cabr']));				

	?>
			<h2>Modify college</h2>
			
			<table summary="" >
				<tr>
					<td>	<span>Name of College: </span>	</td>
					<td>	<input type="text" id="collegename" data-field="colname" value="<?php echo $clean_cname;?>">	</td>				
				</tr>
				<tr>
					<td>	<span>Abbreviation (3 letters): </span>	</td>	
					<td>	<input type="text" id="collegeabbr" data-field="colabbr" value="<?php echo $clean_abbr;?>">	</td>						
				</tr>		
				<tr>
					<td>	<span>Create directory and database entry</span>	</td>
					<td>	
						<button class="myButton" id="prevbutton" onclick="createcolldir('modifycommit')">Commit</button>	
						<button class="myButton" id="cancelbutton" onclick="createcolldir('cancel')">Cancel</button>	
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
	?>
			<h2>Modify college</h2>
			<div>
			<table summary="" >
				<tr>
					<td>	<span>Name of College: </span>	</td>
						<?php		
							$purifier = new HTMLPurifier();	
							$clean_cname = $purifier->purify(urldecode($_SESSION['cname']));
						?>	
					<td>	<?php echo $clean_cname?>	</td>		
				</tr>
				<tr>
					<td>	<span>Abbreviation (3 letters): </span>	</td>
						<?php		
							$purifier = new HTMLPurifier();
			 				$clean_abbr = substr(strtoupper($purifier->purify(urldecode($_SESSION['cabr']))),0,3);					
						?>	
					<td>	<?php echo $clean_abbr?>	</td>							
				</tr>
			</table> 
			</div>
			<?php      
			/********************************************************
				open a TinyMCE instance to add a description
				
				Set write folder for Responsive Filemanager
			*********************************************************/			
			$purifier = new HTMLPurifier();
			$clean_dbid = $_SESSION['dbid'];

			/*echo $_SERVER['SERVER_NAME'];*/
			$_SESSION['upload_dir']= "/academics/colleges/".$clean_dbid."/source/" ;
			$_SESSION['current_path']="../academics/colleges/".$clean_dbid."/source/" ;
			$_SESSION['thumbs_base_path']="../academics/colleges/".$clean_dbid."/thumbs/";
			
 			$clean_name = $_SESSION['cname'];

			$collpath = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/colleges/'.$clean_dbid;
			$file = $clean_dbid.'_description.php';
			$filename = $collpath.'/'.$file ;					
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
				<button class="myButton" id="addstuffbutton" onclick="createcolldir('add_description')">Submit</button>
				<button class="myButton" id="cancelbutton" onclick="createcolldir('cancel')">Skip</button>			
				<div id="preview"></div>
				<div id="writefileresult"></div>
			</div>	
	<?php break;
/********************************************************
	For case 'DEFAULT', display a list of existing colleges
	and a button to add a new college 
*********************************************************/
	default:
		
		echo '<h2>Manage Colleges and Academic Departments</h2>';

		$directory = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/colleges';
	
		$folders = scandir($directory);
	

		/* Get directories from file system*/
		for($i = 0; $i < count($folders); $i++ ) 
		{
			if( $folders[$i]!='.' && $folders[$i]!='..' /*strlen($folders[$i])==4*/) 
			{ 

			$fs_folders[] = $folders[$i];
			}
		}
	
		require_once '../db_login.php'; 	
		$query = "SELECT * FROM colleges";
		$result = 	mysqli_query($db_server, $query) or die("Couldn't execute insert query: <br>".$query." error:". mysqli_error($db_server));
		
		/* Get directories from database */
		while ($fetch_result = mysqli_fetch_assoc($result))
		{
			/*$db_folders[] = $fetch_result['cabbr'];*/
			$db_folders[] = $fetch_result['cid'];
			$db_collnames[$fetch_result['cid']] = $fetch_result['cname'];
			$db_collabbr[$fetch_result['cid']] = $fetch_result['cabbr'];
		}

		/* Join file system and database directory arrays */
		$combined_folders = array_unique(array_merge($fs_folders, $db_folders));
		asort($combined_folders);
		
		echo '<div >';
		echo '<table id="collegestable" >'.
					'<tr class="tableheader">'.
						'<td>ID#</td>'.
						'<td>Abbr.</td>'.						
						'<td>Name</td>'.
						'<td>File System</td>'.
						'<td>Action</td>'.
					'</tr>';
		foreach ($combined_folders as $value)
		{
			echo '<tr>';
			echo '<td>'.$value."</td>";
			
			if	(!in_array($value, $db_folders))	
			{
				echo '<td style="color:red">###</td>';
				echo '<td style="color:red">Not in database ###</td>';
				$dbok = 0;
				$dbid = $value;
				$dbab = 0;
			}	
			else 
			{
				echo '<td>'.$db_collabbr[$value]."</td>";
				echo '<td>'.$db_collnames[$value]."</td>";
				$dbok = true;
				$dbid = $value;
				$dbab = $db_collabbr[$value];
			}
		
			if	(!in_array($value, $fs_folders))	
			{
				echo '<td style="color:red">Missing</td>';
				$fsok = 0;
			}	
			else 
			{
				echo '<td class="greentext">Check OK</td>';
				$fsok = true;				
			}
	
			/* Determine whether departments are shown or hidden */	
			if(isset($_COOKIE['COLLEGE'.$dbid])) 
			{		
				$dept_hidden = 'Hide';
				$dept_style = 'border:2px solid;';
			}
			else
			{
				$dept_hidden = 'Depts';
				$dept_style = 	'height:0px;border:0px solid transparent;';	
			}
			
			?>
				<td>
					<button class="myButton delete" data-fsok="<?php echo $fsok ?>" data-dbok="<?php echo $dbok ?>" data-abbr="<?php echo $dbab?>" data-dbid="<?php echo $dbid?>" onclick="createcolldir('delete',this)" alt="Delete" title="Delete"></button>
					<button class="myButton edit" data-fsok="<?php echo $fsok ?>" data-dbok="<?php echo $dbok ?>" data-abbr="<?php echo $dbab?>" data-dbid="<?php echo $dbid?>" onclick="createcolldir('modify',this)" alt="Edit" title="Edit" ></button>
					<button class="myButton" data-target="COLLEGE<?php echo $dbid?>" onclick="toggle_coll_depts(this)" title="Departments"><?php echo $dept_hidden; ?></button>
				</td>
			<?php	
			echo '</tr>';
			echo '<tr class="table_colldepts"><td class="notableborder" colspan="999" style="overflow:hidden;"><div class="collsubtable" id="COLLEGE'.$dbid.'" style="'.$dept_style.'">';
			$dept_cid=$dbid;
			include "createdept.php"; 
			echo '</div></td></tr>';
		}
		/*echo '</table>';*/
		?>
		<tfoot>
			<div>			
			<tr>
				<td colspan="999">
					<button class="myButton" id="addcollege" onclick="createcolldir('createform')">Add College</button>				
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