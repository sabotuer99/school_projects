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
			external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}			
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
		script.src= 'admin.js';
		head.appendChild(script);
	</script>	
	
</div>

<?php 

/*  unset all department session variables  */
		unset($_SESSION['dname']);
		unset($_SESSION['dabbr']);
		unset($_SESSION['deptid']);
		unset($_SESSION['create_dept_option']);	
		unset($_SESSION['deptcid']);


		if(isset($_SESSION['create'])) 
			{
/********************************************************
	Only show the "create college" form if the "create" 
	variable is set
*********************************************************/								
			?>
			
			<h2>Create a new college</h2>
			
			<table summary="" >
				<tr>
					<td>	<span>Name of College: </span>	</td>
			<?php		
			if(isset($_SESSION['cname']) && isset($_SESSION['cabr'])) 
					{
					/************************************************** 
						if college name and abbreviation are set, clean
						cname and display it instead of input form  
					***************************************************/
					$purifier = new HTMLPurifier();	
					$clean_cname = $purifier->purify(urldecode($_SESSION['cname']));
						?>	
					<td>	<?php echo $_SESSION['cname']?>	</td>		
			<?php } else {?>	
					<td>	<input type="text" id="collegename" data-field="colname">	</td>				
			<?php }?>	
				</tr>
				<tr>
					<td>	<span>Abbreviation (3 letters): </span>	</td>
			<?php		
			if(isset($_SESSION['cname']) && isset($_SESSION['cabr'])) 
					{
					/***************************************************
						if college name and abbreviation are set, clean
						cabr and display it instead of input form   
					****************************************************/
					$purifier = new HTMLPurifier();
	 				$clean_abbr = substr(strtoupper($purifier->purify(urldecode($_SESSION['cabr']))),0,3);					
						?>	
					<td>	<?php echo $clean_abbr?>	</td>		
			<?php } else {?>	
					<td>	<input type="text" id="collegeabbr" data-field="colabbr">	</td>
			<?php }?>							
				</tr>
			<?php	
			if(!(isset($_SESSION['cname']) && isset($_SESSION['cabr']))) 	
					{
					/***************************************************
						if college name and abbreviation are NOT set, 
						display the "create" button to call the function
						write the directory and database entry
					****************************************************/						
						?>			
				<tr>
					<td>	<span>Create directory and database entry</span>	</td>
					<td>	
						<button class="myButton" id="prevbutton" onclick="createcolldir()">Create</button>	
						<button class="myButton" id="cancelbutton" onclick="createcolldir('cancel')">Cancel</button>	
					
					</td>		
				</tr>
			<?php }?>		
			</table>
			
			
			
			
			<?php 
/********************************************************
	if college name and abbreviation are set, then open
	a TinyMCE instance to add a description
*********************************************************/			
			
			if(isset($_SESSION['cname']) && isset($_SESSION['cabr'])) 
					{
					/* Set write folder for Responsive Filemanager */
					$purifier = new HTMLPurifier();
	 				$clean_abbr = substr(strtoupper($purifier->purify(urldecode($_SESSION['cabr']))),0,3);
					$_SESSION['upload_dir']= "/academics/colleges/".$clean_abbr."/source/" ;					
					?>
					
					<span>Description of College:</span>
					<div id="target" class="fulledit">Describe the mission, subject matter, and other characteristics of the college</div>
					<button class="myButton" id="addstuffbutton" onclick="writecolldesc()">Submit</button>
					<button class="myButton" id="cancelbutton" onclick="createcolldir('cancel')">Skip</button>	
					<?php }?>
			
			<div id="preview"></div>
			<div id="writefileresult"></div>
			
<?php 
/********************************************************
	End create college form section. If "create" is not 
	set, then show the "add new" button
*********************************************************/	
} else {
	
	$directory = $_SERVER['DOCUMENT_ROOT'].$baseroot.'/academics/colleges';

	$folders = scandir($directory);

	echo 'Directories:<br>';

	for($i = 0; $i < count($folders); $i++ ) 
	{
		if( strlen($folders[$i])==3) 
		{ 
		echo $folders[$i].'<br>';
		}
	}

	require_once '../db_login.php'; 	
	$query = "SELECT * FROM colleges";
	$result = 	mysqli_query($db_server, $query) or die("Couldn't execute insert query: <br>".$query." error:". mysqli_error($db_server));
	
	echo 'Database Entries:<br>';	
	while ($fetch_result = mysqli_fetch_assoc($result))
	{
		echo	$fetch_result['cabbr'].'<br>';
	}
	
	

	?>

	<button class="myButton" id="addcollege" onclick="createcolldir(true)">Add College</button>

<?php }?>
