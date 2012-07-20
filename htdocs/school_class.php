<?session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  


</HEAD>

<?php
if ($_SESSION['login']==1 && $_SESSION['access']<=567)
{
class Klass {
        public $Id;
        public $Name;
        public $Teacher;
	public $Teacher_id;
       }
if (!($_SESSION['sort'])) $_SESSION['sort']='Change'; //сортировка по дате посл. изм  
if (!($_SESSION['order'])) $_SESSION['order']='Max';

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
echo "<TABLE align='center'>
       <FORM METHOD='POST' ID='TABLE'>
       <TR>
        <TD align=center> <a href='school_table_create.php'> Создать журнал </a> </TD>
        <TD align=center> <a href='school_table_del.php'> Удалённые журналы</a> </TD>   
       </TR>
       <TR>
	<TD colspan=2> Здраствуйте, ".$row_teacher['Name']."!<BR> Сегодня ".date("d.m.Y")."<BR> Выберите журнал: <BR></TD>
       </TR>";
$query_class = "select * from classes";
$result_class = mysql_query($query_class, $link);
$count=0;
$classes=array();
while ( $row_class = mysql_fetch_array($result_class)) {
        $count++;
        $query_teacher="select * from users where user_id='".$row_class['teacher_id']."'";
        $result_teacher=mysql_query($query_teacher,$link);
        $row_teacher=mysql_fetch_array($result_teacher);
        $classes[$count]= new Klass;
	$classes[$count]-> Id= $row_class['class_id'];
 	$classes[$count]-> Name= $row_class['Class'];
        $classes[$count]-> Teacher=$row_teacher['Name'];
  	$classes[$count]-> Teacher_id=$row_class['teacher_id'];
      }

do
{
$F=1;
for ($i=1; $i<= $count-1; $i++) {
        if (($_SESSION['sort']=='Name' && $_SESSION['order']=='Max'
                && strnatcasecmp($classes[$i]-> Name,$classes[$i+1]-> Name)>0) ||
        ($_SESSION['sort']=='Name' && $_SESSION['order']=='Min'
              && strnatcasecmp($classes[$i]-> Name,$classes[$i+1]-> Name)<0) ||
        ($_SESSION['sort']=='Teacher' && $_SESSION['order']=='Max'
                && strnatcasecmp($classes[$i]-> Teacher,$classes[$i+1]-> Teacher)>0) ||
        ($_SESSION['sort']=='Teacher' && $_SESSION['order']=='Min'
                && strnatcasecmp($classes[$i]-> Teacher, $classes[$i+1]-> Teacher)<0)) {

               $S=$classes[$i]-> Id;
                $classes[$i]-> Id= $classes[$i+1]-> Id;
                $classes[$i+1]-> Id=$S;
                $S=$classes[$i]-> Name;
                $classes[$i]-> Name= $classes[$i+1]-> Name;
                $classes[$i+1]-> Name=$S;
                $S=$classes[$i]-> Teacher_id;
                $classes[$i]-> Teacher_id= $classes[$i+1]-> Teacher_id;
                $classes[$i+1]-> Teacher_id=$S;
		$S=$classes[$i]-> Teacher;
                $classes[$i]-> Teacher= $classes[$i+1]-> Teacher;
                $classes[$i+1]-> Teacher=$S;
                $F=0;
                }
        }
}
while ($F==0);
//сортировка журналов



$head_color='#999999';
$light_grey='#DDDDDD';
$dark_grey='#BEBEBE';

echo "
       	<TR>
	<TD colspan=2>
	 <table align='center'> 
        <FORM METHOD='POST' ID='TABLE'>
	<TR>       
          <TD colspan=8> Cортировать по <SELECT NAME='Option'>
                <OPTION VALUE='Teacher'> имени учителя </OPTION>
                <OPTION VALUE='Change'> дате посл. изм </OPTION>
                <OPTION VALUE='Year'> уч. году </OPTION>
                <OPTION VALUE='Subject'> предмету </OPTION>
                </SELECT>
              в порядке <SELECT NAME='Order'>
                <OPTION VALUE='Max'> возрастания </OPTION>
                <OPTION VALUE='Min'> убывания </OPTION>
                </SELECT>
             <INPUT TYPE='SUBMIT' NAME='Sort' Value='сортировать'>
         </TD>
        </TR>
   <tr> 
          <th bgcolor=$head_color colspan=3> </th> 
	  <th bgcolor=$head_color> <font size='4' color=black> Класс </font></th>
          <th bgcolor=$head_color> <font size='4' color = black> Учитель </font></th> 
	  <input  type='hidden' name='hidden' id='hidden'/>
                </tr>";

for ($i=1; $i<=$count; $i++) {
        if ($i % 2==0) $color=$dark_grey; else $color=$light_grey;
        $year=$classes[$i]-> Year+1;
       $select=$i.'select';
        $edit=$i.'edit';
        $delete=$i.'delete';

echo "
        <TR>
             <TD bgcolor=$color>                    
                <BUTTON TYPE='SUBMIT' NAME='$delete' FORM='TABLE'
        onclick=\"if (confirm('Вы точно хотите удалить журнал?')) 
        {getElementById('hidden').value='yes'} 
        else {getElementById('hidden').value='no';} \">  
        <IMG SRC='../images/delete.aspx.gif' alt='удалить журнал'> 
                </BUTTON>
                </TD> 

        <TD bgcolor=$color>    
        <BUTTON TYPE ='SUBMIT' FORM='TABLE' NAME='$edit'>  
        <IMG SRC='../images/edit.png' alt='редактировить журнал'> 
        </BUTTON>
        </TD>
 
                <TD bgcolor=$color>    
                <BUTTON TYPE ='SUBMIT' FORM='TABLE' NAME='$select'>
                <IMG SRC='../images/select.jpg'> 
                </BUTTON>
                </TD>
	<td bgcolor=$color> <font size='3' color= black > ".$classes[$i]-> Name ."</font></td>
        <td bgcolor=$color> <font size='3' color= black > " . $classes[$i]-> Teacher ."</font></td>
        </TR>";

   }
echo "</TD></TR> </form></table></TABLE>";
if (isset($_POST['Sort'])) {
        $_SESSION['sort']=$_POST['Option'];
        $_SESSION['order']=$_POST['Order'];
        echo("<script>location.href='school_greet.php'</script>");
        }

//проверяем , какую группу выбрал пользователь
for ($i=1; $i<= $count; $i++) {
        $select=$i.'select';
        $edit=$i.'edit';
        $delete=$i.'delete';
        if (isset($_POST[$select])) {
                $_SESSION['table']= $classes[$i]-> Id;
                $_SESSION['page']=1;
                echo("<script>location.href='school_school_view.php'</script>");
                }
        if (isset($_POST[$delete]) && $_POST['hidden']=='yes') {
                $query_group = "select * from groups where group_id='".$classes[$i]-> Id."'";
                $result_group = mysql_query ($query_group,$link);
                $row_group= mysql_fetch_array($result_group);
                $query_create_del="insert into delete_groups values(".$row_group['group_id'].",".$row_group['class_id'].",
".$row_group['teacher_id'].",'".$row_group['school']."','".$row_group['subject']."',".$row_group['year'].",
'".$row_group['last_change']."')";
                $result_create_del=mysql_query($query_create_del,$link);
                $query_delete= "delete from groups where group_id='".$classes[$i]-> Id."'";
                $result_delete= mysql_query($query_delete,$link);
                echo("<script>location.href='school_greet.php'</script>");
                }
        if (isset($_POST[$edit])) {
                $_SESSION['table']= $classes[$i]-> Id;
                echo("<script>location.href='school_class_edit.php'</script>");
                }
        }
}

else  echo("<script>location.href='error.php?id=1'</script>");

?>
</div>
</div>
</BODY>
</html>

