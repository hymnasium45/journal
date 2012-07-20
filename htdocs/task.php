<?
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  


</HEAD>
<BODY>
<?php

if ($_SESSION['login']==1){
//коннектимся к базе данных
$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);
 include "../includes/db_connect.lib.php";
 collation();
require_once("../includes/register_users.php");
echo "
  <div id='logo'> 
";require_once("../includes/logo.php");

echo" 
</div> 
<div id='main'>";

echo"
<div id='leftbar'>"
;
require_once "../includes/menu.php";
echo "
        </div>
        <div id='content'>
        ";
// получаем айди группы
$query_group="select * from groups where teacher_id='".$_SESSION['user_id']."'";
$result_group=mysql_query($query_group,$link);
$row_group= mysql_fetch_array($result_group);
	//получаем имя учителя
	$query_teacher="select * from users where user_id='".$_SESSION['user_id']."'";
	$result_teacher=mysql_query($query_teacher,$link);
	$row_teacher= mysql_fetch_array($result_teacher);
echo "
        <TABLE align=center> 
        <TD> <a href='table-edit.php'> Выставить оценки </a> </TD> 
        <TD> <a href='schedule.php'> Расписание </a> </TD>
        </TABLE>";

echo "
        <TABLE align='center'>
        <FORM method='POST'>
        <TABLE align=center>
        <TD align ='left' height=100> Страница ". $_SESSION['page'] ." 
        <INPUT type='submit' value='<' name='last'>  <INPUT type='submit' value='>' name='next'> </TD>
        <TD align=right> Номер страницы: 
        <INPUT type = 'text' name = 'page' size=4>  <INPUT type='submit' name='goto' value='перейти'> </TD>
        </FORM>
        <TR> <TD> 
             <TABLE> 
    <TR> <TH align='center' height=20 width=180 > <a href='table.php'> <FONT color='black'> Таблица оценок </a> </FONT></TH>              <TH bgcolor='black'> <FONT color='white'> План урока </FONT> </TH> 
              </TR> </TABLE>
        </TD> </TR>";

echo "  
	<TABLE align='center'>
        <TR> <TH width=600 align=left> Учитель: ".$row_teacher['Name']."</TH> 
	<TABLE align ='center' border=1 frame=box rules = all>
	<TH height=100 align='center'> № </TH> <TD height=100> Дата </TD> 
        <TH height=100> Содержание урока </TH> 
	<TH height=100> Задание домой </TH> "; 

$query_data="select * from Dates where (page='".$_SESSION['page']."' and group_id='".$row_group['group_id']."')";
$result_data=mysql_query($query_data,$link);

for ($i=1; $i<=16; $i++) {
	//получаем дату
	$row_data=mysql_fetch_array($result_data);
	//получаем задание и план урока
	$query_lesson="select * from lesson where 
	(group_id='".$row_group['group_id']."' and date_id='".$row_data['date_id']."')";
	$result_lesson=mysql_query($query_lesson,$link);
	$row_lesson=mysql_fetch_array($result_lesson);
	echo "
		<TR>
		<TD width=50 height=50 align='center'> $i </TD> 
        	<TD width=50 height=50 align='center'>".$row_data['Day']."/".$row_data['month']."</TD> 
        	<TD width=300 height=50> ".$row_lesson['plan']." </TD> 
        	<TD width=300 height=50> ".$row_lesson['task']." </TD> 
		</TR>";

	}
echo "
	</TABLE>";
//проверим нажаты ли клавишы
if (isset($_POST['next']) && $_SESSION['page'] < 99) {
        $_SESSION['page']++;
        echo("<script>location.href='task.php'</script>");
        }

if (isset($_POST['last']) && $_SESSION['page'] > 1) {
        $_SESSION['page']--;
        echo("<script>location.href='task.php'</script>");
        }

if (isset($_POST['goto']) && $_POST['page'] >0 && $_POST['page']<100) {
        $_SESSION['page']=$_POST['page'];
        echo("<script>location.href='task.php'</script>");
        }

}
else 
        echo("<script>location.href='error.php?id=1'</script>");

?>
</div>
</div>
</BODY>
</HTML>
