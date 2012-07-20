<?php



function getDay ($day_id) {
	$Days=array("Понедельник","Вторник","Среда","Четверг","Пятница","Суббота","Воскресенье");
	$day=$Days[$day_id-1];
	return $day;
	}
function getMonth ($mon_id) {
	$Months=array("января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря");
	return $Months[$mon_id-1];
	}
function getDateMonth ($mon_id) {
	$Months=array("январь","февраль","март","апрель","май","июнь","июль","август","сентябрь","октябрь","ноябрь","декабрь");
	return $Months[$mon_id-1];
	}

function makeDate ($date) {
	$Months=array("января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря");
	$year=substr($date,0,4);
	$mon=substr($date,5,2);
	$month=$Months[$mon-1];
	$day=substr($date,8,2);
	$time=substr($date,11,8);
	$true=$day." ".$month." ".$year." ".$time;
	return $true;
	}
function makeDateTime($date) {
	return makeDate(substr($date,0,10)).substr($date,10,9);
	}

?>

