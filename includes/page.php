<?
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");

if (isset($_POST['exit'])) {
	session_destroy();
	echo("<script>location.href='../../index.php'</script>");	}

if ($_SESSION['login']!=1) die();


function getSidebar() {
	include ("../includes/connection.php");
	$path='/journal/htdocs/';
	$user_id=intval($_SESSION['user_id']);
	require_once("../user/includes/user.lib.php");
	require_once("../club/includes/club.lib.php");
	$count=getUserInviteCount($_SESSION['user_id']);
	$html ="	
     <div id='sidebar'>
     <div class='box'>	 
	  <ul>
	   <li> <a href='../blog/news_list.php'>Главная</a></li>
	   <li> <a href='../htdocs/profile.php?id=".$user_id."'>Профиль</a> </li>";
	$html.=" <li> <a href='../club/'> Клубы";
	if ($count>0) $html.="(".$count.")";  
	$html.="</a> </li>";


if (isPupil($user_id))
	$html.="<li> <a href='../htdocs/diary1.php?time=".$time."'> Дневник </a> </li>";
if (isRaporter($user_id))
	$html.=" <li> <a href='../htdocs/raport.php'> Рапортичка </a> </li>";
if (isClassTeacher($user_id))
	$html.= " <li> <a href='../htdocs/class.php'> Классы </a> </li>";
if (isTeacher($user_id)) {
	$html.=" <li> <a href='../htdocs/greet.php'> Журналы </a> </li>";
	if ($_SERVER['REQUEST_URI']==$path.'table_del.php' || 
	    $_SERVER['REQUEST_URI']==$path.'greet.php' ||
	    $_SERVER['REQUEST_URI']==$path.'table_create.php'||
	    $_SERVER['REQUEST_URI']==$path.'old_journals.php' ) 
	$html.= "<ul> 
	       <li> <a href='../htdocs/table_create.php'> Создать  </a> </li>
	       <li> <a href='../htdocs/greet.php'> Текущие </a> </li>
           <li> <a href='../htdocs/old_journals.php'> Старые </a> </li>
	      </ul>";
	if (($_SERVER['REQUEST_URI']==$path.'table.php' ||
	    $_SERVER['REQUEST_URI']==$path.'table.php?style=table' ||
	    $_SERVER['REQUEST_URI']==$path.'table.php?style=task') 
	    && isGroupTeacher($_SESSION['user_id'],$_SESSION['table']))
	$html.= "
		<ul>
		 <li> <a href='../htdocs/task_edit.php'> Редактировать </a></li>
		</ul>"; 
	$html.= "<li> <a href='../htdocs/schedule.php'> Расписание</a> </li>";
	}
$html.= "</ul></div></div>";
return $html;
}
function getPage($headers,$content) {
	require_once("../smarty/Smarty.class.php");
	$tpl= new Smarty;
	$tpl-> template_dir="../templates/";
	$tpl-> compile_dir="../templates_c/";
	$tpl-> config_dir="../configs/";
	$tpl-> cache_dir="../cache/";
	
	$p=$_SERVER['REQUEST_URI'];
	$index=preg_match("|/index.php|",$p)&!preg_match("|club/index.php|",$p);
	$index1=preg_match("|^/$|",$p);
	$index3=preg_match("|^/?|",$p);
	$registr=preg_match("|^/journal/htdocs/registration.php|",$p);
	$pass=preg_match("|^/journal/htdocs/forgot_pass.php|",$p);
	$error=preg_match("|^/journal/htdocs/error.php|",$p);
	if (!$index && !$index1  && !$error && !$pass && !$registr) 
		$tpl-> assign("exit","show");
	$tpl-> assign("headers",$headers);
	$tpl-> assign("content",$content);
	$tpl-> assign("leftbar",getSidebar());
	return $tpl-> fetch("page.tpl");
	}

?>




