<?php
//Функция, которая преобразует картинку в приемлемый вид
//$size= makeImage("/var/www/valentine9.jpg",90,60);
//echo $size[0].' '.$size[1];
function makeImage($file/*Имя файла */,$h/*Необходимая высота*/,$w/*Необходимая ширина*/) {
	$size=getimagesize($file);
	$th= $size[1];
	$tw= $size[0];
	$true=array();
	if ($th <= $h && $tw<=$w) {
		$true[1]=floor($h);
		$true[0]=floor($w);
		return $true;
		die();	
		}
	if ($th /$h  > $tw / $w) {
		$true[1]= $h;
		$true[0]= floor($tw*$h/$th);
		return $true;
		die();
		}
	if ($th / $h <=  $tw/ $w) {
                $true[1]= floor($th*$w/$tw);
                $true[0]= $w;
                return $true;
                die();
                }

	}
function makeAvatar($file) {
	return makeImage($file,300,200);
	}

function makePost($file) {
	return makeImage($file,120,80);
	}
function resizeImage($file,$newfile,$h,$w) {
	$query="convert -scale '".$w."x".$h."' ".$file." ".$newfile;
	shell_exec($query);
	}
?>
