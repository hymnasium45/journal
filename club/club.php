<?
session_start();
error_reporting(0);
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");

if ($_SESSION['login']!=1) {
        echo("<script>location.href='../htdocs/error.php?id=1'</script>");
		die();
		}

require_once("../includes/register_users.php");
require_once("../includes/connection.php");
require_once("includes/club.lib.php");
require_once("includes/club.class.php");
require_once("includes/chat.lib.php");
require_once("includes/chat.class.php");
require_once("../includes/defence.lib.php");

// получаем адйи клуба
$club_id=intval($_GET['club_id']);
$user_id=intval($_SESSION['user_id']);
$page=makeText($_GET['page']);
if ($page!='info') $page='chat';

//Обрабатываем загрузку фотографии
if (isset($_POST['upload'])) {	
	$uploaddir='avatars/';
    $oldname=$_FILES['userfile']['name'];
    $pos=strpos($oldname,'.');
    $type=strtolower(substr($oldname,$pos+1));
 	$name='temp'.$club_id.'.'.$type;
	require_once("../includes/file_type.php");
	if (isimage($type)) {
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir.$name)) {
			require_once("../includes/images.lib.php");
			$temp=$uploaddir.$name;
			$size=makeAvatar($temp);
			$avatar=$uploaddir."avatar".$club_id.".png";
			resizeImage($temp,$avatar,$size[1],$size[0]);
			$icon=$uploaddir."icon".$club_id.".png";
			$size=makePost($temp);
			resizeImage($temp,$icon,$size[1],$size[0]);//asd
			unlink($temp);
			echo ("<script>location.href='club.php?club_id=".$club_id."'</script>");
            }
		else {
			$error=6;//"не удалось загрузить файл, попробуйте ещё раз";
            //$_SESSION['error']=$_FILES['userfile']['error']." ".$_FILES['userfile']['size'];
			echo("<script>location.href='club.php?club_id=".$club_id."&error=".$error."'</script>");
            }
		}
	else {
		$error=7;//"сервер не поддерживает данный формат изображений";
		echo("<script>location.href='club.php?club_id=".$club_id."&error=".$error."'</script>");
		}	
	}

define("count",10,false);//Кол-во сообщений на одной странице

//пока не проверили, является ли пользователь администратором группы, удаляем сессию 
unset($_SESSION['club_edit']);
unset($_SESSION['club_id']);

//проверяем, существует ли клуб с введённым айди
if (!checkClub($club_id)) {
	require_once("../includes/error_page.php");
	makeError("Клуба с таким номером не существует");
	die();
	}


function getClubChat($club_id,$page,$canView,$canWrite,$canRate,$canEdit) {
	include ("../includes/connection.php");
	require_once("includes/chat.class.php");
	require_once("includes/chat.lib.php");
	require_once("../smarty/Smarty.class.php");
	$user_id=intval($club_id);
	$page=intval($page);
	$first=($page-1)*count;
	$query="select * from club_messages where club_id='".$club_id."' order by `date` desc limit ".$first.",".count."";
	$result=mysql_query($query,$link);
	if (!$result) return "Ошибка. Не удалось выполнить запрос";
	$mess_count=0;    
	$messages=array();            
	while ($row=mysql_fetch_array($result)) {
		$message=new message($user_id,1,$club_id,1);
		$message-> getMessage($row['message_id']);
		$answers=$message-> getAnswers();
		$messages[$mess_count]=$message-> getMessTpl($canView,$canWrite,$canRate,$canEdit,$answers);
		$mess_count++;
		}		
	$tpl= new Smarty;
	$tpl-> template_dir="templates/";
	$tpl-> compile_dir="templates_c/";
	$tpl-> config_dir="configs/";
	$tpl-> cache_dir="cache/";	
	$tpl-> assign ("arr",$messages);
	$ans=$tpl-> fetch("table.tpl");
	return $ans;
	}
//получаем общую информацию о клубе
$club=new club($club_id);
$club-> getInfo();
//получаем роль пользователя в клубе
$role=$club-> getRole($user_id);
$canView=$club-> canView($user_id);
$canWrite=$club-> canWrite($user_id);
$canEdit=$club-> canEdit($user_id);
if ($canEdit) 
	$_SESSION['club_id']=$club_id;
$canRate=$club-> canRate($user_id);
if ($_GET['action']=='setClubChatContent') {
	$content=getClubChat($club_id,$_GET['p_num'],$canView,$canWrite,$canRate,$canEdit);
	echo $content;
	die();
	}
//Получаем массив членов клуба
$members=$club-> getMembers();
$count=$club-> getCountMember();
$member_count_name="В клубе ".$count." ".makeCountMember($count);


//Получаем кол-во сообщений в чате клуба
$query="select * from `club_messages` where `club_id`='".$club_id."'";
$result=mysql_query($query,$link);
require_once("../includes/defence.lib.php");
$mess_count=mysql_num_rows($result);
$mess_count_name=$mess_count." ".makeCountMessage($mess_count);

//получаем кол-во страниц чата клуба
$chat_page_num=floor($mess_count/count)+1;
if ($mess_count%count==0) $chat_page_num--;
//Получаем чат клуба
$chat=getClubChat($club_id,1,$canView,$canWrite,$canRate,$canEdit);

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

$club-> getRole($user_id);
$tpl-> assign("role",$club-> role);
$tpl-> assign("hasInvite",$club-> hasInvite());
$tpl-> assign("hasApply",$club-> hasApply());
$tpl-> assign("canWrite",$club-> canWrite());
$tpl-> assign("canEnter",$club-> canEnter());
$tpl-> assign("user_id",$user_id);
//Поллучаем шаблон меню клуба
$menu=$tpl-> fetch("clubMenu.tpl");
$tpl-> assign("menu",$menu);

$tpl-> assign("count_member",$member_count_name);
$tpl-> assign("members",$members);

$tpl-> assign("chat_content",$chat);
$tpl-> assign("message_count",$mess_count_name);
//Выводим блок с кнопками переключения страниц
require_once("../includes/page.lib.php");
if ($chat_page_num>1) 
	$tpl-> assign("chat_page_pattern",getPagePattern(1,$chat_page_num,'setClubChatContent'));

//Передаём всё в шаблон общей страницы
$content=$tpl-> fetch("club.tpl");
$headers=$tpl-> fetch("headers.tpl");
require_once("../includes/page.php");
$html=getPage($headers,$content);


echo $html;
?>
