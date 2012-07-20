<?php
session_start();
error_reporting(0);

if (($_SESSION['login'])!=1)       
echo("<script>location.href='error.php?id=1'</script>");
 
header("Content-Type: text/html; charset=utf-8");
$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);
include "../includes/db_connect.lib.php";
 collation();
require_once("../includes/defence.lib.php");
if (isset($_POST['day']) && isset($_POST['month']) && isset($_POST['year']) 
	&& isset($_POST['task']) && isset($_POST['group'])) {
	$day=intval($_POST['day']);
	$month=intval($_POST['month']);
	$year=intval($_POST['year']);
	$task=makeText($_POST['task']);
	$group=intval($_POST['group']);
	if ($task=='') {
		echo "Необходимо ввести ввести задание";
		die();
		}
	$query="select * from Dates where day='".$day."' and month='".$month."' and year='".$year."'";
	$result=mysql_query($query,$link);
	if (mysql_num_rows($result)) {
		echo "На эту дату уже есть домашнее заданее";
		die();
		}
	$query="select * from Dates where month='".$month."' and group_id='".$group."'";
	//echo $query;
	$result=mysql_query($query,$link);
	$num=mysql_num_rows($result);
	if ($num>0) {
		$row=mysql_fetch_array($result);
		$page=$row['page'];
		}
	if ($num==0) {
		$query="select * from Dates where group_id='".$group."' and date_id=(select max(page_id) from Dates)";
		$result=mysql_query($query,$link);
		$row=mysql_fetch_array($result);
		$page=$row['page']+1;
		}
	//echo $page;
	$query ="insert into Dates (`page`,`group_id`,`day`,`month`,`year`) 
			values ('".$page."','".$group."','".$day."','".$month."','".$year."')";
	//echo $query;
	$result=mysql_query($query,$link);
	$query="select date_id from Dates where date_id=(select max(date_id) from Dates)";
	$result=mysql_query($query,$link);
	$row=mysql_fetch_array($result);
	$date=$row['date_id'];
	$query="insert into lesson (`group_id`,`date_id`,`task`) values ('".$group."','".$date."','".$task."')";
	$result=mysql_query($query,$link);
	//echo $query;
	//echo "<font class='okey'>Задание успешно добавлено</font>";
	die();
	
	
	}

require_once("../includes/register_users.php");
class group {
	public $id;
	public $subject;
	public $teacher;
	}
$user_id=$_SESSION['user_id'];
$query="select * from group_admins where user_id='".$user_id."'";
$result=mysql_query($query,$link);
if (mysql_num_rows($result)) $this_admin=true; 
else $this_admin=false;

$query_user= "select * from users where user_id='".$user_id."'";
$result_user = mysql_query ($query_user,$link);
$row_user = mysql_fetch_array($result_user);
$pupil='ученика';
if ($row_user['sex']=='female') $pupil='ученицы';
$query_class_id= "select * from `class_users`where `user_id`='".$user_id."'";
$result_class_id = mysql_query ($query_class_id,$link);
$row_class_id = mysql_fetch_array($result_class_id);

$query_class= "select * from `classes` where `class_id`='".$row_class_id['class_id']."'";
$result_class = mysql_query ($query_class,$link);
$row_class = mysql_fetch_array($result_class);
require_once("../includes/class.php");
$class=getclass(-1,$row_class['year'],$row_class['letter']);
if ($_GET['time']<100000) {
	$date=getdate();
	$_GET['time']=$date[0];
	}	
$date=getdate($_GET['time']);
$seconds=$date['0']-($date['wday']-1)*60*60*24;

$mday_ar=array();
$wday_ar=array();
$mon_ar=array();

for ($i= 1; $i<=6; $i++) {
        $date=getdate($seconds);
        $wday_ar[$i]=$date['wday'];
        $mday_ar[$i]=$date['mday'];
	$mon_ar[$i]=$date['mon'];
	$year=$date['year'];
	$seconds+= 60*60*24;
	}

$query_groups="select * from `group_users` where `user_id`='".$user_id."'";

$result_groups=mysql_query($query_groups,$link);
$groups=array();
$count_group=0;
while ($row_groups=mysql_fetch_array($result_groups)) {
	$count_group++;
	$query_subject="select * from groups where group_id='".$row_groups['group_id']."'";
        $result_subject=mysql_query($query_subject,$link);
        $row_subject=mysql_fetch_array($result_subject);
	$groups[$count_group]=new group;
	$groups[$count_group]-> id=$row_groups['group_id'];
    $groups[$count_group]-> subject=$row_subject['subject'];
	$query="select * from users where user_id='".$row_subject['teacher_id']."'";
	$result=mysql_query($query,$link);
	$row=mysql_fetch_array($result);
	$groups[$count_group]-> teacher=$row['Name'];
	}
require_once("../includes/date.lib.php");
if (isset($_POST['right'])) {
        $time= $_GET['time']+60*60*24*7;
        echo("<script>location.href='diary1.php?time=".$time."'</script>");
        }

if (isset($_POST['last'])) {
        $time= $_GET['time']- 60*60*24*7;
        echo("<script>location.href='diary1.php?time=".$time."'</script>");
       }

?>
<HTML>
 <HEAD>
<title>Журнал</title>
  <link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
 <script type="text/javascript" src='../includes/jquery-1.3.2.min.js'></script>
<script type='text/javascript' src='../includes/window.js'></script>
<link rel='stylesheet' href='../css/window.css' type='text/css' media='screen' />
<script type='text/javascript' src='../includes/ajax.js'></script>
<script type="text/javascript" src='../includes/jquery-1.3.2.min.js'></script>

