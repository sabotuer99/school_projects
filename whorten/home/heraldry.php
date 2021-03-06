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

<h2>Coat of Arms</h2>
<div id="coa_box">
<img src="coatofarms_ml.gif" alt="" width="100%">
</div>

<p>
<em>Blazon:</em><br>
ARMS Argent and Purpure lozengy a Unicorn trippant argent.
CREST A helmet proper surrounded by a laurel wreath vert.
SUPPORTERS two oak leaves vert. between two lions rampant or armed argent langued gules.
MOTTO ex Perseverantia Sapientia et Gnaritas.
</p>

<p>
<em>Meanings:</em><br>
The lozenge represents constancy and wisdom. <br>
Purple and white represent sovereignty and sincerity, respectively.<br>
The Unicorn represents extreme courage.<br>
Oak branches represent great age and strength.<br> 
The Lion represents dauntless courage.<br>
The laurel represents peace and triumph, and the helmet wise defence and wisdom.<br>
The motto translates "from Perseverance, Wisdom and Knowledge"
</p>

<p>
<em>Meanings interpreted:</em><br>
The symbols in Whorten's coat of arms harmonize with our values and beliefs.  Symbols for courage (the lions and the unicorn) represent the courage of Whorten students to pursue higher education.  Purple (sovereignty) symbolizes our students taking charge of their own destiny, and pays tribute to the individual spirit so esteemed by the Academy.  The oak branches symbolize the great age and strength of the educational institutions that have come before us. Finally, symbols for peace and wisdom represent the cooperative community of devoted learners we strive to create.
</p>
