<?php 

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
require_once("includes/club.lib.php");
require_once("includes/club.class.php");
$club_id=intval($_SESSION['club_id']);
//Подготавливаем шаблоны
require_once ("../smarty/Smarty.class.php");
$tpl= new Smarty;
$tpl-> template_dir="templates/";
$tpl-> compile_dir="templates_c/";
$tpl-> config_dir="configs/";
$tpl-> cache_dir="cache/";	
$tpl-> assign("club_id",$club_id);


if ($_POST['action']=='searchUser') {
	require_once("includes/club.lib.php");
	$tpl-> assign("arr",searchClubUser($club_id,$_POST['argc'],$_POST['showMembers']));
	echo $tpl-> fetch("table.tpl");
	die();
	}


$content=$tpl-> fetch("clubInvite.tpl");
$headers=$tpl-> fetch("headers.tpl");
require_once("../includes/page.php");
$html=getPage($headers,$content);
echo $html;
?>
