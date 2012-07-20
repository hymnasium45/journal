<?php
session_start();
//Обрабатываем запрос на добавление новости
if ($_POST['action']=='addNews') {
	echo addNews($_SESSION['user_id'],$_POST['title'],$_POST['content'],
			 date('Y-m-d G:i:s'),$_POST['tags']);
	die();
	}
//Фунцкия проверяет, может ли пользователь добовлять новость
function canAddNews($user_id) {
	$user_id=intval($user_id);
	include ("../includes/connection.php");

	$query="select * from `school_admins` where `user_id`='".$user_id."'";
	$result=mysql_query($query,$link);
	if (!$result) 
		return "Ошибка. Не удалось выпонить запрос";
	$row=mysql_fetch_array($result);
	
	return $row['canAdd'];
	}
//Функция создаёт новость
function addNews($user_id,$title,$content,$date,$tags) {
	include("../../includes/connection.php");
	require_once("../../includes/defence.lib.php");	
	$user_id=intval($user_id);
	$title=makeText($title);
	$tags=makeText($tags);
	$query="insert into news (`user_id`,`name`,`text`,`date`,`tags`) values
		('".$user_id."',
		 '".$title."',
		 '".$content."',
		 '".$date."',
		 '".$tags."')";
	$result=mysql_query($query,$link);
	if (!$result) 
		return "Ошибка. Не удалось добавить новость.";
	}
?>
