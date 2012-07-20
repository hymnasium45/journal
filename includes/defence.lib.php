<?php
/**
функции для обработки текста, вводимого пользователем
*/
function makeText($text) {
	$true=mysql_escape_string(htmlspecialchars($text));
	$true=str_replace("\\n","<br>",$true);
	return $true;
	}
function makeWords($string) {
	$wordmaxlen=50;
	$hyp=" ";	
        return preg_replace('/([^\s]{' . intval($wordmaxlen) .'})+/U', '$1' . $hyp, $string);
}
function makeName($name) {
	return substr($name,0,strpos($name,'&#160'))."<br>".substr($name,strpos($name,'&#160')+5);
	}
function makeLinks($text) {
	return ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]",
                    "<a target=\"_blank\" href=\"\\0\">\\0</a>", $text);
	}
function makeCountMessage($count) {
	$count=$count % 100;
	if ($count>10 && $count<19) return "сообщений"; 	
	else {
		$count=$count % 10;
		if ($count == 1) return "сообщение";
		else if ($count > 0 && $count < 5) return "сообщения";
		else return "сообщений";
		}
	}
function makeCountPupil($count) {
        $count=$count % 100;
        if ($count>10 && $count<19) return "учеников"; 
        else {
                $count=$count % 10;
                if ($count == 1) return "ученик";
                else if ($count > 0 && $count < 5) return "ученика";
                else return "учеников";
                }
        }

function makeCountApply($count) {
        $count=$count % 100;
        if ($count>10 && $count<19) return "заявок"; 
        else {	
                $count=$count % 10;
                if ($count == 1) return "заявка";
                else if ($count > 0 && $count < 5) return "заявки";
                else return "заявок";
                }
        }

function makeCountMember($count) {
        $count=$count % 100;
        if ($count>10 && $count<19) return "участников"; 
        else {	
                $count=$count % 10;
                if ($count == 1) return "участник";
                else if ($count > 0 && $count < 5) return "участника";
                else return "участников";
                }
        }

function makeCountInvite($count) {
        $count=$count % 100;
        if ($count>10 && $count<19) return "приглашений"; 
        else {
                $count=$count % 10;
                if ($count == 1) return "приглашение";
                else if ($count > 0 && $count < 5) return "приглашения";
                else return "приглашений";
                }
        }

function makeCountClub($count) {
        $count=$count % 100;
        if ($count>10 && $count<19) return "клубах"; 
        else {
                $count=$count % 10;
                if ($count == 1) return "клубе";
                else return "клубах";
                }
        }
function makeCountClub2($count) {
        $count=$count % 100;
        if ($count>10 && $count<19) return "клубов"; 
        else {
                $count=$count % 10;
                if ($count == 1) return "клуб";
                else if ($count>1 && $count <5) return "клуба";
                else return "клубов";
                }
        }


function isName ($name) {
	$length=strlen($name)-1;
	if (preg_match("/^[А-я][a-я\s]{".$length."}$/",$name)) return true; else return false;
	}
function isEmail($email){
  $p = '/^[a-z0-9!#$%&*+-=?^_`{|}~]+(\.[a-z0-9!#$%&*+-=?^_`{|}~]+)*';
  $p.= '@([-a-z0-9]+\.)+([a-z]{2,3}';
  $p.= '|info|arpa|aero|coop|name|museum|mobi)$/ix';
  return preg_match($p, $email);
	}
function freeEmail($email,$user_id) {
	session_start();
error_reporting(0);
        $local_link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
        mysql_select_db($_SESSION['dbname'],$local_link);
	$email=makeText($email);
        $query="select * from `users` where `Email`='".$email."'"; 
	$result=mysql_query($query,$local_link);
        $num=mysql_num_rows($result);
        $row=mysql_fetch_array($result);
	$query="select * from `applies` where `email`='".$email."'"; 
	$result=mysql_query($query,$local_link);
        $num1=mysql_num_rows($result);
        $row1=mysql_fetch_array($result);
	if (($num==0 || ($num==1 && $row['user_id']==$user_id)) && ($num1==0 || ($num1==1 && $row1['user_id']==$user_id))) return true;
        else return false;
	}

function isLogin($login,$user_id) {
  	session_start();
error_reporting(0);
        $local_link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
        mysql_select_db($_SESSION['dbname'],$local_link);
	$login=makeText($login);
        $query="select * from `users` where `Login`='".$login."'";
	$result=mysql_query($query,$local_link);
        $num=mysql_num_rows($result);
        $row=mysql_fetch_array($result);
	if ($num==0 || ($num==1 && $row['user_id']==$user_id)) return true;
        else return false;
	}
?>
