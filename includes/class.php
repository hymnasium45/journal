<?php
/**по году выпуска класса определяет его номер
*если $date=-1, то определяется текущая дата
*/
function getclass($date,$class_year,$class_letter) {
	if ($date==-1) $date=date("d.m.Y");
	$day=substr($date,0,2);
	$month=substr($date,3,2);
	$year=substr($date,6,4);
	if ($month>7 || ($month==7 && $day>=15))  $year++;
	$class=11-$class_year+$year;
	if ($class>11) return 'Выпускники '.$class_year.'-'.$class_letter;
	if ($class<=11 && $class>0) return $class.'-'.$class_letter;
	if ($class<=0) return "false";
	}
function isclass($date,$class_year) {
        if ($date==-1) $date=date("d.m.Y");
        $day=substr($date,0,2);
        $month=substr($date,3,2);
        $year=substr($date,6,4);
        if ($month>7 || ($month==7 && $day>=15))  $year++;
        $class=11-$class_year+$year;
        if ($class<=11 && $class>=0) return true;
		else return false;
        }
?>
