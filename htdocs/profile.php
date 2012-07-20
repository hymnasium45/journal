<?
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");

if ($_SESSION['login']!=1) 	
	echo("<script>location.href='error.php?id=1'</script>");

include_once("../includes/connection.php");
require_once("../includes/register_users.php");
	
if (isset($_POST['upload'])) {	
	$uploaddir='../avatars/';
    $oldname=$_FILES['userfile']['name'];
    $pos=strpos($oldname,'.');
    $type=strtolower(substr($oldname,$pos+1));
 	$user_id=intval($_SESSION['user_id']);
 	$name='temp'.$user_id.'.'.$type;
	require_once("../includes/file_type.php");
	if (isimage($type)) {
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir.$name)) {
		require_once("../includes/images.lib.php");
		$temp=$uploaddir.$name;
		$size=makeAvatar($temp);
		$avatar=$uploaddir."avatar".$user_id.".png";
		resizeImage($temp,$avatar,$size[1],$size[0]);
		$icon=$uploaddir."icon".$user_id.".png";
		$size=makePost($temp);
		resizeImage($temp,$icon,$size[1],$size[0]);
		unlink($temp);
		$query_update="update `users` set `avatar`='avatar".$user_id.".png' where `user_id`='".$_SESSION['user_id']."'";
		$result_update=mysql_query($query_update,$link);
		//echo ("<script>location.href='profile.php?id=".$_SESSION['user_id']."'</script>");
                }
                else {
                $error=6;//"не удалось загрузить файл, попробуйте ещё раз";
                //$_SESSION['error']=$_FILES['userfile']['error']." ".$_FILES['userfile']['size'];
				echo("<script>location.href='profile.php?id=".$_SESSION['user_id']."&error=".$error."'</script>");
                }
	}
	else {
		$error=7;//"сервер не поддерживает данный формат изображений";
		echo("<script>location.href='profile.php?id=".$_SESSION['user_id']."&error=".$error."'</script>");
		}	
	}

if ($_POST['action']=='invite') {
	require_once("../user/includes/user.lib.php");
	echo inviteUser($_POST['mail'],$_SESSION['user_id']);
	die();
	}


	$id=intval($_GET['id']);
	$query="select * from users where user_id ='".$id."'";
	$result=mysql_query($query,$link);	
	$row = mysql_fetch_array($result);

if (!$result) { 
	require_once("../includes/error_page.php");
	makeError("Пользователя с таким индификационным номером не существует"); 
	die(); 
	}

	require_once("../user/includes/user.class.php");

	$user=new user($id);
	$user-> getUser();
	$img=$user-> avatar;

	require_once("../includes/access.lib.php");
	require_once("../includes/date.lib.php");
	require_once("../user/includes/user.lib.php");
	
	if (isOnline($id)){
		$state="<font color=green>Онлайн</font>";
		}
	else if (isAFK($id)) {
		$state="<font color=orange> < 10 минут </font>";
		}
	else {
		$time=makeDate(lastAppear($id));
		$state=$time;
		}
	$category='Без категории';
	if (isPupil($id)) {
		$category='Ученик';
		}
	else if (isTeacher($id)) {
		$category='Учитель';
		}
		
$query_comment="select * from `club_messages` where `user_id`='".$id."'";
$result_comment=mysql_query($query_comment,$link);
$rate=0;
while ($row_comment=mysql_fetch_array($result_comment)) 
	$rate+= $row_comment['rate'];
if ($rate==0) $rate="<font style='color:gray; font-size:large'>".$rate."</font>";
if ($rate>0) $rate="<font style='color:green; font-size:large'>".$rate."</font>";
if ($rate<0) $rate="<font style='color:red; font-size:large'>".$rate."</font>";
?>
<HTML>

<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
<link rel='stylesheet' href='../css/window.css' type='text/css' media='screen' />  
<script type='text/javascript' src='../includes/jquery-1.3.2.min.js'></script>
<script type='text/javascript' src='../includes/ajax.js'></script>
<script type='text/javascript' src='../includes/window.js'></script>

<link rel='stylesheet' href='../css/tab.css' type='text/css' media='screen' />

<script type='text/javascript' language=JavaScript>
function invite_user() {
	Handler= function(Request) {
		document.getElementById('inviteError').innerHTML=Request.responseText;
		}
	var mail=document.getElementById('inviteMail').value;
	var str="mail="+mail+"&action=invite";
	SendRequest('post','profile.php',str,Handler);

	}
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
</script>
<STYLE type="text/css">

td {}
 #left {color: #808080; }
	
</STYLE>
</HEAD>

<BODY>

  <div id='logo'> 
