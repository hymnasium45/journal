<?php
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
if ($_SESSION['login']=1) {
class group {
        public $id;
        public $name;
        public $subject;
        public $year;
        }
if (!($_SESSION['sort'])) $_SESSION['sort']='name';
if (!($_SESSION['order'])) $_SESSION['order']='min';
$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);
 include "../includes/db_connect.lib.php";
 collation();
require_once("../includes/register_users.php");
$query_group = "select * from `old_groups` where `teacher_id`='".$_SESSION['user_id']."'";
$result_group= mysql_query($query_group,$link);
$groups=array();
$count=0;
include "../includes/class.php";
while ($row_group=mysql_fetch_array($result_group)) {
        $query_class="select * from `classes` where `class_id`='".$row_group['class_id']."'";
        $result_class=mysql_query($query_class,$link);
        $row_class=mysql_fetch_array($result_class);
	        $count++;
                $groups[$count] = new group;
                $groups[$count]-> id= $row_group['group_id'];
                $groups[$count]-> name=getclass('-1',$row_class['year'],$row_class['letter']);
		$groups[$count]-> subject=$row_group['subject'];
                $groups[$count]-> year=$row_group['year'];
                }
require_once ("../includes/sort.php");
if ($_SESSION['sort']=='year' )
	mysort_number('group',$_SESSION['sort'],$_SESSION['order'],$groups,$count);
if ($_SESSION['sort']=='subject' || $_SESSION['sort']=='name')
        mysort_string('group',$_SESSION['sort'],$_SESSION['order'],$groups,$count);

if (isset($_POST['classmax'])) {
        $_SESSION['sort']='name';
        $_SESSION['order']='max';
        echo ("<script>location.href='old_journals.php'</script>");
        }
if (isset($_POST['classmin'])) {
        $_SESSION['sort']='name';
        $_SESSION['order']='min';
        echo ("<script>location.href='old_journals.php'</script>");
        }
if (isset($_POST['subjectmax'])) {
        $_SESSION['sort']='subject';
        $_SESSION['order']='max';
        echo ("<script>location.href='old_journals.php'</script>");
        }
if (isset($_POST['subjectmin'])) {
        $_SESSION['sort']='subject';
        $_SESSION['order']='min';
        echo ("<script>location.href='old_journals.php'</script>");
        }
if (isset($_POST['yearmax'])) {
        $_SESSION['sort']='year';
        $_SESSION['order']='max';
        echo ("<script>location.href='old_journals.php'</script>");
        }
if (isset($_POST['yearmin'])) {
        $_SESSION['sort']='year';
        $_SESSION['order']='min';
        echo ("<script>location.href='old_journals.php'</script>");
        }
       
for ($i=1; $i<=$count; $i++) {
	$select=$i.'select';
	$delete=$i.'delete';
	if (isset($_POST[$select])) {
                $_SESSION['table']= $groups[$i]-> id;
                $_SESSION['page']=1;
                echo("<script>location.href='class_table.php'</script>");
                }

	if (isset($_POST[$delete]) && $_POST['hidden']=='yes') {
		$id=$groups[$i]-> id;
                $query_del_group="delete from old_groups where group_id='".$id."'";
                $result_del_group=mysql_query($query_del_group,$link);
                $query_del_users="delete from group_users where group_id='".$id."'";
                $result_del_users=mysql_query($query_del_users,$link);
                $query_del_grades="delete from grades where group_id='".$id."'";
                $result_del_grades=mysql_query($query_del_grades,$link);
                $query_del_lesson="delete from lesson where group_id='".$id."'";
                $result_del_lesson=mysql_query($query_del_lesson,$link);
                $query_del_sched="delete from schedule where group_id='".$id."'";
                $result_del_sched=mysql_query($query_del_sched,$link);
                echo("<script>location.href='old_journals.php'</script>");
                }
	}
}
else echo ("<script>location.href='fail_avto.php'</script>");
?>
<HTML>
<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
</HEAD>
<BODY>
 <div id='logo'> 
<?require_once("../includes/logo.php");
?> 
</div> 
<div id='main'><?

?>
<div id='leftbar'>"
<? require_once "../includes/menu.php";?>
</div>
<div id='content'>
      <FORM method='post' class='form_settings'>
        <TABLE class='bigtable'>
        <TR>
          <TD colspan=6> Старые журналы: </TD>
        </TR> 

        <tr> 
          <th rowspan=2 colspan=2> </th> 
          <th rowspan=2 id='arrow_left' width='150px'> Класс </th> 
          <th id='arrow_up'> <button name='classmax' class='up'></th>   
          <th rowspan=2 id='arrow_left' width='200px'> Предмет  </th> 
          <th id='arrow_up'> <button name='subjectmax' class='up'></th>   
          <th rowspan=2 id='arrow_left' width='150px'> Уч. год </th> 
          <th id='arrow_up'> <button name='yearmax' class='up'></th>   
         </tr>
         <tr>
           <th id='arrow_down'> <button name='classmin' class='down'> </th>
           <th id='arrow_down'> <button name='subjectmin' class='down'> </th>
           <th id='arrow_down'> <button name='yearmin' class='down'> </th>
         </tr>

         <input  type='hidden' name='hidden' id='hidden'/>
<?for ($i=1; $i<=$count; $i++)
        {
	$select=$i.'select';
	$delete=$i.'delete';
	$year=$groups[$i]-> year +1;
        if ($i % 2==0) $id='odd'; else $id='even';
echo "
            <TD id='".$id."'>                    
                <BUTTON TYPE='submit' class='delete' title='удалить' NAME='".$delete."' 
        onclick=\"if (confirm('Вы точно хотите удалить журнал?')) 
        {getElementById('hidden').value='yes'} 
        else {getElementById('hidden').value='no';} \">  
                </TD> 
 
   
                <TD id='".$id."'>    
                <BUTTON type='submit' class='choose' NAME='".$select."' title='выбрать'>
                </TD>

        <td id='".$id."' colspan=2> " . $groups[$i]-> name. "</td> 
        <td id='".$id."' colspan=2> ".$groups[$i]-> subject."</td>
	<td id='".$id."' colspan=2> ".$groups[$i]-> year."-".$year."</td>
        </TR>";

   }
?>
</table></form>
</div>
</div>
</body>
</html>
