<?

session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");

if ($_SESSION['login']!=1) echo("<script>location.href='error.php?id=1'</script>");

$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);
 include "../includes/db_connect.lib.php";
 collation();
require_once("../includes/register_users.php");
require_once "../includes/defence.lib.php";
if ($_POST['ajax']=='private') {
	$adress=makeText($_POST['adress']);
	$phone=makeText($_POST['phone']);
	if ($_POST['sex']=='female' || $_POST['sex']=='male') $sex=$_POST['sex']; else $sex='none';
	$date=$_POST['date'];
	$query="update `users` set `sex`='".$sex."',`phone`='".$phone."',`adress`='".$adress."',
			`birthday`='".$date."' where `user_id`='".$_SESSION['user_id']."'";
	$result=mysql_query($query,$link);
	if ($result) echo "<font class='okey'>Данные успешно сохранены</font>";
		else echo "Ошибка. Не удалось обновить данные"; 
    die();
	}
if ($_POST['ajax']=='change') {
		$pass=md5($_POST['pass']);
		$query="update `users` set `Password`='".$pass."' where `user_id`='".$_SESSION['user_id']."'";
		$result=mysql_query($query,$link);
		if ($result) echo "<font class='okey'>Пароль успешно изменён</font>";
			else echo "Ошибка. Не удалось изменить пароль.";
		die();
		}
if ($_POST['ajax']=='save') {
	require_once("../includes/defence.lib.php");
	if (!isName($_POST['surname'])) {
		echo "Фамилия введена некорректно.";
		die();
		}
	if ($_POST['surname']=='') {
		echo "Введите фамилию.";
		die();
		}
	if (!isName($_POST['name'])) {
		echo "Имя введено некорректно.";
		die();
		}
	if ($_POST['name']=='') {
		echo "Введите имя.";
		die();
		}
	if (!isEmail($_POST['email'])) {
		echo "Недопустимый электронный адрес.";
		die();
		}
	if (!freeEmail($_POST['email'],$_SESSION['user_id'])) {
		echo "Данный элктронный адрес уже используется.";
		die();
		}
	
	$name=makeText($_POST['surname']).'&#160'.makeText($_POST['name']);
	$email=makeText($_POST['email']);

	$query="update `users` set `Name`='".$name."',`email`='".$email."' where `user_id`='".$_SESSION['user_id']."'";
	$result=mysql_query($query,$link);
	if ($result) echo "<font class='okey'>Данные успешно сохранены</font>";
		else echo "Ошибка. Не удалось обновить данные.";
	die();
	}
	
	if ($_POST['ajax']=='check') {
	require_once("../includes/defence.lib.php");
		if (isset($_POST['surname'])) {
			if ($_POST['surname']=='') 
				echo "Введите фамилию"; 
			else
				if (!isName($_POST['surname'])) 
					echo "Фамилия содержит только русские буквы";
			}
		else if (isset($_POST['name'])) {
			if ($_POST['name']=='') 
				echo "Введите имя"; 
			else
				if (!isName($_POST['name'])) 
					echo "Имя содержит только русские буквы";
			}
		else if (isset($_POST['Login'])) {
			if ($_POST['Login']=='') 
				echo "Введите логин"; 
			else
				if (isLogin($_POST['Login'],$_SESSION['user_id'])) 
					echo "Данный логин уже используется";
			}
		else if (isset($_POST['email'])) {
			if ($_POST['email']=='') 
				echo "Введите эл. адрес"; 
			else
				if (!isEmail($_POST['email'])) 
					echo "Вы неправильно ввели эл. адрес";
				else 
					if (!freeEmail($_POST['email'],$_SESSION['user_id'])) 
						echo "Эл. адресс уже используется";
                        }
			die();
	}	
	$error=$_GET['error'];
	$query="select * from users where user_id ='".$_SESSION['user_id']."'";

	$result=mysql_query($query,$link);
	$row = mysql_fetch_array($result);
	$secur=$row['security'];
	$DateSec=substr($row['security'],0,1);
	$DateSecMass=array('','','','');
	$DateSecMass[$DateSec]="selected";
	
	$AdresSec=substr($row['security'],1,1);
	$AdresSecMass=array('','','','');
	$AdresSecMass[$AdresSec]="selected";
	
	$Date= $row['birthday'];
	
	$Pos=strpos($Date,'-');
	$year= substr($Date,0,$Pos);
	$Date=substr($Date,$Pos+1,strlen($Date)-$Pos);
	$Pos=strpos($Date,'-');
	$month=intval(substr($Date,0,$Pos));
	$day=intval(substr($Date,$Pos+1));
	$my_pass=$row['Password'];

