<?
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");

require_once("../includes/class.php");

if ($_SESSION['login']!=1) echo("<script>location.href='error.php?id=1'</script>");
if (isset($_POST['id'])) {
	$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
	mysql_select_db($_SESSION['dbname'],$link);
    require_once("../includes/db_connect.lib.php");
    collation();
	
	$id=intval($_POST['id']);
	$class_id=intval($_SESSION['class']);
	if ($id<=0 || $class_id<=0) {
		echo"<font class='error'>Ошибка. Не удалось выполнить запрос</font>";
		die();
		}
	$query="update `classes` set `raporter_id`='".$id."' 
				where `class_id`='".$class_id."'";
	$result=mysql_query($query,$link);
	if (!$result) 
		echo "<font class='error'>Ошибка. Не удалось выполнить запрос</font>";
	else 
		echo "<font class='okey'>Отв. за рапортичку успешно обновлен</font>";
	die();	
		}


class Pupil {
	public $Id;
	public $Name;
	}
	//коннектимся к базе данных
	$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
	mysql_select_db($_SESSION['dbname'],$link);
 include "../includes/db_connect.lib.php";
 collation();


require_once("../includes/register_users.php");
$teacher_id=intval($_SESSION['user_id']);
require_once("../includes/error_page.php");
require_once("../user/includes/user.lib.php");

if (!isClassTeacher($teacher_id)) {
	makeError("Редактировать классы могут только учителя. Для получения доступа обратитесь к администрации школы.");
	die();
	}
if (!isset($_SESSION['class'])) {
	makeError("Необходимо выбрать класс для редактирования, пройдите по данной <a href='class.php'>ссылке</a> ");
	die();
	} 
	$query_teacher="select * from users where user_id='".$_SESSION['user_id']."'";
	$result_teacher=mysql_query($query_teacher,$link);
	$row_teacher=mysql_fetch_array($result_teacher);
$query_class="select * from classes where class_id='".$_SESSION['class']."'";
$result_class=mysql_query($query_class,$link);
$row_class=mysql_fetch_array($result_class);
require_once("../includes/class.php");
$class_name=getClass(-1,$row_class['year'],$row_class['letter']);
$class_code=$row_class['code'];
$class_invites=$row_class['invites'];


$club_id=intval($row_class['club_id']);

$query="select * from club where club_id='".$club_id."'";
$result=mysql_query($query,$link);
$num=mysql_num_rows($result);
if ($club_id>0 && $num>0) {
	$row=mysql_fetch_array($result);
	$class_club="<a href='club.php?club_id=".$row['club_id']."'>".$row['name']."</a>";
	}
else $class_club="<input type='submit' class='simple' name='create_club' value='Создать'>";
	$query_users="select * from class_users where class_id='".$_SESSION['class']."'";
	$result_users=mysql_query($query_users,$link);
	$count=0;
$query_raporter="select * from users where user_id='".$row_class['raporter_id']."'";
$result_raporter=mysql_query($query_raporter,$link);
$row_raporter=mysql_fetch_array($result_raporter);
$pupils=array();
$count=0;
 
while ($row_users=mysql_fetch_array($result_users)) {
        $count++;
        $query_user_name="select * from users where user_id='".$row_users['user_id']."'";
        $result_user_name=mysql_query($query_user_name,$link);
        $row_user_name=mysql_fetch_array($result_user_name);
        $pupils[$count]=new Pupil;
        $pupils[$count]-> Name=$row_user_name['Name'];
        $pupils[$count]-> Id=$row_users['user_id'];
	}
require_once("../includes/sort.php");
mysort_string('Pupil','Name','max',$pupils,$count);

for ($i=1; $i<=$count; $i++) {
        if (isset($_POST[$i])) {
                $query_delete="delete from class_users where 
                (class_id='".$_SESSION['class']."' and user_id='".$pupils[$i]-> Id."')";
                echo $query_delete;
		$result_delete=mysql_query($query_delete,$link);
                echo("<script>location.href='class_edit.php'</script>");
		}
	}

if (isset($_POST['download'])) {
	$_SESSION['error']='';	
	$uploaddir='/var/www/version2/uploads/';
	$uploadfile=$uploaddir. basename($_FILES['userfile']['name']);
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		$_SESSION['file']=$_FILES['userfile']['name'];
		echo ("<script>location.href='class_edit_add_user.php'</script>");
		}
		else {
		$_SESSION['error']="ошибка при загрузке файла, попробуйте ещё раз";
		echo("<script>location.href='class_edit.php'</script>");
		}
	}
