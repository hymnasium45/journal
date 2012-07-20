<?php
session_start();
//Проверяем, если был отправлен завпрос на удаление комментария, вызываем функцию удаления
if ($_POST['action']=='deleteComment') {
	echo deleteComment($_POST['id']);
	die();
	}
//Функция удаляет комментарий пользователя
function deleteComment($comm_id) {
	include("../../includes/connection.php");
	$id=intval($comm_id);
	$query="update news_comments set date = (
	select date from (select * from news_comments) 
	as x  where comment_id= '".$id."'), text='The message was deleted by user'    
	where comment_id='".$id."'";
	$result=mysql_query($query,$link);
	if ($result) return json_encode(array('status'=>1));
	}

?>
