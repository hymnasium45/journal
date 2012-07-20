<HTML>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
 <STYLE text=css/text>
 TH {height:50}
 </STYLE>


</HEAD>

<BODY>

<?php

session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
if ($_SESSION['login']==1) {

//коннектимся к базе данных
$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);
 include "../includes/db_connect.lib.php";
 collation();
require_once("../includes/register_users.php");
echo "
  <div id='logo'> 
";require_once("../includes/logo.php");

echo" 
</div> 
<div id='main'>";

echo"
<div id='leftbar'>"
;
require_once "../includes/menu.php";
echo "
        </div>
        <div id='content'>
        ";
// получаем айди группы
	$query_group = "select * from delete_groups where teacher_id='".$_SESSION['user_id']."'";
        $result_group= mysql_query($query_group,$link);
        $head_color='#999999';
        $light_grey='#DDDDDD';
        $dark_grey='#BEBEBE';

        echo "
        <table align='center' > 
         <tr> 
          <th bgcolor=$head_color> <font size='4' color = black> Восст.</font> </th> 
          <th bgcolor=$head_color> <font size='4' color = black> Класс </font></th> 
          <th bgcolor=$head_color> <font size='4' color= black > Предмет </font> </th> 
          <th bgcolor=$head_color> Дата удаления </th> 
          <th bgcolor=$head_color> уч. год </th> 
         </tr>
         <form id = 'TABLE' method='POST'>";

$count=0;
$mass=array();
while ($row_group=mysql_fetch_array($result_group)) {
	$count++;
	$mass[$count]=$row_group['group_id'];
	 if ($select % 2==0) $color=$dark_grey; else $color=$light_grey;

	$class_query = "select * from classes where class_id='".$row_group['class_id']."'";
        $class_result = mysql_query($class_query,$link);
        $class_row=mysql_fetch_array($class_result);
	$year=$row_group['year']+1;
echo "
	<TR>
		 <TD bgcolor=$color>    
                <BUTTON TYPE ='SUBMIT' FORM='TABLE' NAME='$count'>
                <IMG SRC='/version2/images/select.jpg'> 
                </BUTTON>
                </TD>
        <td bgcolor=$color> <font size='3' color= black > " . $class_row['Class']. "</font></td>
        <td bgcolor=$color> <font size='3' color= black >" . $row_group['subject']. "</font> </td> 
        <td bgcolor=$color> ".$row_group['last_change']."</td>
        <td bgcolor=$color> ".$row_group['year']."-".$year."</td>
        </TR>";
	}         
echo "
  </FORM>
 </TABLE>";
/*
for ($i=1; $i<=$count; $i++) 
	if (isset($_POST[$i]) {

 	$query_group = "select * from delete_groups where group_id='".$mass[$i]."'";
    //    $result_group = mysql_query ($query_group,$link);
    //    $row_group= mysql_fetch_array($result_group);
                $query_create_group="insert into groups values(".$row_group['group_id'].",".$row_group['class_id'].",
".$row_group['teacher_id'].",'".$row_group['school']."','".$row_group['subject']."',".$row_group['year'].",
'".$row_group['last_change']."')";
      //  $result_create_group=mysql_query($query_create_group,$link);
        $query_delete= "delete from delete_groups where group_id='".$mass[$i]."'";
     //   $result_delete= mysql_query($query_delete,$link);
        echo("<script>location.href='table_restore.php'</script>");

	}*/
}
else
        echo("<script>location.href='error.php?id=1'</script>");

?>
</div>
</div>
</BODY>
</HTML>

