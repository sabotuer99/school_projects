function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}




function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}




function eraseCookie(name) {
	createCookie(name,"",-1);
}




function swapStyleSheet (sheet){


//var	target = document.domain + '/' + file.getAttribute('data-target');

	document.getElementById('pagestyle').setAttribute('href',sheet);	
	createCookie('style',sheet,99*365);
	/*
	var expiration = new Date( +new Date + (1000 * 60 * 60 * 24 * 365 * 99));
	document.cookie="style="+sheet+"; expires="+expiration.toUTCString()+"; path=/";
	*/
}




function ToggleDiv(div){
		tdiv=div;
		i=1;
		while(i){
			if(tdiv.nodeType!=1)
			{
				tdiv = tdiv.nextSibling;					
				}
			else if(tdiv.tagName!='DIV')
			{
				tdiv = tdiv.nextSibling;					
				}	
			else {
				i=0;	
				}
							
			}
	
	
		if (tdiv.clientHeight==0)//getAttribute('')=='hide')
				{
					tdiv.setAttribute('data-style','show');
					tdiv.setAttribute('style','height:'+tdiv.scrollHeight+'px');
					div.setAttribute('data-state','down');
				}	
		else
				{
					tdiv.setAttribute('data-style','hide');
					tdiv.setAttribute('style','height:0px');		
					div.setAttribute('data-state','side');
					/*document.getElementById('mainbody').setAttribute('style','display:inline-block;');	
					document.getElementById('mainbody').offsetHeight;
					document.getElementById('mainbody').setAttribute('style','display:block;');*/
				}
}




function newAjax(){
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




function navigate(file, popstate){

var xmlhttp = newAjax();
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
    	document.getElementById("maincontent").innerHTML=xmlhttp.responseText;
    	
    	if (document.getElementById("runscript")!=null) 
    		{
    		var i=0;
    		while (document.getElementById("runscript").getElementsByTagName('script')[i]!=null)
    			{
      		eval(document.getElementById("runscript").getElementsByTagName('script')[i].innerHTML); 
      		i++; 			
    			}
    		}
		}
  }  

/*alert(typeof file);
//if file is passed as a sting, use it directly, otherwise assume it is an element    */
if (typeof file == 'string')  
{
		var target = 'http://' + document.domain + '/' + file;
		var cookietarget = file;
}
else 
{
		var target = 'http://' + document.domain + '/' + file.getAttribute('data-target');
		var cookietarget = file.getAttribute('data-target');
}

/*alert(target.search('\\?'));*/
if (target.search('\\?') >= 0 )
	{
	ajax = '&ajax=TRUE';
	}
else 
	{
	ajax = '?ajax=TRUE';	
	}

opentarget = target + ajax;

xmlhttp.open("GET",opentarget,true);
xmlhttp.send();

if (popstate=='replace'){window.history.replaceState({'url':target},target,target); }
else if (popstate!=false ){ window.history.pushState({'url':target},target,target); }

createCookie('currloc',cookietarget,99*365);

return false;
}




function deletesibs(element){
	var b = element;

	while(b.nextSibling){
		b.parentNode.removeChild(b.nextSibling);
		}	
}

/*
function resetcrumbs(){
	document.getElementById('breadcrumbs').innerHTML='';
}

function addcrumb(element){
 	var bc=document.getElementById('breadcrumbs');
	var newcrumb=document.createElement("a");
	if(element.getAttribute('data-crumbtitle'))
	{
	newcrumb.innerHTML = element.getAttribute('data-crumbtitle');		
	}
	else
	{
	newcrumb.innerHTML = element.innerHTML;
	}
	newcrumb.setAttribute('data-target',element.getAttribute('data-target'));	
	newcrumb.setAttribute('onclick',"navigate(this);deletesibs(this);");
		
	if (bc.innerHTML == '')
	{ 
			//newcrumb.innerHTML = element.getAttribute('title'); 
			bc.appendChild(newcrumb);
	}
	else
	{
			newcrumb.innerHTML = "&gt; " + newcrumb.innerHTML;		
	
			if (bc.lastChild.getAttribute('data-target') != newcrumb.getAttribute('data-target'))
			{
					bc.appendChild(newcrumb);
			}		
	}
	
}
*/

