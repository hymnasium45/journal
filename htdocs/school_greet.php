<?session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<HEAD>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />  


</HEAD>

<?php
if ($_SESSION['login']==1 && $_SESSION['access']<=567)
{
class Group {
        public $Id;
        public $Name;
        public $Teacher;
	public $Teacher_id;
	public $Subject;
        public $Change;
        public $Year;
        }
if (!($_SESSION['sort'])) $_SESSION['sort']='Change'; //сортировка по дате посл. изм  
if (!($_SESSION['order'])) $_SESSION['order']='Max';

$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);
 include "../includes/db_connect.lib.php";
 collation();
echo "
  <div id='logo'> 
";require_once("../includes/logo.php");

echo" 
</div> 
<div id='main'>";
require_once("../includes/topbar.php");
echo"
<div id='sidebar'>"
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
$query_group = "select * from groups";
$result_group = mysql_query($query_group, $link);
while ( $row_group = mysql_fetch_array($result_group)) {
        $count++;
        $query_teacher="select * from users where user_id='".$row_group['teacher_id']."'";
        $result_teacher=mysql_query($query_teacher,$link);
        $row_teacher=mysql_fetch_array($result_teacher);
	$query_class = "select * from classes where class_id='".$row_group['class_id']."'";
	$result_class= mysql_query($query_class,$link) ;
	$row_class=mysql_fetch_array($result_class);
        $groups[$count]-> Id= $row_group['group_id'];
 	$groups[$count]-> Name= $row_class['Class'];
        $groups[$count]-> Teacher=$row_teacher['Name'];
   	$groups[$count]-> Teacher_id=$row_group['teacher_id'];
 	$groups[$count]-> Subject=$row_group['subject'];
        $groups[$count]-> Change=$row_group['last_change'];
        $groups[$count]-> Year=$row_group['year'];
        }
do
{
$F=1;
for ($i=1; $i<= $count-1; $i++) {
     $change1=substr($groups[$i]-> Change,0,2)+31*substr($groups[$i]-> Change,3,2)+366*substr($groups[$i]-> Change,6,4);
$change2=substr($groups[$i+1]-> Change,0,2)+31*substr($groups[$i+1]-> Change,3,2)+366*substr($groups[$i+1]-> Change,6,4);

        if (($_SESSION['sort']=='Name' && $_SESSION['order']=='Max'
                && strnatcasecmp($groups[$i]-> Name,$groups[$i+1]-> Name)>0) ||
        ($_SESSION['sort']=='Name' && $_SESSION['order']=='Min'
                && strnatcasecmp($groups[$i]-> Name,$groups[$i+1]-> Name)<0) ||
        ($_SESSION['sort']=='Change' && $_SESSION['order']=='Max'
                && $change1>$change2) ||
        ($_SESSION['sort']=='Change' && $_SESSION['order']=='Min'
                && $chage1<$change2) ||
        ($_SESSION['sort']=='Teacher' && $_SESSION['order']=='Max'
                && strnatcasecmp($groups[$i]-> Teacher,$groups[$i+1]-> Teacher)>0) ||
        ($_SESSION['sort']=='Teacher' && $_SESSION['order']=='Min'
                && strnatcasecmp($groups[$i]-> Teacher, $groups[$i+1]-> Teacher)<0) ||
        ($_SESSION['sort']=='Subject' && $_SESSION['order']=='Max'
                && strnatcasecmp($groups[$i]-> Subject, $groups[$i+1]-> Subject)>0) ||
        ($_SESSION['sort']=='Subject' && $_SESSION['order']=='Min'
                && strnatcasecmp($groups[$i]-> Subject, $groups[$i+1]-> Subject)<0) ||
        ($_SESSION['sort']=='Year' && $_SESSION['order']=='Max'
                && $groups[$i]-> Year > $groups[$i+1]-> Year)  ||
        ($_SESSION['sort']=='Year' && $_SESSION['order']=='Min'
                && $groups[$i]-> Year < $groups[$i+1]-> Year)) {

                $S=$groups[$i]-> Id;
                $groups[$i]-> Id=$groups[$i+1]-> Id;
                $groups[$i+1]-> Id=$S;
                $S=$groups[$i]-> Name;
                $groups[$i]-> Name=$groups[$i+1]-> Name;
                $groups[$i+1]-> Name=$S;
                $S=$groups[$i]-> Teacher_id;
                $groups[$i]-> Teacher_id=$groups[$i+1]-> Teacher_id;
                $groups[$i+1]-> Teacher_id=$S;
		$S=$groups[$i]-> Teacher;
                $groups[$i]-> Teacher=$groups[$i+1]-> Teacher;
                $groups[$i+1]-> Teacher=$S;
                $S=$groups[$i]-> Subject;
                $groups[$i]-> Subject=$groups[$i+1]-> Subject;
                $groups[$i+1]-> Subject=$S;
                $S=$groups[$i]-> Change;
                $groups[$i]-> Change=$groups[$i+1]-> Change;
                $groups[$i+1]-> Change=$S;
                $S=$groups[$i]-> Year;
                $groups[$i]-> Year=$groups[$i+1]-> Year;
                $groups[$i+1]-> Year=$S;
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
          <th bgcolor=$head_color> <font size='4' color= black > Предмет </font> </th> 
          <th bgcolor=$head_color> Дата посл. изм. </th> 
          <th bgcolor=$head_color> уч. год </th> 
	  <input  type='hidden' name='hidden' id='hidden'/>
                </tr>";

for ($i=1; $i<=$count; $i++) {
        if ($i % 2==0) $color=$dark_grey; else $color=$light_grey;
        $year=$groups[$i]-> Year+1;
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
	<td bgcolor=$color> <font size='3' color= black > ".$groups[$i]-> Name ."</font></td>
        <td bgcolor=$color> <font size='3' color= black > " . $groups[$i]-> Teacher ."</font></td>
        <td bgcolor=$color> <font size='3' color= black >" . $groups[$i]-> Subject. "</font> </td> 
        <td bgcolor=$color> ".$groups[$i]-> Change."</td>
        <td bgcolor=$color> ".$groups[$i]-> Year."-".$year."</td>
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
                $_SESSION['table']= $groups[$i]-> Id;
                $_SESSION['page']=1;
                echo("<script>location.href='school_table.php'</script>");
                }
        if (isset($_POST[$delete]) && $_POST['hidden']=='yes') {
                $query_group = "select * from groups where group_id='".$groups[$i]-> Id."'";
                $result_group = mysql_query ($query_group,$link);
                $row_group= mysql_fetch_array($result_group);
                $query_create_del="insert into delete_groups values(".$row_group['group_id'].",".$row_group['class_id'].",
".$row_group['teacher_id'].",'".$row_group['school']."','".$row_group['subject']."',".$row_group['year'].",
'".$row_group['last_change']."')";
                $result_create_del=mysql_query($query_create_del,$link);
                $query_delete= "delete from groups where group_id='".$groups[$i]-> Id."'";
                $result_delete= mysql_query($query_delete,$link);
                echo("<script>location.href='school_greet.php'</script>");
                }
        if (isset($_POST[$edit])) {
                $_SESSION['table']= $groups[$i]-> Id;
                echo("<script>location.href='school_table_edit.php'</script>");
                }
        }
}

else  echo("<script>location.href='fail_avto.php'</script>");

?>
</div>
</div>
</BODY>
</html>

