<?php
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
if ($_SESSION['login'] ==1)  {

$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);
 include "../includes/db_connect.lib.php";
 collation();
require_once("../includes/register_users.php");
require_once("../includes/class.php");
class group {
        public $klass;
        public $id;
        public $subject;
        }

$query_groups="select * from groups where teacher_id='".$_SESSION['user_id']."'";
$result_groups= mysql_query($query_groups,$link);

$groups=array();
$count=0;
while ($row_groups= mysql_fetch_array($result_groups)) {
        $count++;
        $groups[$count]= new group;
        $query_class_name="select * from classes where class_id='".$row_groups['class_id']."'";
        $result_class_name=mysql_query($query_class_name,$link);
        $row_class_name=mysql_fetch_array($result_class_name);
        $groups[$count]->klass=$row_class_name['Class'];
        $groups[$count]->id=$row_groups['group_id'];
        $groups[$count]->subject=$row_groups['subject'];
        }


$query_group_teacher="select * from users where user_id='".$_SESSION['user_id']."'";
$result_group_teacher= mysql_query($query_group_teacher,$link);
$row_group_teacher= mysql_fetch_array($result_group_teacher);
require_once("../includes/date.lib.php");
} else
        echo("<script>location.href='error.php?id=1'</script>");
?>
<html>
<head>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
</head>
<body>
 <div id='logo'> 
<?require_once("../includes/logo.php");
?> 
</div> 
<div id='main'><?
?>
<div id='leftbar'>
<?require_once "../includes/menu.php";?>
</div>
 <div id='content'>
 <table>
 <?for ($i=1; $i<=6; $i++) {
	$day=getDay($i);
	echo "
	 <tr>
          <td> ".$day."</td>
         </tr>
         <tr>
          <td> <table class='table'>
	    <tr>
             <th width='20px'> № </th>
	     <th width='300px'> Предемет </th>
	     <th width='200px'> Класс </th>";
	for ($j=1; $j<= 8; $j++) {
		if ($j % 2==0) $type='odd'; else $type='even';
 		$query_lesson="select * from `schedule` where `teacher_id`='".$_SESSION['user_id']."' and 
			        `day`='".$i."' and `number`='".$j."'";
		$result_lesson=mysql_query($query_lesson,$link);
		$num_lesson=mysql_num_rows($result_lesson);
	//	echo $query_lesson;
		if ($num_lesson==0) 
			echo "
			   <tr> 
			     <td align='center' id='".$type."'>".$j.".</td> 
			     <td id='".$type."'>окно </td> 
			     <td id='".$type."'></td>"; 
		else 
		echo "<tr> <td rowspan=".$num_lesson." align='center' id='".$type."'> ".$j.".</td>";
		$z=0;
		while ($row_lesson=mysql_fetch_array($result_lesson)) {
			$z++;
			$query_subject="select * from `groups` where `group_id`='".$row_lesson['group_id']."'";
			$result_subject=mysql_query($query_subject,$link);
			$row_subject=mysql_fetch_array($result_subject);
                        $query_class="select * from `classes` where `class_id`='".$row_subject['class_id']."'";
                        $result_class=mysql_query($query_class,$link);
                        $row_class=mysql_fetch_array($result_class);
			$class_name=getclass(-1,$row_class['year'],$row_class['letter']);
		
			if ($z>1) echo "<tr>";
			echo" 
			     <td id='".$type."'>".$row_subject['subject']."</td>
			     <td id='".$type."'>".$class_name."</td>";
			} 
		}
	echo "</table></td></tr>";
	}?>
 </table>
 </div>
</div>
</body>
</html>
