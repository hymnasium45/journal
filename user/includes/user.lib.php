<?php
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
function isPupil($user_id) {
	include("../includes/connection.php");
	$user_id=intval($user_id);
	$query= "select * from `class_users` where `user_id`='".$user_id."'";
	$result=mysql_query($query,$link);
	if (!$result) echo "error";
	if (mysql_num_rows($result)>0) return true; else return false;
	}
function isRaporter($user_id) {
	include("../includes/connection.php");
	$user_id=intval($user_id);
	$query="select * from classes where raporter_id='".$user_id."'";
	$result=mysql_query($query,$link);
	if (mysql_num_rows($result)>0) return true; else return false;
	}
function isTeacher($user_id) {
	include("../includes/connection.php");
	$user_id=intval($user_id);
	$query="select * from groups where teacher_id='".$user_id."'";
	$result=mysql_query($query,$link);
	if (mysql_num_rows($result)>0) return true; else return false;
	}
function isClassTeacher($user_id) {
	include("../includes/connection.php");
	$user_id=intval($user_id);
	$query="select * from classes where teacher_id='".$user_id."'";
	$result=mysql_query($query,$link);
	if (mysql_num_rows($result)>0) return true; else return false;
	}
function isGroupTeacher($user_id,$group_id) {
	include("../includes/connection.php");
	$user_id=intval($user_id);
	$group_id=intval($group_id);
	$query="select * from `groups` where `group_id`='".$group_id."'";
	$result=mysql_query($query,$link);
	$row=mysql_fetch_array($result);
	echo $row['teacher_id'];
	if ($row['teacher_id']==$user_id) return true;
	else return false;
	}
function inviteUser($user_mail,$sender_id) {
	include("../includes/connection.php");
	require_once("../includes/defence.lib.php");
	if (!isEmail($user_mail)) 
		return "Ошибка. Неправильный электронный адрес";
	$query="select * from users where email='".$user_mail."'";
	$result=mysql_query($query,$link);
	if (mysql_num_rows($result)>0)
		return "Ошибка. Пользователь с таким адресом уже зарегистрирован";
	
	do {
		$code=md5(rand(100000,1000000).$user_mail."sajdflkasutb");
		$query="select * from applies where code='".$code."'";
		$result=mysql_query($query,$link);
		}
		while(mysql_num_rows($result)>0);
	$query="insert into applies (`email`,`code`,`date`) values
			('".$user_mail."','".$code."','NOW()')";
	$result=mysql_query($query,$link);
	if (!$result) 
		return "Ошибка. Не удалось добавить приглашение в базу.";
		
	require_once("../includes/mail.class.php");
	$query="select * from users where user_id='".$sender_id."'";
	$result=mysql_query($query,$link);
	$row=mysql_fetch_array($result);
	$name=str_replace("&#160"," ",$row['Name']);
	
	$text="Доброго времени суток!<BR>".
		   $name." прислал(а) Вам приглашение зарегистрироваться на 
		   <a href='www.ag45.org.ua'>сайте</a>.<br><br>
		   Для того, чтобы принять его, пройдите по 
		   <a href='www.ag45.org.ua/journal/htdocs/registration.php?id=".$code."'>ссылке</a>.<br><br>
		   С уважением, администрация.";
	$title="Your invitation to the ag45";
	$mail=new mail($user_mail,$title,$text);
	
	if (!$mail-> sendMail()) {
		$query="delete from applies where code='".$code."'";
		$result=mysql_query($query,$link);
		return $mail-> getError();
		}
	else 
		return "<font class='okey'>Приглашение успешно доставлено</font>";
	}
?>

