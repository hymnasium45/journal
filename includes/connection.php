<?
session_start();
error_reporting(0);
$_SESSION['server']='localhost';
$_SESSION['username']='root';
$_SESSION['password']='sasham';
$_SESSION['dbname']='ag45';

$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);
if (!$link) 
	echo "Ошибка. Не удалось подключиться к базе данных.";

require_once ("db_connect.lib.php");
collation();

?>
