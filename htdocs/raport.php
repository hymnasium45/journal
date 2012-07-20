<?
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
?>
<HTML>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
 <STYLE text=text/css>
 TD {height:35} 
 TH {height:40}
 </STYLE>
</HEAD>

<BODY>
<?php
class pupil {
        public $name;
        public $id;
        public $comment;
        }

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
//получаем айди класса и имя юзера
//узнаём текущую дату, день недели 
if (!$_SESSION['time']) {
        $time=getdate();
        $_SESSION['time']=$time[0];
        }

$time = getdate($_SESSION['time']);
$day= $time['mday'];
$month=$time['mon'];
$year=$time['year'];

        $query_class="select * from classes where 
	(class_id='".$_SESSION['class']."' or raporter_id='".$_SESSION['user_id']."')";
        $result_class=mysql_query($query_class,$link);
	$row_class=mysql_fetch_array($result_class);
	require_once("../includes/class.php");
	$class=getclass(-1,$row_class['year'],$row_class['letter']);
$query_raporter="select * from users where user_id='".$row_class['raporter_id']."'";
$result_raporter=mysql_query($query_raporter,$link);
$row_raporter=mysql_fetch_array($result_raporter);
$query_raport="select * from raport where (class_id='".$row_class['class_id']."' and
               Day='".$day."' and Month='".$month."' and `Year`='".$year."')";
$result_raport=mysql_query($query_raport,$link);
$num=mysql_num_rows($result_raport);
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
        }
require_once("../includes/sort.php");
mysort_string('pupil','name','max',$pupils,$count_ill);

echo "
 <FORM method='POST' class='form_settings'>
 <TABLE ALIGN='CENTER'>
  <TR> 
   <TD> <STRONG>Дата ".$day.".".$month.".".$year." </STRONG><BR>
    Изменить дату 
    <INPUT TYPE='SUBMIT' class='submit' id='min' NAME='Last' VALUE='<' >
     <INPUT TYPE='SUBMIT'class='submit' id='min'  NAME='Next' VALUE='>'>
   Выберите дату: 
   <SELECT NAME='Day'>";

    for ($i=1; $i<=31; $i++)
	echo"
     	  <OPTION VALUE='".$i."'> ".$i." </OPTION>";

echo"  
   </SELECT>
    <SELECT NAME='Month'>";

    for ($i=1; $i<=12; $i++)
	echo "
	  <OPTION VALUE='".$i."'> ".$i." </OPTION>";

  echo"
   </SELECT>
   <SELECT NAME='Year'> 
   <OPTION VALUE='2011'> 2011 </OPTION>
   <OPTION VALUE='2012'> 2012 </OPTION>
   </SELECT>
    <INPUT TYPE='SUBMIT' class='submit' NAME='Select' VALUE='Выбрать'> 
  <TR> 
   <TD> Рапортичка <STRONG>".$class."</STRONG> класса <BR> 
	Ответственный за рапортичку: <STRONG>".$row_raporter['Name']."</STRONG> </TD>
  </TR>
  <TR>
   <TD align='left'>
   <TABLE class='table'>
    <TR> 
     <TH width='20px'> № </TH>
     <TH width='200px'> Имя </TH>
     <TH width='300px'> Коментарий(причина) </TH>
    </TR>";
if ($num==0) echo "<TR><TD colspan=3 id='even'>Нет отсутствующих</TD></TR>";
for ($i=1; $i<= $count_ill; $i++) {
     if ($i % 2==0) $id='odd'; else $id='even';
echo "
    <TR>
     <TD id='".$id."' ALIGN=CENTER> ".$i." </TD>
     <TD id='".$id."'> ".$pupils[$i]-> name." </TD>
     <TD id='".$id."'> ".$pupils[$i]-> comment." </TD>
    </TR>";
      }
echo "  </TABLE> 
   </TD>
  </TR>
  <TR>
  <TD> <INPUT TYPE='submit'  class='submit' NAME='edit' VALUE='Редактировать'> </TD>
  </TR>
 </FORM>
 </TABLE>
";
if (isset($_POST['edit'])) {
        echo("<script>location.href='raport_add.php'</script>");
	
	}	
if (isset($_POST['Next'])) {
        $_SESSION['time']+=60*60*24;
        echo("<script>location.href='raport.php'</script>");
        }

if (isset($_POST['Last'])) {
        $_SESSION['time']-=60*60*24;
        echo("<script>location.href='raport.php'</script>");
        }
if (isset($_POST['Select'])) {

//echo  mktime(0,0,0,$_POST['Day'],$_POST['Month'],$_POST['Year']). " ".mktime(0,0,0,26,8,2010);
$_SESSION['time']=  mktime(0,0,0,$_POST['Month'],$_POST['Day'],$_POST['Year']); 
       echo("<script>location.href='raport.php'</script>");
	}

}
else echo("<script>location.href='error.php?id=1'</script>");

?> 
</div>
</div>
</BODY>

</HTML>
