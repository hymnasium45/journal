<?php
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");


if ($_SESSION['login']!=1) {
	echo("<script>location.href='error.php?id=1'</script>");
	die();
	}	
$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);

include ("../includes/connection.php");
require "includes/comment.class.php";
require "includes/news.class.php";
require "../includes/date.lib.php";
require "../includes/defence.lib.php";

$_GET['id']=makeText($_GET['id']);
$_SESSION['news_id']=$_GET['id'];
$row_new=mysql_fetch_array(mysql_query("select * from news where news_id='".$_GET['id']."'"));
$row_new['text'];
$new=new News($row_new);

$row_com=mysql_fetch_array(mysql_query("select * from news_comments news_id='".$_GET['id']."'"));
$comm= new Comment;
?>
<head>
<meta http-equiv='Content-Type' content='text/html'; charset='utf-8' />

<link rel='stylesheet' href='css/comment.css' type='text/css' media='screen' /> 
<link rel='stylesheet' href='css/article.css' type='text/css' media='screen' /> 
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' /> 

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

<?




echo $new->post_full();

echo"

<div id='cBlock'>
";
$news_id=mysql_escape_string($_GET['id']);
$comm=$comm->sort_ans(0,0,-25, '1',1,$news_id);
?>

<div class="addCommentContainer">

	<p>Добавить комментарий</p>
            
            <label for="text">Поле для комментария</label>
            <textarea name="text" id="text" cols="20" rows="5" style="width:500px"></textarea>
            
            <input type="button" class="submit" value="Добавить" />
    		<input type="hidden" id="ans_num" value="0"/>


</div>

</div>
</div>
</div>
<script type="text/javascript" src="../includes/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="includes/script.js"></script>

</body>
</html>
