/*****************************************************************************************
****
****  toggleDisplay() toggles display:none and display:block on a target element
****      
******************************************************************************************/
function toggleDisplay(target, button){
		if (document.getElementById(target).offsetWidth==0 || document.getElementById(target).offsetHeght==0) 
		{	
			document.getElementById(target).setAttribute('style','display:block');
			button.innerHTML="Hide";
		} 
		else 
		{
			document.getElementById(target).setAttribute('style','display:none');		
			button.innerHTML="Show";	
		}
}



/*****************************************************************************************
****
****  newAjax() returns a new cross browser compatible HttpRequest Object
****      
******************************************************************************************/
function newAjax()
{
		var xmlhttp;
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		    
		  return xmlhttp;
			
}



/*****************************************************************************************
****
****  submitReg() grabs the registration form data and sends it POST to register.php
****      
******************************************************************************************/
function submitReg() {
		errormessages = new Array();		
		//--------------------------------------
		//serialized list of optional elements  |
		//--------------------------------------
		forminputs = document.getElementById('registrationform').getElementsByTagName('input');
		formselects = document.getElementById('registrationform').getElementsByTagName('select');
						
		opts = new Array();
		for (i=0; i < forminputs.length + formselects.length; i++) 
		{

			if(i < forminputs.length )
			{
				//inputs first
				if (forminputs[i].hasAttribute('data-optional')) 
				{
					if (forminputs[i].getAttribute('data-optional')=='TRUE') 
					{
						opts[opts.length] = forminputs[i].getAttribute('data-field');
					}
				}
			} 
			else 
			{
				//then selects
				if (formselects[i - forminputs.length].hasAttribute('data-optional')) 
				{
					if (formselects[i - forminputs.length].getAttribute('data-optional')=='TRUE') 
					{
						opts[opts.length] = formselects[i - forminputs.length].getAttribute('data-field');
					}
				}					
			}
		}

		var optstring = new String;		
		for (j=0; j < opts.length; j++) 
			{
			optstring += '&opt' + (j+1) + '=' + opts[j];
			}
		
		
		
		//----------------------------------------------------------------
		//serialized list of input elements, excluding password fields    |
		//----------------------------------------------------------------
		var inputstring = new String;
		for (j=0; j < forminputs.length; j++) 
		{
			if (forminputs[j].type == 'text') 
			{	
				inputstring += '&' + forminputs[j].getAttribute('data-field') + '=' + encodeURIComponent(forminputs[j].value);
			}

			var a = forminputs[j].value == '';				
			var b = forminputs[j].hasAttribute('data-field');
			var c = !(forminputs[j].hasAttribute('data-optional') ? forminputs[j].getAttribute('data-optional') == 'TRUE' : false );
			
			/*/debugging
			if (forminputs[j].getAttribute('data-field')=='username') 
				{	
				alert( a.toString() + ' ' + b.toString() + ' ' + c.toString());	
				}
			//end debugging */
						
			if (a && b && c) 
			{
				errormessages[errormessages.length] = "Required field " + forminputs[j].getAttribute('data-field') + " is blank" + "<br>";		
			}
		}
		
		//alert(inputsting);		
		
		//--------------------------------------
		//serialized list of select elements    |
		//--------------------------------------
		var selectstring = new String;
		for (j=0; j < formselects.length; j++) 
			{
			selectstring += '&' + formselects[j].getAttribute('data-field') + '=' +  encodeURIComponent(formselects[j].options[formselects[j].selectedIndex].value);								
			}
		
		
		
		//------------------------------------------------------
		//check for password match, hash password, stringify    |
		//------------------------------------------------------
		passchk = comparePassword('regpassword','regconfpass');
		var passwordstring = new String;
		if (passchk == true) 
		{
			//insert code to check for complexity requirements
			var username = document.getElementById('regusername').value;
			var password = document.getElementById('regpassword').value;
			var message = username + password;
			var hashedpass = CryptoJS.SHA3(message); 
			passwordstring = '&password=' + hashedpass;
		}
		else if (passchk == 'blank') 
		{
		//do nothing, blank is already caught above.		
		}
		else  
		{
			errormessages[errormessages.length] = passchk;
		}
		
		//alert(errormessages);		
		//--------------------------------------------
		//combine serialized lists into POST sting    |
		//--------------------------------------------
		poststring = inputstring.substr(1) + selectstring + optstring + passwordstring;
		//alert(poststring);	

		//---------------------------------------------------------------
		//if error free, create account, otherwise post error message    |
		//---------------------------------------------------------------
		
		if (errormessages.length==0) 
		{
				xmlhttp = newAjax();
				
				xmlhttp.onreadystatechange=function()
				  {
				  if (xmlhttp.readyState==4 && xmlhttp.status==200)
				    {
				    document.getElementById("regstatus").innerHTML=xmlhttp.responseText;
				 	  	}
				  } 
		
				xmlhttp.open("POST","/createaccount.php",false);
				xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				xmlhttp.send(poststring);
				//alert(poststring);
		}
		else 
		{
				errorstring = new String;
				for (i=0; i<errormessages.length; i++) 
				{
					errorstring += errormessages[i];
				}
				document.getElementById('regerrors').innerHTML=errorstring;	
		}
}




