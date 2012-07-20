<?
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
?>
<HTML>

<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
</HEAD>

<BODY>
<?php
$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);
 include "../includes/db_connect.lib.php";
 collation();
require_once("../includes/register_users.php");
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
      // проверяем логин и пароль

if ($_SESSION['login'] == 1) {
class pupil {
	public $name;
	public $id;
	public $comment;
	public $raport;	
	}
//получаем айди класса и имя юзера
        $query_class="select * from classes where 
        (class_id='".$_SESSION['class']."' or raporter_id='".$_SESSION['user_id']."')";
        $result_class=mysql_query($query_class,$link);
        $row_class=mysql_fetch_array($result_class);
	require_once("../includes/class.php");
	$class=getclass(-1,$row_class['year'],$row_class['letter']);
$query_raporter="select * from users where user_id='".$row_class['raporter_id']."'";
$result_raporter=mysql_query($query_raporter,$link);
$row_raporter=mysql_fetch_array($result_raporter);

$time=getdate($_SESSION['time']);
$day= $time['mday'];
$month=$time['mon'];
$year=$time['year'];

$query_raport="select * from raport where (class_id='".$row_class['class_id']."' and
               Day='".$day."' and Month='".$month."' and Year='".$year."')";

$result_raport=mysql_query($query_raport,$link);
$count_ill=0;
$pupils=array();
while ($row_raport=mysql_fetch_array($result_raport)) {
        $count_ill++;
        $query_ill_user="select * from users where user_id='".$row_raport['user_id']."'";
        $result_ill_user=mysql_query($query_ill_user,$link);
        $row_ill_user=mysql_fetch_array($result_ill_user);
	$pupils[$count_ill]= new pupil;
        $pupils[$count_ill]-> id=$row_ill_user['user_id'];
        $pupils[$count_ill]-> name=$row_ill_user['Name'];
	$pupils[$count_ill]-> comment=$row_raport['Comment'];
	$pupils[$count_ill]-> raport= $row_raport['raport_id'];
	}
require_once("../includes/sort.php");
mysort_string('pupil','name','max',$pupils,$count_ill);
$query_class_users="select * from class_users where class_id='".$row_class['class_id']."'";
$result_class_users=mysql_query($query_class_users,$link);
$users=array();
$count_user=0;
while ($row_class_users=mysql_fetch_array($result_class_users)) {
	$count_user++;
	$query_user="select * from users where user_id='".$row_class_users['user_id']."'";
        $result_user=mysql_query($query_user,$link);
        $row_user=mysql_fetch_array($result_user);
	$users[$count_user]=new pupil;
	$users[$count_user]-> id=$row_user['user_id'];
        $users[$count_user]-> name=$row_user['Name'];
	}
require_once("../includes/sort.php");
mysort_string('pupil','name','max',$users,$count_user);
echo "
 <FORM method='POST' class='form_settings'>
 <TABLE ALIGN='CENTER'>
  <TR> 
   <TD colspan=2> <STRONG>Дата ".$day.".".$month.".".$year."</STRONG> </TD>
  </TR>
  <TR> 
   <TD colspan=2> Рапортичка <STRONG>".$class." </STRONG> класса <BR> 
                  Ответственный за рапортичку: <STRONG>".$row_raporter['Name']."</STRONG> </TD>
  </TR>
  <TR>
   <TD colspan=2>
  <TABLE class='table'>
    <TR> 
     <TH width='20px'> № </TH>
     <TH width='200px'> Имя </TH>
     <TH width='300px'> Коментарий(причина) </TH>
     <TH ></TH>
    </TR>";
for ($i=1; $i<= $count_ill; $i++ ) {
if ($i % 2 ==0) $id='odd'; else $id='even';
$delete='delete'.$i;
$comment='comment'.$i;
echo "
    <TR>
     <TD id='".$id."' ALIGN=CENTER>". $i ."</TD>
     <TD id='".$id."'> ".$pupils[$i]-> name." </TD>
     <TD id='".$id."'><INPUT type='text' class='text' NAME='".$comment."' value=' ".$pupils[$i]-> comment."' style='width:300px'> </TD>
     <TD id='".$id."'><BUTTON type='submit' NAME='".$delete."' class='delete' ></TD>
    </TR>";
}
$i=$count_ill+1;	
echo "
   <TR>
    <TD id='even' align='center'> ".$i." </TD>

    <TD id='even'> <SELECT style='width:200px' NAME='User'>
		   <OPTION VALUE='0'> Не выбрано </OPTION>";
for ($i=1; $i<= $count_user; $i++)
	echo	"  <OPTION VALUE='".$users[$i]-> id."'>".$users[$i]-> name."</OPTION>";
echo "   
  </SELECT>
  <TD id='even' colspan=2>
   <INPUT style='width:330px' TYPE='TEXT' class='text'NAME='Comment'>
  </TD>
  </TABLE> 
   </TD>
  </TR>
  <TR> 
   <TD align=left> <INPUT TYPE='SUBMIT' class='submit' VALUE='Добавить' NAME='Add'> </TD>
   <TD align=right> <INPUT TYPE='SUBMIT' class='submit' VALUE='Cохранить' NAME='Save'> </TD>
   </FORM>	
  </TR>
 </TABLE>";
require_once("../includes/defence.lib.php");       
for ($i=1; $i<=$count_ill; $i++) {
	$delete='delete'.$i;
	$comment='comment'.$i;
	if (isset($_POST[$delete])) {
		$query_del="delete from `raport` where `raport_id`='".$pupils[$i]-> raport."'";
		echo $query_del;	
		$result_del=mysql_query($query_del,$link);
		echo("<script>location.href='raport_add.php'</script>");
		}
	}
if (isset($_POST['Add']) && $_POST['User']!=0) {
	$true_comment=makeText($_POST['Comment']);
	$query_add="insert into raport (`class_id`,`user_id`,`Comment`,`Day`,`Month`,`Year`) values
(".$row_class['class_id'].",".$_POST['User'].",'".$true_comment."',".$day.",".$month.",'".$year."')";
	$result_add=mysql_query($query_add,$link);
	echo("<script>location.href='raport_add.php'</script>");
	}
if (isset($_POST['Save'])) {
	for ($i=1; $i<=$count_ill; $i++) {
		$comment='comment'.$i;
		$true_comment=makeText($_POST[$comment]);
		$query_add="update `raport` set `comment`='".$true_comment."' where `raport_id`='".$pupils[$i]-> raport."'";
		$result_add=mysql_query($query_add,$link);
		}
        $query_add="insert into raport values 
('',".$row_class['class_id'].",".$_POST['User'].",'".$_POST['Comment']."',".$day.",".$month.",'".$year."')";
		//echo $query_add;
	if ($_POST['User']!=0)
        $result_add=mysql_query($query_add,$link);
        echo("<script>location.href='raport.php'</script>");

        }

}
else 
	echo("<script>location.href='error.php?id=1'</script>");

?>
</div>
</div>
</BODY>
</HTML>
