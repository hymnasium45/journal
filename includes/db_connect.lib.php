<?php
session_start();
error_reporting(0);
$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);
 	  
function collation() {
	$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
	mysql_select_db($_SESSION['dbname'],$link);
	$result=mysql_query('SET CHARACTER SET utf8',$link);
	$result=mysql_query('SET NAMES utf8',$link);
	$result=mysqli_query('SET CHARACTER SET utf8',$link);
    $result=mysqli_query('SET NAMES utf8',$link);
	}
?>

