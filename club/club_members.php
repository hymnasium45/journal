<?

session_start();
error_reporting(0);
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
if ($_SESSION['login']!=1) echo("<script>location.href='../htdocs/error.php?id=1'</script>");

if (!isset($_SESSION['club_id'])) {
	require_once("../includes/error_page.php");
	makeError("Не выбран клуб для редактирования. Вы можете редактировать 
			только тот клуб, в котором являетесь администратором");
	die();
	}


require_once("../includes/connection.php");
require_once("../includes/register_users.php");
require_once("includes/club.lib.php");
require_once("includes/club.class.php");
require_once("../user/includes/user.class.php");

function getClubUsers() {
	include("../includes/connection.php");
	require_once("includes/club.class.php");	
	require_once("../user/includes/user.class.php");
	$club_id=intval($_SESSION['club_id']);
	
	//Подготавливаем шаблоны
	require_once ("../smarty/Smarty.class.php");
	$tpl= new Smarty;
	$tpl-> template_dir="templates/";
	$tpl-> compile_dir="templates_c/";
	$tpl-> config_dir="configs/";
	$tpl-> cache_dir="cache/";	
	$query="select * from users join club_users 
		where users.user_id = club_users.user_id and club_users.club_id='".$club_id."' 
		order by users.Name limit 0, 30";
	$result=mysql_query($query,$link);
	$members=array();
	$count=0;
	$uClub=new userClub;
	$club=new club($_SESSION['club_id']);
	$club-> getInfo();
	$uClub-> getClub($club_id);
	while ($row=mysql_fetch_array($result)) {
		$uClub-> getUserClub($row['user_id']);
		$role=$club-> getRole($row['user_id']);
		$user=new user($row['user_id']);
		$user-> getUser();
		$tpl-> assign("isCreater",$club-> isCreater($row['user_id']));
		$tpl-> assign("name",$user-> name);
		$tpl-> assign("avatar",$user-> icon);
		$tpl-> assign("date",$uClub-> enterDate);
		$tpl-> assign("user_id",$user-> id);
		$tpl-> assign("role",$role);
		$tpl-> assign("canWrite",$club-> canWrite());
		$tpl-> assign("canEdit",$club-> canEdit());
		$tpl-> assign("viewer_id",$_SESSION['user_id']);
		$members[$count]=$tpl-> fetch("clubUser.tpl");
		$count++;
		}
	return $members;
	}
function getClubApplies() {
	include("../includes/connection.php");
	require_once("../user/includes/user.class.php");
	$club_id=intval($_SESSION['club_id']);
	
	//Подготавливаем шаблоны
	require_once ("../smarty/Smarty.class.php");
	$tpl= new Smarty;
	$tpl-> template_dir="templates/";
	$tpl-> compile_dir="templates_c/";
	$tpl-> config_dir="configs/";
	$tpl-> cache_dir="cache/";	
	$query="select * from users join club_applies 
		where users.user_id = club_applies.user_id and club_applies.club_id='".$club_id."'
		order by users.Name limit 0, 30";
	$result=mysql_query($query,$link);
	if (!$result) echo "error";
	$count=0;
	$applies=array();
	while  ($row=mysql_fetch_array($result)) {
		$user=new user($row['user_id']);
		$user-> getUser();
		$tpl-> assign("user_id",$user-> id);
		$tpl-> assign("avatar",$user-> icon);
		$tpl-> assign("name",$user-> name);
		$tpl-> assign("club_id",$club_id);
		$applies[$count]=$tpl-> fetch("apply.tpl");
		$count++;
		}
	return $applies;
	}
//получаем айди клуба
$club_id=intval($_SESSION['club_id']);
//
$club= new club($club_id);
$club-> getInfo();
$count_user=$club->getCountMember();
$count_apply=$club-> getCountApply();
$members=getClubUsers();
$applies=getClubApplies();
//Подготавливаем шаблоны
require_once ("../smarty/Smarty.class.php");
$tpl= new Smarty;
$tpl-> template_dir="templates/";
$tpl-> compile_dir="templates_c/";
$tpl-> config_dir="configs/";
$tpl-> cache_dir="cache/";	

$tpl-> assign("arr",$members);
$users=$tpl-> fetch("table.tpl");
$tpl-> assign("count_users",$count_user); 
$tpl-> assign("users",$users); 

$tpl-> assign("arr",$applies);
$applies_tpl=$tpl-> fetch("table.tpl");
$tpl-> assign("count_apply",$count_apply); 
$tpl-> assign("applies",$applies_tpl); 

$tpl-> assign("name",$club-> name);
$tpl-> assign("club_id",$club-> id);

$content=$tpl-> fetch("clubUsers.tpl");
$headers=$tpl-> fetch("headers.tpl");
require_once("../includes/page.php");
$html=getPage($headers,$content);


echo $html;
?>
