function SQLInsert(div, table)
{
var xmlhttp;

var div_id = div + "Form";

var fieldarray  = document.getElementById(div_id).querySelectorAll('*[accesskey]');
var selectarray = document.getElementById(div_id).getElementsByTagName('select');

var arrayclean = new Array();

	for (var i = 0; i < (fieldarray.length); i++)
	{ 
			arrayclean[i] = new Array();		
			arrayclean[i][0]= (fieldarray[i].getAttribute('accesskey'));
			arrayclean[i][1]= (fieldarray[i].value);
	}
	
	for (var j = i; j < i + (selectarray.length); j++)
	{
			arrayclean[j] = new Array();	
			arrayclean[j][0]= (selectarray[j-i].getAttribute('data-field'));
			arrayclean[j][1]= (selectarray[j-i].options[selectarray[j-i].selectedIndex].value);	
	
	}

var file = "insert.php?table=" + table;


for (var i = 0; i < arrayclean.length; i++)
{ 
		file += "&" + arrayclean[i][0] + "=" + arrayclean[i][1];
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
    document.getElementById(div).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET",file,true);
xmlhttp.send();
}


function BuildSelect(select,table,label,value)
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
    	//alert(xmlhttp.responseText);
    document.getElementById(select).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET",'buildselect.php?table='+table+'&label='+label+'&value='+value,true);
xmlhttp.send();	
}


function CleanDiv(div)
{
document.getElementById(div).innerHTML=	"";
}


function BuildDocOffSelect(select)
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
    	//alert(xmlhttp.responseText);
    document.getElementById(select).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET",'builddocoff.php',true);
xmlhttp.send();	
}



function BuildPatient(select)
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
    	//alert(xmlhttp.responseText);
    document.getElementById(select).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET",'buildpatient.php',true);
xmlhttp.send();	
}




function BuildPRoom(select)
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
    	//alert(xmlhttp.responseText);
    document.getElementById(select).innerHTML=xmlhttp.responseText;
    BedLabel();
    }
  }
xmlhttp.open("GET",'buildproom.php',true);
xmlhttp.send();	
}


function BedLabel()
{

  var room = document.getElementById('rnumfk_bed').options[document.getElementById('rnumfk_bed').selectedIndex].innerHTML;
  
  if (room.search("Semi-private") > -1 )
  {
  document.getElementById('bedlabel').innerHTML = "<option value='A'> A </option> <option value='B'> B </option>";
  }
  else
  {
  document.getElementById('bedlabel').innerHTML = "<option value='A'> A </option>";
  }
}



function BuildBed(select)
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
    	//alert(xmlhttp.responseText);
    document.getElementById(select).innerHTML=xmlhttp.responseText;
    BedLabel();
    }
  }
xmlhttp.open("GET",'buildbed.php',true);
xmlhttp.send();	
}

function ToggleDiv(div,mybutton)
{
if (document.getElementById(div).getAttribute('style')=='display:none;')
	{
		document.getElementById(div).setAttribute('style','display:block;');
		mybutton.innerHTML = "Hide";
	}	
else
	{
		document.getElementById(div).setAttribute('style','display:none;');		
		mybutton.innerHTML = "Show";
		document.getElementById('insertcol').setAttribute('style','display:none;');	
		document.getElementById('insertcol').offsetHeight;
		document.getElementById('insertcol').setAttribute('style','display:block;');	
	}
}
	
	
function SQLSelect(div, tablediv)
{
var xmlhttp;

var div_id = div + "Form";
var table = document.getElementById(tablediv).options[document.getElementById(tablediv).selectedIndex].value;
var file = "select.php?table=" + table;


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
    document.getElementById(div).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET",file,true);
xmlhttp.send();
}

function BuildTablelist(select)
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
    	//alert(xmlhttp.responseText);
    document.getElementById(select).innerHTML=xmlhttp.responseText;
    BedLabel();
    }
  }
xmlhttp.open("GET",'buildtablelist.php',true);
xmlhttp.send();	
}

function SQLDischarge()
{
var xmlhttp;

var date = document.getElementById("dischargedate").value;
var patient = document.getElementById('pidfk_dis').options[document.getElementById('pidfk_dis').selectedIndex].value;
var file = "discharge.php?date=" + date + "&patient="+patient;


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
    document.getElementById("Discharge").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET",file,true);
xmlhttp.send();
}

function SQLBill()
{
var xmlhttp;

var patient = document.getElementById('pidfk_bill').options[document.getElementById('pidfk_bill').selectedIndex].value;
var file = "patientbill.php?pid="+patient;


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
    document.getElementById("ReportBill").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET",file,true);
xmlhttp.send();
}

function SQLRoomUtil()
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
    document.getElementById("RoomUtil").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET",'roomutil.php',true);
xmlhttp.send();
}

function SQLPatientRep()
{
var xmlhttp;

var patient = document.getElementById('pidfk_patrep').options[document.getElementById('pidfk_patrep').selectedIndex].value;
var file = "patientreport.php?pid="+patient;


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
    document.getElementById("PatientReport").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET",file,true);
xmlhttp.send();
}

function SQLDocRep()
{
var xmlhttp;

var eid = document.getElementById('eidfk_docrep').options[document.getElementById('eidfk_docrep').selectedIndex].value;
var file = "docreport.php?eid="+eid;


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
    document.getElementById("DocReport").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET",file,true);
xmlhttp.send();
}