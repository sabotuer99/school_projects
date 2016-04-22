<?php

$ideatext = $_GET['imgtext'];

echo str_replace("\\", "", htmlentities(trim($ideatext),ENT_QUOTES, $double_encode = null));

$ideatext = str_replace("#","%23",$ideatext);

//$ideatext = mb_convert_encoding($ideatext, "HTML-ENTITIES", "UTF-8");
//$ideatext = preg_replace('~^(&([a-zA-Z0-9]);)~',htmlentities('${1}'),$ideatext);
//echo $ideatext;


echo "<meta id='genImg' src='imageGenerate.php?text=".$ideatext."'>";


?>