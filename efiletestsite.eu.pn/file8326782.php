<head>
		<meta charset="UTF-8">
		<!-- www.phpied.com/conditional-comments-block-downloads/ -->
		<!--[if IE]><![endif]-->
		
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
		<link rel="shortcut icon" href="/favicon.ico">	
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">	
		
		
		<link rel="stylesheet" href="css/reset.css">
		<link rel="stylesheet" href="css/960_24_col.css">
		<link rel="stylesheet" href="css/text.css">
		<link rel="stylesheet" href="css/style.css">
		
		<!-- for the less enabled mobile browsers like Opera mini 
		<link rel="stylesheet" media="handheld" href="css/handheld.css?v=1">
		-->		
		
		<!-- google fonts
		<link href='http://fonts.googleapis.com/css?family=Fredoka One' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Pompiere' rel='stylesheet' type='text/css'>
		 -->		
		
		<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<!endif]--> 
		
		
		<script src="js/scripts.js" language="JavaScript" type="text/javascript"></script>		
<!--		<script src="js/fb_scripts.js" language="JavaScript" type="text/javascript" ></script>
		<!--  Crypto hash script -->
		<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha3.js"></script>

		<title> Wyoming DOR Property Tax E-File </title>	
</head><body>

	<div class="container_24">
	
		<div id="pageheader" class="container_24">
			<div id="wyologo">
				<img src="css/wyoming_logo_fixed.gif" alt="Wyoming Logo">			
			</div>				

			<div id="titleblock">
				<h1>Wyoming Department of Revenue</h1>
				<hr>
				<h2>Property Tax E-File</h2>
			</div>
		</div>
		
		<div id="mainbody" class="container_24">

		<div id="loginbox">
	<strong>HACKED</strong>
	<br>
	<hr>
	<br>
	<p>Existing user login</p>
	<table summary="">
		<tbody><tr>
			<td>User Name:</td>
			<td><input type="text" id="regusername"></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password"></td>
		</tr>
		<tr>
			<td></td>
			<td><span id="passwordmessage">(password is case sensitive)</span></td>
		</tr><tr>
			<td></td>
			<td><button id="signinbutton">Sign In</button></td>
		</tr>	
						
	</tbody></table>	
	<hr><br>
	<span>Register as a new user</span>
	<button onclick="toggleDisplay('registrationform',this)">Show</button><br><br>
	<table summary="" id="registrationform" style="display:none">
		<tbody><tr>
			<td>User Name:</td>
			<td><input type="text" id="regusername" data-field="username" data-optional="FALSE"><img src="/css/20_button_red.png" alt="" onload="reqCheck(this.previousSibling)" title="username is too shortusername is not valid"></td>
		</tr>
		<tr>
			<td>Email:</td>
			<td><input type="text" id="regemail" data-field="email" data-optional="FALSE"><img src="/css/20_button_red.png" alt="" onload="reqCheck(this.previousSibling)" title="email is not valid"></td>
		</tr>
		<tr>
			<td>First Name:</td>
			<td><input type="text" id="regfname" data-field="fname" data-optional="FALSE"><img src="/css/20_button_red.png" alt="" onload="reqCheck(this.previousSibling)" title="fname is not valid"></td>
		</tr>
		<tr>
			<td>Last Name:</td>
			<td><input type="text" id="reglname" data-field="lname" data-optional="FALSE"><img src="/css/20_button_red.png" alt="" onload="reqCheck(this.previousSibling)" title="lname is not valid"></td>
		</tr>
		<tr>
			<td>Title:</td>
			<td><input type="text" id="regtitle" data-field="title" data-optional="FALSE"><img src="/css/20_button_red.png" alt="" onload="reqCheck(this.previousSibling)" title="Required field is blank"></td>
		</tr>
		<tr>
			<td>Phone:</td>
			<td><input type="text" id="regphone" data-field="phone" data-optional="FALSE"><img src="/css/20_button_red.png" alt="" onload="reqCheck(this.previousSibling)" title="Required field is blank"></td>
		</tr>
		<tr>
			<td>Fax:</td>
			<td><input type="text" id="regfax" data-field="fax" data-optional="TRUE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)"></td>
		</tr>
		<tr>
			<td>Role:</td>
			<td><select id="roleselect" data-field="role" data-optional="FALSE">
					<option value="staff" selected="">Company Staff</option>
					<option value="agent">Third Party Tax Agent</option>
					<option value="officer">Company Officer</option>
					<option value="government">Government Official</option>				
				</select><img src="/css/checkmark_small.png" alt="" onload="reqCheck(this.previousSibling)" title="OK">
			</td>
		</tr>				
		<tr id="agencyselect">
			<td>Company Name <a style="background:yellow;" title="This is the company you work for. If you represent multiple companies, you will be able to add them to your account after you are registered.">?</a> :</td>
			<td><input type="text" id="regcompany" data-field="company" data-optional="FALSE"><img src="/css/20_button_red.png" alt="" onload="reqCheck(this.previousSibling)" title="Required field is blank"></td>
		</tr>
		<tr>
			<td>Mailing Address 1:</td>
			<td><input type="text" id="regaddress1" data-field="address1" data-optional="FALSE"><img src="/css/20_button_red.png" alt="" onload="reqCheck(this.previousSibling)" title="Required field is blank"></td>
		</tr>
		<tr>
			<td>Mailing Address 2:</td>
			<td><input type="text" id="regaddress2" data-field="address2" data-optional="TRUE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)"></td>
		</tr>
		<tr>
			<td>Mailing Address 3:</td>
			<td><input type="text" id="regaddress3" data-field="address3" data-optional="TRUE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)"></td>
		</tr>
		<tr>
			<td>City:</td>
			<td><input type="text" id="regcity" data-field="city" data-optional="FALSE"><img src="/css/20_button_red.png" alt="" onload="reqCheck(this.previousSibling)" title="Required field is blank"></td>
		</tr>
		<tr>
			<td>Country:</td>
			<td><select id="countryselect" data-field="country" data-optional="FALSE">
					<option value="US" selected="">United States</option>
					<option value="Mex">Mexico</option>
					<option value="Can">Canada</option>			
				</select><img src="/css/checkmark_small.png" alt="" onload="reqCheck(this.previousSibling)" title="OK">
			</td>
		</tr>		
		<tr>
			<td>State:</td>
			<td><input type="text" id="regstate" data-field="state" data-optional="FALSE"><img src="/css/20_button_red.png" alt="" onload="reqCheck(this.previousSibling)" title="Required field is blank"></td>
		</tr>
		<tr>
			<td>Zip:</td>
			<td><input type="text" id="regzip" data-field="zip" data-optional="FALSE"><img src="/css/20_button_red.png" alt="" onload="reqCheck(this.previousSibling)" title="Required field is blank"></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" id="regpassword" data-field="password" data-optional="FALSE"><img src="/css/20_button_red.png" alt="" onload="reqCheck(this.previousSibling)" title="Required field is blank"></td>
		</tr>
		<tr>
			<td>Confirm Password:</td>
			<td><input type="password" id="regconfpass" data-optional="FALSE"><img src="/css/blank.png" alt="" style="display:none;"></td>
		</tr>			
		<tr>
			<td></td>
			<td><button id="registerbutton" onclick="submitReg();">Register</button></td>
		</tr>			
	</tbody></table>	
	<div id="regpasswordmessage" style="display:none;"></div>
	<span id="regerrors" style="color:red;"></span>	
	<span id="regstatus" style="color:red;"></span>	
	<script type="text/javascript">
		regListeners();
	</script>	
	<button onclick="writeFile()">file</button>	
	<div id="writefileresult"></div>							
</div>			
		</div>
		
	
	</div>




</body>