function addEventListeners(){
	//add event listeners to sub-navigation menus
	var nodelist = document.getElementsByClassName('subnav');
	for (var j=0; j<nodelist.length;j++)
	{

		var alist = nodelist[j].getElementsByTagName('a');
			for(var i=0;i < alist.length;i++)
				{
						alist[i].addEventListener("click",function(){navigate(this);/* resetcrumbs(); addcrumb(this.parentNode.previousSibling.previousSibling); addcrumb(this);*/},false);
				}
	}
	
	//add event listeners to side, down arrow icons for navigation
	var buttonlist = document.getElementsByClassName('toggle');
	for (var i=0; i<buttonlist.length; i++){
		buttonlist[i].addEventListener("click",function(){ToggleDiv(this);},false);
		}
	
	//add event listeners to main nav items	
	var navlist = document.getElementsByClassName('nav');
	for (var i=0; i<navlist.length; i++){
		navlist[i].addEventListener("click",function(){ToggleDiv(this.parentNode.getElementsByClassName('toggle')[0]); navigate(this); /*resetcrumbs(); addcrumb(this);*/},false);
		}
		
	//CSS theme change buttons
	document.getElementById('darkthemebutton').addEventListener("click",function(){swapStyleSheet('/css/dark.css')},false);
	document.getElementById('lightthemebutton').addEventListener("click",function(){swapStyleSheet('/css/light.css')},false);
}

window.onpopstate = function(event) {
  if(event && event.state) {
  		var navtarget = location.pathname.substr(1);
  		//var locelement = document.querySelectorAll('[data-target="'+ navtarget +'"]')[0];
    navigate(navtarget, false);
  }
}

function login(option){
		
		var xmlhttp = newAjax();
		var target = document.getElementById('loginbox');
		var poststring = "val="+option;
		
		xmlhttp.onreadystatechange=function()
		{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
						target.innerHTML=xmlhttp.responseText;
						
						if (document.getElementById("loginscript")!=null) 
			    		{
			    		eval(document.getElementById("loginscript").getElementsByTagName('script')[0].innerHTML);
			    		}
				}
		}  
		
		if(option=='submit')
		{
				var username = document.getElementById('usernameinput').value;
				var password = document.getElementById('passwordinput').value;
				var message = username + password;
				var hashedpass = CryptoJS.SHA3(message); //uncomment when I have internet... doh!
				poststring += "&u="+username+"&p="+hashedpass;
				//alert(hashedpass);
			
		}	
		
		xmlhttp.open("POST","/home/login.php",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(poststring);

}

function reloadNav(){
	
		var xmlhttp = newAjax();
		var target = document.getElementById('leftsidenavdiv');
		
		xmlhttp.onreadystatechange=function()
		{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
						if (target!=null) 
			    		{
			    		target.innerHTML=xmlhttp.responseText;
			    		addEventListeners();
			    		}
				}
		} 

		xmlhttp.open("GET",'/home/leftsidenav.php',true);
		xmlhttp.send();

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
		
				xmlhttp.open("POST","/home/createaccount.php",false);
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

