<?php 
session_start();
if($_SESSION['auth']!=1) {
	$_SESSION['navigate']="home.php','homelink";
	header("Location:index.php");
	}
	else {
		require_once 'db_login.php';
	}
	
?>

<div id="createAccount" class="grid_9 alpha rounded">

	<h4 class="grid_8 rounded" >My Account Info</h4>
	<?php 
	if(isset($_SESSION['editMsg'])) {echo "<p style='clear:left;color:red;'>".$_SESSION['editMsg']."</p>";}
	?>
	<div id="newAccountMenu">
			<span>Username:</span><br>
			<span>Preview:</span><br>
			<span>First Name:</span><br>
			<span>Last Name:</span><br>
			<span>Email:</span><br>
			<span>Gender:</span><br>
			<span>Old Password:</span><br>
			<span>New Password:</span><br>
			<span>Confirm:</span><br>
	</div>
	<form action="modifyaccount.php" method="post" id="createAccountForm" >
			<input type="text" id="username" onchange="checkUsername()" onkeyup="checkUsername()" value="<?php echo $_SESSION['username']; ?>"><br>
			<span id="usernamePreview" style="margin-left:16px;"><?php echo $_SESSION['username']; ?></span><span>  &lt-- </span><span id="usernameStatus">That's you!</span><br>
			<input type="hidden" name="usernameClean" id="usernameClean" value="<?php echo $_SESSION['username']; ?>">
			<input type="text" name="fname" id="fname" value="<?php echo $_SESSION['fname']; ?>"><br>
			<input type="text" name="lname" id="lname" value="<?php echo $_SESSION['lname']; ?>"><br> 
			<input type="text" name="email" id="email" value="<?php echo $_SESSION['email']; ?>"><br>
			<select name="gender" id="gender">
					<option <?php if($_SESSION['gender']=='Male'){echo "SELECTED";}?> >Male</option>
					<option <?php if($_SESSION['gender']=='Female'){echo "SELECTED";}?> >Female</option>
			</select><br>
			<input type="password" id="oldpwd" onchange="hashPassword('oldpwd','usernameClean','oldpwdHash')" onkeyup="hashPassword('oldpwd','usernameClean','oldpwdHash')"><br>
			<input type="hidden" name="oldpwdHash" id="oldpwdHash" value="">
			<input type="password" id="pwd" onchange="comparePassword()" onkeyup="comparePassword()"><br>
			<input type="password" id="confirmpwd" onchange="comparePassword()" onkeyup="comparePassword()">
			<span id="pwdMatchImg"></span><br>
			<span id="pwdMatchMsg"></span><br>
			<input type="hidden" name="pswHash" id="pswHash" value="">
			<span class="wordwrap" id="hashpreview" style="display:block;"></span>
			<input type="submit" value="Submit Changes" class="button"><br>
	</form>	
	<?php echo $_SESSION['DEBUG']; ?>
</div>
