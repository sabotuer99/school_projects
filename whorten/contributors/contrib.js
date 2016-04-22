function collpreview()
{ 	
		var iframe = document.getElementById('target_ifr');
		var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
		document.getElementById('preview').innerHTML = innerDoc.getElementById('tinymce').innerHTML; 
}

function createcrs(option,element)
{ 	
	switch(option) 
	{
		case 'createform':
			var poststring = 'ajax=TRUE&opt='+option;
		break;

		case 'modifycommit':		
		case 'createnew':
			var cname = document.getElementById('coursename').value;

			var deptlist = document.getElementById('deptlist');
			var level = document.getElementById('class_level');
			var sublevel = document.getElementById('class_sublevel');
		
			var did = deptlist.options[deptlist.selectedIndex].value;
			var levelval = level.options[level.selectedIndex].value;
			var sublevelval = sublevel.options[sublevel.selectedIndex].value;
		
			if (sublevelval == 'null') 
			{
				sublevelval = 0;	
			}
			var prefix = (levelval*1) + (sublevelval*1);	
			
			var crsdesc = 	new String(document.getElementById('crsdesc').value);		
			
			var cred = document.getElementById('credithours');
			var credhr = cred.options[cred.selectedIndex].value;					
					
			var poststring = 'name='+encodeURIComponent(cname)+'&did='+encodeURIComponent(did)+'&ajax=TRUE'+'&opt='+option+'&prefix='+prefix+'&crsdesc='+encodeURIComponent(crsdesc)+'&credhr='+credhr;			
		break;
		
		case 'cancel':
			var poststring = 'ajax=TRUE&opt='+option;
		break;
		
		case 'add_description':		
			var iframe = document.getElementById('target_ifr');
			var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
			var stuff = innerDoc.getElementById('tinymce').innerHTML; 			
			var poststring = 'ajax=TRUE&opt='+option+'&stuff='+encodeURIComponent(stuff);
		break;
		
		case 'delete':
		case 'modify':
			var fsok = element.getAttribute('data-fsok');
			var dbok = element.getAttribute('data-dbok');
			var crsid = element.getAttribute('data-crsid');
			var did = element.getAttribute('data-did');
			var poststring = 'ajax=TRUE&opt='+option+'&dbok='+dbok+'&fsok='+fsok+'&crsid='+crsid+'&did='+did;
		break;
		
		case 'updatecrslist':
			var cid = element.getAttribute('data-cid');
			var poststring = 'ajax=TRUE&opt='+option+'&cid='+cid;
		break;
	}
	/* alert(poststring); /* DEBUGGING CODE*/
	 	xmlhttp = newAjax();
				
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				/*document.getElementById("writefileresult").innerHTML=xmlhttp.responseText;*/
				/*  If write was successful, create a description  */
				if (option == 'delete') 
				{
				eraseCookie('CRS'+crsid);		
				}
				if (xmlhttp.responseText.length==1) 
					{
					navigate("contributors/courseadmin.php");
					}
				else { alert(xmlhttp.responseText); }
			}
		} 
	
		xmlhttp.open("POST","/contributors/writecourse.php",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(poststring);	

}


function updatecrsform(option,element,target)
{ 	
	switch(option) 
	{		
		case 'updatecrslist':
			var cid = element.options[element.selectedIndex].getAttribute('value');
			var poststring = 'ajax=TRUE&opt='+option+'&cid='+cid;
		break;
	}
	/* alert(poststring); /* DEBUGGING CODE*/
	 	xmlhttp = newAjax();
				
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById(target).innerHTML = xmlhttp.responseText;
				update_prelim_id();
			}
		} 
	
		xmlhttp.open("POST","/contributors/writecourse.php",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(poststring);	

}

function toggle_crsgroup_create() 
{
	form = document.getElementById('create_crsgroup');
	buttons = document.getElementById('crsgroup_buttons');
	
	if (form.getAttribute('style')=='display:block') 
	{
		form.setAttribute('style','display:none');
		buttons.setAttribute('style','display:block');		
	}
	else
	{
		form.setAttribute('style','display:block');
		buttons.setAttribute('style','display:none');		
	}
}

