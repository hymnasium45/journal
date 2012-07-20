<?
session_start();
error_reporting(0);
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
if ($_SESSION['login']!=1) {
	echo("<script>location.href='../htdocs/error.php?id=1'</script>");
	die();
	}

require_once("../includes/connection.php");
require_once("../includes/register_users.php");
require_once("../includes/error_page.php");
require_once("includes/club.class.php");
if (!isset($_SESSION['club_id'])) {
	makeError("Необходимо выбрать клуб для редактирования, пройдите по данной <a href='my_clubs.php'>ссылке</a> ");
	die();
	} 
//получаем айди клуба
$club_id=intval($_SESSION['club_id']);
$club= new club($club_id);
$club-> getInfo();
if ($_SESSION['user_id']!=$club-> creater_id) {
	makeError("Вы не являетесь создателем этого клуба.");
	die();
	}
//Подготавливаем шаблоны
require_once ("../smarty/Smarty.class.php");
$tpl= new Smarty;
$tpl-> template_dir="templates/";
$tpl-> compile_dir="templates_c/";
$tpl-> config_dir="configs/";
$tpl-> cache_dir="cache/";	

$tpl-> assign("club_id",$club-> id);
$tpl-> assign("name",$club-> name);
$tpl-> assign("avatar",$club-> avatar);
$tpl-> assign("info",$club-> about);

$tpl-> assign("canView",$club-> canView);
$tpl-> assign("canWrite",$club-> canWrite);
$tpl-> assign("canEnter",$club-> canEnter);

//Передаём всё в шаблон общей страницы
$content=$tpl-> fetch("editClub.tpl");
$headers=$tpl-> fetch("headers.tpl");
require_once("../includes/page.php");
$html=getPage($headers,$content);
echo $html;
?>
