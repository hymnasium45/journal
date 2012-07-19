<?
session_start();
error_reporting(0);
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");

if ($_SESSION['login']!=1) 
        echo("<script>location.href='error.php?id=1'</script>");

$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);
include "../includes/db_connect.lib.php";
 collation();
if (isset($_POST['name'])) {	
	require_once("includes/club.lib.php");
	echo createClub($_POST['name'],$_SESSION['user_id']);
	echo "sdfgdh";
	die();
	}	
require_once("../includes/register_users.php");
class club{
	public $id;
	public $name;
	public $avatar;
	public $date;
	public $role="Участник";
	}
	
//Получам страницу
$page=$_GET['page'];
if ($page=='invite') {
	$invite_show="";
	$club_show="style='display:none;'";
	$invite_sel="class='selected'";
	$club_sel="class='none'";
	} 
else {
	$club_show="";
	$invite_show="style='display:none;'";
	$club_sel="class='selected'";
	$invite_sel="class='none'";
	}
//Получаем клубы пользователя 
$query="select * from club_users where user_id='".$_SESSION['user_id']."'";
$result=mysql_query($query,$link);

require_once("../includes/images.lib.php");
$club_count=0;    
$clubs=array();            
require_once("../includes/date.lib.php");
while ($row=mysql_fetch_array($result)) {
	$club_count++;
	$clubs[$club_count]= new club;
	$query_club="select * from club where club_id='".$row['club_id']."'";
	$result_club=mysql_query($query_club,$link);
	$row_club=mysql_fetch_array($result_club);
	$clubs[$club_count]-> id=$row_club['club_id'];
	$clubs[$club_count]-> name="<a href='club.php?club_id=".$row_club['club_id']."'>".$row_club['name']."</a>";
	$clubs[$club_count]-> date=makeDate($row['date']);
	if (file_exists("../avatars/".$row_club['avatar']) && $row_club['avatar']!='') {
        $size=makePost("../avatars/".$row_club['avatar']);
		$clubs[$club_count]-> avatar="<img src='../avatars/".$row_club['avatar']."' width='".$size[0]."' height='".$size[1]."'>";
        }
	else
	$clubs[$club_count]-> avatar="<img src='../avatars/noavatar.gif' class='post_image'";
	$clubs[$club_count]-> avatar="<a href='club.php?club_id=".$row_club['club_id']."'>".
							$clubs[$club_count]->avatar."</a>";
	}

$query="select * from club where creater_id='".$_SESSION['user_id']."'";
$result=mysql_query($query,$link);
while ($row=mysql_fetch_array($result)) {
	$club_count++;
	$clubs[$club_count]= new club;
	$clubs[$club_count]-> id=$row['club_id'];
	$clubs[$club_count]-> name="<a href='club.php?club_id=".$row['club_id']."'>".$row['name']."</a>";
	//$clubs[$club_count]-> date=makeDate($row['date']);
	if (file_exists("../avatars/".$row['avatar']) && $row['avatar']!='') {
        $size=makePost("../avatars/".$row['avatar']);
		$clubs[$club_count]-> avatar="<img src='../avatars/".$row['avatar']."' width='".$size[0]."' height='".$size[1]."'>";
        }
	else
	$clubs[$club_count]-> avatar="<img src='../avatars/noavatar.gif' class='post_image'";
	$clubs[$club_count]-> avatar="<a href='club.php?club_id=".$row['club_id']."'>".
							$clubs[$club_count]->avatar."</a>";
	$clubs[$club_count]-> role="Создатель";
	}

require_once("../includes/defence.lib.php");

//сколянем количество клубов согласно правилам русского языка	
if ($club_count==0) $club_count_name="Вы не состоите ни в одном клубе";
else  
$club_count_name="Вы состоите в ".$club_count." ".makeCountClub($club_count);

//сортируем клубы по имени
require_once("../includes/sort.php");
mysort_string('club','max','name',$clubs,$club_count);

//Получаем приглашения пользователя 
$query="select * from club_invites where user_id='".$_SESSION['user_id']."'";
$result=mysql_query($query,$link);


