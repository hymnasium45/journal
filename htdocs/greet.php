<?
session_start();
error_reporting(0);
$_SESSION['location']='greet.php';
header("Content-Type: text/html; charset=utf-8");
if ($_SESSION['login']!=1) {
	echo("<script>location.href='error.php?id=1'</script>");
	die();
	}
$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);
 include "../includes/db_connect.lib.php";
 collation();

$user_id=$_SESSION['user_id'];
$teacher_id=intval($_SESSION['user_id']);
require_once("../includes/error_page.php");
require_once("../user/includes/user.lib.php");

if (!isTeacher($user_id)) {
	makeError("Эту страницу могут только учителя. Для получения доступа обратитесь к администрации школы.");
	die();
	}

require_once ("../includes/class.php");
require_once ("../includes/sort.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
 <STYLE text=css/text>

 </STYLE>


</HEAD>

<BODY>
<?php


class group {
        public $id;
        public $name;
        public $subject;
        public $change;
        public $year;
	public $date;
	public $bookmark;
	}

if (!($_SESSION['sort'])) $_SESSION['sort']='change'; //сортировка по дате посл. изм  
if (!($_SESSION['order'])) $_SESSION['order']='max';

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

echo "<TABLE align='center'>
        <TR>
        <TD colspan=2>";
	$row_teacher = mysql_fetch_array($result_teacher);
  	$query_group = "select * from groups where teacher_id='".$_SESSION['user_id']."'";
  	$result_group= mysql_query($query_group,$link);
  	
	$head_color='#999999';
    	$light_grey='#DDDDDD';
    	$dark_grey='#BEBEBE';

	echo "
       <FORM METHOD='POST' class='form_settings' >

	<table align='center' class='bigtable'> 
	<TR> <TD colspan=6> Выберите журнал: </TD> </TR> 
	<tr> 
	  <th rowspan=2 colspan=3> </th> 
	  <th rowspan=2 id='arrow_left' width='100px'> Класс </th> 
          <th id='arrow_up'> <button name='classmax' class='up'></th>   
          <th rowspan=2 id='arrow_left' width='200px'> Предмет  </th> 
	  <th id='arrow_up'> <button name='subjectmax' class='up'></th>   
	  <th rowspan=2 id='arrow_left'> Дата посл. изм. </th> 
          <th id='arrow_up'> <button name='changemax' class='up'></th>   
	 </tr>
         <tr>
           <th id='arrow_down'> <button name='classmin' class='down'> </th>
           <th id='arrow_down'> <button name='subjectmin' class='down'> </th>
           <th id='arrow_down'> <button name='changemin' class='down'> </th>
         </tr>

 	 <input  type='hidden' name='hidden' id='hidden'/>
         ";

// записываем в таблицу названия группы и имя учителя
  $count=0;
$groups = array();
 	$day=substr($date,0,2);
        $month=substr($date,3,2);
        $year=substr($date,6,4);
        if ($month>7 || ($month==7 && $day>=15))  $year--;
require_once ("../includes/date.lib.php");
if (mysql_num_rows($result_group)==0) 
	echo "<TR> <TD colspan=7> У Вас пока не журналов </TD> </TR>";
else 
	while ($row_group=mysql_fetch_array($result_group))
	if ($row_group['year']>= $year)  {
    		$count++;
 		$query_class = "select * from classes where class_id='".$row_group['class_id']."'";
		$result_class = mysql_query($query_class,$link);
		$row_class=mysql_fetch_array($result_class);
		$groups[$count]=new group;
		$groups[$count]-> id= $row_group['group_id'];
		$groups[$count]-> name=getclass(-1,$row_class['year'],$row_class['letter']);
        	$groups[$count]-> subject=$row_group['subject'];
		$groups[$count]-> change=makeDate($row_group['last_change']);
        	$groups[$count]-> year=$row_group['year'];
	        $groups[$count]-> date=$row_group['last_change'];
		$groups[$count]-> bookmark=$row_group['bookmark'];
		}
require_once("../includes/sort.php");
if ($_SESSION['sort']=='change')	
	mysort_time('group','date',$_SESSION['order'],$groups,$count);
if ($_SESSION['sort']=='subject' || $_SESSION['sort']=='name') 
	mysort_string('group',$_SESSION['sort'],$_SESSION['order'],$groups,$count);
//сортировка журналов
for ($i=1; $i<=$count; $i++)
	{		
	if ($i % 2==0) $id='odd'; else $id='even';
	$select=$i.'select';
	$edit=$i.'edit';
	$delete=$i.'delete';
echo "
        
          <TR> 
                <TD id='".$id."'>                    
                <BUTTON TYPE='submit' class='delete' title='удалить' NAME='".$delete."' 
	onclick=\"if (confirm('Вы точно хотите удалить журнал?')) 
	{getElementById('hidden').value='yes'} 
	else {getElementById('hidden').value='no';} \">  
		</TD> 

	<TD id='".$id."'>    
	<BUTTON TYPE ='SUBMIT' class='edit' NAME='".$edit."' title='редактировать'>  
     	</TD>
		<TD id='".$id."'>    
                <BUTTON type='submit' class='choose' NAME='".$select."' title='выбрать'>
                </TD>

	<td id='".$id."' colspan=2> " . $groups[$i]-> name. "</td>
	<td id='".$id."' colspan=2> " . $groups[$i]-> subject. "</td> 
	<td id='".$id."' colspan=2> ".$groups[$i]-> change."</td>
	</TR>";
        
   }
  echo " </form></table> </TD> </TR> </TABLE> ";
if (isset($_POST['classmax'])) {
        $_SESSION['sort']='name';
        $_SESSION['order']='max';
        echo ("<script>location.href='greet.php'</script>");
        }
if (isset($_POST['classmin'])) {
        $_SESSION['sort']='name';
        $_SESSION['order']='min';
        echo ("<script>location.href='greet.php'</script>");
        }
if (isset($_POST['subjectmax'])) {
	$_SESSION['sort']='subject';
	$_SESSION['order']='max';
	echo ("<script>location.href='greet.php'</script>");
	}
if (isset($_POST['subjectmin'])) {
        $_SESSION['sort']='subject';
        $_SESSION['order']='min';
        echo ("<script>location.href='greet.php'</script>");
        }
if (isset($_POST['changemax'])) {
        $_SESSION['sort']='change';
        $_SESSION['order']='max';
        echo ("<script>location.href='greet.php'</script>");
        }
if (isset($_POST['changemin'])) {
        $_SESSION['sort']='change';
        $_SESSION['order']='min';
        echo ("<script>location.href='greet.php'</script>");
        }

//проверяем , какую группу выбрал пользователь
for ($i=1; $i<= $count; $i++) {     		
	$select=$i.'select';
	$edit=$i.'edit';
	$delete=$i.'delete';   
	if (isset($_POST[$select])) {
		$_SESSION['table']= $groups[$i]-> id;
		$_SESSION['page']=$groups[$i]-> bookmark;
 		echo("<script>location.href='table.php'</script>");
		}
     		if (isset($_POST[$delete]) && $_POST['hidden']=='yes') {
		$id=$groups[$i]-> id;	
		$query_del_group="delete from groups where group_id='".$id."'";
		//echo $query_del_group;
		$result_del_group=mysql_query($query_del_group,$link);
		$query_del_users="delete from group_users where group_id='".$id."'";
  		$result_del_users=mysql_query($query_del_users,$link);
		$query_del_grades="delete from grades where group_id='".$id."'";
                $result_del_grades=mysql_query($query_del_grades,$link);
		$query_del_lesson="delete from lesson where group_id='".$id."'";
                $result_del_lesson=mysql_query($query_del_lesson,$link);
		$query_del_sched="delete from schedule where group_id='".$id."'";
                $result_del_sched=mysql_query($query_del_sched,$link);
	        echo("<script>location.href='greet.php'</script>");
		}

     	if (isset($_POST[$edit])) {
		$_SESSION['table']= $groups[$i]-> id;
       		echo("<script>location.href='table_edit.php'</script>");
		}
   	}

	

 
?>
</div>
</div>
</BODY>
</html>

