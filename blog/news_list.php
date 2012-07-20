<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
error_reporting(0);

if ($_SESSION['login']!=1) {
	echo("<script>location.href='error.php?id=1'</script>");
	die();
	}	

include "../includes/conncetion.php";
require_once "includes/news.class.php";
require_once ("includes/news.lib.php");
$canAdd=canAddNews($_SESSION['user_id']);

?>



<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<script type='text/javascript' src='../includes/jquery-1.3.2.min.js'></script>
 <link rel='stylesheet' href='css/article.css' type='text/css' media='screen' />
<script type='text/javascript' language=JavaScript>

$(document).ready(function(){
	$('.addNews').mouseover(function(){
		$(this).fadeTo('250','0.8');	  
		});
	$('.addNews').mouseout(function(){
		$(this).fadeTo('250','0.5');
        });

});
</script>


  </head>
  <body>



  <div id='logo'> 
<?require_once("../includes/logo.php")?>
</div> 

<div id='main'>

<div id='leftbar'>

<?require_once "../includes/menu.php";?>

</div>
<div id='content'>
<h6>
 Новости
 <? if ($canAdd) echo "<div style='float:right; margin-right:15px;'>
  <a href='create_news.php' class='addNews' title='Добавить новость' style='opacity:0.5'>
	<img src='../images/pencil.png' > 
  </a>
 </div>";?>
</h6>
<?


  

if (!empty($_GET['page'])) $page=(intval($_GET['page'])-1)*6;
else $page=0;


$result = mysql_query("SELECT * FROM news ORDER BY date DESC");
$num_rows=mysql_num_rows($result);

$res= mysql_query("SELECT * FROM news ORDER BY date DESC limit ".$page.",6");
while($row = mysql_fetch_assoc($res))
{	
        $news= new News($row);
	echo $news->post_brief();
}

if ($num_rows%6==0) $num_pages=$num_rows/6;
        else $num_pages=ceil($num_rows/6);


if ($num_rows > 42) $blocks=8;
else $blocks=$num_pages;


echo "<br><br><br><br>";
$j=intval($_GET['page']);

if ($num_pages>=2)
{ 
if ($j>$num_pages) echo "К сожалению, данная страница не найдена";
else {
$plus=$j+1;
$minus=$j-1;
if ($blocks<8) {$start=1; $j=1;}

else if (($j>3) && ($j<$num_pages-2)) {
$j=$j-3;
$start=0;
}
else if (($j>3) && ($j>= $num_pages-2)) {
$start=0;
if ($j==$num_pages) {$blocks=$blocks-1; }
$j=$num_pages-6;
}
 else if ($j<=3) {
$start=0;
if ($j==1) $start=1;
$j=1;
}
?>
<div align='center'><?
for ($i=$start;$i<=$blocks;$i++)
	{
		
	if ($i==0) {echo "<a class='page' href='news_list.php?page=".$minus."'>< Предыдущая</a>"; continue;}
	else if ($i==8) echo "<a class='page' href='news_list.php?page=".$plus."' name='$num_rows' >Следующая ></a>";  
		else if ($j==$page/6+1) echo "<a class='page_active' href='news_list.php?page=".$j."'>".$j."</a>"; 
		else echo "<a class='page' href='news_list.php?page=".$j."' >$j</a>";
	$j++;
	}
?></div><?
}
}


?>
</div>
</div>
</body>
</html>

