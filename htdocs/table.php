<?
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
if ($_SESSION['login']!=1)         echo("<script>location.href='error.php?id=1'</script>");


class Pupil {
	public $name;
	public $id;
	}
class Data {
	public $day;
	public $id;
	public $month;
	public $plan;
	public $task;
	}

if ($_SESSION['page'] < 1) $_SESSION['page']=1;

//коннектимся к базе данных
$mylink= new mysqli($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
$mylink-> set_charset("utf8");

if (isset($_POST['makeMark'])) {
	$query="update groups set bookmark='".$_SESSION['page']."' where group_id='".$_SESSION['table']."'";
	//echo $query;
	$result=$mylink->query($query);
	}

include "../includes/db_connect.lib.php";
collation();
require_once("../includes/register_users.php");

if ($_GET['style']=='task') {
	$style_task='';
	$style_table="style='display:none'";
	$class_table="class='none'";
	$class_task="class='selected'";
	}
	else {
        $style_table='';
        $style_task="style='display:none'";
	$class_task="class='none'";
        $class_table="class='selected'";

        }

// получаем айди группы
$query_group="select * from groups where group_id='".$_SESSION['table']."'";
$result_group=$mylink-> query($query_group);
$row_group= $result_group-> fetch_assoc();
$bookmark='';
if ($row_group['bookmark']!=$_SESSION['page'])
	$bookmark="style=opacity:0.5;";
		$query_teacher="select * from users where user_id='".$row_group['teacher_id']."'";
        $result_teacher=$mylink-> query($query_teacher);
        $row_teacher= $result_teacher-> fetch_assoc();


  //получаем месяц
  $query_date= "select * from Dates where (Page = '".$_SESSION['page'] ."' and group_id = '".$row_group['group_id']."')";      $result_date= $mylink-> query($query_date);
  $row_date= $result_date-> fetch_assoc();
  require_once("../includes/date.lib.php");
  $month=getDateMonth($row_date['month']);
//отрисовываем таблицу

$query_date= "select * from Dates where (Page = '".$_SESSION['page'] ."' and group_id = '".$row_group['group_id']."')";
$result_date= $mylink-> query($query_date);
$date=array();
$i=0;
while ($row_date=$result_date-> fetch_assoc()) {
	$i++;
	$query_lesson="select * from lesson where 
        (group_id='".$row_group['group_id']."' and date_id='".$row_date['date_id']."')";
        $result_lesson=$mylink-> query($query_lesson);
        $row_lesson=$result_lesson-> fetch_assoc();
	//echo $query_lesson;
	$date[$i]= new Data;
	$date[$i]-> id= $row_date['date_id'];
	$date[$i]-> day= $row_date['day'];
	$date[$i]-> month=$row_date['month'];
	$date[$i]-> task=$row_lesson['task'];
	$date[$i]-> plan=$tow_lesson['plan'];
	}
//получим из таблицы групп айди всех учеников, состоящих в группе 
$query_pupils= "select * from group_users where group_id='".$row_group['group_id']."'";
$result_pupils= $mylink-> query($query_pupils);

$count=0;
$pupil= array();
      

while ($row_pupils=$result_pupils-> fetch_assoc()) { 
	//в цикле по айди получаем фамилию и имя ученика 
	$count++;
        $query_pupil_name="select `Name` from `users` where user_id='".$row_pupils['user_id']."'";
	$result_pupil_name= $mylink-> query($query_pupil_name);
	$row_pupil_name= $result_pupil_name-> fetch_assoc();
        $pupil[$count]=new Pupil;
	$pupil[$count]-> name=$row_pupil_name['Name'];
	$pupil[$count]-> id=$row_pupils['user_id'];
	}
require_once ("../includes/sort.php");
mysort_string('Pupil','name','max',$pupil,$count);



//проверим нажаты ли клавишы

if (isset($_POST['next']) && $_SESSION['page'] < 99) {
	$_SESSION['page']++;
	echo("<script>location.href='table.php?style=".$_POST['style']."'</script>");
	}

if (isset($_POST['last']) && $_SESSION['page'] >1) {
	$_SESSION['page']--;
	echo("<script>location.href='table.php?style=".$_POST['style']."'</script>");
	}

if (isset($_POST['goto']) && $_POST['page'] >0 && $_POST['page']<100) {
	$_SESSION['page']=$_POST['page'];
        echo("<script>location.href='table.php?style=".$_POST['style']."'</script>");
	}
?>
<HTML>
<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
<link rel='stylesheet' href='../css/tab.css' type='text/css' media='screen' />
<script type="text/javascript" src='../includes/jquery-1.3.2.min.js'></script>
<script type="text/javascript" src='../includes/jquery-1.3.2.min.js'></script>
<script type='text/javascript' src='../includes/window.js'></script>
<link rel='stylesheet' href='../css/window.css' type='text/css' media='screen' />

<script type="text/javascript" language=JavaScript>

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

function task_show()
{
document.getElementById('task').style.display='';
document.getElementById('table').style.display='none';
document.getElementById('style').value='task';

}
function table_show()
{
document.getElementById('table').style.display='';
document.getElementById('task').style.display='none';
document.getElementById('style').value='table';

}

</script>
</HEAD>
<BODY>
<div id='logo'> 
<?require_once("../includes/logo.php");
?>
 
</div> 
<div id='main'><?

?>
<div id='leftbar'>
<? require_once "../includes/menu.php";
?>
        </div>
        <div id='content'>
        <FORM method='POST' class='form_settings'>
		    <div id='boxes'>
			 <div id='dialog' class='window' style='width:500px; height:250px;'>
			  <div id='head'> Помощник </div>
			  <div id='w_content' style='padding-top:1%'>

			   <table>
			    <tr>
			     <td class='w_h1'>Заполнение,редактирование журнала:</td>
			    </tr>
			    <tr>
			     <td>Выберите пункт меню <strong>"Редактировать"</strong></td>
			    </tr>
                <tr>
                 <td class='w_h1'>Редактирование группы, расписания: </td>
                </tr>
                <tr>
                 <td>Выберите пункт меню <strong>"Журналы"</strong>, выберите  
				   <td rowspan=2 valign='bottom'><img src='../images/edit_hover.png'></td>
                
				</tr>
				<tr>
				 <td>журнал для редактирования, нажмите кнопку </td>
                </tr>
               </table>
              </div>
			  <div id='footer'>
			   <table height=100%>
				<tr>
				 <td  width=340px align='right'><input type='button' id='create' class='w_button' 
						value='Спасибо, я понял(а)!'
						onclick="location.href='table.php';"></td>
				 <td width=110px align='right'><input type='button' class='w_button' value='Всё равно не понял(а)!'
					onclick="location.href='help.php';"></td>
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




        <input type='hidden' name='style' id='style' value=<?echo $_GET['style'];?>>
	<TABLE align=center'>
        <tr>
         <td align='left' height=50px><a href='#dialog' name='modal' >Что мне с этим делать?</td> </td>
        </tr>
        <tr>
        <TD align ='left' height=100> Страница <?echo $_SESSION['page'];?> 
         <button title ='Закладка' type='submit' class='simple' <?echo $bookmark;?> name='makeMark'>
         <img src='../images/bookmark.png' width='40px' height='40px'>
         </button>
         <input type='submit' class='page' name='last' value='Пред.'>  
         <input name='next' class='page' type='submit' value='След.'> </TD>
        <TD align=right> Номер страницы: 
        <INPUT type = 'text' class='page_input' name = 'page' maxlength='3'>  
	<INPUT class='page' type='submit' value='Перейти' name='goto'> </TD>
	<tr>
	 <td colspan=2> 
   	  <ul id="navigation">
	   <li <?echo$class_table;?>>  <a href='#' onclick='table_show()'> таблица оценок</a> </li>
	   <li <?echo$class_task;?>> <a href='#' onclick='task_show();'> план урока </a> 
         </ul>
         </td>
	</tr>
	  <tr <?echo $style_table;?> id='table'> 
	   <td colspan=2 width='800px'>
	   <div id='tab_content'>
	   <table align='center'> 
            <TR> 
             <TH width='300px' align=center height=50> Предмет: <?echo $row_group['subject'];?> </TH> 
             <TH width='500px' align=left> Обзор учебных достижений учеников </TH>  
            </TR>
            <TR> <TD colspan=2> 
             <TABLE border=1 frame=box rules = all align=center>
              <TR> 
               <TH height='50' rowspan=2>№</TH>
               <TH colspan=1 rowspan=2 width=150 >Фамилия и имя ученика(ученицы)</TH> 
               <TH height='50' width=53>месяц</TH>
               <TH height='50' colspan=17><? echo $month; ?></TH> 
              </TR>
              <TR>
               <TH height='50'> число </TH>
	      <? for ($i=1; $i<= 17; $i++)
		
		  echo " <TD height='50' width=30px align='center'>".$date[$i]-> day."</TD> ";?>
	      </TR>
	       <?
	       for ($i=1; $i<=$count; $i++) {
               echo "<TR> <TD width='20' align=right> $i </TD> <TD width='208' colspan=2>".$pupil[$i]-> name."</TD> ";
               for ($j=1; $j<= 17; $j++) {
               $query_grade="select * from grades 
                where ( user_id = '".$pupil[$i]-> id."' and group_id ='".$row_group['group_id']."' 
                and date_id='".$date[$j]-> id."')";
                $result_grade=mysql_query($query_grade,$link);
                $row_grade=mysql_fetch_array($result_grade);
                echo "<TD width='25' >".$row_grade['Grade']."</TD>";
        	}
             echo "</TR>";
        	}?>
		</div>
             </table>
            </table>
            </td>
	   </tr>
           <TR <?echo $style_task;?> id='task'>
            <TD colspan=2>
             <div id='tab_content'>
	     <TABLE align='center' >
              <TR> 
               <TH height='40px' width='800px' align=left> Учитель: <?echo$row_teacher['Name'];?></TH> 
               <TABLE align ='center' border=1 frame=box rules = all>
                 <TH height=100 align='center' width=50px> № </TH> <TH height=100 width=80px> Дата </TH> 
                 <TH height=100 width=300px> Содержание урока </TH> 
                 <TH height=100 width=420px> Задание домой </TH>
	         <?for ($i=1; $i<= 17; $i++) 
		  echo"
 		 <TR>
                <TD width=50 height=50 align='center'>". $i." </TD> 
                <TD width=50 height=50 align='center'>".$date[$i]-> day."/".$date[$i]-> month."</TD> 
                <TD width=300 height=50> ".$date[$i]-> plan." </TD> 
                <TD width=300 height=50> ".$date[$i]-> task." </TD> 
                </TR>";?>
            </table> 
            </td>
           </tr>
          </div>
	  </table>

</table>
</div>
</div>

</BODY>
</HTML>
