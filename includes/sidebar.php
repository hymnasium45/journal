<?
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
if ($_SESSION['login']!=1) die();


function getSidebar() {
	include ("connection.php");
	$path='/journal/htdocs/';
	$user_id=intval($_SESSION['user_id']);
	require_once("user.lib.php");
	$html ="	
     <div id='sidebar'>
     <div class='box'>	 
	  <ul>
	   <li> <a href='news_list.php'>Главная</a></li>
	   <li> <a href='profile.php?id=".$user_id."'>Профиль</a> </li>";
	$html.=" <li> <a href='../club/index.php'> Клубы  </a> </li>";


if (isPupil($user_id) && $class_id>0)
	$html.="<li> <a href='diary1.php?time=".$time."'> Дневник </a> </li>";
if (isRaporter($user_id))
	$html.=" <li> <a href='raport.php'> Рапортичка </a> </li>";
if (isClassTeacher($user_id))
	$html.= " <li> <a href='class.php'> Классы </a> </li>";
if (isTeacher($user_id)) {
	$html.=" <li> <a href='greet.php'> Журналы </a> </li>";
	if ($_SERVER['REQUEST_URI']==$path.'table_del.php' || 
	    $_SERVER['REQUEST_URI']==$path.'greet.php' ||
	    $_SERVER['REQUEST_URI']==$path.'table_create.php'||
	    $_SERVER['REQUEST_URI']==$path.'old_journals.php' ) 
	$html.= "<ul> 
	       <li> <a href='table_create.php'> Создать  </a> </li>
	       <li> <a href='greet.php'> Текущие </a> </li>
           <li> <a href='old_journals.php'> Старые </a> </li>
	      </ul>";
	if (($_SERVER['REQUEST_URI']==$path.'table.php' ||
	    $_SERVER['REQUEST_URI']==$path.'table.php?style=table' ||
	    $_SERVER['REQUEST_URI']==$path.'table.php?style=task') 
	    && isGroupTeacher($_SESSION['user_id'],$_SESSION['table']))
	$html.= "
		<ul>
		 <li> <a href='task_edit.php'> Редактировать </a></li>
		</ul>"; 
	$html.= "<li> <a href='schedule.php'> Расписание</a> </li>";
	}
$html.= "</ul></div></div>";
return $html;
}
?>