function update_prelim_id()
{
	deptabbr = document.getElementById('prelim_deptabbr');
	crsnum = document.getElementById('prelim_crsnum');
	deptlist = document.getElementById('deptlist');
	level = document.getElementById('class_level');
	sublevel = document.getElementById('class_sublevel');

	did = deptlist.options[deptlist.selectedIndex].value;
	levelval = level.options[level.selectedIndex].value;
	sublevelval = sublevel.options[sublevel.selectedIndex].value;

	if (sublevelval == 'null') 
	{
		sublevelval = 0;	
	}

	prefix = (levelval*1) + (sublevelval*1);

	var poststring = 'ajax=TRUE&opt=updatecrsnum&prefix='+prefix+'&did='+did;

 	xmlhttp = newAjax();
			
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			deptabbr.innerHTML = deptlist.options[deptlist.selectedIndex].getAttribute('data-abbr');
			crsnum.innerHTML = xmlhttp.responseText.trim();
		}
	} 

	xmlhttp.open("POST","/contributors/writecourse.php",false);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(poststring);	
	

}


function createlesson(option,element)
{ 	
	switch(option) 
	{
		case 'createassign':
		case 'createlesson':
			var crsid = element.getAttribute('data-crsid');
			var poststring = 'ajax=TRUE&opt='+option+'&crsid='+crsid;
		break;

		case 'modifycommit':
			var type_elem = document.getElementById('lesson_type');
			var lsntype = type_elem.options[type_elem.selectedIndex].value;			
		case 'createnew':		
			if (option == 'createnew') { lsntype = element.getAttribute('data-lsntype'); }		
			var crsid = element.getAttribute('data-crsid');	
			var lsnid = element.getAttribute('data-lsnid');
			var lsntitle = document.getElementById('lesson_title').value;		
			var poststring = 'ajax=TRUE'+'&opt='+option+'&crsid='+crsid+'&lsnid='+lsnid+'&title='+encodeURIComponent(lsntitle)+'&type='+encodeURIComponent(lsntype);			
		break;
		
		case 'cancel':
			var poststring = 'ajax=TRUE&opt='+option;
		break;
		
		case 'add_description':		
			var iframe = document.getElementById('target_ifr');
			var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
			var stuff = innerDoc.getElementById('tinymce').innerHTML; 			
			var poststring = 'ajax=TRUE&opt='+option+'&stuff='+encodeURIComponent(stuff);
		break;
		
		case 'delete':
		case 'modify':
			var lsntype = element.getAttribute('data-lsntype');	
			var typenum = element.getAttribute('data-typenum');	
			var fsok = element.getAttribute('data-fsok');
			var dbok = element.getAttribute('data-dbok');
			var lsnid = element.getAttribute('data-lsnid');
			var crsid = element.getAttribute('data-crsid');
			var poststring = 'ajax=TRUE&opt='+option+'&dbok='+dbok+'&fsok='+fsok+'&lsnid='+lsnid+'&crsid='+crsid+'&type='+encodeURIComponent(lsntype)+'&typenum='+encodeURIComponent(typenum);
		break;
	}
	
	 	xmlhttp = newAjax();
				
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				/*document.getElementById("writefileresult").innerHTML=xmlhttp.responseText;*/
				/*  If write was successful, create a description  */
				if (xmlhttp.responseText.length<=2) 
					{
						switch(option) 
							{
								case 'createassign':
								case 'createlesson':								
								case 'createform':	
								case 'modifycommit':		
								case 'createnew':	
								case 'modify':														
								navigate("contributors/coursedetail.php");
								break;
								
								case 'delete':								
								case 'cancel':
								case 'add_description':								
								navigate("contributors/courseadmin.php");
								break;
								
							}						

					}
				else { alert(xmlhttp.responseText); }
			}
		} 
	
		xmlhttp.open("POST","/contributors/writelesson.php",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(poststring);	

}
 
   
function toggle_course(element) 
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
					
					tdiv.setAttribute('style','height:'+h+'px;border:2px solid;');
					element.innerHTML = "Hide";
					createCookie(target,1,1);
				}	
		else
				{
					tdiv.setAttribute('style','transition:none;-webkit-transition:none;');
					tdiv.setAttribute('style','height:'+h+'px;border:2px solid;transition:none;-webkit-transition:none;');
					/*alert();*/
					window.setTimeout("tdiv.setAttribute('style','height:0px;border:0px solid transparent;')",1);
					element.innerHTML = "Show";	
					eraseCookie(target);
				}
}
