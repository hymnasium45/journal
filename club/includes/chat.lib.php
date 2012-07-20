<?php
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");

function sendMessage($club_id,$user_id,$text,$answer_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	require_once("../../includes/defence.lib.php");
    chdir($way);
    $text=makeText($text);
    $text=makeLinks($text);
    $user_id=intval($user_id);
    $club_id=intval($club_id);
	$answer_id=intval($answer_id);
	$query="insert into `club_messages` (`club_id`,`user_id`,`answer_id`,`text`) 
				values('".$club_id."','".$user_id."','".$answer_id."','".$text."')";
	$result=mysql_query($query,$link);
	if (!$result) return "Ошибка. Не удалось отправить сообщение";
	}	
function rateMessage($rate,$mess_id,$user_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	require_once("../../includes/defence.lib.php");
    chdir($way);
    $mess_id=intval($mess_id);
    $user_id=intval($user_id);
    
    $query= "select * from `club_message_likes` 
		 where `message_id`='".$mess_id."' and `user_id`='".$user_id."'";
	$result=mysql_query($query,$link);
	if (!$result) 
		return "Ошибка. Не удалось выполнить запрос";
	$num=mysql_num_rows($result);
	if ($num>0) 
		return "Вы уже голосовали за данное сообщение";
	$query="select * from `club_messages` where message_id='".$mess_id."'";
	$result=mysql_query($query,$link);
	if (!$result) 
		return "Ошибка. Не удалось выполнить запрос";
	$row=mysql_fetch_array($result);
	if ($row['user_id']==$user_id) 
		return "Вы не можете голосовать за своё сообщение.";
	$query= "insert into `club_message_likes` values ('".$mess_id."','".$user_id."')";
	$result=mysql_query($query,$link);
	$query="select * from `club_messages` where `message_id`='".$mess_id."'";
	$result=mysql_query($query,$link);
	$row=mysql_fetch_array($result);
	if ($rate=='down') 
		$val=$row['rate']-1; 
	else 
		$val=$row['rate']+1;
	$query="update `club_messages` set `rate`='".$val."',date='".$row['date']."' 
			where `message_id`='".$mess_id."'";
	$result=mysql_query($query,$link);
	if ($result) 
		return $val;
	else 
		return "Ошибка. Не удалось проголосовать за сообщение";
	}
function deleteMessage ($mess_id) {
	$way= getcwd();
	chdir("includes");
	include ("../../includes/connection.php");
	require_once("../../includes/defence.lib.php");
    chdir($way);
    $mess_id=intval($mess_id);
    $query="delete from `club_messages` where `message_id`='".$mess_id."'";
	$result=mysql_query($query,$link);
	}

?>
