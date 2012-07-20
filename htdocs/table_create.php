<?
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
require_once("../includes/class.php");
require_once("../includes/defence.lib.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
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
unset($_SESSION['table']);
if ($_SESSION['login']==1) {
class Klass {
        public $Id;
        public $Name;
        }
class Subject{
	public $Id;
	public $Name;
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
$query_class="select * from classes where 1=1";
$result_class=mysql_query($query_class,$link);
$query_subject="select * from subjects where 1=1";
$result_subject=mysql_query($query_subject,$link);
$classes=array();
$subject=array();
$count_class=0;
$count_subject=0;
while ($row_class=mysql_fetch_array($result_class)) {
        if (isclass(-1,$row_class['year'])) {
		$count_class++;
        	$classes[$count_class]=new Klass;
        	$classes[$count_class]-> Name=getclass(-1,$row_class['year'],$row_class['letter']);
        	$classes[$count_class]-> Id=$row_class['class_id'];
    		}
	}
do {
        $F=0;
        for ($i=1; $i<= $count_class-1; $i++)
        if (strnatcasecmp($classes[$i]-> Name,$classes[$i+1]-> Name)>0) {
                $S=$classes[$i]-> Id;
                $classes[$i]-> Id=$classes[$i+1]-> Id;
                $classes[$i+1]-> Id=$S;
                $S=$classes[$i]-> Name;
                $classes[$i]-> Name=$classes[$i+1]-> Name;
                $classes[$i+1]-> Name=$S;
                $F=1;
                }
        }
while ($F==1);

while ($row_subject=mysql_fetch_array($result_subject))
	{
	$count_subject++;
	$subjects[$count_subject]=new Subject;
	$subjects[$count_subject]-> Name=$row_subject['subject'];
	$subjects[$count_subject]-> Id=$row_subject['subject_id'];
	}

do {
        $F=0;
        for ($i=1; $i<= $count_subject-1; $i++)
        if (strnatcasecmp($subjects[$i]-> Name,$subjects[$i+1]-> Name)>0) {
                $S=$subjects[$i]-> Id;
                $subjects[$i]-> Id=$subjects[$i+1]-> Id;
                $subjects[$i+1]-> Id=$S;
                $S=$subjects[$i]-> Name;
                $subjects[$i]-> Name=$subjects[$i+1]-> Name;
                $subjects[$i+1]-> Name=$S;
                $F=1;
                }
        }
while ($F==1);

$today=getdate();
if ($today['mon'] <6 ) $year=$today['year']; else $year=$today['year']-1;
echo "

  <FORM METHOD='POST' class='form_settings'>
  <input type='hidden' name='check' id='check' value='true'>
  <TABLE align='center'>
  <TR> 
   <TD colspan=2> Создание журнала: </TD>
  </TR>
  <TR>
   <TD colspan=2> ".$_SESSION['error_create_class']." </TD>
  </TR>
   <TR> 
   <TD> Выберите класс: </TD>
   <TD> <SELECT NAME='Class' id='class'>
	<OPTION VALUE='no'> Не выбран </OPTION>";
for ($i=1; $i<=$count_class; $i++) 
	echo"     <OPTION VALUE='".$classes[$i]-> Id."'> ".$classes[$i]-> Name." </OPTION>";

echo   "
    </SELECT> </TD>
   </TR> 
  <TR>
   <TD> Выберите изучаемый предмет: </TD>
   <TD> <SELECT NAME='subject' id='subject'> 
        <option value='no'>Не выбран</option>";
for ($i=1; $i<= $count_subject; $i++)
	echo "<OPTION VALUE='".$subjects[$i]-> Name."'>".$subjects[$i]-> Name."</OPTION>";
echo"
 </TD>
  </TR>
  <TR>
   <TD> Свой вариант: </TD>
   <TD> <input type='text' class='text' name='my_subject' id='my_subject'> </td>
  </TR>
  <TR> 
   <TD align=right colspan=2> <INPUT TYPE='SUBMIT' class='submit' VALUE='Сохранить' NAME='Save'	onclick=\"
					this.class=getElementById('class').value;
					this.subject=getElementById('subject').value;
					this.my_subject=getElementById('my_subject').value;
					if (this.class=='no') {
						alert('Выберите класс');	
						document.getElementById('check').value='false';
						}
					if (this.subject=='no' && this.my_subject=='') {
						alert('Выберите предмет или введите свой');
						document.getElementById('check').value='false';
						}
				\"> </TD>
  </TR>
 </FORM> 
 </TABLE>";

if (isset($_POST['Save']) && $_POST['check']=='true') {

		if ($_POST['subject']=='no') {
		$mysqli= new mysqli($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
		$mysqli-> set_charset("utf8");
			$param=strtolower(makeText($_POST['my_subject']));
		
			$result= $mysqli-> query("select * from subjects where subject='".$param."'");
			if  ($result-> num_rows==0) {
				$result= $mysqli-> query("insert into `subjects` values('','".$param."')");
				}
			
			}
		$change=date("d.m.Y");
		$query_max1="SELECT group_id FROM groups  WHERE   
      			group_id = (SELECT MAX(group_id) FROM groups)";
		$result_max1=mysql_query($query_max1,$link);
		$row_max1=mysql_fetch_array($result_max1);
		$query_max3="SELECT group_id FROM old_journals  WHERE   
                        group_id = (SELECT MAX(group_id) FROM old_journals)";
                $result_max3=mysql_query($query_max3,$link);
                $row_max3=mysql_fetch_array($result_max3);
		
		$max=max($row_max1['group_id'],$row_ax3['group_id'])+1;
		if ($_POST['subject']=='no') $subject=$_POST['my_subject']; else $subject=$_POST['subject'];	
		$query_insert="insert into groups (`group_id`,`class_id`,`teacher_id`,`subject`,`year`)
				values('".$max."','".$_POST['Class']."','".$_SESSION['user_id']."',
				'".$subject."','".$year."')";
		$result_insert=mysql_query($query_insert,$link);
		$_SESSION['table']=$max;
		
		echo("<script>location.href='table_edit.php'</script>");
	}
	
}
else
       echo("<script>location.href='error.php?id=1'</script>");

?>
</div>
</div>
</BODY>
</HTML>


