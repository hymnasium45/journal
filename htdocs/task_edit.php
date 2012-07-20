<?

class day {
public $dateid;
public $Day;
}

class name {
public $Name;
public $user_id;
}

$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);
require_once "../includes/db_connect.lib.php";
 collation();
require_once("../includes/register_users.php");
//$query_page="select month from Dates where Page='".$_SESSION['page']."' and  group_id='".$_SESSION['table']"'";
$row_month_id=mysql_fetch_array(mysql_query("select month from Dates where Page='".$_SESSION['page']."' and  group_id='".$_SESSION['table']."' limit 1 "));
$query_month="select Month from months where month_id='".$row_month_id['month']."' ";
$result_month_init=mysql_query($query_month, $link);
$month_init=mysql_fetch_array($result_month_init);
if ($month_init['Month']=='') $month_init['Month']="<div style='height: 40px; width: 250px;' >&#160</div>";
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' /> 
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
<link rel='stylesheet' href='../css/comments.css' type='text/css' media='screen' />  
<link rel='stylesheet' href='../css/window.css' type='text/css' media='screen' />  


<style>


.choose 
{
background: url('../../version2/htdocs/images/choose.png') no-repeat;
}

a {color:#333; text-decoration:none}
a:hover {color:#ccc; text-decoration:none}





</style>
<script type='text/javascript' src='../includes/jquery-1.3.2.min.js'></script>

<script type='text/javascript' src='../includes/modal-window.js'>
</script>
<script>
$(document).ready(function() {  
$('img[name=img]').hide();
$('input[type=text]').focus( function() {
	$(this).siblings('a').children('img').show('fast');
	$(this).keydown(function(event) { if (event.keyCode ==39) $(this).siblings('a').click()}); 
	});

 $('input[type=text]').click( function() {
	$(this).siblings('a').children('img').show('fast');
	$(this).stop();                
	});

 $('input[type=text]').blur( function() {
	$(this).siblings('a').children('img').hide('fast');
	
	});



});

</script>


</head>

<body>

<div id='logo'><?
 require_once("../includes/logo.php");
?>
</div>
<div id='main'>
<div id='leftbar'><?
require_once("../includes/menu.php");
?>
</div>
<div id='content'>
<div class='form_settings'> 

<div id='boxes'>
 <div id='dialog' class='window'>
  <h3>Выставление комментария</h3>
  <p><span style='width: 25px;'>&#160</span>Комментарий к оценке:</p>
  <p><span style='width: 25px;'>&#160</span><textarea  maxlength='255'  rows='2' cols='32' name='tema' id='comment'></textarea></p>
  <p><span style='width: 25px'>&#160</span><input type='button' align='right'  value='Выставить' name='put' onclick= \"$('#mask, .window').hide(); 
  var name=getElementById('hidden').value;  
  get='h'.concat(name);  
  comment=getElementById('comment').value; 
  getElementById(get).value=comment; 
 \">
 </p>
<div class='closed'> <img class='close' src='images/x.png'></div>
</div>

<div id='dialog2' class='window'>
<h3>Выставление месяца</h3>
&#160&#160&#160 Выберите месяц: &#160&#160&#160

<select name='month' id='month'>
<option value='0' disabled>Месяц</option>
<?
$month=array ('январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь');
   for ($g=0; $g<=11 ;$g++)
         {
                  $k=$g+1;
                    if ($k==date("n"))
                     {				

                       echo "<option value='$k' selected>$month[$g]</option>";																										                                                                               }
	             else echo "<option value='$k'>$month[$g]</option>";
							          }
   ?> </select><br><br>
	   <p><span style='width: 25px'>&#160</span><input type='button' onclick=\" $('#mask, .window').hide();
   var name=getElementById('hidden').value;
   get='h'.concat(name);
   dmonth=getElementById('month');
   temp=dmonth.options[dmonth.selectedIndex].text;
   getElementById(name).innerHTML=temp;
   getElementById(get).value=dmonth.options[dmonth.selectedIndex].value;
   \" value='Выставить'/>
	 </p>  <div class='closed'> <img class='close' src='images/x.png'></div>

</div>




</div>
<?
echo"

<input type='hidden' id='hidden' >

<form method='POST' >
<table align=center width='110%' > <tr> <td><TABLE  border=1  style='border: 2px solid #AEAEAE;' frame=box rules = all align=center>
<TR> <TH height='50' rowspan=2>№</TH>
<TH colspan=1 rowspan=2>Имя</TH> <TH height='50'>Месяц</TH><TH height='50'  align='center'  colspan=17><input type='hidden' id='h00' name='00' value='".$row_month_id['month']."'><a href='#dialog2' name='modal' id='00'  onclick=\"getElementById('hidden').value=this.id; var el= document.getElementById('month');
var opts=el.getElementsByTagName('option');
month=$(this).siblings('input[type=hidden]').val();
for (i=0; opts[i];i++)
        {if (opts[i].value==month) opts[i].selected=true;}
\">".$month_init['Month']."</a></TH> </TR>
<TR><TH height='50'> Число </TH>";

$first=$_SESSION['user_id'];
$query = "select user_id from group_users where  group_id='".$_SESSION['table']."' order by user_id";
$result=mysql_query($query,$link);
$kolvo=mysql_num_rows($result);

//echo $kolvo;

$query_dates="select Day,date_id from Dates where Page='".$_SESSION['page']."' and group_id='".$_SESSION['table']."' order by Day ASC";
$result_dates=mysql_query($query_dates,$link);
//for ($i=1; $i<=17; $i++)
//{
$date=array();
$i=0;
$j=0;
while ($j<17)
{
$row_dates=mysql_fetch_array($result_dates);


$j++;

$date[$j]= new day;
$date[$j]-> Day=$row_dates['Day'];
$date[$j]-> date_id=$row_dates['date_id'];
$date[$j]-> num=$j;
//if (($date[$i]==$date[$i-1]) && ($i>1) && ($date[$i]!='')) {$j--; continue;}
if ($row_dates['Day']=='') $row_dates['Day']="<div style='height:30px; width:20px;'>&#160</div>";
$row_task=mysql_fetch_array(mysql_query("select task,theme from lesson where date_id='".$row_dates['date_id']."' and group_id='".$_SESSION['table']."'"));
/*!!!!!!*/$row_task['status']=1;
$manufacture=$row_dates['Day'].'_'.$row_task['theme'].'_'.$row_task['task'].'_'.$row_task['status'];
echo " 
<TD height='50' align='center'><input type='hidden' value=\"".$manufacture."\" name='0".$j."' id='h0".$j."'>

<a href='#dialog1' name='modal' style='font-size:110%' 
onclick=\"getElementById('hidden').value= this.id; line=$(this).siblings('input[type=hidden]').val(); 
var arr= new Array();
arr=line.split('_');


var el= document.getElementById('day');
var opts=el.getElementsByTagName('option');
for (i=0; opts[i];i++)
	{if (opts[i].value==arr[0]) opts[i].selected=true;}

$('#theme').val(arr[1]);
$('#hw').val(arr[2]);
el= document.getElementById('status');
opts=el.getElementByTagName('option');
for (i=0; opts[i];i++)
        {if (opts[i].value==arr[3]) opts[i].selected=true;}

\"  id='0$j'>".$row_dates['Day']."</a></TD> 

";}
echo "</TR>";

$i=0;
$num_rows=mysql_num_rows($result);
//for ($i=1; $i<=$kolvo; $i++) 
//$j=0;

 while($row=mysql_fetch_array($result))
 {
 //$j=0;
 $i++; 
$query1= "select Name from users where user_id=".$row['user_id']."";
//echo $row['Name']; 
 $result2=mysql_query($query1,$link);
 $row1=mysql_fetch_array($result2);
 $Name[$i]=new name;
 $Name[$i]-> Name=$row1['Name'];

$Name[$i]-> user_id=$row['user_id'];

 }
 require_once("../includes/sort.php");
 mysort_string('name','Name','max', $Name, $i);
 mysort_string('day','Day','max', $date, $j);
$k=0;
$temp_c=1;
echo $i;
for ($j=1; $j<=$i; $j++)
{
$k=0;
echo "<TR> <TD width='20' align=center > $j </TD> <TD width='200' colspan=2 height='33'><font  size='4' > &#160".$Name[$j]->Name." </font> </TD> ";

while($k<17)
{
$k++;
$row_user_grade['Grade']='';
$row_user_grade['Comment']='';

if (($date[$k]->date_id)>0)
{
$query_user_grade="select Grade, Comment from grades where date_id='".$date[$k]->date_id."' and user_id='".$Name[$j]->user_id."' ";
$row_user_grade=mysql_fetch_array(mysql_query($query_user_grade, $link));
//$temp_c++;
}
$tab=($k-1)*$i+$j;
echo "<TD width='41' align='center'><input type='hidden' value='".$row_user_grade['Comment']."' name='$j$k' id='h$j$k'><input type='text' name='t$j$k' maxlength='2' 
value='".$row_user_grade['Grade']."' tabindex='$tab' style='background-color:#FFF; font-size:100%; width:30px;float:left; border:0;' ><a href='#dialog' name='modal'  onclick=\"getElementById('hidden').value= this.id; a=$(this).siblings('input[type=hidden]').val(); $('#comment').val(a); \"  id='$j$k'><img style='padding-top:9px; padding-right:1px;' src='../images/arrow.1.png' name='img' /></a></TD>"; 

}
}



echo "</TR>"; 
echo "
	</table></td></tr> <tr> <td style='position:absolute; right:7.5%;'> <input  type='submit' class='submit' name='submit' onclick=\" 
month=getElementById('h00').value; 
if (month=='') { alert('   Вы не поставили месяц!       '); return false;}
var count=0;

for (var i=1; i<18;i++)
{
	idh='h0'.concat(i);
	day=getElementById(idh).value;
	if (day=='')
	 {
		
		 for (var j=1; j<=$i; j++)
		 {
		id='h'.concat(j).concat(i);
			
		grade=getElementById(id).value;
		//alert(grade);
       		if (grade!='') count++; 		
		}
		//alert(count);	 
		if (count!=0) {  alert('    Оценка выставлена без даты     '); return false; break;   }
		count=0;
		 }
}
\"></td></tr></table> </form> 




<div id='dialog1' class='window'>
<h3>Выставление даты и темы</h3>
                 
<p>&#160&#160&#160 1) Выберите день: &#160&#160&#160
		
	 <select  id='day' name='day'>";

 for ($g = 0; $g <= 31; $g++)
    { if ($g==0) echo "<option value='0' disabled> День</option>";
     else{
           if ($g==date("j"))
		echo "<option value='$g' selected>$g</option>";
	   		
	else
            echo "<option value='$g'>$g</option>";

	}
}
    

echo " </select></p>
<br>
		  <p>&#160&#160&#160 2) Выберите событие: &#160&#160&#160

                       <select   id='status' name='status' >
 
                       <option value='0' disabled>Событие</option> 
                        <option value='1' selected>Текущая оценка</option>
    			<option value='Tе'>Тест</option>
			<option value='Кр'>Контрольная работа</option>
                        <option value='Tо'>Тематическая оценка</option>
                        <option value='Ар'>Административная работа</option>
                        <option value='Со'>Семестровая оценка</option>
                        <option value='Го'>Годовая оценка</option>

			</select></p><br>

	<!--<p> &#160&#160&#160 3) Тема урока </p><font color='#BEBEBE'>(необязательно):</font> -->
	<span style='width: 25px;'>&#160</span> <textarea  maxlength='255' value='Введите тему урока' onfocus=\"if (this.value=='Введите тему урока') this.value=''\" onblur=\"if (this.value=='') this.value='Введите тему урока'\" id='theme' name='theme'>Введите тему урока</textarea><br>
	 <span style='width: 25px;'>&#160</span><textarea maxlength='255' onfocus=\"if (this.value=='Введите домашнее задание') this.value=''\" onblur=\"if (this.value=='') this.value='Введите домашнее задание'\" id='hw' rows='2' cols='50' name='hw'>Введите домашнее задание</textarea><br>

	 <span style='width:25px'>&#160 </span>	<img  src='images/choose.png'  name='put1' onclick= \"$('#mask, .window').hide(); 
var name=getElementById('hidden').value;  id='h'.concat(name);
var dday=getElementById('day');

var value=dday.options[dday.selectedIndex].value;

var event=getElementById('status'); status=event.options[event.selectedIndex].value; 
if (status!='1')
{
//temp='#'.concat(name);
//temp2=$(temp).parent('td');
getElementById(name).innerHTML=value;
$(name).css('font-weight','bold');
if (status=='Tе') color='#FFDEAD'; 
if (status=='Кр') color='#FFEC8B'; 
if (status=='Tо') color='#ADD8E6'; 
if (status=='Ар') color='#98FB98'; 
if (status=='Со') color='#8B6969'; 
if (status=='Го') color='#FFA54F'; 
//if (status=='T') color='#FFA54F'; 
	
	

	for (var j=0; j<=$i;j++)
	{
	var kod=name.substr(1, name.length);
	var childh='#h'.concat(j).concat(kod);
	//$(childh).parent('td').css('background-color', color);
	if (j==0) $(childh).parent('td').css('border',  '2px solid #000000');
	 if (j==$i) $(childh).parent('td').css('border-bottom',  '2px solid #000000');
	$(childh).parent('td').css('border-left',  '2px solid #000000').css('border-right','2px solid #000000');	
}
	




}
else getElementById(name).innerHTML=value;
theme=getElementById('theme').value;  

hw=getElementById('hw').value; /*total=value.concat('_').concat(theme).concat('_').concat(hw).concat('_').concat(status); 
*/ total=(value + '_' + theme + '_' + hw + '_' + status);
getElementById(id).value=total;
/*getElementById('hw').value='Введите домашнее задание';
getElementById('theme').value='Введите тему урока';
*/event.selectedIndex='1';\" >


<div class='closed'> <img class='close' src='images/x.png'></div>




</div>
<div id='mask'></div>
</div>

</div>
</div>
</div>

</body>

";

if (isset($_POST['submit'])) 
{



 
$month_1=$_POST['00'];
/*$query = "select user_id from group_users where  group_id='$second'";
$result=mysql_query($query,$link);
$ar=array();

while($row=mysql_fetch_array($result))
{
$i++;
$ar[$i]=$row['user_id'];
}
$k=$i;       
$i=-1;
*/
$k=count($Name);
$arra=array();
$array_dates_1=array();
$array_dates_2=array();
for ($i=0; $i<=$k; $i++)
{
	for ($j=1; $j<=17; $j++)
        {
	//$result_check=mysql_query("select date_id from Dates where Day='".$day_1."' and month='".$month_1."'",$link);
	
	if ($i==0){
        
	$line=$_POST["$i$j"];
	
	
	$array=split('_',$line);
	
	$day_1=$array[0];
	$hw=$array[2];
	$theme=$array[1];
	$event=$array[3];
	if ($hw== 'Введите домашнее задание') $hw='';
	if ($theme=='Введите тему урока') $theme='';

	
	$query_day="SELECT date_id FROM Dates WHERE   
	                date_id = (SELECT MAX(date_id) FROM Dates)";
	      $result_day=mysql_query($query_day,$link);
	      $row_temp = mysql_fetch_array($result_day);
	            $max=$row_temp['date_id']+1;

	            $query_lesson="SELECT lesson_id FROM lesson WHERE   
			          lesson_id = (SELECT MAX(lesson_id) FROM lesson)";
		          $result_les=mysql_query($query_lesson,$link);
		    $row_temp1 = mysql_fetch_array($result_les);
			        $max1=$row_temp1['lesson_id']+1;

	
	
	
		    if  ($day_1>0)	{
	
	
	$result_check=mysql_query("select date_id from Dates where Day='".$day_1."' and month='".$month_1."'",$link);
	
	if (mysql_num_rows($result_check)==0){
	$array_dates_1[$j]=$max;
	$query_date=mysql_query("insert into Dates values ('".$max."','".$_SESSION['page']."','".$_SESSION['table']."','".$day_1."','".$month_1."')",$link);
	
	if ($hw!='' || $theme!='') {
        $query_task=mysql_query("insert into lesson values ('".$max1."','".$_SESSION['table']."','".$max."','".$hw."','','".$theme."','') ", $link);
        
	}
	}
	
	else { $row_check=mysql_fetch_array($result_check);
	$array_dates_2[$j]=$row_check['date_id'];
	$update=mysql_query("update lesson set `task`='".$hw."', `theme`='".$theme."' where date_id='".$row_check['date_id']."'",$link);	
	
	}
	//!!!!$result_task=mysql_query($query_task,$link);
	
	
	}
	}

   // for ($j=1; $j<=17; $j++)
  // while($row=mysql_fetch_array($result))
	//for ($i=0; $i<=$k; $i++) 
	//{
	//$i++; 
	else {
	
	$comment= $_POST["$i$j"];
	$grade= $_POST["t$i$j"];
        //$nmax=$max+$i;
 	//echo $grade;	
	if ($array_dates_1[$j]>0){	
	if ($grade!='')
      	{
     	$query_grade="insert into grades values ('".$_SESSION['table']."','".$Name[$i]->user_id."','".$array_dates_1[$j]."','".$grade."','".$comment."') ";
      	//echo $query_grade;
	$result_grade=mysql_query($query_grade,$link);
     	//if (shell_exec('stat -c%s LOG_Pupil.txt')<2000000) shell_exec("echo ");
	}      
        }
	else {
	$result_e_grade=mysql_query("select grade,Comment from grades where date_id='".$array_dates_2[$j]."' and user_id='".$Name[$i]->user_id."'",$link);
	 
	if (mysql_num_rows($result_e_grade)>0)
	$update=mysql_query("update grades set `grade`='".$grade."', `Comment`='".$comment."' where date_id='".$array_dates_2[$j]."' and user_id='".$Name[$i]->user_id."'",$link);
	else  $query_grade=mysql_query("insert into grades values ('".$_SESSION['table']."','".$Name[$i]->user_id."','".$array_dates_2[$j]."','".$grade."','".$comment."')",$link );
}
	}
    
    }  
  }

/*for ($i=1; $i<=17; $i++)  
{
if ($array_dates_1[$i]=='') $array_dates_1[$i]='n';
if ($array_dates_2[$i]=='') $array_dates_2[$i]='n';

echo "$array_dates_1[$i] &#160 $array_dates_2[$i] <br>";

}
*/
echo "<script>location.href='http://localhost/version2/htdocs/table.php' </script>";
   //   echo $query_task;
	      
	     
}
//rows='2' cols='38'
?>
