<?php
session_start();
error_reporting(0);
if ($_SESSION['login']!=1) die("Ошибка. Выполнять данный запрос могут только авторизованные пользователи");
if ($_POST['action']=='updateClub') {
	require_once("club.lib.php");
	if ($_POST['name']=='')	
		die("Введите имя клуба");
	echo updateClub($_SESSION['club_id'],$_POST['name'],$_POST['info'],$_POST['canView'],$_POST['canWrite'],$_POST['canEnter']);
	die();
	}
if ($_POST['action']=='createClub') {
	require_once("club.lib.php");
	echo createClub($_POST['name'],$_SESSION['user_id']);
	die();
	}
if ($_POST['action']=='leaveClub') {
	require_once("club.lib.php");
	echo deleteMember($_POST['club_id'],$_SESSION['user_id']);
	die();
	}
if ($_POST['action']=='deleteClub') {
	include("../includes/connection.php");
	require_once("club.lib.php");
	echo deleteClub($_POST['club_id']);
	die();
	}
if ($_POST['action']=='acceptInvite') {
	require_once("club.lib.php");
	echo acceptInvite($_POST['club_id'],$_SESSION['user_id']);
	die();
	}
if ($_POST['action']=='deleteInvite') {
	require_once("club.lib.php");
	echo deleteInvite($_POST['club_id'],$_SESSION['user_id']);
	die();
	}	
if ($_POST['action']=='sendInvite') {
	require_once("club.lib.php");
	echo addInvite($_POST['club_id'],$_POST['user_id']); 
	die();
	}	

if ($_POST['action']=='deleteClubInvite') {
	require_once("club.lib.php");
	echo deleteInvite($_POST['club_id'],$_POST['user_id']); 
	die();
	}	

if ($_POST['action']=='addApply') {
	require_once("club.lib.php");
	echo addApply($_POST['club_id'],$_POST['user_id']);
	die();
	}	
if ($_POST['action']=='acceptApply') {
	require_once("club.lib.php");
	echo deleteApply($_SESSION['club_id'],$_POST['user_id']);
	echo addMember($_SESSION['club_id'],$_POST['user_id']);
	die();
	}	
	
if ($_POST['action']=='deleteApply') {
	require_once("club.lib.php");
	echo deleteApply($_POST['club_id'],$_POST['user_id']);
	die();
	}	
if ($_POST['action']=='addUser') {
	require_once("club.lib.php");
	echo addMember($_POST['club_id'],$_POST['user_id']);
	die();
	}

if ($_POST['action']=='deleteUser') {
	require_once("club.lib.php");
	echo deleteMember($_SESSION['club_id'],$_POST['user_id']);
	die();
	}
if ($_POST['action']=='makeAdmin') {
	require_once("club.lib.php");
	echo addAdmin($_SESSION['club_id'],$_POST['user_id']);
	die();
	}
if ($_POST['action']=='unmakeAdmin') {
	require_once("club.lib.php");
	echo deleteAdmin($_SESSION['club_id'],$_POST['user_id']);
	die();
	}
if ($_POST['action']=='muteUser') {
	require_once("club.lib.php");
	echo addMute($_SESSION['club_id'],$_POST['user_id']);
	die();
	}

if ($_POST['action']=='unmuteUser') {
	require_once("club.lib.php");
	echo deleteMute($_SESSION['club_id'],$_POST['user_id']);
	die();
	}


if ($_POST['action']=='sendMessage') {
	require_once("chat.lib.php");
	if ($_POST['text']==" ") 
		echo "Введите текст сообщения."; 
	else 
		echo sendMessage($_POST['club_id'],$_SESSION['user_id'],$_POST['text'],$_POST['answer_id']);
	die();
	}
if ($_POST['action']=='rateMessage') {
	require_once("chat.lib.php");
	echo rateMessage($_POST['change'],$_POST['mess_id'],$_SESSION['user_id']);
	die();
	}
	
if ($_POST['action']=='deleteMess') {
	require_once("chat.lib.php");
	deleteMessage($_POST['mess_id']);
	die();
	}
	

?>