<?require_once("../includes/logo.php");?> 
</div> 
<div id='main'>
<div id='leftbar'>
<?require_once "../includes/menu.php";
?>
</div>       
        <div id='content'>
		<form method='post' enctype='multipart/form-data'>
		<div class='form_settings'>
			<div id='boxes'>
			 <div id='dialog' class='window' style='width:500px; height:250px;'>
			  <table style='padding:30px'>
			  <tr>
			   <th colspan=2>Загрузка фотографии</th>
			  </tr>
			  <tr>
			   <td height=50px>Выберите файл:
			    <input style='padding-top:30px;' name='userfile' type='file'/>
			   </td>
			  </tr>
			  <tr>
			  <th height=60px valign='bottom'>
		      <input type='submit' name='upload' class='submit' value='Загрузить'>
              <input type='hidden' name='MAX_FILE_SIZE' value='30M' />
              </th>
              </tr>
              </table>
			  <div class='closed'></div>
             </div>
			 <div id='mask'></div>
			</div>
			<div id='boxes'>
			 <div id='dialog1' class='window' style='width:500px; height:250px;'>
			  <div id='head'> Пригласить друга </div>
			  <div id='w_content' style="background-color:white">
			   <table >
			    <tr>
			     <td ><h1>Электронный адрес:</h1></td>
			    </tr>
			    <tr>
			     <td><input maxlength=50 style='width:450px'type='text' class='text' id='inviteMail' placeholder='Введите значение'></td>
			    </tr>
               </table>
              </div>
			  <div id='footer'>
			   <table height=100%>
				<tr>
				 <td  width=340px align='right'><input type='button' id='create' class='w_button' value='Пригласить'
						onclick="
						invite_user();"></td>
				 <td width=110px align='right'><input type='button' class='w_button' value='Отменить'
					onclick="location.href='';"></td>
				</tr>
				<tr>
				 <td colspan=2 align=right class='error' id='inviteError'> </td>
				</tr>
			   </table>
			  </div>
			  <div class='closed'></div>
             </div>
             <div id='mask'></div>
		    </div>

		
		<h6><?echo$row['Name'];?></h6>
		<TABLE valign='top'>
		 <? if (isset($_GET['error'])) {
	 echo "<tr><td colspan=2 class='warningtd'> Ошибка.";
	if ($_GET['error']==7) echo "Сервер не поддерживает такой формат изображений";
	if ($_GET['error']==6) echo "Не удалось загрузить файл, попробуйте ещё раз";
	echo "</td></tr>";
	}?>
		 <TR>
		  <TD>
		   <TABLE align='center'  valign='top' style='padding-top:50px;'>
		    <TR> <TD width='200px' height='300px' valign='top'><?echo $img;?></TD></TR>
<?if ($_SESSION['user_id']==$id) {
	?>
		    <TR> <TD class='menu'><a href='profile_edit.php'>Редактировать</a></TD></tr>
			 <TR> <td class='menu'><a id='photo_edit'  href='#dialog' name='modal' >Обновить фотографию</a></td></TR>     
			<TR> <td class='menu'><a id='invite_user'  href='#dialog1' name='modal' >Пригласить друга</a></td></TR>     
			
	<?}?>

	 	   </TABLE>
		  </TD>
		  <td valign='top'>
            <table>
		     <TR> 
		      <td id='tab_td' align='left'>
		      <ul id="navigation" style='width:300px'>
			   <li class='selected'>  <a  href='#' >Профиль</a> </li>
	          </ul>
		  </TR>
		   <TR> 
		    <TD id='tab_content' style='width:575px'>
		     <TABLE>
		      <th id='tab_header' align='left' colspan=2> Личная Информация:</th>
	 	      <TR> 
		       <TD id='tab_name'> Эл. адрес: </TD>
		       <TD width=200px> <?echo $row['email'];?></TD> 
		      </TR>
                      <TR> 
                       <TD id='tab_name'> Телефон: </TD>
                       <TD width=200px> <?echo  $row['phone'];?></TD> 
                      </TR>
                      <TR> 
                       <TD id='tab_name'> Адрес: </TD>
                       <TD width=200px> <?echo  $row['adress']?></TD> 
                      </TR>
	         
                    </TD>
                   </TR>		
		   <TR>
		    <TD id='tab_name'> Категория: </TD>
		    <TD> <? echo $category;?></TD>
		   </TR>
		   <tr>
		    <th colspan=2 align='left' id='tab_header'>Статистика</th>
		   </tr>
		    <TR> 
                    <TD id='tab_name' > Посл. раз на сайте: </TD>
                    <TD width='200px'> <?echo $state;?></TD>
                   </TR>

		   <tr>
		    <td id='tab_name'> Рейтинг сообщений: </td>
		    <td> <? echo $rate;?></td>
		   </tr>
		  </TABLE>
		 </TD>
                </TR>
                
               </TABLE>
             </td>
             </tr>
             </table>
	       </form>
		</div>
		</div>

</div>
</BODY>
</HTML>
