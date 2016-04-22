<!-- Show Message for AJAX response -->
<div id="login_response"></div>

<!-- Form: the action="javascript:login()"call the javascript function "login" into ajax_framework.js -->
<form method="post" action="logout.php" id="logoutForm">  
<div>
		<?php echo "<span>".$_SESSION['firstlast']."</span>"; ?>
		<input type="submit" name="Logout" value="Logout"/>
</div>
</form>

