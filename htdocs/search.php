<?
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
if ($_SESSION['login'] == 1) {
class klass {
	public $year;
	public $name;
	public $id;
	}
	$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
	mysql_select_db($_SESSION['dbname'],$link);
	include "../includes/db_connect.lib.php";
	collation();
require_once("../includes/register_users.php");

$query_class="select * from classes";
$result_class=mysql_query($query_class,$link);
require_once("../includes/class.php");
$classes=array();
$count_class=0;
while ($row_class=mysql_fetch_array($result_class)) {
	$count_class++;
	$classes[$count_class]= new Klass;
	$classes[$count_class]-> id=$row_class['class_id'];
	$classes[$count_class]-> year=$row_class['year'];
	$classes[$count_class]-> name=getclass(-1,$row_class['year'],$row_class['letter']);
	}
require_once("../includes/sort.php");
mysort_number('klass','year','max',$classes,$count_class);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
</HEAD>
<BODY>
<FORM method='POST'>
<div class='form_settings'>
<TABLE align='center'>
 <TR> 
  <TH colspan=2> Поиск пользователя: </TH>
 </TR> 
 <TR>
  <TD> Фамилия: </TD>
  <TD> <INPUT  NAME='surname' PLACEHOLDER='не указано'> </TD>
 </TR>
 <TR>
  <TD> Имя: </TD>
  <TD> <INPUT  NAME='name' PLACEHOLDER='не указано'> </TD>
 </TR>
 <TR>
  <TD> Инд. номер: </TD>
  <TD> <INPUT  NAME='id' PLACEHOLDER='не указано'> </TD>
 </TR>
 <TR>
  <TD> Дата рождения: </TD>
  <TD> <SELECT class='select' NAME='day'> 
 <? for($i=1; $i<=31; $i++) 
	echo "<OPTION VALUE='".$i."'>".$i."</OPTION>";?>
 </SELECT> 
	<SELECT class='select' NAME='month'>
 <? for ($i=1; $i<=12; $i++)
	echo "<OPTION VALUE='".$i."'>".$i."</OPTION>";?>
  </SELECT>
 	<SELECT class='select' NAME='year'>
 <? for ($i=1900; $i<=2012; $i++)
	echo "<OPTION VALUE='".$i."'>".$i."</OPTION>";?>
   </SELECT>
  </TD>
 </TR>
 <TR>
  <TD> Класс: </TD>
  <TD> <SELECT class='select' NAME='class'>
 <? for ($i=1; $i<=$count_class; $i++)
	echo "<OPTION VALUE='".$classes[$i]-> id."'>".$classes[$i]-> name."</OPTION>";?>
   </SELECT>
   </TD>
  </TR>
  <TR>
   <TD> Категория: </TD>
  </TR>


</TABLE>
</div>
</FORM>

</div>
</div>
</BODY>
</HTML>

<?
}
else
        echo("<script>location.href='error.php?id=1'</script>");
?>