$mail=$row['email'];
$about=$row['about'];
$interests=$row['interests'];
$sex=$row['sex'];
$phone=$row['phone'];
$adress=$row['adress'];
$security=$row['security'];
	$male='';
	if ($row['sex']=='male') 
		$male='selected';
	if ($row['sex']=='female')
		$male='selected';
$oldName= $row['Name'];
	$Pos=strpos($oldName, '&#160');
	$surname=substr($oldName,0,$Pos);
	$name=substr($oldName,$Pos+5,strlen($oldName)-$Pos);

?>


<HTML>
<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
<script type='text/javascript' src='../includes/ajax.js'></script>
<link rel='stylesheet' href='../css/tab.css' type='text/css' media='screen' />
<link rel="stylesheet" type="text/css" href="../css/select.css" />

<script type="text/javascript" src='../includes/jquery-1.3.2.min.js'></script>
<script language="JavaScript" src="../includes/md5.js"></script>
<script src="../includes/jquery-1.4.3.min.js"></script>
<script src="../includes/select-script.js"></script>

<script type='text/javascript' language=JavaScript>

$(document).ready(function(){
        $("ul#navigation li a").click(function() {
				$("ul#navigation li.selected").removeClass('selected');
				$("ul#navigation li").addClass('none');
			    $(this).parents().addClass('selected');
                $(this).parents().removeClass('none');
                //alert($(this).parents().attr('class'));
                //alert($("ul#navigation li").attr('class'));
                return false;
        });
});
function profile_show()
{

document.getElementById('profile').style.display='';
document.getElementById('private').style.display='none';
//document.getElementById('style').value='task';

}
function private_show()
{
document.getElementById('private').style.display='';
document.getElementById('profile').style.display='none';
//document.getElementById('style').value='table';

}

function ReadName(name) {
	Handler= function(Request) {
		document.getElementById(name+'text').innerHTML=Request.responseText;
		}	
	document.getElementById('savepattern').innerHTML='';
	var str=name+'='+document.getElementById(name).value+'&ajax=check';
	SendRequest('post','profile_edit.php',str,Handler);
	}
function saveInfo() {
	Handler= function(Request) {
	document.getElementById('privatetext').innerHTML=Request.responseText;
    }
	var adress=document.getElementById('adress').value;
	var phone=document.getElementById('phone').value;
	var sex=document.getElementById('sex').value;
	var day=parseInt(document.getElementById('day').value);
	var month=parseInt(document.getElementById('month').value);
	var year=parseInt(document.getElementById('year').value);
	var str='sex='+sex+'&adress='+adress+'&phone='+phone+'&date='+year+'-'+month+'-'+day+'&ajax=private';
	SendRequest('post','profile_edit.php',str,Handler);
	}
function saveProfile() {
	Handler= function(Request) {
	document.getElementById('savepattern').innerHTML=Request.responseText;
		}
	var check=true;
	var name= document.getElementById('name').value;
	var surname= document.getElementById('surname').value;
	var email=document.getElementById('email').value;
	
	if (check) {
		var str='name='+name+'&surname='+surname+'&email='+email+'&ajax=save';
		SendRequest('post','profile_edit.php',str,Handler);
		}
	}
function changePass() {
	Handler= function(Request) {
	document.getElementById('changepattern').innerHTML=Request.responseText;
    document.getElementById('pass1').value=''; 
    document.getElementById('pass2').value='';
	document.getElementById('oldpass').value=''; 
		
    }	
	var oldpass=calcMD5(document.getElementById('oldpass').value);
	var pass1=document.getElementById('pass1').value;
	var pass2=document.getElementById('pass2').value;
	var truepass=document.getElementById('truepass').value;
	//alert(document.getElementById('truepass').value);
	
	var f=true;
	if (pass2.length<8) {
		f=false;
		document.getElementById('newpasstext').innerHTML='Слишком короткий пароль'; 
		} else 
	if (pass2!=pass1) {
		f=false;
		document.getElementById('newpasstext').innerHTML='Введённые пароли не совпадают'; 
		}
	if (f) document.getElementById('newpasstext').innerHTML=''; 

	if (oldpass!=truepass) {
		f=false;
		document.getElementById('oldpasstext').innerHTML='Неправильный пароль'; 
		}
	else document.getElementById('oldpasstext').innerHTML=''; 
		
		
	if (f) {
		var str='pass='+pass2+'&ajax=change';
		SendRequest('post','profile_edit.php',str,Handler);
		}
	}
