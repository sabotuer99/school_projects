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

<h2>Mission Statement</h2>
<p>Our mission is to produce graduates of the highest calibre, who possess a breadth and depth of knowledge that will equip them to blaze their own path with confidence and competence, and who exemplify our core values of excellence, integrity, creativity, and wisdom.</p>
<h2>Core Values</h2>
<p>Whorten Academy will accomplish this mission by following and instilling in the student body the following core values:</p>

<table summary="" >
	<tr>
		<td><p><strong>Excellence</strong></p></td>
		<td><p>accept no less than the best from yourself, your peers, and Whorten Academy.</p></td>
	</tr>
	<tr>
		<td><p><strong>Integrity</strong></p></td>
		<td><p>reject deceit and fraud and strive for forthright honesty.</p></td>
	</tr>
	<tr>
		<td><p><strong>Creativity</strong></p></td>
		<td><p>seek beauty and innovation at every opportunity.</p></td>
	</tr>
	<tr>
		<td><p><strong>Wisdom</strong></p></td>
		<td><p>critical and creative analysis of information yields knowledge, and experience and reflection on this knowledge will yield wisdom.</p></td>
	</tr>
</table>
