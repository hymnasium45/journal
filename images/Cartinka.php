<?php

// Set the content-type
header('Content-Type: image/png');

// Create the image
$im = imagecreatetruecolor(100, 50);
$a=mt_rand(2,5);
$b=mt_rand(2,5);
$c=mt_rand(1,4);
$randT=mt_rand(-15,15);
$randT1=mt_rand(-15,15);
// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
imagefilledrectangle($im, 0, 0, 399, 49, $white);
$text_bg="$b $c $a";
// The text to draw
$text = "$a*$b-$c";
$sum=$a*$b-$c;
// Replace path  y your own font path
$font = '/usr/share/fonts/truetype/ttf-indic-fonts-core/gargi.ttf';


imagettftext($im, 20, $randT, 13, 33, $grey, $font, $text);

imagettftext($im, 20, $randT, 10, 30, $black, $font, $text);
imagettftext($im, 13, $randT1, 14,30, $grey, $font, $text_bg);

imagepng($im);
imagedestroy($im);

$h = fopen("sum.txt","w");
$text = "$sum";
fwrite($h,$text);
fclose($h);
 ?>
