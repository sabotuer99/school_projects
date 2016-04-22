<!-- Show Message for AJAX response -->
<div id="login_response"></div>

<!-- Form: the action="javascript:login()"call the javascript function "login" into ajax_framework.js -->
<div onmouseover="CurLoc();">
<form method="post" action="login.php" id="loginForm">
<input type="submit" name="Submit" value="Login" />
<div>
		<span>Password:</span><br>
		<input type="password" id="pswLogin" value="" onchange="hashPassword('pswLogin','userLogin','loginPwdHash')" onkeyup="hashPassword('pswLogin','userLogin','loginPwdHash')" />
</div> 
<div>
		<span>User:</span><br> 
        <input name="userLogin" type="text" id="userLogin" value="" onchange="hashPassword('pswLogin','userLogin','loginPwdHash')" onkeyup="hashPassword('pswLogin','userLogin','loginPwdHash')" />
</div>
<input type="hidden" name="CurLoc" id="CurLoc" value=""/>
<input type="hidden" name="loginPwdHash" id="loginPwdHash" />

</form>
<a href="#" onclick="navigate('profile.php','profilelink');" style="float:right;">Register</a>
</div>