if (isset($_POST['create_club'])) {
	$query="insert into club (`name`) values('".$class_name." класс')";
	$result=mysql_query($query,$link);
	$query="select club_id from club where club_id=(select max(club_id) from club)";
	$result=mysql_query($query,$link);
	$row=mysql_fetch_array($result);
	$query="update classes set club_id='".$row['club_id']."' where class_id='".$_SESSION['class']."'";
	$result=mysql_query($query,$link);
	$query="insert into club_admins values('".$_SESSION['user_id']."','".$row['club_id']."')";
	$result=mysql_query($query,$link);
	$query="insert into club_users (`club_id`,`user_id`,`date`) 
			values ('".$row['club_id']."','".$teacher_id."',NOW())";
	$result=mysql_query($query,$link);
	for ($i=1; $i<=$count; $i++) {
		$query="insert into club_users (`club_id`,`user_id`,`date`) 
				values ('".$row['club_id']."','".$pupils[$i]-> Id."',NOW())";
		$result=mysql_query($query,$link);
		}
	echo("<script>location.href='club?club_id=".$row['club_id']."'</script>");
	}

?>
<HTML>
<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
<script type='text/javascript' src='../includes/ajax.js'></script>

<script language=JavaScript>
function makeRaporter(value) {
	Handler= function(Request) {
		document.getElementById('error').innerHTML=Request.responseText;
		}
	str='id='+value;
	SendRequest('post','class_edit.php',str,Handler);
	}
</script>
<STYLE type=text/css>
   TH {height:50}
   TD {height:40}
 </STYLE>
</HEAD>

<BODY>
  <div id='logo'> 
<?require_once("../includes/logo.php");?> 
  </div> 
<div id='main'>
<??>
<div id='leftbar'>

<?require_once "../includes/menu.php";?>
        </div>
        <div id='content'>
<FORM method='POST' class='form_settings'>
<TABLE ALIGN='CENTER' >

 <TR>
  <TD colspan=2 valign=top> 
    <TABLE ALIGN='CENTER' frame='box' bgcolor='F0F0F0'>
     <TR> 
      <TH width=400px colspan=2 align='left'> Информация о классе: </TH>
     </TR> 
     <TR> 
      <TD> Название: </TD> 
      <TD> <?echo $class_name;?></TD>
     </TR> 
     <TR>
      <TD> Код класса:</TD>
      <TD> <?echo $class_code;?></TD>
     </TR>
     <TR>
      <td> Кол-во оставшихся <BR> приглашений:</td>
      <td> <?echo $class_invites;?></td>
     </TR>
      
     <TR>
      <TD> Отв. за рапортичку: </TD>
      <TD> 
       <SELECT NAME='raporter' onChange="makeRaporter(this.value);"> 
	<OPTION VALUE='<?echo $row_raporter['user_id'];?>'><?echo $row_raporter['Name'];?> </OPTION>
       

<?for ($i=1; $i<=$count; $i++)
	{
    	echo "
       <OPTION VALUE='".$pupils[$i]-> Id."'>".$pupils[$i]-> Name."</OPTION>";
	}?>      
  </SELECT>        
   </TR>
   <tr>
    <td align='right' colspan=2 id='error'></td></tr>
   <tr>
    <td> Клуб класса:</td>
    <td> <?echo$class_club;?></td>
   </tr>
   <tr> 
    <td> Добавить ученика:</td>
    <td><a href='class_edit_add.php'>Онлайн</a></td>
   </tr>
  </TD>
 </table>
 
  <TD valign=top> 
   <table>
    <tr>
     <th align='left'>Список учеников <?echo $class_name;?> класса: </th>
    </tr>
   <TR>
   <TD>
    <TABLE class='table'>
     <TR>
     <TH width='25px' > № </TH> 
      <TH width='250px'  >
       Имя Фамилия 
      </TH> 
      <TH>
       Удалить 
      </TH>
     </TR>

<?       for ($i=1; $i<=$count; $i++){
	if ($i % 2==0) $id='odd'; else $id='even';
	echo "
     	<TR>
      	 <TD id='".$id."' align=center> ".$i." </TD>
         <TD id='".$id."'> <a href='profile.php?id=".$pupils[$i]-> Id."'>".$pupils[$i]-> Name."</a> </TD>
          <TD id='".$id."' align = center >                    
            <BUTTON class='delete'  NAME='".$i."'>
          </TD>
         </TR>";
	}
?> 
 </FORM>
  </TABLE>
   </TD>
 </TR>
 </table>
 </td>
 </tr>
</TABLE>

</div>
</div>
</BODY>
</HTML>
