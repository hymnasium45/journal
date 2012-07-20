<?php
/**определяет является ли файл картинкой
*$type- тип файла, который надо проверить
*/
function isimage($type) {
	$type=strtolower($type);
	if ($type=='bmp' || 
		$type=='jpg' || 
		$type=='gif' || 
		$type=='tif' ||
		$type=='png') return true;
	else return false;
	}
?>
