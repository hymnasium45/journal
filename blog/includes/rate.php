<?php
error_reporting(E_ALL^E_NOTICE);
session_start();
error_reporting(0);
include "comment.class.php";
require_once "db_connect.lib.php";
collation();

$id= filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$dir=filter_input(INPUT_POST,'direct');
$curr=filter_input(INPUT_POST, 'current', FILTER_VALIDATE_INT);
$row=mysql_fetch_array(mysql_query("select comment_id from news_comments_likes where user_id='".$_SESSION['user_id']."' and comment_id='".$id."'"));
if ($row['comment_id']>0)
{echo '{"status":0}';} 
else {
if ($dir=='up') {$num=intval($curr)+1;}
else if ($dir=='down') {$num=intval($curr)-1;}

mysql_query("update news_comments    set date = (select date from (select * from news_comments) as x  where comment_id= '".$id."'), rate='".$num."'    where comment_id='".$id."'"); 
mysql_query("insert into news_comments_likes values('".$id."','".$_SESSION['user_id']."')");
if ($num<0) { $color='#F76541';}
else {if ($num>0) { $num='+'.$num; $color='#4E9258';}
	else if ($num==0) { $color='#c2c2c2';}
}
echo json_encode(array('status'=>1, 'num'=>$num, 'color'=>$color));
}

?>
