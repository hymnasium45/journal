<?php

// Error reporting:
include ("../../includes/connection.php");
include "comment.class.php";
session_start();
error_reporting(0);


$arr = array();
$validates = Comment::validate($arr);

if($validates)
{	
	
	
	$status=filter_input(INPUT_POST, 'status');
 
	if ($status=='edit')
	{	
	
	if(mysql_query("update news_comments    set date = (select date from (select * from news_comments) as x  where comment_id= '".$arr['ans_num']."'), text='".$arr['text']."'    where comment_id='".$arr['ans_num']."' "))	
		echo '{"status":0}';
	}

	else
	{
  	$temp=date('Y-m-d G:i:s');		
	$query="	INSERT INTO news_comments (`user_id`,`date`,`answer_id`,`text`,`news_id`)
					VALUES (
						'".$_SESSION['user_id']."',
						'".$temp."',
						'".$arr['ans_num']."',
						'".$arr['text']."',
						'".$_SESSION['news_id']."'	
					)";
	
	mysql_query($query);
	$arr['date'] =$temp;
	//$arr['id'] = mysql_insert_id();
	
	$foo=mysql_fetch_array(mysql_query('select comment_id from news_comments order by date DESC limit 1'));
	$arr['comment_id']=$foo['comment_id'];
	$arr['rate']='0';
 	$arr['user_id']=$_SESSION['user_id'];	
	$arr = array_map('stripslashes',$arr);
	$margin=(intval(substr($arr['margin'],0,strlen($arr['margin'])-1)));
	if ((!$arr['ans_num']==0 ) && ($margin<100)) $margin+=25;
		
		
	$insertedComment = new Comment($arr);

	echo json_encode(array('status'=>1,'html'=>$insertedComment->markup($margin)));
}
}
/*else
{
	echo '{"status":0,"errors":'.json_encode($arr).'}';
}
*/
?>
