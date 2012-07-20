<?
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
include("../includes/connection.php");
require_once("../includes/defence.lib.php");
require_once("../includes/date.lib.php");
	 

if ($_POST['action']=='check') {
	if (isset($_POST['surname'])) {
		if ($_POST['surname']=='') echo "Введите фамилию"; else
		if (!isName($_POST['surname'])) echo "Фамилия содержит только русские буквы";
		}
	else if (isset($_POST['name'])) {
		if ($_POST['name']=='') echo "Введите имя"; else
			if (!isName($_POST['name'])) echo "Имя содержит только русские буквы";
			}
	die();
	}	

if ($_POST['action']=='save') {
	//Проверяем данные
	if (!isName($_POST['surname']) || !isName($_POST['name'])) {
		echo "Данные введены некорректно";
		die();
		}
	$name=makeText($_POST['surname']).'&#160'.makeText($_POST['name']);
	$code=makeText($_POST['code']);
	$sex=makeText($_POST['sex']);
	$date=makeText($_POST['date']);
	$pass=md5($_POST['pass']);
	//Получаем заявку с данным кодом
	$query="select * from applies where code='".$code."'";
	$result=mysql_query($query,$link);
	$row=mysql_fetch_array($result);
	$mail=$row['email'];
	
	//Регистрируем пользователя
	$query="insert into users (`Name`,`email`,`Password`,`birthday`,`sex`) 
			values ('".$name."','".$mail."','".$pass."','".$date."','".$sex."')";
	$result=mysql_query($query,$link);
	//Получаем его айди
	$query="select * from users where email='".$mail."'";
	$result=mysql_query($query,$link);
	$row=mysql_fetch_array($result);
	$user_id=$row['user_id'];
	
	//Удаляем заявку
	$query="delete from applies where code='".$code."'";
	$result=mysql_query($query,$link);
	$_SESSION['user_id']=$user_id;
	$_SESSION['login']=1;
	die($user_id);
	}

$code=makeText($_GET['id']);
$query="select * from applies where code='".$code."'";
$result=mysql_query($query,$link);
if (!$result) 
	echo "Ошибка. Не удалось выпонить запрос.";
$num=mysql_num_rows($result);
if ($num==0) {
	echo "Ошибка. Приглашения с таким кодом не существует.";
	die();  
	}
	

?>
<HTML>
<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
<script type='text/javascript' src='../includes/ajax.js'></script>
<script type="text/javascript" src='../includes/jquery-1.3.2.min.js'></script>
<script language="JavaScript" src="../includes/md5.js"></script>
<script language="JavaScript" src="../includes/simple.lib.js"></script>

<script src="../includes/jquery-1.4.3.min.js"></script>

<link rel='stylesheet' href='../css/tab.css' type='text/css' media='screen' />
<script type='text/javascript' language=JavaScript>

function ReadName(name) {
	Handler= function(Request) {
	document.getElementById(name+'text').innerHTML=Request.responseText;
    }	
	document.getElementById('savetext').innerHTML='';
	var str=name+'='+document.getElementById(name).value+'&action=check';
	SendRequest('post','registration.php',str,Handler);
	}
function saveProfile() {
	Handler= function(Request) {
	var answer=Request.responseText;
	if (answer.length<20 ) 
		location.href='profile.php?id='+answer;
	else  
		document.getElementById('savetext').innerHTML=answer;
    }
	var check=true;
	//Проверяем правильность имени
	var name= document.getElementById('name').value;
	if (name=='') {
		document.getElementById('nametext').innerHTML='Введите имя';
		check=false;
		}
	//Проверяем правильность фамилии
	var surname= document.getElementById('surname').value;
	if (surname=='') {
		document.getElementById('surnametext').innerHTML='Введите фамилию';
		check=false;
		}
	var sex=document.getElementById('sex').value;
	var day=parseInt(document.getElementById('day').value);
	var month=parseInt(document.getElementById('month').value);
	var year=parseInt(document.getElementById('year').value);
	
	//Проверяем валидность пароля
	var pass1=document.getElementById('pass1').value;
	var pass2=document.getElementById('pass2').value;
	
	if (pass1.length<8) {
		document.getElementById('pass1_error').innerHTML='Пароль должен содержать не менее 8 символов';
		check=false;
		}
	else if (pass1!=pass2) {
		document.getElementById('pass1_error').innerHTML='';
		document.getElementById('pass2_error').innerHTML='Пароли не совпедают';
		check=false;
		}
	else 
		document.getElementById('pass2_error').innerHTML='';
	
	var get=parseGetParams();
	
	if (check) {
		var str='name='+name+'&surname='+surname+'&sex='+sex+'&date='+year+'-'+month+'-'+day+'&code='+get['id']+'&pass='+pass1+'&action=save';
		SendRequest('post','registration.php',str,Handler);
		}
	}

</script>
</HEAD>
<BODY>
<div id='logo'> 
<?require_once("../includes/logo.php");?>
</div> 
<div id='main' style='background-color:#FFF;'>
<div id='content' style='border:none;'>
<FORM  method ='POST' enctype='multipart/form-data' class='form_settings'>
 <TABLE align='center' >
 <tr>
    <td id='tab_content'  >
     <table>
    <tr>
	 <th id='tab_header' colspan=2 align=left> Личная информация: </th>
	</tr>
	<tr>
	 <TD id='tab_name' align='right' height=40px width=200px> Фамилия: </TD> 
     <TD> 
      <input type='text' class='tab_text' name='surname' id='surname'
		onkeyup="ReadName('surname');"> </TD>
    </tr>
    <tr> 
     <td colspan=2 align='right' id='surnametext' class='error'> </td>
	</tr>
	</TR>
    <TR> 
	 <TD id='tab_name' align='right' height=40px> Имя: </TD> 
	 <TD> <input type = 'text' class='tab_text' name ='name' id='name' 
		 onkeyup=" ReadName('name');"></td>
    </tr>
    <tr>
     <td colspan=2 align='right' id='nametext' class='error'></td>
    </tr>      
     <TR > 
     <TD height=40px id='tab_name' align='right'> Пол: </TD> 
     <TD> <SELECT NAME='sex' id='sex' style='width:250px'>
				<OPTION value='none'>Выберите пол</OPTION>
				<OPTION value='male'>мужской</OPTION>
				<OPTION value='female'>женский</OPTION>
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
   
    <tr>
     <td id='tab_name'>Введите пароль: </td>
     <td><input type='password' class='tab_text' id='pass1'></td>
    </tr>
    <tr> 
     <td colspan=2 align='right' id='pass1_error' class='error'></td> 
    </tr>
    <tr>
     <td id='tab_name'>Повторите пароль: </td>
     <td><input type='password' class='tab_text' id='pass2'></td>
    </tr>
    <tr> 
     <td colspan=2 align='right' id='pass2_error' class='error'></td> 
    </tr>
    <tr>
     <td colspan=2 align='right'><input type='button' class='submit' name='save' value='Зарегистрироваться'
									onclick='saveProfile();'></td>
    </tr>
<tr> 
     <td colspan=3 align='right' id='savetext' class='error' width='300px'> </td>
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
