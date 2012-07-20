<?session_start();
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

$teacher_id=intval($_SESSION['user_id']);
require_once("../includes/error_page.php");
require_once("../user/includes/user.lib.php");

if (!isTeacher($teacher_id)) {
	makeError("Редактировать группы могут только учителя. Для получения доступа обратитесь к администрации школы.");
	die();
	}
if (!isset($_SESSION['table'])) {
	makeError("Необходимо выбрать группу для редактирования, пройдите по данной <a href='greet.php'>ссылке</a> ");
	die();
	} 
?>
<HTML>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
 <STYLE type=text/css> 
   TH {height:50} 
   TD {height:40}
 </STYLE>


</HEAD>

<BODY>
<?php


class Pupil {
        public $Id;
        public $Name;
        }

//коннектимся к базе данных
echo "
  <div id='logo'> 
";require_once("../includes/logo.php");

echo" 
</div> 
<div id='main'>";

echo"
<div id='leftbar'>"
;
require_once "../includes/menu.php";
echo "
        </div>
        <div id='content'>
        ";
	$query_group="select * from groups where group_id='".$_SESSION['table']."'";
	$result_group=mysql_query($query_group,$link);
	$row_group=mysql_fetch_array($result_group);
$query_users="select * from group_users where group_id='".$_SESSION['table']."'";
$result_users=mysql_query($query_users,$link);
        $query_class="select * from classes where class_id='".$_SESSION['class']."'";
        $result_class=mysql_query($query_class,$link);
        $row_class=mysql_fetch_array($result_class);
require_once ("../includes/class.php");
$Class=getclass(-1,$row_class['year'],$row_class['letter']);

$head_color='#999999';
$light_grey='#DDDDDD';
$dark_grey='#BEBEBE';
$count=0;
$pupils=array();
while ($row_users=mysql_fetch_array($result_users)) {
        $count++;
        $query_user_name="select * from users where user_id='".$row_users['user_id']."'";
        $result_user_name=mysql_query($query_user_name,$link);
        $row_user_name=mysql_fetch_array($result_user_name);
        $pupils[$count]=new Pupil;
        $pupils[$count]-> Name=$row_user_name['Name'];
        $pupils[$count]-> Id=$row_users['user_id'];
        }
do {
	$F=0;
	for ($i=1; $i<=$count-1; $i++) {
                $name1=$pupils[$i]-> Name;
                $name2=$pupils[$i+1]-> Name;
                $num=0;
                $length=strlen($name1)-1;

                while (ord($name1[$num])==ord($name2[$num])&& $num<$length) $num++;
                if (ord($name1[$num])>ord($name2[$num])) {
                        $Id= $pupils[$i+1]-> Id;
                        $pupils[$i+1]-> Id =$pupils[$i]-> Id;
                        $pupils[$i]-> Id=$Id;
                        $pupils[$i]-> Name=$name2;
                        $pupils[$i+1]-> Name=$name1;
                        $F=1;
                        }
                }
        }
while ($F==1);
echo "
<FORM method='post' class='form_settings'>
<TABLE ALIGN='CENTER' >
 <TR>
  <TD> 
   Список группы:<BR>
  </TD> 
    <TD rowspan='3' width='50'>&#160 </TD>
    <TD> 
   Список ".$Class." класса:<BR> 
   (не состоят в группе) 
 </TD>
 <TD>
  </TD>
   </TR>
    <TR>
     <TD valign=top rowspan=2>
     <TABLE class='table'>
    <TR>
     <TH width='25px' id='".$id."'> № </TH> 
      <TH width=250px  id='".$id."'>
       Имя Фамилия 
      </TH> 
     </TR>
    ";
if ($count==0) echo "<TR> <TD> В группе нет учеников </TD> </TR>";
for ($i=1; $i<=$count; $i++) {
	if ($i % 2==0) $id='odd'; else $id='even';

echo "
     <TR>
      <TD id='".$id."' align=center>
       ".$i."
      </TD>
      <TD id='".$id."'>
       ".$pupils[$i]-> Name."
      </TD>
     </TR>";
	}

