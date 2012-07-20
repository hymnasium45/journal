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



if ($_SESSION['login']==1)
{
class group {
        public $id;
        public $name;
        public $subject;
        public $change;
        public $year;
	}
if (!($_SESSION['sort'])) $_SESSION['sort']='change'; //сортировка по дате посл. изм  
if (!($_SESSION['order'])) $_SESSION['order']='min';

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
$query_class = "select * from classes where class_id='".$_SESSION['class']."'";
$result_class= mysql_query($query_class,$link) ;
$head_color='#999999';
$light_grey='#DDDDDD';
$dark_grey='#BEBEBE';

	echo "
       <FORM METHOD='POST' class='form_settings' >

	<table align='center' class='bigtable'> 
	<TR> <TD colspan=3> Выберите журнал: </TD> </TR> 
	<tr> 
	  <th rowspan=2> </th>    
          <th rowspan=2 id='arrow_left' width='200px'> Предмет  </th> 
	  <th id='arrow_up'> <button name='subjectmax' class='up'></th>   
	  <th rowspan=2 id='arrow_left'> Дата посл. изм. </th> 
          <th id='arrow_up'> <button name='changemax' class='up'></th>   
	 </tr>
         <tr>
           <th id='arrow_down'> <button name='subjectmin' class='down'> </th>
           <th id='arrow_down'> <button name='changemin' class='down'> </th>
         </tr>

 	 <input  type='hidden' name='hidden' id='hidden'/>
         ";
// записываем в таблицу названия группы и имя учителя
  $cout=0;
  $groups = array();
$row_class=mysql_fetch_array($result_class);
$query_group = "select * from groups where class_id = '".$row_class['class_id']."'";
$result_group = mysql_query($query_group, $link);

while ( $row_group = mysql_fetch_array($result_group)) {
	$count++;
        $query_teacher="select * from users where user_id='".$row_group['teacher_id']."'";
        $result_teacher=mysql_query($query_teacher,$link);
        $row_teacher=mysql_fetch_array($result_teacher);
	    $groups[$count]= new group;
	    $groups[$count]-> id= $row_group['group_id'];
    	$groups[$count]-> teacher=$row_teacher['Name'];
    	$groups[$count]-> subject=$row_group['subject'];
    	$groups[$count]-> change=$row_group['last_change'];
    	$groups[$count]-> year=$row_group['year'];
	}

require_once("../includes/sort.php");
if ($_SESSION['sort']=='change')	
	mysort_time('group','change',$_SESSION['order'],$groups,$count);
if ($_SESSION['sort']==subject || $_SESSION['sort']==name) 
	mysort_string('group',$_SESSION['sort'],$_SESSION['order'],$groups,$count);
for ($i=1; $i<=$count; $i++)
	{		
	if ($i % 2==0) $id='odd'; else $id='even';
echo "
        
   
		<TD id='".$id."'>    
                <BUTTON type='submit' class='choose' NAME='".$i."'>
                </TD>

	<td id='".$id."' colspan=2> " . $groups[$i]-> subject. "</td> 
	<td id='".$id."' colspan=2> ".$groups[$i]-> change."</td>
	</TR>";
        
   }
echo "</TABLE> </FORM>";   
if (isset($_POST['subjectmax'])) {
	$_SESSION['sort']='subject';
	$_SESSION['order']='max';
	echo ("<script>location.href='class_greet.php'</script>");
	}
if (isset($_POST['subjectmin'])) {
        $_SESSION['sort']='subject';
        $_SESSION['order']='min';
        echo ("<script>location.href='class_greet.php'</script>");
        }
if (isset($_POST['changemax'])) {
        $_SESSION['sort']='change';
        $_SESSION['order']='max';
        echo ("<script>location.href='class_greet.php'</script>");
        }
if (isset($_POST['changemin'])) {
        $_SESSION['sort']='change';
        $_SESSION['order']='min';
        echo ("<script>location.href='class_greet.php'</script>");
        }
//проверяем , какую группу выбрал пользователь
for ($i=1; $i<= $count; $i++)
 
 if (isset($_POST[$i] ))
     {
    $_SESSION['table']= $groups[$i]-> id;
    $_SESSION['page']=1; 
    echo("<script>location.href='table.php'</script>");
    }
}

else  echo("<script>location.href='error.php?id=1'</script>");

?>
</div>
</div>
</BODY>
</html>
