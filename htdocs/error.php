<?
header("Content-Type: text/html; charset=utf-8");
$error=$_GET['id'];
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
<div id='main'>
<div id='content'>
<?
//не удалось подключиться к базе данных
if ($error==2) echo "Сервер временно недоступен. Приносим извинения за неудобства. С уважением, адманистрация сайта.";
//пользователь не авторизовался
if ($error==1) echo "Для вохода в систему сначала необходимо авторизоваться, для этого пройдите по 
<a href='../../index.php'>данной ссылке</a>";
//пользователь не являющийся классным руководителем пытаеться редактировать класс
if ($error==3) echo "Данную страницу может просматривать и редактировать только классный руководитель";
if ($error==4) echo "Ученики данного клсасса решили скрыть свою страницу";
if ($error==5) echo "Класса с таким номером не существует";
if ($error==6) echo "На сервере ведутся плановые работы. Приносим извинения за неудобства.";
if ($error==7) echo "Для просмотра этой страницы сначала необходимо выбрать класс, для этого пройдите по данной 
			<a href='class.php'>ссылке</a>";
?>
</div>
</div>
</body>
</html>
