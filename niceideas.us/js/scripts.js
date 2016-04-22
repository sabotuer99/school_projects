function navigate(file,linkid)
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
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("maincolumn").innerHTML=xmlhttp.responseText;
    document.getElementById("homelink").setAttribute("class","");
    document.getElementById("sharelink").setAttribute("class","");
    document.getElementById("profilelink").setAttribute("class","");
    document.getElementById("aboutlink").setAttribute("class","");
    document.getElementById("browselink").setAttribute("class","");
    document.getElementById("newlink").setAttribute("class","");
	 	 if (!(linkid=="pudding")){    
      document.getElementById(linkid).setAttribute("class","currentlocation");
 	   	}
    }
  }
xmlhttp.open("GET",file,true);
xmlhttp.send();
}


function ideaPostFunction(row, col, cat1, cat2, cat3, cat4, opt1, opt2, opt3, opt4, mood)
{
var xmlhttp;
var div_id;
var d = new Date();

div_id = row + col + "_cont";
document.getElementById(div_id).children[0].setAttribute("class", "ideatext transparent");

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById(div_id).innerHTML=xmlhttp.responseText;
    document.getElementById(div_id).children[0].setAttribute("class", "ideatext");
    }
  }
xmlhttp.open("GET","ideaquery.php?row="+row+"&col="+col+"&cat1="+cat1+"&cat2="+cat2+"&cat3="+cat3+"&cat4="+cat4+"&opt1="+opt1+"&opt2="+opt2+"&opt3="+opt3+"&opt4="+opt4+"&mood="+mood,true);
xmlhttp.send();
}

function ideaquery(row)
{
//	alert("ideaquery called");
	var cat1, cat2, cat3, cat4;
	var option1, option2, option3, option4, mood;
		
	switch(row)
	{
	case 'today':
		cat1 		= "Mood";
		cat2 		= "Gender";
		cat3 		= "Age Range";
		cat4 		= "";
		option1 	= document.getElementById("todaymood").value;
		option2 	= document.getElementById("todaygender").value;
		option3 	= document.getElementById("todayage").value;
		option4 	= "";
		mood = document.getElementById("todaymood").options[document.getElementById("todaymood").selectedIndex].text;
		break;
	case 'bigger':
		cat1 		= "Mood";
		cat2 		= "Gender";
		cat3 		= "Time Frame";
		cat4 		= "Age Range";
		option1 	= document.getElementById("biggermood").value;
		option2 	= document.getElementById("biggergender").value;
		option3 	= document.getElementById("biggertimeframe").value;
		option4 	= document.getElementById("biggerage").value;
		mood = document.getElementById("biggermood").options[document.getElementById("biggermood").selectedIndex].text;
		break;
	case 'special':
		cat1 		= "Mood";
		cat2 		= "Gender";
		cat3 		= "Occasion";
		cat4 		= "Age Range";
		option1 	= document.getElementById("specialmood").value;
		option2 	= document.getElementById("specialgender").value;
		option3 	= document.getElementById("specialoccasion").value;
		option4 	= document.getElementById("specialage").value;
		mood = document.getElementById("specialmood").options[document.getElementById("specialmood").selectedIndex].text;
		//alert(mood);
		break;
	default:
		cat1 		= "";
		cat2 		= "";
		cat3 		= "";
		cat4 		= "";
		option1 	= "";
		option2 	= "";
		option3 	= "";
		option4 	= "";
		mood = "";
	}; 

	//alert(row + " ",cat1 + " ",cat2 + " ",cat3 + " ",cat4 + " ",option1 + " ",option2 + " ",option3 + " ",option4 + " ");
	ideaPostFunction(row,"say",cat1,cat2,cat3,cat4,option1,option2,option3,option4,mood);
	ideaPostFunction(row,"do",cat1,cat2,cat3,cat4,option1,option2,option3,option4,mood);
	ideaPostFunction(row,"give",cat1,cat2,cat3,cat4,option1,option2,option3,option4,mood);
}
	
	
	
function ideapreview(source,destination)
{
	
	var selectdata='', options_selected=0;
	srcdoc = document.getElementById(source);

	document.getElementById('ideaMessage').innerHTML="";

if (source=='ideascope') {
	option4replace();
}


if (srcdoc.tagName=='TEXTAREA' || srcdoc.getAttribute('type')=='text') {
	selectdata = reEscape(srcdoc.value); }
else {
	try 
	{
		for (var i=0; i < srcdoc.length; i++)
		{
		
		if (srcdoc[i].selected)
			{
			options_selected++ 
			if (options_selected > 1 && !(i==srcdoc.length)) {selectdata = selectdata + ", ";}
			selectdata = selectdata + srcdoc[i].value;
			}
	
		}	
	}
	catch(err) 
	{
		alert("Array logic didn't work");
		selectdata = srcdoc.value;
	}
}

var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById(destination).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","preview.php?value="+selectdata,true);
xmlhttp.send();

	
}

function reEscape(s) {
			return s.replace(/[^\w\s\d\.\?!]/gi, '');		
}


