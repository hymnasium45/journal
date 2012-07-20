<?php
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");

// Создание клуба
function createClub($name,$user_id) {	
	$way= getcwd();
	chdir("includes");
	include("../../includes/defence.lib.php");
	include("../../includes/connection.php");
	chdir($way);
	if (!$link) return "Ошибка. Не удалось подключиться к базе данных";
	$name=makeText($name);
	if ($name=='') return "Введите имя клуба";
	$user_id=intval($user_id);
	$query="select * from club where name='".$name."'";
	$result=mysql_query($query,$link);
	$num=mysql_num_rows($result);
	if ($num > 0) {
		return "Клуб с таким названием уже существует";
		}
	else {	
		$query="insert into club (`name`,`creater_id`,`createDate`) values('".$name."','".$user_id."',NOW())";
		$result=mysql_query($query,$link);
		$query="select * from club where name='".$name."'";
		$result=mysql_query($query,$link);
		$row=mysql_fetch_array($result);
		addMember($row['club_id'],$user_id);
		return;
		}
	}
//Удаление клуба
function deleteClub($club_id) {
	$way= getcwd();
	chdir("includes");
	require_once("../../includes/connection.php");
	chdir($way);
	$club_id=intval($club_id);
	$query="delete from club where club_id='".$club_id."'";
	$result=mysql_query($query,$link);
	if (!$result) return "Ошибка. Не удалось удалить клуб";
	$query="delete from club_users where club_id='".$club_id."'";
	$result=mysql_query($query,$link);
	$query="delete from club_messages where club_id='".$club_id."'";
	$result=mysql_query($query,$link);
	$query="delete from club_invites where club_id='".$club_id."'";
	$result=mysql_query($query,$link);
	$query="delete from club_applies where club_id='".$club_id."'";
	$result=mysql_query($query,$link);
	mysql_free_result($result);
	}
function updateClub($club_id,$name,$info,$canView,$canWrite,$canEnter) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	require_once("../../includes/defence.lib.php");
	chdir($way);
	$club_id=intval($club_id);
	$canWrite=(boolean)$canWrite;
	$canView=(boolean)$canView;
	$canEnter=(boolean)$canEnter;
	$name=makeText($name);
	$info=makeText($info);
	$query="update club set `name`='".$name."',`about`='".$info."',
			`canView`='".$canView."',`canWrite`='".$canWrite."',`canEnter`='".$canWrite."' 
			 where club_id='".$club_id."'";
	$result=mysql_query($query,$link);
	if (!$result) 
		return "Ошибка. Не удалось выполнить запрос.";
	}
//функция, которая проверяет, существует ли клуб с данным айди
function checkClub($club_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	chdir($way);
	$club_id=intval($club_id);
	$query="select * from club where club_id='".$club_id."'";
	$result=mysql_query($query,$link);
	if (mysql_num_rows($result)>0) return true; else return false;
	}
//количество клубов, в которых состоит пользователь
function getUserClubCount($user_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	chdir($way);
	$user_id=intval($user_id);
	$query="select * from club_users where user_id='".$user_id."'";
	$result=mysql_query($query,$link);
	if (!$result) return "Ошибка. Не удалось выполнить запрос."; else return mysql_num_rows($result);
	}
//количество приглашений пользователя
function getUserInviteCount($user_id) {
	$way= getcwd();
	chdir("../club/includes");
	include ("../../includes/connection.php");
	chdir($way);
	$user_id=intval($user_id);
	$query="select * from club_invites where user_id='".$user_id."'";
	$result=mysql_query($query,$link);
	if (!$result) return "Ошибка. Не удалось выполнить запрос."; else return mysql_num_rows($result);
	}
function addInvite($club_id,$user_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	chdir($way);
	$user_id=intval($user_id);
	$club_id=intval($club_id);
	if (checkInvite($club_id,$user_id)) 
		return "Ошибка. Пользователь уже получил приглашение";
	$query="insert into `club_invites` (`club_id`,`user_id`) values ('".$club_id."','".$user_id."')";
	$result=mysql_query($query,$link);
	if (!$result) return "Ошибка. Не удалось отправить приглашение."; else return true;
	}
//проверка, существует ли приглашение с данным айди
function checkInvite($club_id,$user_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	chdir($way);
	$user_id=intval($user_id);
	$club_id=intval($club_id);
	$query="select * from club_invites where club_id='".$club_id."' and user_id='".$user_id."'";
	$result=mysql_query($query,$link);
	if (mysql_num_rows($result)>0) return true; else return false;
	}
//удалене приглашения пользователя в клуб
function deleteInvite($club_id,$user_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	chdir($way);
	$user_id=intval($user_id);
	$club_id=intval($club_id);
	$query="delete from club_invites where user_id='".$user_id."' and club_id='".$club_id."'";
	$result=mysql_query($query,$link);
	if (!$result) return "Ошибка. Не удалось удалить приглашение";
	}
//функция принимает приглашение в клуб
function acceptInvite($club_id,$user_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	chdir($way);
	deleteInvite($club_id,$user_id);
	addMember($club_id,$user_id);
	}
//функция проверяет, является ли данный пользователь членом данного клуба
function checkMember($club_id,$user_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	chdir($way);
	$user_id=intval($user_id);
	$club_id=intval($club_id);
	$query="select * from club_users where club_id='".$club_id."' and user_id='".$user_id."'";
	$result=mysql_query($query,$link);
	if (mysql_num_rows($result)>0) return true; else return false;
	}
