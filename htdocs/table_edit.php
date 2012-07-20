<?
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");

if ($_SESSION['login']!=1) {
	echo("<script>location.href='error.php?id=1'</script>");
	die();
	}
$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);
 include "../includes/db_connect.lib.php";
 collation();

require_once("../user/includes/user.lib.php");
$teacher_id=intval($_SESSION['user_id']);
require_once("../includes/error_page.php");


if (!isTeacher($teacher_id)) {
	makeError("Редактировать группы могут только учителя. Для получения доступа обратитесь к администрации школы.");
	die();
	}
if (!isset($_SESSION['table'])) {
	makeError("Необходимо выбрать группу для редактирования, пройдите по данной <a href='greet.php'>ссылке</a> ");
	die();
	} 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
</HEAD>

<BODY>
<?php



class Pupil {
        public $Id;
        public $Name;
        public $avatar;
        public $admin=false;
        }

//коннектимся к базе данных
require_once("../includes/register_users.php");
$group_id=intval($_SESSION['table']);
echo "
  <div id='logo'> 
";

require_once("../includes/logo.php");
echo" 
</div> 
<div id='main'>
<div id='leftbar'>";
require_once "../includes/menu.php";
echo "
        </div>
        <div id='rightbar'>
         <div id='sidebar'>
         <div class='box'>
          <div class='form_settings'>
          <form method='post'>
          <INPUT TYPE='SUBMIT' class='submit' VALUE='Добавить ученика' NAME='insert_value'> 
          </form>          
          </div>         
         </div>
        </div>
        </div>
        <div id='small_content'>
        ";
	$query_group="select * from groups where group_id='".$_SESSION['table']."'";
	$result_group=mysql_query($query_group,$link);
	$row_group=mysql_fetch_array($result_group);
	$_SESSION['class']=$row_group['class_id'];
$query_class="select * from `classes` where `class_id`='".$_SESSION['class']."'";
$result_class=mysql_query($query_class,$link);
$row_class=mysql_fetch_array($result_class);
require_once("../includes/class.php");
$class=getclass(-1,$row_class['year'],$row_class['letter']);
$query_users="select * from group_users where group_id='".$_SESSION['table']."'";
$result_users=mysql_query($query_users,$link);
$num_users=mysql_num_rows($result_users);
$count=0;
$pupils=array();
while ($row_users=mysql_fetch_array($result_users)) {
        $count++;
        $query_user_name="select * from users where user_id='".$row_users['user_id']."'";
        $result_user_name=mysql_query($query_user_name,$link);
        $row_name=mysql_fetch_array($result_user_name);
        $pupils[$count]=new Pupil;
        $pupils[$count]-> Name=$row_name['Name'];
        $pupils[$count]-> Id=$row_users['user_id'];
         if (file_exists("../avatars/".$row_name['avatar']) && $row_name['avatar']!='') {
			require_once("../includes/images.lib.php");
			$size=makePost("../avatars/".$row_name['avatar']);
			$img="<a href='profile.php?id=".$row_name['user_id']."'>
			<img src='../avatars/".$row_name['avatar']."' width='".$size[0]."' height='".$size[1]."' > </a>";
			}
        else
            $img="<img src='../avatars/noavatar.gif' class='post_image'>";
		$pupils[$count]-> avatar=$img;
		$query="select * from group_admins where user_id='".$row_users['user_id']."' and group_id='".$group_id."'";
		$result=mysql_query($query,$link);
		if (mysql_num_rows($result)>0) {
			$pupils[$count]-> admin=true;
			}
        }
$query_sched="select * from `schedule` where `group_id`='".$row_group['group_id']."' order by `day`";
$result_sched=mysql_query($query_sched,$link);
$num_sched=mysql_num_rows($result_sched);
$days=array('Понедельник','Вторник','Среда','Четверг','Пятница', 'Суббота');

$head_color='#999999';
$light_grey='#DDDDDD';
$dark_grey='#BEBEBE';
echo "
<FORM method='post' class='form_settings'>
<TABLE align='center'> 
 <TR> <TD valign='top'> <TABLE frame='box' bgcolor='F0F0F0'>
	<TR> <TH align='left' colspan=2 height='40'> Информация о группе </TH></TR>
	<TR> 
	 <TD height='30' width='200px'> Класс </TD> 
	 <TH align='left' width='150px'> ".$class."</TH> 
	</TR>
	<TR> <TD height='30'> Изучаемый предмет </TD> <TH align='left'> ".$row_group['subject']."</TH> </TR>
	</TABLE>
	</td>
	<td style='padding-left:20px;'>
<TABLE class='table' >
<TR>
 <TH colspan='3' align='left'> Расписание: </TH>