</script>
<style>
.head {
	}
.name {
	padding-right:20px;
	height:40px;
	width:200px;
	}	
</style>
</HEAD>
<BODY>
<div id='logo'> 
<?require_once("../includes/logo.php");?>
</div> 
<div id='main'>
<??>
<div id='leftbar'>
<?require_once "../includes/menu.php";
?>
</div>
<div id='content'>
<FORM  method ='POST' enctype='multipart/form-data' >
<div class='form_settings'>
 <TABLE align='center'>
 <tr>
	 <td> 
   	  <ul id="navigation">
	   <li class='selected'>  <a  href='#' onclick='profile_show();'>Профиль</a> </li>
	   <li class='none'> <a href='#' onclick='private_show();'>Личное</a> </li> 
         </ul>
         </td>
	</tr>
	
   <TR id='profile'> 
    <td id='tab_content'  >
     <table>
    <tr>
	 <th id='tab_header' colspan=2 align=left> Личная информация: </th>
	</tr>
	<tr>
	 <TD id='tab_name' align='right' height=40px width=200px> Фамилия: </TD> 
     <TD> 
      <input type='text' class='tab_text'  name='surname' id='surname' <?echo"value='".$surname."'";?>> </TD>
    </tr>
    <tr> 
     <td colspan=2 align='right' id='surnametext' class='error'> </td>
	</tr>
	</TR>
    <TR> 
	 <TD id='tab_name' align='right' height=40px> Имя: </TD>  
	 <TD> 
	 <input type = 'text' class='tab_text' name ='name' id='name' <?echo"value='".$name."'";?> 
		 ></td>
    </tr>
   <tr>
     <td colspan=2 align='right' id='nametext' class='error'></td>
    </tr>      
   <TR> 
	 <TD height=40px id='tab_name' align='right' height=40px> Эл. адрес: </TD> 
	 <TD> <input type = 'text' class='tab_text' id='email' name='email' value='<?echo$mail;?>'  
		onkeyup=" ReadName('email');"
		onclick=" ReadName('email');"></td>
	 <td><?/*<select name "fancySelect" class="makeMeFancy" id='email_save'>
			 <option value="<?echo$DateSec;?>" selected="selected" data-skip="1">C</option>
        	<option value="2" data-icon="../images/select/Web.png" <?echo$DateSecMass[2]?>  data-html-text="Всем">Всем</option>
        	<option value="1" data-icon="../images/select/Users.png" <?echo$DateSecMass[1]?> data-html-text="Одноклассникам">Одноклассникам</option>
            <option value="0" data-icon="../images/select/Lock.png" <?echo$DateSecMass[0]?> data-html-text="Никому">Никому</option>
            </select>*/?></td>
    </tr>
    <tr> 
     <td colspan=2 align='right' id='emailtext' class='error' > </td>
    </TR>
    
    
    <tr>
     <td colspan=2 align='right'><input type='button' class='submit' name='save' value='Сохранить' id='save'
									onclick="
											saveProfile();"></td>
    </tr>
    <tr>
     <td colspan=2 align='right' id='savepattern' class='error'></td>
    </tr>
    <tr>
     <th id='tab_header' colspan=2 align='left'>Изменение пароля:</th>
    </tr>
    <input type='hidden' id='truepass' value='<?echo$my_pass;?>'>
    <TR> 
     <TD id='tab_name' align='right'> Введите старый пароль:</TD>
	 <TD> <input class='tab_text' id='oldpass' type='password' name='oldpass'/></TD>
	</TR>
	 <tr> 
     <td colspan=2 align='right' id='oldpasstext' class='error' width='300px'> </td>
    </TR>
    <TR> 
     <TD id='tab_name' align='right'> Введите новый пароль:</TD> 
	 <TD> <input class='tab_text' id='pass1' type='password' name='newpass1'></TD>
	</TR>

    <TR> 
     <TD id='tab_name' align='right'> Повторите пароль:</TD>
     <TD> <input class='tab_text' id='pass2' type='password' name='newpass2'></TD>
    </TR>
    <tr> 
     <td colspan=2 align='right' id='newpasstext' class='error' width='300px'> </td>
    </TR>
   
    <TR> 
     <TD colspan=2 align='right'> <input type='button' class='submit' value='Изменить' name='change' id='change'
									onclick='changePass();'> </td>
    </tr>
    <tr> 
     <td colspan=2 align='right' id='changepattern' class='error' width='300px'> </td>
    </TR>
     

   </table> 
  </td>
 </tr> 
 <tr id='private' style='display:none'>
  <td id='tab_content'>
   <table>
   <tr>
    <th id='tab_header' colspan=3 align='left' >Личная информация:</th></tr>
    <TR > 
     <TD height=40px id='tab_name' align='right'> Пол: </TD> <TD> <SELECT NAME='sex' id='sex' style='width:250px'>
				<OPTION value='none'>Выберите пол</OPTION>
				<OPTION <?echo $male;?> value='male'>мужской</OPTION>
				<OPTION <?echo $female;?> value='female'>женский</OPTION>
				</SELECT>
	 </TD> 
	</TR>
    <TR> 
     <TD height=40px id='tab_name' align='right'> Дата рождения: </TD> 
     <TD> <SELECT NAME='Day' id='day' > 
	  <?echo "	<OPTION VALUE='0'> День</OPTION>";
	  for ($i=1; $i<=31; $i++){
	   if ($i<10) $t='0'.$i; else $t=$i;
	   echo "<OPTION VALUE='".$t."'";
	   if ($i==$day) echo "selected";
	   echo"> ".$t." </OPTION>";
	   }
	  echo "</SELECT> <SELECT style='width:100px' NAME='Month' id='month'> 
        <OPTION VALUE='0'> Месяц</OPTION>";
	  require_once("../includes/date.lib.php");
	  for ($i=1; $i<=12; $i++){
		$t=getDateMonth($i);
       echo "<OPTION VALUE='".$i."'";
       if ($i==$month) echo "selected";
       echo"> ".$t." </OPTION>";
       }
	  echo "</SELECT> <SELECT NAME='Year' id='year'> 
        <OPTION VALUE='0'> Год</OPTION>";
	  for ($i=1940; $i<=2005; $i++){
        echo "<OPTION VALUE='".$i."'";
        if ($i==$year) echo "selected";
        echo"> ".$i." </OPTION>";
        }
	   ?>
	  </SELECT>
	 </TD>
	</TR>
    <TR> 
	 <TD id='tab_name' height=40px align='right'> Адрес: </TD> 
	 <TD> <input type='tab_text' class='text' id='adress' name='adress' value='<?echo$adress;?>'></TD>
     <td><?/*<select name "fancySelect" class="makeMeFancy" id='adress_save'>
			<option value="<?echo$AdresSec;?>" selected="selected" data-skip="1">C</option>
        	<option value="2" data-icon="../images/select/Web.png" <?echo$AdresSecMass[2]?>  data-html-text="Всем">Всем</option>
        	<option value="1" data-icon="../images/select/Users.png" <?echo$AdresSecMass[1]?> data-html-text="Одноклассникам">Одноклассникам</option>
            <option value="0" data-icon="../images/select/Lock.png" <?echo$AdresSecMass[0]?> data-html-text="Никому">Никому</option>
            </select>*/?></td>
    
    </TR>
    <TR> 
	 <TD id='tab_name' height=30px align='right'> Телефон: </TD> 
	 <TD> <input type='tab_text' class='text' id='phone' name='phone' value='<?echo$phone;?>'></TD>
    </TR>
    <TR> 
     <TD height=40px; colspan=3 align='right'> 
					<input type='button' class='submit' value='Сохранить' name='savePrivate' id='savePrivate'
									onclick="saveInfo();"> </td>
    </tr>
    <tr> 
     <td colspan=3 align='right' id='privatetext' class='error' width='300px'> </td>
    </TR>
  
   </table>
  </td>
 </tr>
</table>
</div>
 </FORM> 
    


</div>
</div>
</BODY>
</HTML>