<script type='text/javascript' language=JavaScript>
function saveTask() {
	Handler= function(Request) {
		var answer=Request.responseText;
		if (answer.length<5) location.href='diary1.php';
		document.getElementById('saveText').innerHTML=Request.responseText;
		}
	
	var day=document.getElementById('day').value;
	var month= document.getElementById('month').value;
	var year=document.getElementById('year').value;
	var task=document.getElementById('task').value;
	var group=document.getElementById('group').value;
	
	var str='day='+day+'&month='+month+'&year='+year+'&task='+task+'&group='+group;
	//alert(str);
	SendRequest('post','diary1.php',str,Handler);
	
	 }
</script>
 </HEAD>
<body>
 <div id='logo'> 
<?require_once("../includes/logo.php");
?> 
<div id='main'>
 <div id='leftbar'>
 <? require_once "../includes/menu.php";?>
 </div>
 <div id='content'>

 <form method='post' class='form_settings'>
 <input type='hidden' id='month' value=''>
 <input type='hidden' id='day' value=''>
 <input type='hidden' id='year' value=''>
  
		    <div id='boxes'>
			 <div id='dialog' class='window' style='width:500px; height:250px;'>
			  <div id='head'> Создание клуба </div>
			  <div id='w_content'>
			   <table >
			    <tr>
			     <td ><h1>Выберите группу:</h1></td>
			    </tr>
			    <tr>
			     <td> 
			     <select id='group'>
			     <? for ($i=1; $i<=$count_group; $i++) {
					echo "<option value='".$groups[$i]-> id."'>
					".$groups[$i]-> subject." ".$groups[$i]-> teacher."
					</option>";
					}?>
			     </select>
			     
			     </td>
			    </tr>
			    <tr>
			     <td> <h1>Введите задание:</h1></td>
			    </tr>
			    <tr>
			     <td><textarea id='task' style="width:450px;"></textarea></td>
			    </tr>
			   </table>
              </div>
			  <div id='footer'>
			   <table height=100%>
				<tr>
				 <td  width=340px align='right'>
				 <input type='button' id='create' class='w_button' value='Добавить задание'
						onclick="saveTask();"></td>
				 <td width=110px align='right'><input type='button' class='w_button' value='Отменить'
					onclick="location.href='diary1.php';"></td>
				</tr>
				<tr>
				 <td colspan=2 align=right class='error' id='saveText'> </td>
				</tr>
			   </table>
			  </div>
			  <div class='closed'></div>
             </div>
             <div id='mask'></div>
		    </div>

 
 
 <table align='center'>
  <tr>
   <th align='left'> <font size='4'>Виртуальный дневник </font> </th>
   <th align='right' rowspan=3> Неделя 
		<input type='submit' class='page' name='last' value='Пред.'> 
		<input type='submit' class='page' name='right' value='След.'> </th>
  </tr>
  <tr>
   <th align='left'><?echo $pupil." ".$class;?> класса </th>
  </tr>
  <tr>
   <th align='left'><?echo $row_user['Name'];?></th>
  </tr>
<? for($i=1; $i<=6; $i++) {
	$day=getDay($wday_ar[$i]);
	$mon=getMonth($mon_ar[$i]);
	echo "
	 <tr>
	  <th colspan=2 height='40px' valign='bottom' align='left'>".$day.", ".$mday_ar[$i]." ".$mon." ".$year."</th>
         </tr>
	 <tr>
          <td colspan=2>
	 <table class='table'>
	  <tr>
	   <th width='100px'> Предмет </th> 
	   <th width='200px'> Тема </th>
	   <th width='250px'> Задание </th>
	   <th width='50px'> Оценка </th>
	   <th width='100px'> Файлы </th>
	  </tr>";
	$count=0;
	for ($j=1; $j<= $count_group; $j++) {
		$query_date="select * from `Dates` where `day`='".$mday_ar[$i]."' and `month`='".$mon_ar[$i]."' and 
			     `year`='".$year."' and `group_id`='".$groups[$j]-> id."'";
		$result_date=mysql_query($query_date,$link);
		$num_date=mysql_num_rows($result_date);
		while ($row_date=mysql_fetch_array($result_date)) {
			$count++;
			if ($count % 2==0) $style="id='even'"; else $style="id='odd'";
			$query_task="select * from `lesson` where `date_id`='".$row_date['date_id']."'";
			$result_task=mysql_query($query_task,$link);
			$row_task=mysql_fetch_array($result_task);
			$query_grade="select * from `grades` where `date_id`='".$row_date['date_id']."' and 
				      `user_id`='".$user_id."'";
			$result_grade=mysql_query($query_grade,$link);
			$row_grade=mysql_fetch_array($result_grade);
			echo "
			 <tr>
			  <td ".$style.">".$groups[$j]-> subject."</td>
			  <td ".$style.">".$row_task['theme']."</td>
			  <td ".$style.">".$row_task['task']."</td>
			  <td ".$style.">".$row_grade['Grade']."</td>
			  <td ".$style.">";
			if ($row_task['file']!='') 
				echo "<a href='../uploads/".$row_task['file']."'>скачать</a>";
			echo "
			  </td>
		         </tr>";
			}
		}
	if ($count==0) echo "<tr><td colspan=5 id='even'>На этот день ничего не задано</td></tr>";
	
	echo "</table></td> </tr>";		
	if ($this_admin) echo "
	<tr>
	 <td><a href='#dialog' name='modal' onclick=\"
		document.getElementById('day').value='".$mday_ar[$i]."';
		document.getElementById('month').value='".$mon_ar[$i]."';
		document.getElementById('year').value='".$year."';
		\">+Добавить</a></td>
	</tr>";
	}
?>
 </table>
 </form>
 </div>       
</div>
</body>
</html>
 
