<?php 
session_start();
?>

<div id="createAccount" class="grid_9 alpha rounded">

	<h4 class="grid_8 rounded" >Create New Account</h4>
	<?php 
	if(isset($_SESSION['message_new'])) {echo "<p style='clear:left;color:red;'>".$_SESSION['message_new']."</p>";}
	?>
	<div id="newAccountMenu">
			<span>Username:</span><br>
			<span>Preview:</span><br>
			<span>First Name:</span><br>
			<span>Last Name:</span><br>
			<span>Email:</span><br>
			<span>Gender:</span><br>
			<span>Password:</span><br>
			<span>Confirm:</span><br>
	</div>
	<form action="createaccount.php" method="post" id="createAccountForm" >
			<input type="text" id="username" onchange="checkUsername()" onkeyup="checkUsername()"><br>
			<span id="usernamePreview" style="margin-left:16px;"></span><span>  &lt-- Your username is </span><span id="usernameStatus"></span><br>
			<input type="hidden" name="username" id="usernameClean" value="">
			<input type="text" name="fname" id="fname" value="<?php echo $_SESSION['FbFirst']; ?>"><br>
			<input type="text" name="lname" id="lname" value="<?php echo $_SESSION['FbLast']; ?>"><br> 
			<input type="text" name="email" id="email" value="<?php echo $_SESSION['FbEmail']; ?>"><br>
			<select name="gender" id="gender">
					<option <?php if($_SESSION['FbSex']=='Male'){echo "SELECTED";}?> >Male</option>
					<option <?php if($_SESSION['FbSex']=='Female'){echo "SELECTED";}?> >Female</option>
			</select><br>
			<input type="password" id="pwd" onchange="comparePassword()" onkeyup="comparePassword()"><br>
			<input type="password" id="confirmpwd" onchange="comparePassword()" onkeyup="comparePassword()">
			<span id="pwdMatchImg"></span><br>
			<span id="pwdMatchMsg"></span><br>
			<input type="hidden" name="pswHash" id="pswHash" value="">
			<span class="wordwrap" id="hashpreview" style="display:block;"></span>
			<input type="submit" value="Create Account!" class="button"><br>
	</form>	
	
</div>


<div class="grid_1"></div>

<div id="linkExistingAccount" class="grid_9 omega rounded">

	<h4 class="grid_8 rounded" style="text-align:center;">Link Existing Account</h4>

</div> 