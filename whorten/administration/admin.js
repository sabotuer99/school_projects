function collpreview()
{ 	
		var iframe = document.getElementById('target_ifr');
		var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
		document.getElementById('preview').innerHTML = innerDoc.getElementById('tinymce').innerHTML; 
}

function createcolldir(option,element)
{ 	
	switch(option) 
	{
		case 'createform':
			var poststring = 'ajax=TRUE&opt='+option;
		break;

		case 'modifycommit':		
		case 'createnew':
			var cname = document.getElementById('collegename').value;
			var cabr = document.getElementById('collegeabbr').value;			
			var poststring = 'name='+encodeURIComponent(cname)+'&abbr='+encodeURIComponent(cabr)+'&ajax=TRUE'+'&opt='+option;			
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
			var abbr = element.getAttribute('data-abbr');
			var dbid = element.getAttribute('data-dbid');
			var poststring = 'ajax=TRUE&opt='+option+'&abbr='+abbr+'&dbok='+dbok+'&fsok='+fsok+'&dbid='+dbid;
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
				eraseCookie('COLLEGE'+dbid);		
				}
				if (xmlhttp.responseText.length==1) 
					{
					navigate("administration/createcollege1.php");
					}
				else { alert(xmlhttp.responseText); }
			}
		} 
	
		xmlhttp.open("POST","/administration/writecollege1.php",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(poststring);	

}


function createdeptdir(option,element)
{ 	
	switch(option) 
	{
		case 'createform':
			var cid = element.getAttribute('data-cid');
			var poststring = 'ajax=TRUE&opt='+option+'&cid='+cid;
		break;

		case 'modifycommit':		
		case 'createnew':
			var cname = document.getElementById('deptname').value;
			var cabr = document.getElementById('deptabbr').value;	
			var cid = document.getElementById('collegenum').innerHTML;		
			var poststring = 'name='+encodeURIComponent(cname)+'&abbr='+encodeURIComponent(cabr)+'&ajax=TRUE'+'&opt='+option+'&cid='+cid;			
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
			var abbr = element.getAttribute('data-abbr');
			var dbid = element.getAttribute('data-dbid');
			var cid = element.getAttribute('data-cid');
			var poststring = 'ajax=TRUE&opt='+option+'&abbr='+abbr+'&dbok='+dbok+'&fsok='+fsok+'&dbid='+dbid+'&cid='+cid;
		break;
	}
	
	 	xmlhttp = newAjax();
				
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				/*document.getElementById("writefileresult").innerHTML=xmlhttp.responseText;*/
				/*  If write was successful, create a description  */
				if (xmlhttp.responseText.length==1) 
					{
						switch(option) 
							{
								case 'createform':	
								case 'modifycommit':		
								case 'createnew':	
								case 'modify':														
								navigate("administration/createdept.php");
								break;
								
								case 'delete':								
								case 'cancel':
								case 'add_description':								
								navigate("administration/createcollege1.php");
								break;
								
							}						
						/*if (nav) 
						{
							navigate("administration/createdept.php");
						}
						else
						{
							navigate("administration/createcollege1.php");
						}*/
					}
				else { alert(xmlhttp.responseText.length+' '+xmlhttp.responseText); }
			}
		} 
	
		xmlhttp.open("POST","/administration/writedept.php",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(poststring);	

}
  
   
function toggle_coll_depts(element) 
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
					element.innerHTML = "Depts";	
					eraseCookie(target);
				}
}
