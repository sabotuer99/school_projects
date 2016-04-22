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
	
<!--	<script type="text/javascript" >
		if (document.getElementById('prelim_deptabbr')!=null) 
		{
			update_prelim_id();
		}
	</script> -->
	
</div>

<?php 
/********************************************************
	if the option variable is not set, use the default 
	case. otherwise, use the given option variable
*********************************************************/	
if(!isset($_SESSION['create_crs_option'])) 
{
	$option = 'DEFAULT';
}
else 
{
	$option = $_SESSION['create_crs_option'];
}

if(isset($_SESSION['create_lesson_option'])) 
{
	unset($_SESSION['create_lesson_option']);
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
			
			<h2>Create a new course</h2>
			<table summary="Catalog Entry" style="width:100%">
				<tr class="tableheader">
					<td colspan="4">Catalog Entry</td>
				</tr>
				<tr>
					<td style="width:20%">	<span>Title: </span>	</td>
					<td style="width:30%">	<input type="text" id="coursename" data-field="crsname" style="width:100%">	</td>	
					<td style="width:20%"></td>	
					<td style="width:30%"></td>		
				</tr>
				<tr>
					<td>	<span>College: </span>	</td>	
					<td>	<select onchange="updatecrsform('updatecrslist',this,'deptlist')" style="width:100%;">
					<?php
					echo '<option value="null">Select a college</option>';						
					require_once '../db_login.php'; 	
					$query = 'SELECT * FROM colleges ';
					$result = 	mysqli_query($db_server, $query) or die("Couldn't execute SELECT query: <br>".$query." error:". mysqli_error($db_server));
					while($fetch_result = mysqli_fetch_assoc($result)) 
					{
						echo '<option value="'.$fetch_result['cid'].'">'.$fetch_result['cname'].'</option>';	
					}
					
					?>		</select>	</td>		
					<td>  <span>Credit Hours: </span> </td>	
					<td>  <select id='credithours' style="width:100%;">
								<option value="1">1</option>
								<option value="2">2</option>
								<option selected value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>								
							</select> </td>									
				</tr>		
				<tr>
					<td>	<span>Department: </span>	</td>	
					<td>	<select id="deptlist" style="width:100%;" onchange="update_prelim_id()">
								<option>No Departments</option>
							</select>	</td>		
					<td>  <span>Type: </span> </td>	
					<td>  <select style="width:100%;">
								<option>Lecture</option>
							</select> </td>									
				</tr>	
				<tr>
					<td>	<span>Level: </span>	</td>	
					<td>	<select style="width:100%;" onchange="update_prelim_id()" id="class_level">
								<option value="1000">1000 - Freshman</option>
								<option value="2000">2000 - Sophmore</option>
								<option value="3000">3000 - Junior</option>
								<option value="4000">4000 - Senior</option>
								<option value="5000">5000 - Advanced</option>
							</select>	</td>		
					<td>   </td>	
					<td>   </td>									
				</tr>	
				<tr>
					<td>	<span>Sublevel: </span>	</td>	
					<td>	<select style="width:100%;" onchange="update_prelim_id()" id="class_sublevel">
								<option value="null">None</option>
								<option value="100">0100 - [No Category]</option>
							</select>	</td>		
					<td>  <span>Preliminary ID: </span> </td>	
					<td>  <span id="prelim_deptabbr">ENGL</span><span id="prelim_crsnum">1100</span> </td>									
				</tr>	
				<tr>
					<td>	<span>Section of: </span>	</td>	
					<td>	<select style="width:100%;">
								<option>None (New Course)</option>
							</select>	</td>		
					<td>  <span>Section #: </span> </td>	
					<td>  01 </td>									
				</tr>	
				<tr>
					<td colspan="999"><span>Description:</span></td>
				</tr>
				<tr>
					<td colspan="999">
						<textarea style="width:100%" rows="4" id="crsdesc"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="999"><span>Prerequisites:</span></td>
				</tr>
				<tr>
					<td colspan="999">
						<table summary="" style="width:100%;border:1px solid">
							<tr class="tableheader">
								<td style="width:45%;border-right:1px solid">
									Individual Courses
								</td>
								<td style="width:55%">
									Course Groups
								</td>
							</tr>
							<tr>
								<td style="width:45%;border-right:1px solid">
									<button class="myButton" >Add class</button>
								</td>
								<td id="pr_cg_list">
									<div class="pr_cg">
										<span>Course Group 1</span><br>
										<select class="pr_cg_selection">
											<option>0001 - Orientation</option>		
											<option>0002 - English Foundation</option>								
										</select><br>
										<span>Current Group Courses:</span><br>
										<span>- ORNT1000 - Being a Whorten Student</span><br>
										<span>- ORNT1001 - Basic College Readiness</span><br>
										<span>Courses required for satisfaction:</span><br>
										<select>
											<option>ALL</option>		
											<option>SOME</option>	
											<option>ONE</option>									
										</select><br><br>
										<hr>
									</div>
									<div id="crsgroup_buttons" style="display:block">
										<button class="myButton" >Add Course Group</button><br>
										<button class="myButton" onclick="toggle_crsgroup_create()">Create New Course Group</button><br>
									</div>
									<div id="create_crsgroup" style="display:none">
										
										<span>Create New Course Group</span><br><br>
										<button class="myButton" >Add class</button><br>
										<button class="myButton" onclick="toggle_crsgroup_create()">Save</button><br>
										
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>	
				<tr>
					<td colspan="999"><span>Add this course to Course Groups:</span></td>
				</tr>
				<tr>
					<td colspan="999">
						<select>
							<option>0011 - Freshman English Core</option>		
							<option>0012 - Sophmore English Core</option>	
							<option>0013 - Junior Level History Core</option>									
						</select>	
						<button class="myButton" >Filter</button><br>
						<button class="myButton" >Add to another group</button>				
					</td>
				</tr>										
				<tr>
					<td colspan="999">	
						<hr>
						<button class="myButton" id="prevbutton" onclick="createcrs('createnew')">Create Catalog Entry</button>	
						<button class="myButton" id="cancelbutton" onclick="createcrs('cancel')">Cancel</button>	
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
/*	?>
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
/* 
	  		$purifier = new HTMLPurifier();
 			$clean_abbr = substr(strtoupper($purifier->purify(urldecode($_SESSION['cabr']))),0,3);
			$_SESSION['upload_dir']= "/academics/colleges/".$clean_abbr."/source/" ;	
			/* $descpath = */				
/*		
		?>
			
			<div>	
				<span>Description of College:</span>
				<div id="target" class="fulledit">Describe the mission, subject matter, and other characteristics of the college</div>
				<button class="myButton" id="addstuffbutton" onclick="createcrs('add_description')">Submit</button>
				<button class="myButton" id="cancelbutton" onclick="createcrs('cancel')">Skip</button>			
				<div id="preview"></div>
				<div id="writefileresult"></div>
			</div>	
	<?php 
*/			break;
/********************************************************
	For case 'modify', check 
*********************************************************/
	case 'modify':

/*	echo 			'Name: '.$_SESSION['crsname'].'<br>'.
					'Level: '.$_SESSION['crslevel'].'<br>'. 
					'Sublevel: '.$_SESSION['crssublevel'].'<br>'.	
					'Description: '.$_SESSION['crsdesc'].'<br>'.
					'Credit hours: '.$_SESSION['crscred'].'<br>'.
					'Course Num: '.$_SESSION['crsnum'].'<br>'.					
					'College ID: '.$_SESSION['crscid'].'<br>'.
					'Course ID: '.$_SESSION['crsid'].'<br>'.		
					'Dept ID: '.$_SESSION['crsdid'].'<br>';
*/

foreach($_SESSION as $key => $value)
{
	echo $key.": ".$value."<br>";
}
	?>
			
			<h2>Modify a course</h2>
			<table summary="Catalog Entry" style="width:100%">
				<tr class="tableheader">
					<td colspan="4">Catalog Entry</td>
				</tr>
				<tr>
					<td style="width:20%">	<span>Title: </span>	</td>
					<td style="width:30%">	<input type="text" id="coursename" data-field="crsname" style="width:100%" value="<?php echo $_SESSION['crsname']; ?>">	</td>	
					<td style="width:20%"></td>	
					<td style="width:30%"></td>		
				</tr>
				<tr>
					<td>	<span>College: </span>	</td>	
					<td>	<select onchange="updatecrsform('updatecrslist',this,'deptlist')" style="width:100%;">
					<?php
					echo '<option value="null">Select a college</option>';						
					require_once '../db_login.php'; 	
					$query = 'SELECT * FROM colleges ';
					$result = 	mysqli_query($db_server, $query) or die("Couldn't execute SELECT query: <br>".$query." error:". mysqli_error($db_server));
					while($fetch_result = mysqli_fetch_assoc($result)) 
					{
						$selected = $_SESSION['crscid'] == $fetch_result['cid'] ? 'selected' : '';

						echo '<option '.$selected.' value="'.$fetch_result['cid'].'">'.$fetch_result['cname'].'</option>';	
					}
					
					?>		</select>	</td>		
					<td>  <span>Credit Hours: </span> </td>	
					<td>  <select id='credithours' style="width:100%;">
								<option <?php if($_SESSION['crscred']==1){echo 'selected';} ?> value="1">1</option>
								<option <?php if($_SESSION['crscred']==2){echo 'selected';} ?> value="2">2</option>
								<option <?php if($_SESSION['crscred']==3){echo 'selected';} ?> value="3">3</option>
								<option <?php if($_SESSION['crscred']==4){echo 'selected';} ?> value="4">4</option>
								<option <?php if($_SESSION['crscred']==5){echo 'selected';} ?> value="5">5</option>								
							</select> </td>									
				</tr>		
				<tr>
					<td>	<span>Department: </span>	</td>	
					<td>	<select id="deptlist" style="width:100%;" onchange="update_prelim_id()">
								<?php		 		
								$clean_cid = $_SESSION['crscid'];
		 		
						 		require_once '../db_login.php'; 	
								$query = "SELECT * FROM departments WHERE cid='". $clean_cid."';";
								$result = 	mysqli_query($db_server, $query) or die("Couldn't execute query: <br>".$query." error:". mysqli_error($db_server));											
								
								if(mysqli_num_rows($result)==0) 
								{
									echo 	'<option> No Departments </option>';
								}			
								
								while($fetch_result = mysqli_fetch_assoc($result)) 
								{
									$selected = $_SESSION['crsdid'] == $fetch_result['did'] ? 'selected' : '';
									
									if ($selected != '') 
									{
											$deptabbr = strtoupper($fetch_result['dabbr']);
									}									
									
									echo '<option '.$selected.' value="'.$fetch_result['did'].'" data-abbr="'.$fetch_result['dabbr'].'">'.$fetch_result['dabbr'].' - '.$fetch_result['dname'].'</option>';	
								}	
								?>
							</select>	</td>		
					<td>  <span>Type: </span> </td>	
					<td>  <select style="width:100%;">
								<option>Lecture</option>
							</select> </td>									
				</tr>	
				<tr>
					<td>	<span>Level: </span>	</td>	
					<td>	<select style="width:100%;" onchange="update_prelim_id()" id="class_level">
								<option <?php if($_SESSION['crslevel']==1000){echo 'selected';} ?> value="1000"> 1000 - Freshman</option>
								<option <?php if($_SESSION['crslevel']==2000){echo 'selected';} ?> value="2000"> 2000 - Sophmore</option>
								<option <?php if($_SESSION['crslevel']==3000){echo 'selected';} ?> value="3000"> 3000 - Junior</option>
								<option <?php if($_SESSION['crslevel']==4000){echo 'selected';} ?> value="4000"> 4000 - Senior</option>
								<option <?php if($_SESSION['crslevel']==5000){echo 'selected';} ?> value="5000"> 5000 - Advanced</option>
							</select>	</td>		
					<td>   </td>	
					<td>   </td>									
				</tr>	
				<tr>
					<td>	<span>Sublevel: </span>	</td>	
					<td>	<select style="width:100%;" onchange="update_prelim_id()" id="class_sublevel">
								<option value="null">None</option>
								<option <?php if($_SESSION['crssublevel']==100){echo 'selected';} ?> value="100">0100 - [No Category]</option>
							</select>	</td>		
					<td>  <span>Preliminary ID: </span> </td>	
					<td>  <span id="prelim_deptabbr"><?php echo $deptabbr; ?></span><span id="prelim_crsnum"><?php echo $_SESSION['crsnum']; ?></span> </td>									
				</tr>	
				<tr>
					<td>	<span>Section of: </span>	</td>	
					<td>	<select style="width:100%;">
								<option>None (New Course)</option>
							</select>	</td>		
					<td>  <span>Section #: </span> </td>	
					<td>  01 </td>									
				</tr>	
				<tr>
					<td colspan="999"><span>Description:</span></td>
				</tr>
				<tr>
					<td colspan="999">
						<textarea style="width:100%" rows="4" id="crsdesc"><?php echo $_SESSION['crsdesc']; ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="999"><span>Prerequisites:</span></td>
				</tr>
				<tr>
					<td colspan="999">
						<table summary="" style="width:100%;border:1px solid">
							<tr class="tableheader">
								<td style="width:45%;border-right:1px solid">
									Individual Courses
								</td>
								<td style="width:55%">
									Course Groups
								</td>
							</tr>
							<tr>
								<td style="width:45%;border-right:1px solid">
									<button class="myButton" >Add class</button>
								</td>
								<td id="pr_cg_list">
									<div class="pr_cg">
										<span>Course Group 1</span><br>
										<select class="pr_cg_selection">
											<option>0001 - Orientation</option>		
											<option>0002 - English Foundation</option>								
										</select><br>
										<span>Current Group Courses:</span><br>
										<span>- ORNT1000 - Being a Whorten Student</span><br>
										<span>- ORNT1001 - Basic College Readiness</span><br>
										<span>Courses required for satisfaction:</span><br>
										<select>
											<option>ALL</option>		
											<option>SOME</option>	
											<option>ONE</option>									
										</select><br><br>
										<hr>
									</div>
									<div id="crsgroup_buttons" style="display:block">
										<button class="myButton" >Add Course Group</button><br>
										<button class="myButton" onclick="toggle_crsgroup_create()">Create New Course Group</button><br>
									</div>
									<div id="create_crsgroup" style="display:none">
										
										<span>Create New Course Group</span><br><br>
										<button class="myButton" >Add class</button><br>
										<button class="myButton" onclick="toggle_crsgroup_create()">Save</button><br>
										
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>	
				<tr>
					<td colspan="999"><span>Add this course to Course Groups:</span></td>
				</tr>
				<tr>
					<td colspan="999">
						<select>
							<option>0011 - Freshman English Core</option>		
							<option>0012 - Sophmore English Core</option>	
							<option>0013 - Junior Level History Core</option>									
						</select>	
						<button class="myButton" >Filter</button><br>
						<button class="myButton" >Add to another group</button>				
					</td>
				</tr>										
				<tr>
					<td colspan="999">	
						<hr>
						<button class="myButton" id="prevbutton" onclick="createcrs('modifycommit')">Update Catalog Entry</button>	
						<button class="myButton" id="cancelbutton" onclick="createcrs('cancel')">Cancel</button>	
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
/*	?>
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
/*			$purifier = new HTMLPurifier();
			$clean_dbid = $_SESSION['dbid'];

			/*echo $_SERVER['SERVER_NAME'];*/
/*			$_SESSION['upload_dir']= "/academics/colleges/".$clean_dbid."/source/" ;
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
				<button class="myButton" id="addstuffbutton" onclick="createcrs('add_description')">Submit</button>
				<button class="myButton" id="cancelbutton" onclick="createcrs('cancel')">Skip</button>			
				<div id="preview"></div>
				<div id="writefileresult"></div>
			</div>	
	<?php 
*/			break;
/********************************************************
	For case 'DEFAULT', display a list of existing colleges
	and a button to add a new college 
*********************************************************/
	default:
		
		echo '<h2>Manage Courses</h2>';

		$directory = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/courses';
	
		$folders = scandir($directory);
	

		/* Get directories from file system*/
		$fs_folders = array();
		$dept_folders = array();
		for($i = 0; $i < count($folders); $i++ ) 
		{
			if( $folders[$i]!='.' && $folders[$i]!='..') 
			{ 
			
			$fs_folders[] = $folders[$i];
			
			/*
				$subdir = $directory.'/'.$folders[$i];
				$subfolders = scandir($subdir);
				for($j = 0; $j < count($subfolders); $j++ ) 
				{
					if( is_dir($subdir.'/'.$subfolders[$j]) && $subfolders[$j]!='.' && $subfolders[$j]!='..' && $subfolders[$j]!='thumbs' && $subfolders[$j]!='source') 
					{ 
						$dept_folders[$folders[$i]][] = $subfolders[$j];
						$fs_folders[] = $subfolders[$j];	
						$fs_dids[$subfolders[$j]] = $folders[$i];					
					}
				}
			*/
			}
		}
	
		require_once '../db_login.php'; 	
		$query = "SELECT * FROM courses LEFT JOIN departments USING(did)";
		$result = 	mysqli_query($db_server, $query) or die("Couldn't execute insert query: <br>".$query." error:". mysqli_error($db_server));
		
		/* Get directories from database */
		$db_crsids = array();
		while ($fetch_result = mysqli_fetch_assoc($result))
		{
			$db_crsids[] = $fetch_result['crsid'];
			$db_crsdepts[$fetch_result['crsid']] = $fetch_result['dabbr'];
			$db_crsdids[$fetch_result['crsid']] = $fetch_result['did'];
			$db_crssec[$fetch_result['crsid']] = $fetch_result['sec'];
			$db_crsver[$fetch_result['crsid']] = $fetch_result['ver'];
			$db_crsnum[$fetch_result['crsid']] = $fetch_result['crsnum'];
			$db_crsstatus[$fetch_result['crsid']] = $fetch_result['status'];
			$db_crsname[$fetch_result['crsid']] = $fetch_result['crsname'];
		}

		/* Join file system and database directory arrays */
		$combined_folders = array_unique(array_merge($fs_folders, $db_crsids));
		asort($combined_folders);		
		
		echo '<div >';
		echo '<table id="crstable" >'.
					'<tr class="tableheader">'.
						'<td>ID#</td>'.
						'<td>Abbr.</td>'.	
						'<td></td>'.	
						'<td></td>'.						
						'<td style="width:25%">Name</td>'.
						'<td>Role</td>'.
						'<td>Status</td>'.
						'<td>FS</td>'.
						'<td>Action</td>'.
					'</tr>';
		foreach ($combined_folders as $id)
		{
			echo '<tr>';
			echo '<td>'.$id."</td>";
			
			if	(!in_array($id, $db_crsids))	
			{
				echo '<td colspan="6" style="color:red">### Not in database ###</td>';
				$dbok = 0;
				$dbid = $id;
			}	
			else 
			{
				echo '<td>'.$db_crsdepts[$id].$db_crsnum[$id]."</td>";
				$sec = $db_crssec[$id] < 10 ? '0'.$db_crssec[$id] : $db_crssec[$id];
				$ver = $db_crsver[$id] < 10 ? '0'.$db_crsver[$id] : $db_crsver[$id];								
				echo '<td>S'.$sec."</td>";
				echo '<td>V'.$ver."</td>";
				echo '<td><div class="tbl_outerdiv"><div class="tbl_innerdiv" title="'. htmlspecialchars($db_crsname[$id]) .'">'. htmlspecialchars($db_crsname[$id]) .'</div></div></td>';
				echo '<td>'.'Role'."</td>";
				echo '<td>'.$db_crsstatus[$id]."</td>";
				$dbok = true;
				$dbid = $id;
			}
		
			$did = $db_crsdids[$id];

			if	(!in_array($id, $fs_folders))	
			{
				echo '<td style="color:red"><img height="16px" src="/css/smallbang.png" title="Folder missing from file system"></td>';
				$fsok = 0;
				/*$did = $db_crsdids[$id];	*/
			}	/*
			elseif( ($db_crsdids[$id] != $fs_dids[$id]) && $dbok == true)  /*!in_array($id, $dept_folders[$db_crsdids[$id]])
			{
				echo '<td style="color:red"><img height="16px" src="/css/smallquestion.png" title="File system and database do not match"></td>';
				$fsok = true;	
				$did = $fs_dids[$id];			
			}*/
			else
			{
				echo '<td class="greentext"><img height="16px" src="/css/checkmark_small.png" title="File system check: OK"></td>';
				$fsok = true;	
				/*$did = $fs_dids[$id];		*/	
			}
	
			/* Determine whether departments are shown or hidden */	
			if(isset($_COOKIE['CRS'.$dbid])) 
			{		
				$dept_hidden = 'Hide';
				$dept_style = 'border:2px solid;';
			}
			else
			{
				$dept_hidden = 'Show';
				$dept_style = 	'height:0px;border:0px solid transparent;';	
			}
			
			?>
				<td>
					<button class="myButton delete" data-fsok="<?php echo $fsok ?>" data-dbok="<?php echo $dbok ?>" data-crsid="<?php echo $dbid?>" data-did="<?php echo $did?>" onclick="createcrs('delete',this)" alt="Delete" title="Delete"></button>
					<button class="myButton edit" data-fsok="<?php echo $fsok ?>" data-dbok="<?php echo $dbok ?>" data-crsid="<?php echo $dbid?>" data-did="<?php echo $did?>" onclick="createcrs('modify',this)" alt="Edit" title="Edit" ></button>
					<button class="myButton" data-target="CRS<?php echo $dbid?>" onclick="toggle_course(this)" title="Course Administration"><?php echo $dept_hidden; ?></button>
				</td>
			<?php	
			echo '</tr>';
			echo '<tr class="table_colldepts"><td class="notableborder" colspan="999" style="overflow:hidden;"><div class="collsubtable" id="CRS'.$dbid.'" style="'.$dept_style.'">';
			$lesson_crsid=$dbid;
			include "coursedetail.php"; 
			echo '</div></td></tr>';
		}
		/*echo '</table>';*/
		?>
		<tfoot>
			<div>			
			<tr>
				<td colspan="999">
					<button class="myButton" id="addcourse" onclick="createcrs('createform')">Add Course</button>				
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