<?
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
require_once("../includes/class.php");
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

<?PHP
if ($_SESSION['login']=1) {
class group {
	public $id;
	public $name;
	public $subject;
	public $change;
	public $year;
	public $date;
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
$query_group = "select * from delete_groups where teacher_id='".$_SESSION['user_id']."'";
$result_group= mysql_query($query_group,$link);
$groups=array();
$count=0;

require_once("../includes/date.lib.php");
while ($row_group=mysql_fetch_array($result_group)) {
	$query_class="select * from classes where class_id='".$row_group['class_id']."'";
	$result_class=mysql_query($query_class,$link);
	$row_class=mysql_fetch_array($result_class);
	if (isclass(-1,$row_class['year'])) {
                $count++;
                $groups[$count] = new group;
		$groups[$count]-> id= $row_group['group_id'];
		$groups[$count]-> name=getclass(-1,$row_class['year'],$row_class['letter']);
		$groups[$count]-> subject=$row_group['subject'];
		$groups[$count]-> change=makeDate($row_group['last_change']);
		$groups[$count]-> year=$row_group['year'];
		$groups[$count]-> date=$row_group['last_change'];
		}
	}
require_once("../includes/sort.php");
if ($_SESSION['sort']=='change')	
	mysort_time('group','date',$_SESSION['order'],$groups,$count);
if ($_SESSION['sort']=='subject' || $_SESSION['sort']=='name') 
	mysort_string('group',$_SESSION['sort'],$_SESSION['order'],$groups,$count);
//сортировка журналов 

echo "
	<FORM method='post' class='form_settings'>
	<TABLE class='bigtable'>
	<TR>
	  <TD colspan=6> Удалённые журналы: </TD>
	</TR> 

	<tr> 
	  <th rowspan=2 colspan=2> </th> 
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

 	 <input  type='hidden' name='hidden' id='hidden'/>";
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
                <BUTTON type='submit' class='choose' NAME='".$select."' title='восстановить'>
                </TD>

	<td id='".$id."' colspan=2> " . $groups[$i]-> name. "</td>
	<td id='".$id."' colspan=2> " . $groups[$i]-> subject. "</td> 
	<td id='".$id."' colspan=2> ".$groups[$i]-> change."</td>
	</TR>";
        
   }
echo "</FORM> </TABLE> </TD> </TR> </TABLE>";

if (isset($_POST['classmax'])) {
        $_SESSION['sort']='name';
        $_SESSION['order']='max';
        echo ("<script>location.href='table_del.php'</script>");
        }
if (isset($_POST['classmin'])) {
        $_SESSION['sort']='name';
        $_SESSION['order']='min';
        echo ("<script>location.href='table_del.php'</script>");
        }
if (isset($_POST['subjectmax'])) {
	$_SESSION['sort']='subject';
	$_SESSION['order']='max';
	echo ("<script>location.href='table_del.php'</script>");
	}
if (isset($_POST['subjectmin'])) {
        $_SESSION['sort']='subject';
        $_SESSION['order']='min';
        echo ("<script>location.href='table_del.php'</script>");
        }
if (isset($_POST['changemax'])) {
        $_SESSION['sort']='change';
        $_SESSION['order']='max';
        echo ("<script>location.href='table_del.php'</script>");
        }
if (isset($_POST['changemin'])) {
        $_SESSION['sort']='change';
        $_SESSION['order']='min';
        echo ("<script>location.href='table_del.php'</script>");
        }
for ($i=1; $i<=$count*2+1; $i++) {
	$delete=$i.'delete';
	$select=$i.'select';
        $id=$groups[$i]-> id;
	if (isset($_POST[$delete]) && $_POST['hidden']=='yes') {	
		$query_del_group="delete from delete_groups where group_id='".$id."'";
		$result_del_group=mysql_query($query_del_group,$link);
		$query_del_users="delete from group_users where group_id='".$id."'";
  		$result_del_users=mysql_query($query_del_users,$link);
		$query_del_grades="delete from grades where group_id='".$id."'";
                $result_del_grades=mysql_query($query_del_grades,$link);
		$query_del_lesson="delete from lesson where group_id='".$id."'";
                $result_del_lesson=mysql_query($query_del_lesson,$link);
		$query_del_sched="delete from schedule where group_id='".$id."'";
                $result_del_sched=mysql_query($query_del_sched,$link);
	        echo("<script>location.href='table_del.php'</script>");
		}
	if (isset($_POST[$select])) {
	$query_group = "select * from delete_groups where group_id='".$id."'";
        $result_group = mysql_query ($query_group,$link);
        $row_group= mysql_fetch_array($result_group);
                $query_create="insert into groups (`group_id`,`class_id`,`teacher_id`,`subject`,`year`) values
		(".$row_group['group_id'].",".$row_group['class_id'].",
	".$row_group['teacher_id'].",'".$row_group['subject']."',".$row_group['year'].")";
	echo $query_create;
               $result_create=mysql_query($query_create,$link);
        $query_delete= "delete from delete_groups where group_id='".$id."'";
        $result_delete= mysql_query($query_delete,$link);
	echo("<script>location.href='table_del.php'</script>");
		
		}
	}		
echo $_SESSION['user_id'];
}
else
       echo("<script>location.href='error.php?id=1'</script>");

?>
</div>
</div>
</BODY>
</HTML>

