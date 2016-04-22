<?php 

session_start();

if(isset($_POST['val'])) 
{
	$val = $_POST['val']; 
}
else 
{
	$val = 'default';
}	


if($val=='login') {
		?>
				<tr>
						<td><span>Login</span></td>
						<td><input type="text" id="usernameinput"></td>						
				</tr>
				<tr>
						<td><span>Password</span></td>
						<td><input type="password" id="passwordinput"></td>
				</tr>	
				<tr>
						<td><button id="loginbutton" class="myButton" onclick="login('submit')">Submit</button></td>
						<td><button class="myButton" onclick="login('default')">Cancel</button></td>
				</tr>					
		<?php 
} 
elseif($val=='submit') {
	/*code for checking login info;  */  
	
			require_once '../db_login.php'; 
		
			if(isset($_POST['u']) && isset($_POST['p'])){
	
			$username = strtoupper(mysqli_real_escape_string($db_server, $_POST['u']));
			$password = mysqli_real_escape_string($db_server, strip_tags(trim($_POST['p'])));
			
			$_SESSION['loginMsg'] = "";
			
			$getSalt_sql = 'SELECT salt FROM sysusers WHERE UPPER(username)="'. $username .'"';
			$getSalt = mysqli_query($db_server, $getSalt_sql);
			$salt = mysqli_fetch_assoc($getSalt);
			
			/*echo $salt['salt']    */
				
			$message = $password . $salt['salt'];
			$password = hash("whirlpool", $message);
			/*echo $password;  */  
			
			$getUser_sql = 'SELECT * FROM sysusers WHERE UPPER(username)="'. $username . '" AND password= "' . $password . '"';
			$getUser = mysqli_query($db_server, $getUser_sql);
			$getUser_result = mysqli_fetch_assoc($getUser); 
			$getUser_RecordCount = mysqli_num_rows($getUser);
			
			if($getUser_RecordCount < 1)	{ 
					$_SESSION['loginMsg'] = 'Login failed...'; /*. $getUser_sql;*/
				 	/*Following is code for failed login 
				 	//echo 'Fail&lt;br&gt;';  
				 	//echo $getUser_sql; */
			?>
				<tr>
						<span><?php echo 'Login Failed'; ?></span>		
				</tr>
				<tr>
						<td><button class="myButton" onclick="login('login')">Try Again</button></td>
						<td><button class="myButton" onclick="login('default')">Cancel</button></td>
				</tr>	
				
		<?php 
		
					} 
			else { 		/*echo 'Success';*/    
					$_SESSION['auth']=true; 
					$_SESSION['fname']=$getUser_result['fname'];
					$_SESSION['lname']=$getUser_result['lname'];
					$_SESSION['email']=$getUser_result['email'];
					$_SESSION['firstlast']=$getUser_result['fname']." ".$getUser_result['lname'];
					$_SESSION['id']=$getUser_result['id'];
					$_SESSION['username']=$getUser_result['username'];
					/*Following is code for successful login  */
					$getPerms_sql = 'SELECT * FROM perms_granted NATURAL JOIN perms WHERE uid='. $getUser_result['id'];
					$getPerms = mysqli_query($db_server, $getPerms_sql);
					
					$getPerms_RecordCount = mysqli_num_rows($getPerms);
					
					while($getPerms_result = mysqli_fetch_assoc($getPerms)) 
					{
							$_SESSION['perm_'.$getPerms_result['permname']]=true;
					}
					 
				
			?>
				<tr>
						<td><a>Welcome Back</a></td>					
				</tr>
				<tr>
						<td><a><?php echo $_SESSION['firstlast']; ?></a></td>
				</tr>	
				<tr>
						<td><button class="myButton" onclick="login('logout')">Logout</button></td>
				</tr>	
				<div id="loginscript">
					<script type="text/javascript" >
							if (currloc = readCookie('currloc'))	{
									navigate(currloc);									
								}					
							reloadNav();									
					</script>
				</div>			
				
		<?php 

		}
}						
}
elseif($val=='logout') {
		$val = 'default';
		 session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true); 
			?>
			<div id="loginscript">    			
    			<script type="text/javascript" >
						if (currloc = readCookie('currloc'))	{
								navigate(currloc);									
							}					
						reloadNav();									
				</script>
			</div>								
		<?php 
}
elseif($_SESSION['auth']==true) {
				?>
				<tr>
						<td><a><?php echo 'Welcome Back'; ?></a></td>					
				</tr>
				<tr>
						<td><a><?php echo $_SESSION['firstlast']; ?></a></td>
				</tr>	
				<tr>
						<td><button class="myButton" onclick="login('logout')">Logout</button></td>
				</tr>	
				<div id="loginscript">
					<script type="text/javascript" >
							if (currloc = readCookie('currloc'))	{
									navigate(currloc);									
								}					
							reloadNav();									
					</script>
				</div>			
				
		<?php 
		$val = null;
	}
	
if($val=='default') {
			?>
				<tr>
						<td><a onclick="login('login')">Login</a></td>					
				</tr>
				<tr>
						<td><a data-target="home/register.php" onclick="navigate('home/register.php')">Register</a></td>
				</tr>	
				
		<?php 
}



?>