echo "
  </TABLE>
   </TD>
 </FORM>
   <TD valign=top colspan=2>
     <TABLE align=top class='table'>
      <TR>
       <TH width='250px'> Имя ученика </TH>
      </TR>
     ";
    
$query_add_user_id="select * from class_users where class_id='".$_SESSION['class']."'";
$result_add_user_id=mysql_query($query_add_user_id,$link);

$count_add=0;
$pupils_add=array();
while ($row_users_add=mysql_fetch_array($result_add_user_id)) {
        $query_inGroup="select * from `group_users` where `user_id`='".$row_users_add['user_id']."' and 
			`group_id`='".$_SESSION['table']."'";
	$result_inGroup=mysql_query($query_inGroup,$link);
	if (mysql_num_rows($result_inGroup)==0) {
	
	$count_add++;
        $query_user_name="select * from users where user_id='".$row_users_add['user_id']."'";
        $result_user_name=mysql_query($query_user_name,$link);
        $row_user_name=mysql_fetch_array($result_user_name);
        $pupils_add[$count_add]=new Pupil;
        $pupils_add[$count_add]-> Name=$row_user_name['Name'];
        $pupils_add[$count_add]-> Id=$row_users_add['user_id'];
        }
	}

do {
        $F=0;
        for ($i=1; $i<=$count_add-1; $i++) {
                $name1=$pupils_add[$i]-> Name;
                $name2=$pupils_add[$i+1]-> Name;
                $num=0;
                $length=strlen($name1)-1;

                while (ord($name1[$num])==ord($name2[$num])&& $num<$length) $num++;
                if (ord($name1[$num])>ord($name2[$num])) {
                        $Id= $pupils_add[$i+1]-> Id;
                        $pupils_add[$i+1]-> Id =$pupils_add[$i]-> Id;
                        $pupils_add[$i]-> Id=$Id;
                        $pupils_add[$i]-> Name=$name2;
                        $pupils_add[$i+1]-> Name=$name1;
                        $F=1;
                        }
                }
        }
while ($F==1);

if ($count_add==0 && $count==0) echo "<TR> <TD class='error'> В классе нет учеников </TD> </TR>";
if ($count_add==0 && $count>0) echo "<TR> <TD class='error'> Все ученики класса состоят в группе </TD> </TR>";


for ($i=1; $i<= $count_add; $i++) {
	if ($i % 2==1) $id='even'; else $id='odd';

	echo "
         <TR> 
	  <TD id='".$id."'>
          <INPUT TYPE='CHECKBOX' class='checkbox' id=".$i." value='".$pupils_add[$i]-> Id."' name=".$i.">
		".$pupils_add[$i]-> Name."
          </TD> 
        </TR>";	
       }
echo" 
   </TR>
   </TABLE>
   <TR>
    <td align='left'>
    <input type='hidden' id='count' name='count' value='".$count_add."'> 
    <input type='checkbox'  value='yes' name='check' id='check'
    onclick=\"
	this.num=getElementById('count').value;
	for (var i=1; i<=this.num; i++) {
		getElementById(i).checked=getElementById('check').checked; 
		}
	\"> Выделить всех 
    </td>	 
    <TD align='right'> 
    <INPUT TYPE='SUBMIT' class='submit' VALUE='Добавить' NAME='insert'>
    </TD>
   </TR>

</TABLE>";
if (isset($_POST['insert'])) {
        for ($j=1; $j<=$i; $j++)
	if (isset($j) && $_POST[$j]!='') {
		$query_insert="insert into group_users values ('".$_SESSION['table']."','".$_POST[$j]."')";
		$result_insert=mysql_query($query_insert,$link);		
		}	
	echo("<script>location.href='table_edit.php'</script>");
	}

?>
</div>
</div>
</BODY>
</HTML>

