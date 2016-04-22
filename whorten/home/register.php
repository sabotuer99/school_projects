<?php 
/********************************************************
	This section checks to make sure the path to the 
	include file exists, then drops it in
*********************************************************/
session_start();
$path = $_SERVER['DOCUMENT_ROOT'].'/includes';
if(file_exists($path)) 
{
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/includes.php';	
}
else 
{
	require_once $_SERVER['DOCUMENT_ROOT'].'/whorten/includes/includes.php';	
}
//End include code
?>

<?php 

$file = pathinfo( __FILE__ );
//echo basename( $_SERVER['PHP_SELF'], '.' . $file[ 'extension' ] );
?>
<div id="regbox">
	<h2>Register as a new user</h2>
	<!-- <button onclick="toggleDisplay('registrationform',this)">Hide</button><br><br> -->
	<table summary="" id="registrationform">
		<tr>
			<td>User Name:</td>
			<td><input type="text" id="regusername" data-field="username" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)" style="display:none"></td>
		</tr>
		<tr>
			<td>Email:</td>
			<td><input type="text" id="regemail" data-field="email" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)" style="display:none"></td>
		</tr>
		<tr>
			<td>First Name:</td>
			<td><input type="text" id="regfname" data-field="fname" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)" style="display:none"></td>
		</tr>
		<tr>
			<td>Last Name:</td>
			<td><input type="text" id="reglname" data-field="lname" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)" style="display:none"></td>
		</tr>
		<tr>
			<td>Phone:</td>
			<td><input type="text" id="regphone" data-field="phone" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)" style="display:none"></td>
		</tr>
		<tr>
			<td>Mailing Address 1:</td>
			<td><input type="text" id="regaddress1" data-field="address1" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)" style="display:none"></td>
		</tr>
		<tr>
			<td>Mailing Address 2:</td>
			<td><input type="text" id="regaddress2" data-field="address2" data-optional="TRUE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)" style="display:none"></td>
		</tr>
		<tr>
			<td>City:</td>
			<td><input type="text" id="regcity" data-field="city" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)" style="display:none"></td>
		</tr>
		<tr>
			<td>Country:</td>
			<td><select id="countryselect" data-field="country" data-optional="FALSE">
					<option value="US" selected>United States</option>
					<option value="Mex">Mexico</option>
					<option value="Can">Canada</option>			
				</select><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)" style="display:none">
			</td>
		</tr>		
		<tr>
			<td>State:</td>
			<td><input type="text" id="regstate" data-field="state" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)" style="display:none"></td>
		</tr>
		<tr>
			<td>Zip:</td>
			<td><input type="text" id="regzip" data-field="zip" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)" style="display:none"></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" id="regpassword" data-field="password" data-optional="FALSE"><img src="/css/blank.png" alt="" onload="reqCheck(this.previousSibling)" style="display:none"></td>
		</tr>
		<tr>
			<td>Confirm Password:</td>
			<td><input type="password" id="regconfpass" data-optional="FALSE"><img src="/css/blank.png" alt="" style="display:none;" style="display:none"></td>
		</tr>			
		<tr>
			<td></td>
			<td><button class="myButton" id="registerbutton" onclick="submitReg();">Register</button></td>
		</tr>			
	</table>	
	<div id="regpasswordmessage" style="display:none;">(password is case sensitive)</div>
	<span id="regerrors" style="color:red;"></span>	
	<span id="regstatus" style="color:red;"></span>	
	<div id="runscript">
		<script type="text/javascript">	
			regListeners();
		</script>
	</div>	
</div>
