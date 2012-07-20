<?php
$agent = $_SERVER['HTTP_USER_AGENT'];

if (!strpos($agent,'Chrome') && !strpos($agent,'Firefox')) echo "<font color='red' style='bold'>Содержимое сайта может быть отображено неправильно. 
Для корректного отображения информации <BR>воспользуйтесь браузером Google Chrome. С уважениeм, администрация сайта</font>";
?> 

<body>
<table style='width:100%; border:none;'>
<tr style='padding:0; border:none;'> 
<td colspan=2  style='border:none;'>
<form method='post'>
<div id='topbar' >
 <div>
  <a href='#'>Главная</a>
  <a href='http://www.gymnasium45.edu.kh.ua'>Школа</a>

  <a href='http://www.ag45.org.ua/moo'>Moodle</a>
  <a href='http://www.ag45.org.ua/wpm'>WPM</a>
  <a href='contacts.php'>Контакты</a> 
  <input type='submit' class='submit' name='exit' value='Выход'>
  </div>
</form>

</div>
</td>
</tr>

<tr style='padding: 0'  style='border:none;'>
<td  style='border:none;'> <img src='../images/shadow_left.png' style='float:left; display:inline;'/></td> 
<td  style='border:none;' align='right'><img src='../images/shadow_right.png' style='float:right; display:inline; '/></td>
</table>