</TR>";
$count_sched=0;
$sched_id=array();
if ($num_sched==0) echo "<TR> <TD height='50px' colspan='3'> Расписание не установлено </TD </TR>";
while ($row_sched=mysql_fetch_array($result_sched)) {
	$count_sched++;
	if ($count_sched % 2>0) $style='odd'; else $style='even';
	$sched_id[$count_sched]=$row_sched['sched_id'];
        $delete='delete_sched'.$count_sched;
	$adding='';
	if ($row_sched['number']==1 || $row_sched['number']==4 || $row_sched['number']==5) $adding='-ый';
	if ($row_sched['number']==2 || $row_sched['number']==6 || $row_sched['number']==7 || $row_sched['number']==8) 
		$adding='-ой';
	if ($row_sched['number']==3) $adding='-ий';
        echo "
<TR> 
 <TD id='".$style."' width='150px'><B>".$days[$row_sched['day']-1]."</B></TD>
 <TD id='".$style."'><B>".$row_sched['number']."</B>".$adding." урок </TD>
 <TD id='".$style."'>    
                <BUTTON TYPE ='SUBMIT' class='delete' NAME='".$delete."'>
                </TD>
        </TR>";
        }
echo "
<TR>
<TH colspan='3' align='left'> Добавить: </TH>

</TR>
<TR> <TD> <SELECT NAME='day'>";
for ($i=1; $i<=6; $i++) echo "<OPTION value='".$i."'>".$days[$i-1]."</OPTION>";
echo "
</SELECT> </TD>
<TD> <SELECT NAME='number'>";
for ($i=1; $i<=8; $i++) echo "<OPTION value='".$i."'>".$i."</OPTION>";

echo "</SELECT></TD>
  <TD>    
                <BUTTON type='submit' class='choose' NAME='insert_sched'>
                </TD>

<TD> </TR> </TABLE>";

echo "
</tr>
<tr>
<TD colspan=2 valign='top' style='padding-left:40px'>
<TABLE ALIGN='CENTER' >
 <TR>
  <TD> 
   <h1>Список группы:<h1> 
  </TD>
 </TR>
  <TR>
   <TD>
    <TABLE >
  ";
if ($num_users==0) echo "<TR> <TD id='even' colspan=3>В группе нет учеников</TD></TR>";
for ($i=1; $i<= $count; $i++) {
      $delete='delete'.$i;
      $make='make'.$i;
      $unmake='unmake'.$i;
        echo "
     <TR>
     <td rowspan=3 align='center' class='post_image' valign='top'>".$pupils[$i]-> avatar."</td>
      <TD>
       <a href='profile.php?id=".$pupils[$i]-> Id."'> ".$pupils[$i]-> Name." </a>
      </TD>
      </tr>
      <tr>
       <TD>                    
       <input type='submit' class='simple' NAME='".$delete."' value='Удалить'>
       </TD>
      </tr>
      <tr>
       <td>";
       if ($pupils[$i]-> admin) echo "<input type='submit' class='simple' NAME='".$unmake."' value='Удалить из администраторов'>";
       else echo "<input type='submit' class='simple' NAME='".$make."' value='Сделать администротором'>";
       
       echo "</td>
      </tr>
      </TR>";
	}
echo "
  </TABLE>
   </TD>
 </TR>
</TABLE></FORM>";

if (isset($_POST['insert_value'])) {
	echo("<script>location.href='table_edit_add_user.php'</script>");
	}
for ($i=1; $i<=$count_sched; $i++) {
	$delete='delete_sched'.$i;
	if (isset($_POST[$delete])) {
		$query_delete="delete from `schedule` where `sched_id`='".$sched_id[$i]."'";
		$result_delete=mysql_query($query_delete,$link);
		echo("<script>location.href='table_edit.php'</script>");
		}
	}
for ($i=1; $i<=$count; $i++) {
	$delete='delete'.$i;
    $make='make'.$i;
    $unmake='unmake'.$i;
    if (isset($_POST[$delete])) {
		$query_delete="delete from group_users where 
		(group_id='".$group_id."' and user_id='".$pupils[$i]-> Id."')";
      	        $result_delete=mysql_query($query_delete,$link);
		echo("<script>location.href='table_edit.php'</script>");
		}
 	if (isset($_POST[$make])) {
		$query=" insert into group_admins(`group_id`,`user_id`) values ('".$group_id."','".$pupils[$i]-> Id."')";
		//echo $query;
		$result=mysql_query($query,$link);
		echo("<script>location.href='table_edit.php'</script>");
		}
	if (isset($_POST[$unmake])) {
		$query="delete from group_admins where group_id='".$group_id."' and user_id='".$pupils[$i]-> Id."'";
		//echo $query;
		$result=mysql_query($query,$link);
		echo("<script>location.href='table_edit.php'</script>");
		
		}

	}	
if (isset($_POST['insert_sched'])) {
	$query_max='select `sched_id` from `schedule` where `sched_id`=(select MAX(`sched_id`) from `schedule`)';
	$result_max=mysql_query($query_max,$link);
	$row_max=mysql_fetch_array($result_max);
	$max=$row_max['sched_id']+1;
	$query="insert into `schedule` values('".$max."','".$_SESSION['user_id']."','".$row_group['group_id']."',
		'".$_POST['day']."','".$_POST['number']."')";
	$result=mysql_query($query,$link);
	echo("<script>location.href='table_edit.php'</script>");

	}	

?>
</div>
</div>
</BODY>
</HTML>