$inv_count=0;    
$invites=array();            
while ($row=mysql_fetch_array($result)) {
	$query_check="select * from club_users where user_id='".$_SESSION['user_id']."' and club_id='".$row['club_id']."'";
	$result=mysql_query($query_check,$link);
	if (mysql_num_rows($result)>0) {
		$query="delete from club_invites where club_id='".$row['club_id']."' and user_id='".$_SESSION['user_id']."'";
		$result=mysql_query($query,$link);
		}
	else {
	$inv_count++;
	$invites[$inv_count]= new club;
	$query_club="select * from club where club_id='".$row['club_id']."'";
	$result_club=mysql_query($query_club,$link);
	$row_club=mysql_fetch_array($result_club);
	$invites[$inv_count]-> id=$row_club['club_id'];
	$invites[$inv_count]-> name="<a href='club.php?club_id=".$row_club['club_id']."'>".$row_club['name']."</a>";
	if (file_exists("../avatars/".$row_club['avatar']) && $row_club['avatar']!='') {
        $size=makePost("../avatars/".$row_club['avatar']);
		$invites[$inv_count]-> avatar="<img src='../avatars/".$row_club['avatar']."' width='".$size[0]."' height='".$size[1]."'>";
        }
	else
		$invites[$inv_count]-> avatar="<img src='../avatars/noavatar.gif' class='post_image'";
	$invites[$inv_count]-> avatar="<a href='club.php?club_id=".$row_club['club_id']."'>".
							$invites[$inv_count]->avatar."</a>";
	}
	}
require_once("../includes/defence.lib.php");

//сколянем количество клубов согласно правилам русского языка	
if ($inv_count==0) $invite_count_name="У Вас нет новых приглашений";
else  
$invite_count_name="У Вас  ".$inv_count." ".makeCountInvite($inv_count);

//сортируем клубы по имени
mysort_string('club','max','name',$invites,$inv_count);

for ($i=1; $i<= $club_count; $i++) {
	$delete='delete'.$i;	
	if (isset($_POST[$delete])) {	
		$query="delete from club_users where user_id='".$_SESSION['user_id']."' and club_id='".$clubs[$i]-> id."'";
		$result=mysql_query($query,$link); 
		$query="delete from club_admins where user_id='".$_SESSION['user_id']."' and club_id='".$clubs[$i]-> id."'";
		$result=mysql_query($query,$link); 
		echo("<script>location.href='my_clubs.php'</script>");
		}
	}
for ($i=1; $i<=$inv_count; $i++) {
	$refuse='drefuse'.$i;
	$accept='accept'.$i;
	if (isset($_POST[$refuse])){
		$query="delete from club_invites 
				where user_id='".$_SESSION['user_id']."' and club_id='".$invites[$i]-> id."'";
		$result=mysql_query($query,$link);
		echo("<script>location.href='my_clubs.php?page=invite'</script>");

		}
	if (isset($_POST[$accept])) {
		$query="delete from club_invites 
				where user_id='".$_SESSION['user_id']."' and club_id='".$invites[$i]-> id."'";
		$result=mysql_query($query,$link);
		//echo $query;
		$query="insert into club_users (`club_id`,`user_id`,`date`)
				values('".$invites[$i]-> id."','".$_SESSION['user_id']."',NOW())";
		$result=mysql_query($query,$link);
		echo("<script>location.href='my_clubs.php?page=invite'</script>");
		}
	}

?>
<HTML>
<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
<link rel='stylesheet' href='../css/tab.css' type='text/css' media='screen' />
<script type='text/javascript' src='../includes/ajax.js'></script>
<script type="text/javascript" src='../includes/jquery-1.3.2.min.js'></script>
<script type='text/javascript' src='../includes/window.js'></script>
<link rel='stylesheet' href='../css/window.css' type='text/css' media='screen' />

<script type='text/javascript' language=JavaScript>
function t() {
	Handler= function(Request) {
		if (Request.responseText.length<5)
			location.href='my_clubs.php';
		else 
			document.getElementById('createError').innerHTML=Request.responseText;
		}
	var name=document.getElementById('name').value;
	if (name=='') document.getElementById('createError').innerHTML='Введите имя клуба';
	else { 
		str="name="+name;
		SendRequest('post','my_clubs.php',str,Handler);
		}
	}

$(document).ready(function(){
        $("ul#navigation li a").click(function() {
				$("ul#navigation li.selected").removeClass('selected');
				$("ul#navigation li").addClass('none');
			    $(this).parents().addClass('selected');
                $(this).parents().removeClass('none');
                return false;
        });
});
	
function showClub()
{

document.getElementById('my_club').style.display='';
document.getElementById('my_invite').style.display='none';


}
function showInvite()
{
document.getElementById('my_invite').style.display='';
document.getElementById('my_club').style.display='none';
}
	
