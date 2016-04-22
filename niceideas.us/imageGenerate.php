<?php
header ('Content-Type: image/png');


$text = $_GET['text'];
//test escape robustness
//$text = "<a href='#'>If this link works you fail</a>"; - PASS
//$text = '<a href="#">If this link works you fail</a>'; - PASS

$text = str_replace("%23", "#", $text);
$text = str_replace("\\", "", htmlentities(trim($text),ENT_QUOTES, $double_encode = null));
$text = mb_convert_encoding($text, "UTF-8", "HTML-ENTITIES");
//utf8_encode($text);

$heading = substr($text, 0, strpos($text, ":") + 1);
$body = substr($text, strpos($text, ":") + 1);


// Set up True Type Font
$font = 'Tangerine_Regular.ttf';
$font_size = 60;
$angle = 0;


// Get width of heading
$bbox = imagettfbbox($font_size, $angle, $font, $heading);
$headwidth = $bbox[2];	
$headheight = $bbox[1] - $bbox[7];
$linewidth[] = $headwidth;



// Get starting dimensions of bounding box for body
$bbox = imagettfbbox($font_size, $angle, $font, $body);
$startwidth = $bbox[2];
$lineheight = $bbox[1] - $bbox[7];
$numlines = ceil(sqrt($startwidth/(1.6*$lineheight)))-1;
if($numlines < 1) { $numlines = 1; }
$charperline = ceil(strlen($body)/$numlines);


// Break body text up into pieces, adjust character count so that
// the text is broken into the right number of lines

$lines = explode('|', wordwrap($body, $charperline, '|'));
$countlines = count($lines);


for ($i = 0; ($countlines > $numlines) && ($i < 25); $i++) 
{
	$x = $charperline + $i;
	$lines = explode('|', wordwrap($body, $x, '|'));
	$countlines = count($lines);
}


foreach ($lines as $line)
{
	
	$bbox = imagettfbbox($font_size, $angle, $font, $line);
	$linewidth[] = $bbox[2];	

}


$linespacing = round($lineheight/5);

$width = max($linewidth) + 2 * $lineheight; 

$height = $lineheight * (count($lines)+2) + $headheight + (count($lines) * $linespacing);

//scale everything so that the image is a good size
$yscale = (600/$height);
$xscale = (600/$width);
$scale = min($yscale,$xscale);
$width = round($scale*$width);
$height = round($scale*$height);
$font_size = round($scale*$font_size);
$lineheight = round($scale*$lineheight);
$linespacing = round($lineheight/5);
$headheight = round($scale*$headheight);


//square up the image
if($width>$height*1.3) {
	$ypad = ($width-$height*1.3)/2;
	$xpad = 0;
	$height = $width/1.3;
} else {
	$ypad = 0;
	$xpad = ($height-$width/1.3)/2;;
	$width = $height*1.3;
}

$y = $font_size + $lineheight + $ypad; //Starting Y position

$im = @imagecreatetruecolor($width, $height)
      or die('Cannot Initialize new GD image stream');
$text_color = imagecolorallocate($im, 233, 14, 91);
//imagestring($im, 1, 5, 5,  $text, $text_color);


$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
$border = imagecolorallocate($im, 255, 174, 185); //pink

//imagefilledrectangle($im, 0, 0, $width-1, $height-1, $border);

$numTranRec = ceil(($lineheight*.75)/4);

for($i = 0; $i < $numTranRec; $i++) {
		$color = imagecolorallocate($im, 255, round(174 + (255-174)/$numTranRec*$i), round(185 + (255-185)/$numTranRec*$i));
		imagefilledrectangle($im, $i*8, $i*8, $width-($i*8+1), $height-($i*8+1), $color);	
}

imagefilledrectangle($im, $lineheight*.75, $lineheight*.75, $width-($lineheight*.75+1), $height-($lineheight*.75+1), $white);

imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR);
imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR);
imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR);

//write heading
		// Add some shadow to the text
		imagettftext($im, $font_size, $angle, ($lineheight+ceil($font_size/60)) + $xpad, $y+ceil($font_size/60), $grey, $font, $heading);
		// Add the text
		imagettftext($im, $font_size, $angle, $lineheight + $xpad, $y, $black, $font, $heading);

$y = $y + $headheight + $linespacing;

foreach ($lines as $line)
{
		// Add some shadow to the text
		imagettftext($im, $font_size, $angle, ($lineheight+ceil($font_size/60)) + $xpad, $y+ceil($font_size/60), $grey, $font, $line);
		// Add the text
		imagettftext($im, $font_size, $angle, $lineheight + $xpad, $y, $black, $font, $line);
		
		$y = $y + $lineheight + $linespacing;
}



$stamp = "www.niceideas.us";
$font = "Ubuntu-Regular.ttf";
$font_size = round($font_size/3.5);


	$bbox = imagettfbbox($font_size, $angle, $font, $stamp);
	$stampwidth = $bbox[2];	
	$stampheight = $bbox[1] - $bbox[7];
	imagettftext($im, $font_size, $angle, $width - ($stampwidth+1+$stampheight), $height - ($stampheight+1), $black, $font, $stamp);	
	
imagepng($im);
imagedestroy($im);
?>