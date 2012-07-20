<?
session_start();
header("Content-Type: text/html; charset=utf-8");

error_reporting(0);

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
if ($page!='invites') $page='clubs';
$user_id=intval($_SESSION['user_id']);

define("count",10,false);//Кол-во клубов на одной странице


//функция выводит новые клубы пользователя, когда нажата кнопка переключения страницы	
if ($_POST['action']=='setUserClubContent') {
	$content= getUserClubs($_POST['p_num']); 
	echo $content;
	die();
	}

//функция выводит новые приглашения пользователя, когда нажата кнопка переключения страницы	
if ($_POST['action']=='setUserInviteContent') {
	$content= getUserInvites($_POST['p_num']); 
	echo $content;
	die();
	}
	
//Функция, которая возвращет таблицу с клубами пользователя и их кол-во
function getUserClubs($page) { 
	include ("../includes/connection.php");
	require_once("includes/club.class.php");
	require_once("includes/club.lib.php");
	require_once("../smarty/Smarty.class.php");
	chdir("includes");
	require_once("template.lib.php");
	chdir("../");
	$user_id=intval($_SESSION['user_id']);
	$page=intval($page);
	$first=($page-1)*count;
	$query="select * from club_users where user_id='".$user_id."'  limit ".$first.",".count."";
	$result=mysql_query($query,$link);
	$club_count=0;    
	$clubs=array(); 
	while ($row=mysql_fetch_array($result)) 
	if (checkClub($row['club_id'])) {
		$club= new club($row['club_id']);
		$club-> getInfo();
		$club-> getMember($_SESSION['user_id']);
		$clubs[$club_count]= getUserClubTpl($club-> id,$club-> creater_id,$club-> creater,
											$club-> name,$club-> icon,
											$club-> getRole($_SESSION['user_id']),$club-> enterDate,
											$club-> getCountMember(),
											$club-> type,
											"index.php");
		$club_count++;
		}
	else 
		echo deleteMember($row['club_id'],$user_id);
	$tpl= new Smarty;
	$tpl-> template_dir="templates/";
	$tpl-> compile_dir="templates_c/";
	$tpl-> config_dir="configs/";
	$tpl-> cache_dir="cache/";	
	$tpl-> assign ("arr",$clubs);
	$ans=$tpl-> fetch("table.tpl");
	return $ans;
	}

//Функция, которая возвращет таблицу с клубами пользователя и их кол-во
function getUserInvites($page) { 
	include ("../includes/connection.php");
	require_once("includes/club.class.php");
	require_once("includes/club.lib.php");
	require_once("../smarty/Smarty.class.php");
	$user_id=intval($_SESSION['user_id']);
	$page=intval($page);
	$first=($page-1)*count;
	$query="select * from club_invites where user_id='".$user_id."'  limit ".$first.",".count."";
	$result=mysql_query($query,$link);
	$inv_count=0;    
	$invites=array();            
	while ($row=mysql_fetch_array($result)) 
	if (!checkMember($row['club_id'],$user_id) && checkClub($row['club_id'])) {
		$invite=new club($row['club_id']);
		$invite-> getInfo();
		$invite-> getMember($user_id);
		$invites[$inv_count]=getUserInviteTpl($invite-> name,$invite-> icon,$invite-> creater,$invite-> creater_id,$invite-> id);
		$inv_count++;
		}
	else 
		deleteInvite($row['club_id'],$user_id);
		
	$tpl= new Smarty;
	$tpl-> template_dir="templates/";
	$tpl-> compile_dir="templates_c/";
	$tpl-> config_dir="configs/";
	$tpl-> cache_dir="cache/";	
	$tpl-> assign ("arr",$invites);
	$ans=$tpl-> fetch("table.tpl");
	return $ans;
	}
//получаем клубы пользователя 
$club_content=getUserClubs(1);


//получаем количество клубов пользователя
$club_count=getUserClubCount($user_id);

//получаем кол-во страниц клубов пользователя
$club_page=floor($club_count/count)+1;
if ($club_count%count==0) $club_page--;
require_once("../includes/defence.lib.php");
//сколянем количество клубов согласно правилам русского языка	
if ($club_count==0) $club_count_name="Вы не состоите ни в одном клубе";
else  
$club_count_name="Вы состоите в ".$club_count." ".makeCountClub($club_count);


//Получаем приглашения пользователя 
$invite_content=getUserInvites(1);
//получаем количество приглашений пользователя
$invite_count=getUserInviteCount($user_id);
//получаем кол-во страниц приглашений пользователя
$invite_page=floor($invite_count/count)+1;
if ($invite_count%count==0) $invite_page--;
require_once("../includes/defence.lib.php");

//сколянем количество клубов согласно правилам русского языка	
if ($invite_count==0) $invite_count_name="У Вас нет новых приглашений";
else  
$invite_count_name="У Вас  ".$invite_count." ".makeCountInvite($invite_count);

require_once ("../smarty/Smarty.class.php");
		$tpl= new Smarty;
		$tpl-> template_dir="templates/";
		$tpl-> compile_dir="templates_c/";
		$tpl-> config_dir="configs/";
		$tpl-> cache_dir="cache/";	
$tpl-> assign("invite_count_name",$invite_count_name);
$tpl-> assign("invite_count",$invite_count);
$tpl-> assign("club_count_name",$club_count_name);
$tpl-> assign("invite_content",$invite_content);
$tpl-> assign("club_content",$club_content);
$tpl-> assign("page",$page);
require_once("../includes/page.lib.php");
if ($club_page>1) 
	$tpl-> assign("clubs_page_pattern",getPagePattern(1,$club_page,'setUserClubContent'));
if ($invite_page>1) 
	$tpl-> assign("invites_page_pattern",getPagePattern(1,$invite_page,'setUserInviteContent'));

$content=$tpl->fetch("userClubList.tpl");
$headers=$tpl-> fetch("headers.tpl");
require_once("../includes/page.php");
$html=getPage($headers,$content);
echo $html;
?>