/*****************************************************************************************
****
****  reqCheck() adds icons to indicate if required and if input is kosher 
****      
******************************************************************************************/
function reqCheck(element) {
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
				 	element.nextSibling.setAttribute('style','display:inline');
			}
			else 
			{ 
					element.nextSibling.setAttribute('src','/css/checkmark_small.png');
					element.nextSibling.setAttribute('title','OK');
				 	element.nextSibling.setAttribute('style','display:inline');
			}
		}
		else 
		{
			element.nextSibling.setAttribute('src','/css/20_button_red.png');
			element.nextSibling.setAttribute('title',d);
			element.nextSibling.setAttribute('style','display:inline');
		}				
	}	
	
}	
/*****************************************************************************************
****
****  reqCheck() adds icons to indicate if required and if input is kosher 
****      
******************************************************************************************/
function regErrors(element) {
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
function regListeners() {
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
function writeFile() {
	
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

function toggle_rubric_table(element) 
{
	target = element.getAttribute('data-target');
	tdiv = document.getElementById(target);
	var a = isNaN(tdiv.clientHeight) ? 0 : tdiv.clientHeight;
	var b = isNaN(tdiv.offsetHeight) ? 0 : tdiv.offsetHeight;
	var c = isNaN(tdiv.scrollHeight) ? 0 : tdiv.scrollHeight;
	var d = isNaN(tdiv.clientY) ? 0 : tdiv.clientY;
	var e = isNaN(tdiv.offsetY) ? 0 : tdiv.offsetY;
	var h = a > 0 ? a : d > 0 ? d : Math.max( b, c, e);

		if (tdiv.clientHeight==0)//getAttribute('')=='hide')
				{
					
					tdiv.setAttribute('style','height:'+h+'px;');
					element.innerHTML = "Hide";
					createCookie(target,1,1);
				}	
		else
				{
					tdiv.setAttribute('style','transition:none;-webkit-transition:none;');
					tdiv.setAttribute('style','height:'+h+'px;transition:none;-webkit-transition:none;');
					/*alert();*/
					window.setTimeout("tdiv.setAttribute('style','height:0px;')",1);
					element.innerHTML = "Show";	
					eraseCookie(target);
				}
}

/******************************************************************************************************* 
 FOLLOWING FUNCTION TAKEN VERBATIM FROM STACKOVERFLOW  
 http://stackoverflow.com/questions/604167/how-can-we-access-the-value-of-a-radio-button-using-the-dom
*******************************************************************************************************/
function getRadioValue(theRadioGroup)
{
    var elements = document.getElementsByName(theRadioGroup);
    for (var i = 0, l = elements.length; i < l; i++)
    {
        if (elements[i].checked)
        {
            return elements[i].value;
        }
    }
	return false;
}


function submit_rubrics(element) 
{
	subID = element.getAttribute("data-subID");	
	
	/* First, select all input nodes in the "maincontent" div */
	inputArray = document.getElementById('maincontent').getElementsByTagName('input');
	
	/* now grab just the radio buttons */
	radioArray = new Array();
	for (i=0; i<inputArray.length; i++) 
	{
		if (inputArray[i].type == 'radio') 
		{
			radioArray.push(inputArray[i]);	
		}	
	}
	
	/* now grab the unique group names */
	groupNames = new Array();
	for (i=0; i<radioArray.length; i++) 
	{
		if (groupNames.indexOf(radioArray[i].getAttribute('name')) == -1) 
		{
			groupNames.push(radioArray[i].getAttribute('name'));	
		}	
	}

	/* create post string, check that all rubrics have a value checked */
	poststring = "ajax=TRUE&subID="+subID;
	
	/* code to include user name for simulator */	
	if (subID == 'sim') 
	{
		poststring += "&visitor=" + document.getElementById('visitorname').value;
	}
	
	for (i=0; i<groupNames.length; i++) 
	{
		if (!getRadioValue(groupNames[i])) 
		{
			alert("All rubrics must be completed!");
			return false;
		}
		else 
		{
			groupVal = getRadioValue(groupNames[i]);
			poststring += "&" + groupNames[i] + "=" + groupVal;
		}
	}

	/* make an AJAX request so submit the marks */
		var xmlhttp = newAjax();
		
		xmlhttp.onreadystatechange=function()
		{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
						document.getElementById('marksubresult').innerHTML=xmlhttp.responseText;
				}
		}  
		
		xmlhttp.open("POST","/mywhorten/submitmarks.php",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(poststring);
}