<?php 

session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");


if ($_SESSION['login']!=1)  echo("<script>location.href='error.php?id=1'</script>");

$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);
include "../includes/db_connect.lib.php";
 collation();
require_once("../includes/register_users.php");

$teacher_id=intval($_SESSION['user_id']);
require_once("../includes/error_page.php");
require_once("../user/includes/user.lib.php");

if (!isClassTeacher($teacher_id)) {
	makeError("Редактировать классы могут только учителя. Для получения доступа обратитесь к администрации школы.");
	die();
	}
if (!isset($_SESSION['class'])) {
	makeError("Необходимо выбрать класс для редактирования, пройдите по данной <a href='class.php'>ссылке</a> ");
	die();
	} 


if (isset($_POST['argc']) && isset($_POST['ajax'])) {
	
	echo search($_POST['argc'],$_POST['showPupils']);
	die();
	}
if (isset($_POST['user_id']) && $_POST['add']=='true') {
	echo addPupil($_POST['user_id'],$_SESSION['class'],$showPupils);
	die();
	}
function addPupil($id,$class) {
	$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
        mysql_select_db($_SESSION['dbname'],$link);
        require_once "../includes/db_connect.lib.php";
        collation();
	$query="insert into `class_users` values('".$class."','".$id."')";
	$result=mysql_query($query,$link);
	if ($result) echo "<font style='color:green; font-style:oblique;'>Ученик успешно добавлен</font>";
	else echo "</font>Ошибка. Не удалось добавить ученика</font>";
	die();
	}
function search($argc,$showPupils) {
	require_once("../includes/defence.lib.php");
	$argc=makeText($argc);
	$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
	mysql_select_db($_SESSION['dbname'],$link);
	require_once "../includes/db_connect.lib.php";
 	collation();
	$query="select * from `users` where (`Name` like '%".$argc."%' or `Email` like '%".$argc."%') 
				and `access` like '1%'";
	$user_result= mysql_query($query,$link);
	$html="<table align='center'> ";
	$count=0;
	while ($row=mysql_fetch_array($user_result)) {
		$name="<a href='profile.php?id=".$row['user_id']."'>".$row['Name']."</a>";
		$id=$row['user_id'];
		if (file_exists("../avatars/".$row['avatar']) && $row['avatar']!='') {
                	require_once("../includes/images.lib.php");
                	$size=makePost("../avatars/".$row['avatar']);
			$img="<img src='../avatars/".$row['avatar']."' width='".$size[0]."' height='".$size[1]."'>";
                	}
        	else
                	$img="<img src='../avatars/noavatar.gif' width=80px height=120px'";
		$query="select * from `class_users` where `user_id`='".$row['user_id']."'";
		$result=mysql_query($query,$link);
		$num=mysql_num_rows($result);
		if ($num>0) {
			$row=mysql_fetch_array($result);
			$query="select * from `classes` where `class_id`='".$row['class_id']."'";
			$result=mysql_query($query,$link);
			$row=mysql_fetch_array($result);
			require_once("../includes/class.php");
			$class=getClass(-1,$row['year'],$row['letter']);
			$state="<a href='class_page.php?id=".$row['class_id']."'>".$class."</a>";
			$inClass=true;
			}
		else {
			$state='Нет';
			$inClass=false;
			}
		if ($num==0 || $showPupils=='true') {
			$count++;
			$html.="<tr><td><table id='tab_table'>
					<tr> <td height=140px width=80px valign='top' rowspan=2>".$img."</td>";
			$html.="<td height=30px>".$name."</td>";	
			$html.="<td rowspan=2 id='".$id."'>";
			if (!$inClass) 
				$html.=" <button type='button' class='choose' NAME='".$select."' title='Добавить в класс'
				onclick=\"addPupil(".$id.");\">";
			$html.="</td>";

			$html.="</tr><tr><td valign='top'>Сост. в классе: ".$state."</td></tr></table></td></tr>";
		}
		}
	if ($count==0) {
		$html.="<tr> <td class='error'> Поиск не дал результатов </td> </tr>";
		}
	$html.="</table>";
	return $html;
	}
?>
<HTML>
<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
<link rel='stylesheet' href='../css/comments.css' type='text/css' media='screen' />  
<link rel='stylesheet' href='../css/tab.css' type='text/css' media='screen' />
<script type='text/javascript' src='../includes/jquery-1.3.2.min.js'></script>

<script type='text/javascript' src='../includes/ajax.js'></script>
<script language=JavaScript>
function addPupil(id) {
	 Handler= function(Request) {
                document.getElementById(id).innerHTML=Request.responseText;
                }
         str='user_id='+id+'&add=true';
         SendRequest('post','class_edit_add.php',str,Handler);

	}
function Search() {
        Handler= function(Request) {
                document.getElementById('result').innerHTML=Request.responseText;
                }
	 if (document.getElementById('showClassPupils').checked) 
                showPupils='false';
         else 
                showPupils='true';
 	 argc=document.getElementById('argc').value;
	 if (argc=='') document.getElementById('error').innerHTML='Введите значение';
	 else  {
		document.getElementById('error').innerHTML='';
         	str='argc='+document.getElementById('argc').value+'&showPupils='+showPupils+'&ajax=true';
	 	SendRequest('post','class_edit_add.php',str,Handler);
        	}
	}
$(document).ready(function() {  

$('#argc').focus( function() {
	$(this).keydown(function(event) { if (event.keyCode ==13) Search();}); 
	});
});

</script>
</HEAD>
<BODY>
<div id='logo'>
 <?require_once("../includes/logo.php");
?>

</div>
<div id='main'><?
?>
 <div id='leftbar'>
  <?require_once "../includes/menu.php";?>
 </div>
 <div id='content'>
<div class='form_settings'>
 <table align='center' id='tab_content'>
 <tr>
  <td> <a href='class_edit.php'><- Обратно</a></td>
 </tr>
 <tr> <td id='tab_header' colspan=2 > Поиск учеников: </td> </tr>
 <tr>
 <td>
 <table>
 <tr> <td colspan=2 height='40px' > <input type='checkbox' class='checkbox' name='showClassPupils' id='showClassPupils'> 
	Не отображать учеников, состоящих в классах </td> </tr>
 <tr> 
   <td width=300px> Введите значение: <br> 
	<font style='font-size:small; color:gray; font-style:oblique;'>(Имя, эл. адрес)</font> </td> 
   <td> <input type='text' class='text' style='width:500px' id='argc' name='argc'> </td>
 </tr>
 <tr>
  <td> </td> <td id='error' height=20px class='error'> </td>
 </tr>
 <tr> <td colspan=2 align='right'> 
	<input type='button' class='submit' name='search' value='Поиск' onclick="Search()"></td></tr>
 </table>
 </td>
 </tr>
 <tr>
  <td colspan=2 id='tab_header'> Результаты поиска: </td> 
 </tr>
 <tr >
  <td colspan=2 id='result' ></td>
 </tr>
 </div>
 </div>
</div>
</body>
</html>
