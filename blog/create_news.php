<?
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
if ($_SESSION['login']!=1) {
	echo("<script>location.href='error.php?id=1'</script>");
	die();
	}	

require_once ("includes/news.lib.php");

?>
<html> 
<head>
	<meta content="text/html; charset=utf-8" http-equiv="content-type" />
	<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="../includes/jquery-1.3.2.min.js"></script>

	<script src="../ckeditor/_samples/sample.js" type="text/javascript"></script>
	<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
	<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />
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
<? if (!canAddNews($_SESSION['user_id'])) 	
	die("Ошибка. У Вас нет прав для того, чтобы добавлять новости на сайт.");?>

<form action="news_list.php" method="post">
<h1>Заголовок новости:</h1>
<div class='form_settings'>
 <input type='text' class='text' style="width:970px" name='title' value=''/>
</div>
<br>
<h1>Текст новости:</h1>
<textarea cols="80"  id="editor1" name="editor1" rows="10"></textarea>
<script type="text/javascript">
CKEDITOR.replace( 'editor1',
			{
					//fullPage:false;
					fontSize_sizes : "30/30%;50/50%;100/100%;120/120%;150/150%;200/200%;300/300%",
					toolbar :
					[	
						['Bold', 'Italic','Underline'],
						['Link', 'Unlink', 'Image', ,'SpecialChar'],
						['Source', '-','Preview','Undo','Redo'],
						['FontSize'],
						['NumberedList','BulletedList','-','Blockquote'],
						['Maximize']
					],
			} );

		</script>
<br />
<h1>Метки:<h1/>
	<div class='form_settings'>
      <input type='text' class='text' style="width:970px" name="tags" value=''>
     <p style="color: gray"> Темы, к которым относится новость. Например: поздравление, олимпиада, информатика...</p>
     <br>
     <br>   
        <input type="submit" class='submit' name="save" value="Опубликовать" onclick="
                    	content=CKEDITOR.instances.editor1.getData();
                        $.post('includes/news.lib.php',
							{'content':content, 
							 'tags':$('input[name=tags]').val(), 
							 'title':$('input[name=title]').val(), 
							 'type':'news',
							 'action':'addNews'}, function(msg){alert('yes');},'json');
                         "/>


</form>
</div>
</div>
</body>
</html>
