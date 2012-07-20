<?
session_start();
error_reporting(0);
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");

if ($_SESSION['login']!=1) {
    echo("<script>location.href='../htdocs/error.php?id=1'</script>");
	die();
	}
include ("../includes/connection.php");
require_once("includes/club.class.php");
require_once("includes/club.lib.php");
require_once("../includes/register_users.php");
require_once("../includes/defence.lib.php");
$page=makeText($_GET['page']);
$user_id=intval($_SESSION['user_id']);

define("count",10,false);//Кол-во клубов на одной странице


//функция выводит новые клубы пользователя, когда нажата кнопка переключения страницы	
if ($_POST['action']=='setClubContent') {
	$content= getAllClubs($_POST['p_num']); 
	echo $content;
	die();
	}

//Функция, которая возвращет таблицу с клубами и их кол-во
function getAllClubs($page) { 
	include ("../includes/connection.php");
	require_once("includes/club.class.php");
	require_once("includes/club.lib.php");
	require_once("includes/template.lib.php");
	require_once("../smarty/Smarty.class.php");
	$user_id=intval($_SESSION['user_id']);
	$page=intval($page);
	$first=($page-1)*count;
	$query="select * from club order by `name` limit ".$first.",".count."";
	$result=mysql_query($query,$link);
	$club_count=0;    
	$clubs=array(); 
	while ($row=mysql_fetch_array($result)) { 
		$club= new club($row['club_id']);
		$club-> getInfo();
		$club-> getMember($_SESSION['user_id']);
		$clubs[$club_count]= getUserClubTpl($club-> id,$club-> creater_id,$club-> creater,
											$club-> name,$club-> icon,
											$club-> getRole($_SESSION['user_id']),$club-> enterDate,
											$club-> getCountMember(),
											$club-> type,
											"all_clubs.php");
		$club_count++;
		}
	$tpl= new Smarty;
	$tpl-> template_dir="templates/";
	$tpl-> compile_dir="templates_c/";
	$tpl-> config_dir="configs/";
	$tpl-> cache_dir="cache/";	
	$tpl-> assign ("arr",$clubs);
	$ans=$tpl-> fetch("table.tpl");
	return $ans;
	}

//получаем клубы  
$club_content=getAllClubs(1);

$query="select * from club";
$result=mysql_query($query,$link);
$club_count=mysql_num_rows($result);

//получаем кол-во страниц клубов пользователя
$club_page=floor($club_count/count)+1;
if ($club_count%count==0) $club_page--;
require_once("../includes/defence.lib.php");
//сколянем количество клубов согласно правилам русского языка	
if ($club_count==0) $club_count_name="Не зарегистрировано ни одного клуба";
else  
$club_count_name="Зарегистрировано ".$club_count." ".makeCountClub2($club_count);

require_once ("../smarty/Smarty.class.php");
		$tpl= new Smarty;
		$tpl-> template_dir="templates/";
		$tpl-> compile_dir="templates_c/";
		$tpl-> config_dir="configs/";
		$tpl-> cache_dir="cache/";	
$tpl-> assign("club_content",$club_content);
$tpl-> assign("page",$page);
$tpl-> assign("club_count_name",$club_count_name);
require_once("../includes/page.lib.php");
if ($club_page>1) 
	$tpl-> assign("clubs_page_pattern",getPagePattern(1,$club_page,'setClubContent'));

$content=$tpl->fetch("clubList.tpl");
$headers=$tpl-> fetch("headers.tpl");
require_once("../includes/page.php");
$html=getPage($headers,$content);
echo $html;
?>
