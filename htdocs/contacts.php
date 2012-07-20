<?php
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");

$h=fopen("../includes/sum.txt","r") or die('error');
$kolvo = fread($h, filesize("sum.txt"));
fclose($h);
echo $kolvo;
if (isset($_POST['enter']) && $_POST['check']=='yes') {
	require_once("../includes/defence.lib.php");
	$name=makeText($_POST['name']);
	$email="sasha.melkonyan@mail.ru";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$subject= "Contacts";
	$message= makeText($_POST['body']) ;
	if (mail($email,$subject,$message,$headers)) 
		echo("<script>location.href='contacts.php?error=0'</script>");
	else echo("<script>location.href='contacts.php?error=1'</script>");
	}
?>
<HTML>
<head>
<title>Журнал</title>  
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />
<style type='text/css'>
.form_settings span {
	width:16%;
	}
h2 {
	font-weight:bold;
	}
.form_settings #refresh {
	display: inline;
	border: 1px solid #BCB9B9;
	border-left:0px;
	height:57px;
	width: 480px;
	}
</style>
</head>
<body>
<div id='logo'> 
<?require_once("../includes/logo.php");
?>
</div> 
<div id='main'><?
?>
<div id='leftbar'><?
require_once ("../includes/menu.php");
?>
</div>
<div id='content'>      
<FORM METHOD='POST' class='form_settings'>   
<input type='hidden' name='count' id='count' value='<?echo $kolvo;?>'>
<input type='hidden' name='check' id='check' value='yes'>
<p>  <h2 style='color: #111'><span>Ваше имя:</span><input type='text' name='name' class='text' ></h2> </p>                   
 
<p> <h2 style='color: #111'><span> Сообщение:</span><textarea id='message'  name='message'></textarea></h2></p> 
<p><h2><span><img id='captcha' src='../includes/Cartinka.php' ><img src='gtk_refresh.png'>  </span>
<input type='text' class='text'  id='num' name ='num' /> <a  href=''  
onclick="document.getElementById('captcha').src='../includes/Cartinka.php?' + Math.random();"> <img src='gtk_refresh.png'> </a>
</h2></p>
<p><span>&nbsp;</span><span>&nbsp;</span><input class='submit' type='submit' name='Enter' value='Отправить' 
onclick=" 
	this.count=getElementById('count').value;
	this.num=getElementById('num').value;
	this.message=getElementById('message').value;
	if (this.count != this.num) {
		getElementById('check').value='no';
		alert('Вы ввели неправильный код безопасности, попробуйте ещё раз');
		}
	if (this.message =='') {
		getElementById('check').value='no';
		alert('Введите текст сообщения');
		}" /></p>    
</div> 

</body>
</HTML>



