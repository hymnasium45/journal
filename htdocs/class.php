<?session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
$_SESSION['location']='class.php';
require_once("../includes/class.php");
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
class Klass {
	public $Id;
	public $Klass;
	public $club;
	}
if ($_SESSION['login']==1) {

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
$query_teacher = "select * from users where user_id='".$_SESSION['user_id']."'";
$result_teacher = mysql_query ($query_teacher,$link);
$row_teacher = mysql_fetch_array($result_teacher);
$query_classes= "select * from classes where teacher_id='".$_SESSION['user_id']."'";
$result_classes= mysql_query($query_classes,$link);
$Num_classes=mysql_num_rows($result_classes);
$classes=array();
$count_class=0;
while ($row_classes=mysql_fetch_array($result_classes)) {
	if (isclass(-1,$row_classes['year'])) {
		$count_class++;
		$classes[$count_class]=new Klass;
		$classes[$count_class]-> Id = $row_classes['class_id'];
        $classes[$count_class]-> club=$row_classes['club_id'];
        
        $classes[$count_class]-> Klass = getclass(-1,$row_classes['year'],$row_classes['letter']);
		}
	}
	
?>

<FORM method='post' class='form_settings'>
<TABLE align='center'>
 <TR>
  <TD height='60' width='400'> <INPUT TYPE='SUBMIT' class='submit' NAME='create' VALUE='Создать класс'> </TD>
 </TR>
<?
if ($Num_classes==0) echo " У Вас нет классов"; else 
for ($i=1; $i<= $count_class; $i++) {
	$edit='edit'.$i;
	$journal='journal'.$i;
	$club='club'.$i;
	$raport='raport'.$i;
	echo "
		<TR>
		 <TD width='400'> 
		  <TABLE >
		   <TR>
		    <TD width='340' height='80'>".$classes[$i]-> Klass." класс </TD>
		      <td><BUTTON TYPE ='SUBMIT' class='edit' ' title='редактировать' NAME='".$edit."'>  
               	      </TD>
		   </tr>
		  </TABLE>
		 </TD>	
		</TR>
		<TR>
		 <TD>
		  <TABLE>
		   <TD height='60' width='100' align='center'> 
			<INPUT TYPE ='SUBMIT' class='submit' VALUE='Журнал' NAME='".$journal."'></TD>
		   <TD height='60' width='100' align='center'> 
			<INPUT TYPE ='SUBMIT' class='submit' VALUE='Клуб' NAME='".$club."'> </TD>
		   <TD height='60' width='100' align='center'> 
			<INPUT TYPE ='SUBMIT' class='submit' VALUE='Рапортичка' NAME='".$raport."'> 
			</TD> 
		  </TABLE>
		 </TD>
		</TR>";
	}
if (isset($_POST['create'])) {
	echo("<script>location.href='class_create.php'</script>");
        
	}
for ($i=1; $i<= $count_class; $i++) {
        $edit='edit'.$i;
        $journal='journal'.$i;
        $club='club'.$i;
        $raport='raport'.$i;
	if (isset($_POST[$edit])) {
		$_SESSION['class']= $classes[$i]-> Id;
                echo("<script>location.href='class_edit.php'</script>");
                }
        if (isset($_POST[$journal])) {
                $_SESSION['class']= $classes[$i]-> Id;
                echo("<script>location.href='class_greet.php'</script>");
                }
        if (isset($_POST[$club])) {
                echo("<script>location.href='club.php?club_id=".$classes[$i]->club."'</script>");
                }
        if (isset($_POST[$raport])) {
                $_SESSION['class']= $classes[$i]-> Id;
                echo("<script>location.href='raport.php'</script>");
                }
	}
	}
else
        echo("<script>location.href='error.php?id=1'</script>");

?>
</div>
</div>
</BODY>
</HTML>


