<?php
require_once "../includes/db_connect.lib.php";
 collation();
require_once("../includes/register_users.php");

$Months=array("января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря");
$Days=array("Понедельник","Вторник","Среда","Четверг","Пятница","Суббота","Воскресенье");
function getDay ($day_id) {
	echo "qq";
//	return $Days[$day_id];
	}
echo $Days['4'];
?>

