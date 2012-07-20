<?php
/**
*определение типа пользователя 
*/
//ученик
/*session_start();
error_reporting(0);

function getAccess($id) {
	$local_link=mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
	mysql_select_db($_SESSION['dbname'],$local_link);
 	require_once"db_connect.lib.php";
 	collation();
	$query="select `access` from `users` where `user_id`='".$id."'";
	$result=mysql_query($query,$local_link);
	$row=mysql_fetch_array($result);
	mysql_close($local_link);
	return $row['access'];
	}
function isClassPupil($user,$class) {
	session_start();
error_reporting(0);
        $local_link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
        mysql_select_db($_SESSION['dbname'],$local_link);
        $query="select * from `class_users` where `class_id`='".$class."' and `user_id`='".$user."'";
	$result=mysql_query($query,$local_link);
	$num=mysql_num_rows($result);
        if ($num>0) return true;
        else return false;
        }

	
//учитель
function isGroupTeacher($user_id,$group_id) {
	session_start();
error_reporting(0);
	$local_link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
	mysql_select_db($_SESSION['dbname'],$local_link);
	$query="select * from `groups` where `group_id`='".$group_id."'";
	$result=mysql_query($query,$local_link);
	$row=mysql_fetch_array($result);
	if ($row['teacher_id']==$user_id) return true;
	else return false;
	}
//учитель, классный руководитель
function isClassHead($user,$class) {
	session_start();
error_reporting(0);
        $local_link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
        mysql_select_db($_SESSION['dbname'],$local_link);
        $query="select * from `classes` where `class_id`='".$class."'";
	$result=mysql_query($query,$local_link);
        $row=mysql_fetch_array($result);
        if ($row['teacher_id']==$user) return true;
        else return false;
	}
function makeHead($user) {
	session_start();
error_reporting(0);
        $local_link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
        mysql_select_db($_SESSION['dbname'],$local_link);
	$query="select * from `users` where `user_id`='".$user."'";
        $result=mysql_query($query,$local_link);
        $row=mysql_fetch_array($result);
	$access=substr($row['access'],0,1).'1'.substr($row['access'],2);
	$query="update `users` set `access`='".$access."' where `user_id`='".$user."'";
	$result=mysql_query($query,$local_link);	
	if (!$result) return false; else return true;
	}
//родитель
function isParent($access) {
        $t=substr($access,2,1);
        if ($t==1) return true; else return false;
        }

//администратор класса
function isCAdmin($access) {
        $t=substr($access,3,1);
        if ($t==1 && isPupil($access)) return true; else return false;
        }
function makeCAdmin($access) {
	$li= substr($access,0,3);
	return $li.'1';
	}
function unmakeCAdmin($access) {
        $li= substr($access,0,3);
        return $li.'0';
        }

function areClassmates($id1,$id2) {
	session_start();
error_reporting(0);
    $local_link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
    mysql_select_db($_SESSION['dbname'],$local_link);

 require_once"db_connect.lib.php";
 collation();
  $result1=mysql_query("select * from `class_users` where `user_id`='".$id1."'",$local_link);
 $row1=mysql_fetch_array($result1);
 $result2= mysql_query("select * from `class_users` where `user_id`='".$id2."'",$local_link);
 $row2=mysql_fetch_array($result2);
 mysql_close($local_link);
if (  $row1['class_id']==$row2['class_id'] && $row1['class_id']>0 && $row2['class_id']>0)
                        return true;
                else return false;
	}
function makeRaporter ($access) {
	$l1=substr($access,0,1);
	$l2=substr($access,2);
 	return $l1.'1'.$l2;
	}
function unmakeRaporter ($access) {
        $l1=substr($access,0,1);
        $l2=substr($access,2);
        return $l1.'0'.$l2;
        }

//является ли пользователь администратором школы
function isSAdmin($access) {
		$t=substr($access,3,1);
		if ($t==1 && isTeacher($access)) return true; 
		else return false;
		
		}

function getClubMember($user_id,$club_id) {
	session_start();
error_reporting(0);
    $local_link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
    mysql_select_db($_SESSION['dbname'],$local_link);
    $user_id=intval($user_id);
    $club_id=intval($club_id);
	$query="select * from club_users where user_id='".$user_id."' and club_id='".$club_id."'";
	$result=mysql_query($query,$local_link);
	if (mysql_num_rows($result)>0) {
		$row=mysql_fetch_array($result);
		return $row;
		} else return false;
	}
	
//Определения доступа клубу
function getClubSecur($club_id) {
	session_start();
error_reporting(0);
    $local_link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
    mysql_select_db($_SESSION['dbname'],$local_link);
	$query="select * from `club` where `club_id`='".$club_id."'";
	$result =mysql_query($query,$local_link);
	$row=mysql_fetch_array($result);
	return $row['security'];
	}

function Chat($user_id,$club_id) {	
	session_start();
error_reporting(0);
    $local_link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
    mysql_select_db($_SESSION['dbname'],$local_link);
    $access=getClubSecur($club_id);
    $secur=array(false,false,false);
    $f=true;
	if (!getClubMember($user_id,$club_id)) 
		$f=false;
	else 
		$info=getClubMember($user_id,$club_id);
	if (!$f && substr($access,2,1)==1) $secur['view']=true; //view
	if ($f && substr($info['chat_access'],0,1)==1) $secur['view']=true;
	if (!$f && substr($access,2,2)==1) $secur['write']=true;
	if ($f && substr($info['chat_access'],1,1)==1) $secur['write']=true;
	if ($f && substr($info['chat_access'],2,1)==1) $secur['edit']=true;
	return $secur;
	}

function Members($user_id,$club_id) {	
	session_start();
error_reporting(0);
    $local_link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
    mysql_select_db($_SESSION['dbname'],$local_link);
    $access=getClubSecur($club_id);
    $secur=array(false,false,false);
    $f=true;
	if (!getClubMember($user_id,$club_id)) 
		$f=false;
	else 
		$info=getClubMember($user_id,$club_id);
	if (!$f && substr($access,2,1)==1) $secur['view']=true; //view
	if ($f && substr($info['member_access'],0,1)==1) $secur['invite']=true;
	if (!$f && substr($access,2,2)==1) $secur['write']=true;
	if ($f && substr($info['member_access'],1,1)==1) $secur['delete']=true;
	if ($f && substr($info['member_access'],2,1)==1) $secur['edit']=true;
	return $secur;
	}

//Определения доступа к информации пользователя
function getUserSecur($user_id) {
	session_start();
error_reporting(0);
	$user_id=intval($user_id);
    $local_link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
    mysql_select_db($_SESSION['dbname'],$local_link);
	$query="select * from `users` where `user_id`='".$user_id."'";
	$result =mysql_query($query,$local_link);
	$row=mysql_fetch_array($result);
	return $row['security'];
	}
//Может ли пользователь просматривать дату рождения
function viewUserDate($this_id,$user_id) {
	session_start();
error_reporting(0);
    $local_link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
    mysql_select_db($_SESSION['dbname'],$local_link);
	
	$this_id=intval($this_id);
	$user_id=intval($user_id);
	$secur=getUserSecur($user_id);
	$secur=substr($secur,1,1);
	if ($secur=='3' || $this_id=$user_id) return true;
	if ($secur=='2' and areClassmates($this_id,$user_id)) return true;
	return false;
	}

?>