function option4replace() {
	
	var ideatype = document.getElementById('ideascope').value;
	var opt4 = document.getElementById('option4');
	var opt4menu = document.getElementById('option4menu');
/*
	var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById('option4').innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","inputmenuoptions.php?value="+ideatype,true);
xmlhttp.send();
*/

		if(ideatype=='bigger') {
		opt4.innerHTML =	'<span>What is the timeframe?</span>';
		opt4menu.innerHTML =	'<select id="biggertimeframe" onchange="ideapreview(&#39;biggertimeframe&#39;,&#39;timeframepreview&#39;);">'+
																			'<option value="thisweek">This Week</option>'+
																			'<option value="thismonth">This Month</option>'+
																			'<option value="thisseason">This Season</option>'+
																			'<option value="thisyear">This Year</option>'+
																			'<option value="lifetime">Once in a lifetime</option>	'+
																		'</select>';
		}
		else if (ideatype=='special') {
		opt4.innerHTML =	'<span>What special occasion?</span>';
		opt4menu.innerHTML =	'<select id="specialoccasion" onchange="ideapreview(&#39;specialoccation&#39;,&#39;specialpreview&#39;);">'+
																			'<option value="nextholiday">Next Holiday</option>'+
																			'<option value="birthday">Birthday</option>	'+
																			'<option value="anniversary">Anniversary</option>'+
																			'<option value="graduation">Graduation</option>	'+
																			'<option value="promotion">Promotion</option>	'+
																			'<option value="bereavement">Bereavement</option>'+
																	'</select>';
		}
		else {
		opt4.innerHTML =	'';
		opt4menu.innerHTML =	'';			
		}
}


function CurLoc() {
	//alert("function called!");
	if (document.getElementById("homelink").getAttribute("class")=='currentlocation') {
	//	alert("HOME");
		document.getElementById("CurLoc").setAttribute("value","home");
		}
	if (document.getElementById("sharelink").getAttribute("class")=='currentlocation') {
	//	alert("SHARE");
		document.getElementById("CurLoc").setAttribute("value","share");
		}	
	if (document.getElementById("profilelink").getAttribute("class")=='currentlocation') {
	//	alert("PROFILE");
		document.getElementById("CurLoc").setAttribute("value","profile");
		}		
	//alert("Missed Something...");
}


function showHint(str)
{
var xmlhttp;
if (str.length==0)
  { 
  document.getElementById("txtHint").innerHTML="...";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getmoodhint.php?q="+str,true);
xmlhttp.send();
}


function FbIdLookup(fbid, first, last, email, sex) {
//function navigate(file,linkid){
var xmlhttp;
//alert(fbid+first+last+email+sex)
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    //	alert(xmlhttp.responseText);
    //document.getElementById("loginaction").innerHTML=xmlhttp.responseText;
			var la = xmlhttp.responseText;
		 	switch (la)
				{
						case "reload":
							location.reload();
						break;
						case "createlink":
							navigate('profile.php','profilelink');
						break;
						default:
						break;
				}	
    }
  }
xmlhttp.open("POST","fblogin.php",false);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("FbId="+fbid+"&FbFirst="+first+"&FbLast="+last+"&FbEmail="+email+"&FbSex="+sex);
}

/*function loginAction() {
	var la = document.getElementById("loginaction").innerHTML; //|| document.getElementById("loginaction").textContent;	
//	alert(la);	
	switch (la)
	{
	case "reload":
		location.reload();
	break;
	case "createlink":
		navigate('profile.php','profilelink');
	break;
	default:
	break;
	}	
}*/

function checkUsername() {
		var usr = document.getElementById("username").value;
		usr = usr.replace(/[^\w\d\.\?!_-]/gi, '');
		var usrStatus = document.getElementById("usernameStatus");

		document.getElementById("usernamePreview").innerHTML = usr;	
		document.getElementById("usernameClean").setAttribute('value',usr);
		
		usrStatus.innerHTML = '';	
		
		if(usr.length < 5 || usr.length > 20)
		{
					if(usr.length < 5) 
					{
								usrStatus.innerHTML = 'too short.';
							  //	document.getElementById("usernameStatus").innerHTML=usrStatus;
					} 
					
					if(usr.length > 20)
					{
								usrStatus.innerHTML = 'too long.';
					}
					
		}
		else 
		{
		
				//	var userString = "<input type='text' name='username' id='username' onchange='checkUsername()' onkeyup='checkUsername()' value='" + usr + "'>";	
				
				//	document.getElementById("username").focus();
					
					var xmlhttp;
					  				
					if (window.XMLHttpRequest)
	  				{// code for IE7+, Firefox, Chrome, Opera, Safari
	  						xmlhttp=new XMLHttpRequest();
	  				}
					else
	  				{// code for IE6, IE5
	  						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  				}
					xmlhttp.onreadystatechange=function()
	  				{
	  						if (xmlhttp.readyState==4 && xmlhttp.status==200)
	 					{
	 							//document.getElementById("usernameStatus").innerHTML=xmlhttp.responseText;
	 							usrStatus.innerHTML = xmlhttp.responseText;
	 					}
	  				}
					xmlhttp.open("GET","checkusername.php?q="+usr,true);
					xmlhttp.send();
		}
}

