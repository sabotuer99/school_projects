<?php 
session_start();

	require_once 'navhelper.php';	
	require_once 'authcheck.php';
	require_once 'HTMLPurifier/HTMLPurifier.standalone.php';
	
/*  Quick test of HTMLPurifier...
    $purifier = new HTMLPurifier();
    $clean_html = $purifier->purify('<p onlick="xss()" >Clean HTML</p>');
    echo $clean_html;
*/
?>