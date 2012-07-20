<?php
session_start();
error_reporting(0);
$local_link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
//if (!$local_link || !isset($_SESSION['user_id'])) exit();
      mysql_select_db($_SESSION['dbname'],$local_link);
 require_once"db_connect.lib.php";
 collation();
$query="select * from `online_users` where `user_id`='".$_SESSION['user_id']."'";
$result=mysql_query($query,$local_link);
if (mysql_num_rows($result)>0) {
	$query="update `online_users` set `time`=NOW()  where `user_id`='".$_SESSION['user_id']."'";
	$result=mysql_query($query,$local_link);
	}
else {
	$query="insert into  `online_users` (`user_id`) values ('".$_SESSION['user_id']."')";
        $result=mysql_query($query,$local_link);
	}
$result=  mysql_query($query,$local_link); 
function isOnline($id) {
	$local_link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
	if (!$local_link || !isset($_SESSION['user_id'])) exit();
	mysql_select_db($_SESSION['dbname'],$local_link);
 	require_once"db_connect.lib.php";
 	collation();
	$query="select * from `online_users` where `user_id`='".$id."' and (`time` >  NOW() - INTERVAL '5' MINUTE)";

	$result=mysql_query($query,$local_link);
	if (mysql_num_rows($result)>0) return true;
	else return false;
	}
function isAFK($id) {
        $local_link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
        if (!$local_link || !isset($_SESSION['user_id'])) exit();
        mysql_select_db($_SESSION['dbname'],$local_link);
        require_once"db_connect.lib.php";
        collation();
        $query="select * from `online_users` where `user_id`='".$id."' and (`time` >  NOW() - INTERVAL '10' MINUTE)";
	$result=mysql_query($query,$local_link);
        if (mysql_num_rows($result)>0) return true;
        else return false;
        }
function lastAppear($id) {
	$local_link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
        if (!$local_link || !isset($_SESSION['user_id'])) exit();
        mysql_select_db($_SESSION['dbname'],$local_link);
        require_once"db_connect.lib.php";
        collation();
        $query="select * from `online_users` where `user_id`='".$id."'";
        $result=mysql_query($query,$local_link);
	$row=mysql_fetch_array($result);
	return $row['time'];
	}



?>