function comparePassword() {
	var password = document.getElementById('pwd').value;
	var compare = document.getElementById('confirmpwd').value;
	var usrgood = document.getElementById('usernameStatus').innerHTML;
	document.getElementById('pwdMatchMsg').innerHTML= "";
	//alert(usrgood == 'Available!');
	
	if (password.length < 8) {
	document.getElementById('pwdMatchMsg').innerHTML+= "Password is too Short. ";		
		}
		
	var pwdRegex = /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*\d)\S*$/;
	if (!pwdRegex.test(password) && password.length > 0) 
	{
			document.getElementById('pwdMatchMsg').innerHTML+= "Invalid password, must contain at least one lowercase letter, one upper case letter, and one digit, and be at least eight digits long. ";		
	}	
	
	if (!password.length==0 || !compare.length==0) 
	{
			if (password == compare) 
			{
					document.getElementById('pwdMatchImg').innerHTML = '<img src="img/icons/checkmark_small.png">';	
					//if (usrgood == 'Available!')	 
					//{
							var username = document.getElementById('username').value.toUpperCase();
							var Message = password + username;
							var pwdhash = document.getElementById('pswHash');
							var hashedval = CryptoJS.SHA3(Message);
							//alert(hashedval);
							pwdhash.setAttribute('value', hashedval);	
							//alert(pwdhash.value);			
							document.getElementById('hashpreview').innerHTML = hashedval;
					//}		
			}	
			else
			{
					document.getElementById('pwdMatchImg').innerHTML= '<img src="img/icons/erroricon_small.png">';	
					document.getElementById('pwdMatchMsg').innerHTML+= "Password and confirmation don't match. ";
			}
	}
	else
	{
				document.getElementById('pwdMatchImg').innerHTML= '';	
	}
	
}

function hashPassword() {
	var pass =	document.getElementById('pswLogin').value;
	var user = document.getElementById('userLogin').value.toUpperCase();
	var Message = pass + user;
	var pwdhash = document.getElementById('loginPwdHash');
	var hashedval = CryptoJS.SHA3(Message);
	pwdhash.setAttribute('value', hashedval);	
	
}

function SubmitIdea() {
	
if (document.getElementById('ideaMessage').innerHTML!="")		
	{
	document.getElementById('ideaMessage').innerHTML="Oops!";
	return;
	}	
	
var scope = document.getElementById('ideascope').value;

var option;
if(document.getElementById('biggertimeframe')!= null){
	option = document.getElementById('biggertimeframe').value;} 
if(document.getElementById('specialoccasion')!= null){
	option = document.getElementById('specialoccasion').value;} 
	
var ideaType = document.getElementById('ideatype').value;
var sex = document.getElementById('genderselect').value;
var mood = document.getElementById('moodselect').value;
var kids = document.getElementById('kids').checked;
var teens = document.getElementById('teens').checked;
var adults = document.getElementById('adults').checked;
var seniors = document.getElementById('seniors').checked;
var ideatext = document.getElementById('ideatextinput').value.replace("\\","");
	
//alert(scope + '\n' + option + '\n' + ideaType + '\n' + sex + '\n' + mood + '\n' + kids + '\n' + teens + '\n' + adults + '\n' + seniors);
	
	
var xmlhttp;
  				
if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
  						xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
  						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
				//document.getElementById("usernameStatus").innerHTML=xmlhttp.responseText;
				document.getElementById('ideaMessage').innerHTML = xmlhttp.responseText;
		}
}
xmlhttp.open("GET","insertIdea.php?scope="+scope+"&option4="+option+"&ideaType="+ideaType+"&sex="+sex+"&mood="+mood+"&kids="+kids+"&teens="+teens+"&adults="+adults+"&seniors="+seniors+"&ideatext="+ideatext,true);
xmlhttp.send();

}

function escapeHtml(str) {
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
};

function imageGen(sourceDiv)
{
		var xmlhttp;
		var ideatext = unescape(encodeURIComponent(document.getElementById(sourceDiv+"_cont").innerText || document.getElementById(sourceDiv+"_cont").textContent)); //.innerHTML.replace(/(<([^>]+)>)/ig,"");
		//alert(ideatext);
		var patt=/Idea.*:/;
		var begin = ideatext.search("Idea");
		var end = ideatext.search(":") + 1;
		var heading = ideatext.substr(begin,end-begin);
		heading = heading.replace("#","%23");
		var strlen = ideatext.length - end;
		ideatext = ideatext.substr(end,strlen);

 		ideatext = ideatext.replace(/\"/g,"%22");
// 		alert(ideatext);
//		ideatext = ideatext.replace("\\","");

		ideatext = heading + ' ' + ideatext; 
		
		//alert(heading + '\n' + ideatext + '\n' + begin + '\n' + end + '\n' + strlen + '\n');
	
//		alert(ideatext);	
		
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
		    document.getElementById("genImgDiv").innerHTML=xmlhttp.responseText;
		    }
		  }
		xmlhttp.open("GET","imgScript.php?imgtext="+ideatext,false);
		xmlhttp.send();
}