</script>
</HEAD>
<BODY>
<div id='logo'>
 <?require_once("../includes/logo.php");
?>
</div>
<div id='main'>
 <div id='leftbar'>
  <?require_once "../includes/menu.php";?>
 </div>
 <div id='content'>
<FORM  method ='POST' enctype='multipart/form-data' >
<div class='form_settings'>

		    <div id='boxes'>
			 <div id='dialog' class='window' style='width:500px; height:250px;'>
			  <div id='head'> Создание клуба </div>
			  <div id='w_content'>
			   <table >
			    <tr>
			     <td ><h1>Название:</h1></td>
			    </tr>
			    <tr>
			     <td><input maxlength=50 style='width:450px'type='text' class='text' id='name' placeholder='Введите значение'></td>
			    </tr>
               </table>
              </div>
			  <div id='footer'>
			   <table height=100%>
				<tr>
				 <td  width=340px align='right'><input type='button' id='create' class='w_button' value='Создать клуб'
						onclick="t();"></td>
				 <td width=110px align='right'><input type='button' class='w_button' value='Отменить'
					onclick="location.href='my_clubs.php';"></td>
				</tr>
				<tr>
				 <td colspan=2 align=right class='error' id='createError'> </td>
				</tr>
			   </table>
			  </div>
			  <div class='closed'></div>
             </div>
             <div id='mask'></div>
		    </div>

<TABLE align='center' >
 <tr>
  <td>
   <table>
   	<tr>
     <td> 
      <ul id="navigation" style='width:500px'>
	   <li <?echo$club_sel;?>>  <a  href='' onclick='showClub();'>Мои клубы</a> </li>
	   <li <?echo$invite_sel;?>>  <a  onclick='showInvite();' href=''>Мои Приглашения</a> </li>
	  
	  </ul>
      </td>
      <td width=130px><a href='all_clubs.php'>Все клубы</a></td>
      <td width=170px><a href='#dialog' name='modal' >Создать клуб</td>
	</tr>
   </table> 
  </td>
  </tr> 
  <tr id='my_club' <?echo$club_show;?>>
   <td id='tab_content'>
	<table>
	 <tr>
	  <td id='tab_header'><?echo $club_count_name;?> </td>
	 </tr>
	<? for ($i=1; $i<=$club_count; $i++) {
	   $delete='delete'.$i;
	   echo "
	    <tr> 
         <td width=20px> &#160</td>
        </tr>
        <tr>
	     <td class='member'>
		  <table>
		   <tr>
	        <td rowspan=4 valign='top' >".$clubs[$i]-> avatar."</td>
	        <td valign=top id='tab_name'>Название:</td>
	        <td valign=top>".$clubs[$i]-> name."</td>
	       </tr>
	       <tr>
	        <td id='tab_name'>Вы вступили в клуб:</td>
	        <td>".$clubs[$i]->date."</td>
	       </tr>
	       <tr>
	        <td id='tab_name'>Роль в клубе:</td>
	        <td>".$clubs[$i]-> role."</td>
	       </tr>
	       <tr>
	        <td colspan=2 align='right'> <input type='submit' class='simple' name='".$delete."' value='Выйти из клуба'></td>
	       </tr>
	      </table>
	     </td>
	    </tr>";
			}?>
	 </table>
   </td>
  </tr>
  <tr id='my_invite' <?echo$invite_show;?>>
   <td id='tab_content'>
	<table>
	<tr>
	 <td id='tab_header'> <?echo $invite_count_name;?></td>
	</tr>
	 <? for ($i=1; $i<= $inv_count; $i++) {	
		 $refuse='drefuse'.$i;
		 $accept='accept'.$i;
	   echo "
	    <tr> 
         <td width=20px> &#160</td>
        </tr>
        <tr>
	     <td class='member'>
		  <table>
		   <tr>
	        <td rowspan=2 valign='top' >".$invites[$i]-> avatar."</td>
	        <td valign=top id='tab_name'>Название:</td>
	        <td valign=top>".$invites[$i]-> name."</td>
	       </tr>
	       <tr>
	        <td> <input type='submit' class='simple' name='".$accept."' value='Принять приглашение'></td>
	        <td> <input type='submit' class='simple' name='".$refuse."' value='Отклонить приглашение'></td>
	       
	       </tr>
	      </table>
	     </td>
	    </tr>";
		}?>
	</table>
   </td>
  </tr>
</TABLE>
</FORM>
 </div>
 </div>

</BODY>
</HTML>