/*****************************************************************************************
****
****  comparePassword() grabs the value of two password fields and compares, checks complexity
****      
******************************************************************************************/
function comparePassword(pass, comp) {
		var password = document.getElementById(pass).value;
		var compare = document.getElementById(comp).value;
	
		var errormessages = new Array;
	
		if (password.length < 8) {
		errormessages[errormessages.length] = "Password is too Short. ";		
			}
			
		var pwdRegex = /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*\d)\S*$/;
		//alert(pwdRegex);
		//alert(pwdRegex.test(password));
		if (!pwdRegex.test(password) && password.length >= 8) 
		{
				errormessages[errormessages.length] = "Password must contain at least one: lowercase letter, upper case letter, and numeral. ";		
		}	
		
		if (!password.length==0 || !compare.length==0) 
		{
				if (password != compare) 
				{
						errormessages[errormessages.length] = "Password and confirmation don't match. ";
				}
		}
		else
		{
				var blank = true;	
		}
	
		if (errormessages.length>0 && blank != true) 
		{
				var errorstring = new String;				
				for (i=0; i<errormessages.length; i++) 
				{	
						errorstring += errormessages[i] + '<br>';
				}			
				return errorstring;
		}
				else if (blank == true) 
		{
		return 'blank';
		}
				else 
		{
				return true;
		}
		
}

/*
function check() {
	chk = comparePassword('regpassword','regconfpass');
	if (chk != true && chk != 'blank') 
	{
			document.getElementById('regpasswordmessage').innerHTML=chk;
	}
	else 
	{
			document.getElementById('regpasswordmessage').innerHTML="";
	}		
}
*/


/*****************************************************************************************
****
****  reqCheck() adds icons to indicate if required and if input is kosher 
****      
******************************************************************************************/
function reqCheck(element) 
{
	var c = element.hasAttribute('data-optional') ? element.getAttribute('data-optional') == 'TRUE' : false ;
	var  d = element.tagName == 'INPUT' ? regErrors(element) : false;	
	
	
	if (!c) 
	{
		if (d==false) 
		{		
			if (element.value == '')
			{
				 	element.nextSibling.setAttribute('src','/css/20_button_red.png');
				 	element.nextSibling.setAttribute('title','Required field is blank');
			}
			else 
			{ 
					element.nextSibling.setAttribute('src','/css/checkmark_small.png');
					element.nextSibling.setAttribute('title','OK');
			}
		}
		else 
		{
			element.nextSibling.setAttribute('src','/css/20_button_red.png');
			element.nextSibling.setAttribute('title',d);
		}				
	}	
	
}	



