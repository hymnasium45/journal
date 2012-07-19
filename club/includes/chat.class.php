<?php
class answer {
	public $sender_id;
	public $sender_name;
	public $text;
	}	

class message {
	private $user_id;//айди пользователя, который просматривает сообщение
	public $rate_able=false;//может ли пользоветь голосовать за комментарий
	public $write_able=false;
	private $club_id;//айди класса
	public $sender;//Имя автора сообщения
	private $sender_id;//айди автора сообщения
	public $avatar;//Аватар автора сообщения
	public $date;//Дата написания сообщения
	public $mess_id;//Инд. номер сообщения
	private $ans_id;//Айди сообщение, ответом к которому является данное
	private $ans_text;//Текст сообщения, ответом к которому является данное
	private $ans_sender;//Автор сообщеня, ответом к которому является данное
	private $ans_count;//кол-во сообщений, ответом на которое является данное
	public $online=false;//онлайн автор сообщения или нет
	public $admin=false;//является автор сообщения администратором страницы, на которой расположено соощение или нет
	public $rate=0;//рейтинг сообщения

function __construct($id,$admin,$club,$write_able) {
	$this-> user_id= $id;
	$this-> admin=$admin;
	$this-> club_id=$club;
	$this-> write_able=$write_able;
	}
function getMessage($id/*айди сообщения*/) {
	$this-> mess_id=intval($id);
	include("../includes/connection.php");
	require_once ("../includes/date.lib.php");
	require_once ("../includes/register_users.php");
	require_once ("../user/includes/user.class.php");
	$query="select * from club_users where user_id='".$this-> user_id."' and club_id='".$this-> club_id."'";
	$result=mysql_query($query,$link);
	$num=mysql_num_rows($result);
	if ($num>0) $this-> rate_able=true;
	if ($this-> rate_able) {
		$query="select * from club_message_likes where message_id='".$id."' and user_id='".$this-> user_id."'";
		$result=mysql_query($query,$link);
		$num=mysql_num_rows($result);
		if ($num>0) $this-> rate_able=false;
		}
	$query="select * from `club_messages` where `message_id`='".$this-> mess_id."'";
	$result=mysql_query($query,$link);
    if (!$result) 
		return "Не удалось получить сообщение из базы данных"; 
	$row=mysql_fetch_array($result);
	$this-> date= makeDate($row['date']);
	$this-> text= $row['text'];
	$this-> ans_id=$row['answer_id'];
	if ($row['rate']!= '') 
		$this-> rate=$row['rate'];
	
	if ($this-> rate_able && $row['user_id']==$this-> user_id) 
		$this-> rate_able=false;
	$user= new user($row['user_id']);
	$user-> getUser();
	$this-> sender=$user-> name;
	$this-> sender_id=$row['user_id'];
	$this-> avatar="<a href='../htdocs/profile.php?id=".$this-> sender_id."'>".$user-> icon."</a>";
	$this-> online= isOnline($this-> sender_id);
	}
function getAnswers() {
	include ("../includes/connection.php");
	$answer=$this-> ans_id;
	$answers=array();
	$count=0;
	while ($answer>0 && $count<5) {
		$count++;
		$query="select * from club_messages where `message_id`='".$answer."'";
		$result=mysql_query($query,$link);
		if (!$result) 
			return  "Ошибка. Не удалось выполнить запрос.";
		$row=mysql_fetch_array($result);
		$answer=$row['answer_id'];
		$answers[$сount]=new answer;
		$answers[$count]-> text= $row['text'];
		$query="select `Name` from `users` where `user_id`='".$row['user_id']."'";
		$result=mysql_query($query,$link);
		$row=mysql_fetch_array($result);
		if (!$result) 
			return "Ошибка. Не удалось выполнить запрос.";
		$answers[$count]-> sender_name=$row['Name'];
		}
	return $answers;
	}
function setMessage($text/*текст сообщения*/,$answer/*айди сообщения, ответом к которому является данное*/) {
	include ("../includes/connection.php");
	require_once("../includes/defence.lib.php");
	$text=makeText($text);
        $text=makeWords($text);
        $text=makeLinks($text);
	$query="insert into `club_messages` 
		(`class_id`,`user_id`,`text`,`answer_id`) values 
		('".$this-> class_id."','".$this-> user_id."','".$text."','".$answer."')";
	$result=mysql_query($query,$link);
	
	if (!$result) 
		return "Не удалось добавить сообщение в базу"; 
	}

function getMessTpl($canView,$canWrite,$canRate,$canEdit,$answers) {
	require_once("../smarty/Smarty.class.php");
	$tpl= new Smarty;
	$tpl-> template_dir="templates/";
	$tpl-> compile_dir="templates_c/";
	$tpl-> config_dir="configs/";
	$tpl-> cache_dir="cache/";	
	$tpl-> assign("avatar",$this-> avatar);
	$tpl-> assign("id",$this-> mess_id);
	$tpl-> assign("text",$this-> text);
	$tpl-> assign("sender_id",$this-> sender_id);
	$tpl-> assign("sender",$this-> sender);
	$tpl-> assign("online",$this-> online);
	$tpl-> assign("rate",$this-> rate);
	$tpl-> assign("canEdit",$canEdit);
	$tpl-> assign("date",$this-> date);
	$tpl-> assign("canWrite",$canWrite);
	$tpl-> assign("canRate",$canRate);
	$tpl-> assign("answers",$answers);
	$tpl-> assign("club_id",$this-> club_id);
	return $tpl-> fetch("message.tpl");
	}
}
?>