//добавления пользователя в клуб
function addMember($club_id,$user_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	chdir($way);
	$user_id=intval($user_id);
	$club_id=intval($club_id);
	deleteMember($club_id,$user_id);
	$query="insert into `club_users` (`club_id`,`user_id`,`date`) values ('".$club_id."','".$user_id."',NOW())";
	$result=mysql_query($query,$link);
	if (!$result) return "Ошибка. Не удалось добавить пользователя."; else return true;
	}
//удаление пользователя из клуба
function deleteMember($club_id,$user_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	chdir($way);
	$user_id=intval($user_id);
	$club_id=intval($club_id);
	$query="delete from `club_users` where club_id='".$club_id."' and user_id='".$user_id."'";
	$result=mysql_query($query,$link);
	if (!$result) return "Ошибка. Не удалось удалить пользователя."; 
	}
function addAdmin($club_id,$user_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	chdir($way);
	$user_id=intval($user_id);
	$club_id=intval($club_id);
	deleteAdmin($club_id,$user_id);
	$query="insert into `club_admins` (`club_id`,`user_id`) values ('".$club_id."','".$user_id."')";
	$result=mysql_query($query,$link);
	if (!$result) return "Ошибка. Не удалось выполнить запрос."; else return true;
	}
function deleteAdmin($club_id,$user_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	chdir($way);
	$user_id=intval($user_id);
	$club_id=intval($club_id);
	$query="delete from `club_admins` where club_id='".$club_id."' and user_id='".$user_id."'";
	$result=mysql_query($query,$link);
	if (!$result) return "Ошибка. Не удалось выполнить запрос."; 
	}

function addMute($club_id,$user_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	chdir($way);
	$user_id=intval($user_id);
	$club_id=intval($club_id);
	deleteMute($club_id,$user_id);
	$query="insert into `club_mute` (`club_id`,`user_id`) values ('".$club_id."','".$user_id."')";
	$result=mysql_query($query,$link);
	if (!$result) return "Ошибка. Не удалось выполнить запрос."; else return true;
	}
function deleteMute($club_id,$user_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	chdir($way);
	$user_id=intval($user_id);
	$club_id=intval($club_id);
	$query="delete from `club_mute` where club_id='".$club_id."' and user_id='".$user_id."'";
	$result=mysql_query($query,$link);
	if (!$result) return "Ошибка. Не удалось выполнить запрос."; 
	}
function addApply($club_id,$user_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	chdir($way);
	$user_id=intval($user_id);
	$club_id=intval($club_id);
	$query="insert into `club_applies` (`club_id`,`user_id`) values('".$club_id."','".$user_id."')";
	$result=mysql_query($query,$link);
	if (!$result) return "Ошибка. Не отправить заявку."; 
	}
function deleteApply($club_id,$user_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	chdir($way);
	$user_id=intval($user_id);
	$club_id=intval($club_id);
	$query="delete from `club_applies` where club_id='".$club_id."' and user_id='".$user_id."'";
	$result=mysql_query($query,$link);
	if (!$result) return "Ошибка. Не удалось удалить заявку."; 
	}
function searchClubUser($club_id,$argc,$showMembers) {
	$way= getcwd();
	chdir("includes");
	require_once("../../includes/defence.lib.php");
	include ("../../includes/connection.php");
	require_once ("../../smarty/Smarty.class.php");	
	require_once ("../../user/includes/user.class.php");
	require_once("club.class.php");
	chdir($way);
	//Подготавливаем шаблоны
	$tpl= new Smarty;
	$tpl-> template_dir="templates/";
	$tpl-> compile_dir="templates_c/";
	$tpl-> config_dir="configs/";
	$tpl-> cache_dir="cache/";	
	$club_id=intval($club_id);
	$showMember=(boolean)$showMembers;
	$argc=makeText($argc);
	$query="select * from `users` where (`Name` like '%".$argc."%' or `Email` like '%".$argc."%') order by `Name`";
	$result= mysql_query($query,$link);
	if (!$result) 
		return "Ошибка. Не удалось выполнить запрос.";
	$invites=array();
	$count=0;
	$club=new club;
	$club-> getInfo;
	while ($row=mysql_fetch_array($result)) {
		$inClub=checkMember($club_id,$row['user_id']);
		$hasInvite=checkInvite($club_id,$row['user_id']);
		if (!$showMembers && !$inClub && !$hasInvite || $showMember) {
			$user=new user($row['user_id']);
			$user-> getUser();
			$tpl-> assign("name",$user-> name);
			$tpl-> assign("user_id",$user-> id);
			$tpl-> assign("avatar",$user-> icon);
			$tpl-> assign("inClub",$inClub);
			$tpl-> assign("hasInvite",$hasInvite);
			$tpl-> assign("inClub",$inClub);
			$tpl-> assign("club_id",$club_id);
			$tpl-> assign("role",$club-> getRole($row['user_id']));
			$invites[$count]= $tpl-> fetch("searchUser.tpl");
			$count++;
			}
		}
	if ($count==0) 
		return "<font class='error'>Поиск не дал результатов </font>";
	else 
		return $invites;
	}


?>
