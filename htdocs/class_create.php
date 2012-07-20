<?
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
if ($_SESSION['login']!=1) echo("<script>location.href='error.php?id=1'</script>");
$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);
include "../includes/db_connect.lib.php";
 collation();
 require_once("../includes/access.lib.php");

require_once("../user/includes/user.lib.php");
$user_id=$_SESSION['user_id'];
if (!isTeacher($user_id)) {
	require_once("../includes/error_page.php");
	makeError("Создавать классы могут только учителя. Для получения доступа обратитесь к администрации школы.");
	die();
	}

require_once("../includes/defence.lib.php");
if (isset($_POST['letter']) && isset($_POST['year'])) {
        if ($_POST['letter']=='') {echo "Введите букву класса"; die();}
        if ($_POST['year']=='none') {echo "Выберите год выпуска"; die();}
        require_once("../includes/defence.lib.php");
        $letter=strtoupper(makeText($_POST['letter']));
        $year=intval($_POST['year']);
        $query="select * from `classes` where `year`='".$year."' and `letter`='".$letter."'";
	$result=mysql_query($query,$link);
	if (!$result) {echo "не удаётся подключится к базе данных, попробуйте позже."; die();}
	$num=mysql_num_rows($result);
        if ($num>0) {
		$row=mysql_fetch_array($result);
		$query="select * from `users` where `user_id`='".$row['teacher_id']."'";
		$result=mysql_query($query,$link);
		$row=mysql_fetch_array($result);
		echo "Такой класс уже создан, <BR> классный руководитель: ".$row['Name'];
		die();
		}
	else {
		$code=substr(md5(time().rand()),0,6);
		$count=intval($_POST['count']);
		if ($count<0) $count=0;
		$query="insert into `classes` (`year`,`letter`,`teacher_id`,`invites`,`code`) values
			('".$year."','".$letter."','".$_SESSION['user_id']."','".$count."','".$code."')";
		$result=mysql_query($query,$link);
		if (!$result) { echo "Ошибка. Не удалось создать класс"; die();}
		$query="select * from `users` where `user_id`='".$row['teacher_id']."'";
                $result=mysql_query($query,$link);
                $row=mysql_fetch_array($result);
		require_once("../includes/access.lib.php");
		if (!makeHead($_SESSION['user_id'])) {
			echo "Ошибка. Не удалось сделать Вас классным руководителем. Доступ остался прежним";
			die();
			}
		$query="select `class_id` from `classes` where  `teacher_id`='".$_SESSION['user_id']."' and
			year='".$_POST['year']."' and letter='".$letter."'";
		$result=mysql_query($query,$link);
		$row=mysql_fetch_array($result);
		$_SESSION['class']=$row['class_id'];
		die();
		}
        die();
   }

require_once("../includes/register_users.php");
$time=getdate();
$year=$time['year'];
		
?>
<HTML>
<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
<script type='text/javascript' src='../includes/ajax.js'></script>
<link rel='stylesheet' href='../css/tab.css' type='text/css' media='screen' />

<script language=JavaScript>
function Create() {
	Handler= function(Request) {
		answer=Request.responseText;
		if (answer.length==1) 
			document.location.replace("class_edit.php");
			
		else 
        		document.getElementById('error').innerHTML=Request.responseText;
		}
	str='letter='+document.getElementById('letter').value+'&year='+document.getElementById('year').value+
	'&count='+document.getElementById('count').value;
	 
	 SendRequest('post','class_create.php',str,Handler);
	}
</script>
</HEAD>
<BODY>
<div id='logo'>
 <?require_once("../includes/logo.php");
?>

</div>
<div id='main'>
 <div id='leftbar'>
  <?require_once "../includes/menu.php";?>
 </div>
 <div id='content'>
<form class='form_settings' method='post'>
<table style="margin:100px auto;">
<tr> 
 <th colspan=2 align='left'> Создание класса: </th>
</tr>
<tr> 
 <td height=30px width=200px >Год выпуска: </td> 
 <td> <select name='year' id='year'>
      <option value='none'> Не выбран </option>
      <?for ($i=$year; $i<=$year+13; $i++)
		echo "<option value='".$i."'>".$i."</option>";
      ?>  
	</select>
 </td>
</tr>
<tr>
 <td height=30px>Буква класса:</td>
 <td> <input type='text' class='text' style='width:120px' maxlength='4' name='letter' id='letter'> </td>
</tr>
<tr> 
 <td height=30px colspan=2 class='error' align='right' id='error'> </td>
</tr>
<tr>
 <td> Кол-во приглашений:</td>
 <td><input type='text' class='text' style="width:120px" maxlength='2' name='count' id='count' value=30></td>
</tr>
<tr>
<td colspan=2 align='right' height=50px valign=bottom> <input type='button' id='save' name='save' class='submit' value='Создать'
				onclick="Create();"> </td>
</tr>
</table>

</form>
</div>
</div>
</body>
<html>