/*****************************************************************************************
****
****  reqCheck() adds icons to indicate if required and if input is kosher 
****      
******************************************************************************************/
function regErrors(element) 
{
		//if a non-input element is passed, return false
		if (element.tagName != 'INPUT') {return false;}
		
		var field = element.getAttribute('data-field');
			
		var val = element.value;
			
		document.getElementById('regpasswordmessage').innerHTML = val; //debug

		var error = new String;
		switch(field) 
		{
			case 'username':
				if (val.length < 6) 
				{
					error += field + " is too short";
				}
				if (! /^[\w\d\.\?!_-]{1,}$/i.test(val)) 
				{
					error += field + " is not valid";
				}
				if (error.length==0){ return false; }
				break;
		
			case 'email':
				if (! /.+@.+\..+/.test(val)) 
				{
					error += field + " is not valid";
				}
				else { return false; }
				break;
		
			case 'fname':
				if (! /^[A-Za-z' -]{1,50}$/.test(val)) //'
				{
					error += field + " is not valid";
				}
				else { return false; }
				break;
		
			case 'lname':
				if (! /^[A-Za-z' -]{1,50}$/.test(val)) //'
				{
					error += field + " is not valid";
				}
				else { return false; }
				break;
				
			case 'password':
				chk = comparePassword('regpassword','regconfpass');
				//alert(chk);
				if (chk != true && chk != 'blank') 
				{
						error += chk.replace(/<(?:.|\n)*?>/gm, '');
				}
				else { return false; }				
				break;

			default:
				return false;		
		}
		
		return error;
}



/*****************************************************************************************
****
****  regListeners() adds event listeners to inputs, selects, and status icons
****      
******************************************************************************************/
function regListeners() 
{
	var inputs = document.getElementById('registrationform').getElementsByTagName('input');
	var selects = document.getElementById('registrationform').getElementsByTagName('select');	

	for (var j=0; j<inputs.length;j++)
	{

		inputs[j].addEventListener("click",function(){reqCheck(this);},false);		
		inputs[j].addEventListener("change",function(){reqCheck(this);},false);
		inputs[j].addEventListener("keyup",function(){reqCheck(this);},false);
		inputs[j].addEventListener("keydown",function(){reqCheck(this);},false);
		inputs[j].addEventListener("focus",function(){reqCheck(this);},false);	
		inputs[j].addEventListener("blur",function(){reqCheck(this);},false);
		inputs[j].addEventListener("select",function(){reqCheck(this);},false);	
	
	}

	for (var j=0; j<selects.length;j++)
	{

		selects[j].addEventListener("click",function(){reqCheck(this);},false);
		selects[j].addEventListener("change",function(){reqCheck(this);},false);
		selects[j].addEventListener("keyup",function(){reqCheck(this);},false);
		selects[j].addEventListener("keydown",function(){reqCheck(this);},false);
		selects[j].addEventListener("focus",function(){reqCheck(this);},false);	
		selects[j].addEventListener("blur",function(){reqCheck(this);},false);
		selects[j].addEventListener("select",function(){reqCheck(this);},false);	
				
	}

	//add listeners for confirmpassword to password
	document.getElementById('regconfpass').addEventListener("click",function(){reqCheck(document.getElementById('regpassword'));},false);
	document.getElementById('regconfpass').addEventListener("change",function(){reqCheck(document.getElementById('regpassword'));},false);
	document.getElementById('regconfpass').addEventListener("keyup",function(){reqCheck(document.getElementById('regpassword'));},false);
	document.getElementById('regconfpass').addEventListener("keydown",function(){reqCheck(document.getElementById('regpassword'));},false);
	document.getElementById('regconfpass').addEventListener("focus",function(){reqCheck(document.getElementById('regpassword'));},false);
	document.getElementById('regconfpass').addEventListener("blur",function(){reqCheck(document.getElementById('regpassword'));},false);
	document.getElementById('regconfpass').addEventListener("select",function(){reqCheck(document.getElementById('regpassword'));},false);

}



/*****************************************************************************************
****
****  writeFile() converts innerHTML to POST string and sends to PHP script
****      
******************************************************************************************/
function writeFile() 
{
	
		stuff=document.getElementsByTagName('html')[0].innerHTML;
		poststring = 'stuff='+encodeURIComponent(stuff);	
	

		xmlhttp = newAjax();
				
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("writefileresult").innerHTML=xmlhttp.responseText;
			}
		} 
		
		xmlhttp.open("POST","/writefile.php",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(poststring);	
	
}


