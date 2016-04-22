<div id="loginbox">
	<strong>Welcome to the Wyoming Department of Revenue property tax e-file system</strong>
	<br>
	<hr>
	<br>
	<p>Existing user login</p>
	<table summary="" >
		<tr>
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
		<tr>
			<td></td>
			<td><button id="signinbutton">Sign In</button></td>
		</tr>	
		</tr>				
	</table>	
	<hr><br>
	<span>Register as a new user</span>
	<button onclick="toggleDisplay('registrationform',this)">Hide</button><br><br>
	<table summary="" id="registrationform">
		<tr>
			<td>User Name:</td>
			<td><input type="text" id="regusername" data-field="username" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)"></td>
		</tr>
		<tr>
			<td>Email:</td>
			<td><input type="text" id="regemail" data-field="email" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)"></td>
		</tr>
		<tr>
			<td>First Name:</td>
			<td><input type="text" id="regfname" data-field="fname" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)"></td>
		</tr>
		<tr>
			<td>Last Name:</td>
			<td><input type="text" id="reglname" data-field="lname" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)"></td>
		</tr>
		<tr>
			<td>Title:</td>
			<td><input type="text" id="regtitle" data-field="title" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)"></td>
		</tr>
		<tr>
			<td>Phone:</td>
			<td><input type="text" id="regphone" data-field="phone" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)"></td>
		</tr>
		<tr>
			<td>Fax:</td>
			<td><input type="text" id="regfax" data-field="fax" data-optional="TRUE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)"></td>
		</tr>
		<tr>
			<td>Role:</td>
			<td><select id="roleselect" data-field="role" data-optional="FALSE">
					<option value="staff" selected>Company Staff</option>
					<option value="agent">Third Party Tax Agent</option>
					<option value="officer">Company Officer</option>
					<option value="government">Government Official</option>				
				</select><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)">
			</td>
		</tr>				
		<tr id="agencyselect" >
			<td>Company Name <a style="background:yellow;" title="This is the company you work for. If you represent multiple companies, you will be able to add them to your account after you are registered.">?</a> :</td>
			<td><input type="text" id="regcompany"  data-field="company" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)"></td>
		</tr>
		<tr>
			<td>Mailing Address 1:</td>
			<td><input type="text" id="regaddress1" data-field="address1" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)"></td>
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
			<td><input type="text" id="regcity" data-field="city" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)"></td>
		</tr>
		<tr>
			<td>Country:</td>
			<td><select id="countryselect" data-field="country" data-optional="FALSE">
					<option value="US" selected>United States</option>
					<option value="Mex">Mexico</option>
					<option value="Can">Canada</option>			
				</select><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)">
			</td>
		</tr>		
		<tr>
			<td>State:</td>
			<td><input type="text" id="regstate" data-field="state" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)"></td>
		</tr>
		<tr>
			<td>Zip:</td>
			<td><input type="text" id="regzip" data-field="zip" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)"></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" id="regpassword" data-field="password" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)"></td>
		</tr>
		<tr>
			<td>Confirm Password:</td>
			<td><input type="password" id="regconfpass" data-optional="FALSE"><img src="/css/blank.png" alt="" style="display:none;"></td>
		</tr>			
		<tr>
			<td></td>
			<td><button id="registerbutton" onclick="submitReg();">Register</button></td>
		</tr>			
	</table>	
	<div id="regpasswordmessage" style="display:none;">(password is case sensitive)</div>
	<span id="regerrors" style="color:red;"></span>	
	<span id="regstatus" style="color:red;"></span>	
	<script type="text/javascript" >
		regListeners();
	</script>	
	<button onclick="writeFile()">file</button>	
	<div id="writefileresult"></div>							
</div>	