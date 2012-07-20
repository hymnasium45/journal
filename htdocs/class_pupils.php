<?
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
if ($_SESSION['login']==1) {
$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
mysql_select_db($_SESSION['dbname'],$link);
include "../includes/db_connect.lib.php";
collation();
require_once("../includes/register_users.php");
class pupil {
        public $id;
        public $name;
        public $avatar;
        public $admin;
        }
$class_id=$_GET['id'];
$query_class="select * from `classes` where `class_id`='".$class_id."'";
$result_class=mysql_query($query_class,$link);
$row_class=mysql_fetch_array($result_class);
require_once("../includes/class.php");
$class=getclass(-1,$row_class['year'],$row_class['letter']);

$query_pupil="select * from `class_users` where `class_id`='".$_GET['id']."'";
$result_pupil=mysql_query($query_pupil,$link);
$pupils=array();
$count_ppl=0;
while ($row_pupil=mysql_fetch_array($result_pupil)) {
        $count_ppl++;
        $query_name="select * from `users` where `user_id`='".$row_pupil['user_id']."'";
        $result_name=mysql_query($query_name,$link);
        $row_name=mysql_fetch_array($result_name);
        $pupils[$count_ppl] = new pupil;
        $pupils[$count_ppl]-> id=$row_pupil['user_id'];
        $pupils[$count_ppl]-> name=$row_name['Name'];
        $pupils[$count_ppl]-> avatar="<a href='profile.php?id=".$pupils[$count_ppl]-> id."'>
                                      <IMG src='../avatars/".$row_name['avatar']."' class='post_image'></a>";

        }
require_once("../includes/sort.php");
mysort_string('pupil','name','max',$pupils,$count_ppl);
}

else
        echo("<script>location.href='error.php?id=1'</script>");

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
<div id='main'><?
?>
 <div id='leftbar'>
  <?require_once "../includes/menu.php";?>
 </div>
 <div id='content'>
 
 
<TABLE align='center' >
 <TR>
  <TH colspan=2> Список учеников <?echo $class;?> класса:</TH>
<?for ($i=1; $i<=$count_ppl; $i++)
echo "
 <TR>
  <td>".$pupils[$i]-> avatar."</td>
  <td><a href='profile.php?id=".$pupils[$i]-> id."'>".$pupils[$i]-> name."</a></td>
 </tr>";?>
</TABLE>
</div>
</div>
</BODY>
</HTML>
