<?php 
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
$mail_error=$_SESSION['error'];

function generate_password($number)
  {
    $arr = array('a','b','c','d','e','f',
                 'g','h','i','j','k','l',
                 'm','n','o','p','r','s',
                 't','u','v','x','y','z',
                 'A','B','C','D','E','F',
                 'G','H','I','J','K','L',
                 'M','N','O','P','R','S',
                 'T','U','V','X','Y','Z',
                 '1','2','3','4','5','6',
                 '7','8','9','0',
                 '(',')','[',']','!','?',
                 );
    // Генерируем пароль
    $pass = "";
    for($i = 0; $i < $number; $i++)
    {
      // Вычисляем случайный индекс массива
      $index = rand(0, count($arr) - 1);
      $pass .= $arr[$index];
    }
    return $pass;
  }
$link= new mysqli($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
$link-> set_charset("utf8");

if (isset($_POST['send']) && $_POST['check']=='ok') {
	require_once"../includes/defence.lib.php";
	if (isEmail($_POST['mail'])) {
		$result= $link-> query("select * from `users` where `email`='".$_POST['mail']."'"); 
			if ($row= $result-> fetch_assoc()) {
			$pass=generate_password(8);
			$title= "Your new password";
			$name=str_replace("&#160"," ",$row['Name']);
			$text=" <html>
				<head>
				<title>Журнал</title>
				</head>
				<body>
				Здраствуйте, ".$name. "!<BR>
				Ваш новый пароль: ".$pass."<BR>
				Вводите пароль внимательно, с учётом регистра букв.<BR>
				С уважением, администрация <a href='www.ag45.org.ua'>
							   сайта </a>.
				</body>
  				</html>";
			require_once ("../includes/mail.class.php");
			$mail=new mail($_POST['mail'],$title,$text);	
			if ($mail-> sendMail()) {
				$pass=md5($pass);
				$res_update=$link-> query("update `users` set `Password`='".$pass."' 
							   where `user_id`='".$row['user_id']."'");
				$_SESSION['error']='okey';
				echo ("<script>location.href='forgot_pass.php'</script>");
				}
			else  {		
				$_SESSION['error']=$mail-> getError();
                echo ("<script>location.href='forgot_pass.php'</script>");
				}
			}	
			else {
				$_SESSION['error']='пользователь с данным адресом не найден';
				echo ("<script>location.href='forgot_pass.php'</script>");
				}
		}
		else { 
			$_SESSION['error']="Вы ввели неправильный адрес, попробуйте ещё раз";
			echo ("<script>location.href='forgot_pass.php'</script>");
			}
	}

?>
<html>
<head>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  

</HEAD>
<BODY>
<div id='logo'>
 <? require_once"../includes/logo.php";
   ?>
</div>
<div id='main' style='background-color:white'>
 <div id='content' style='border:none'>
 <form method='post' class='form_settings'>
 <table align='center' style='margin:100px auto;'>
  <th><h5>Средство борьбы с амнезией</h5></th>
  <? 
     if ($mail_error!='' && $mail_error=='okey') {
  		echo "<tr> <td class='okeytd'>Письмо с данными успешно выслано</td></tr>";
		}
	else  
	if ($mail_error!='') {
		echo "<tr> <td class='warningtd'>".$mail_error."</td></tr>";
		
		}
		?>
  <tr>
   <td height=50px> Введите эл. адрес, указаный в вашем профиле: </td>
  </tr>
  <tr>
    <td><input type='text' style='width:400px'class='text' name='mail' id='mail'></td>
  <tr>
    <td height=60px align=right> 
     <input type='hidden' name='check' id='check' value='ok'>
     <input type='submit' class='submit' name='send' value='Выслать' onclick="
	this.mail=document.getElementById('mail').value;
	if (this.mail=='') {
	 	alert('Введите адрес');
	 	getElementById('check').value='empty';
		}; "> </td>
  </tr>
  <tr>
  <td align=right> <a href='../../index.php'>Я вспомнил пароль!</a></td>
  </tr>
 </form>
 </div>
 </div>
</body>
</html>

