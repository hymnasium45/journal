<?php
if (isset($_POST['user_id']) && isset($_POST['vote_id']) && isset($_POST['opt_id'])) {
	session_start();
error_reporting(0);
	$link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
	mysql_select_db($_SESSION['dbname'],$link);
	include "db_connect.lib.php";
 	collation();
	$query="update `vote_options` set `count`=`count`+1 where `option_id`='".$_POST['opt_id']."'";
	$result=mysql_query($query,$link);
	$query="insert into `vote_users` values('".$_POST['vote_id']."','".$_POST['user_id']."')";
	$result=mysql_query($query,$link);
	if (!$result) {echo "Ошибка. Не удалось проголосовать"; die();}
	else die();
	}
class vote {
public $v_id;//инд. номер голосования
public $v_name;//имя голосования
public $v_date;//дата голосования
public $v_count=0;//количество вариантов в голосовании
public $v_summ=0;//кол-во проголосовавших
public $author_id;//айди автора голосования
public $author_name;//имя автора голосования
private $opt_count=array();//массив названий вариантов
private $opt_name=array();//массив кол-ва проголосовавших за вариант
public $user_id;
public $v_able;
public $v_admin=false;
function __construct($user) {
		$this-> user_id=$user;
		session_start();
error_reporting(0);
        if (!$link)
                $link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
        if (!$link) { $this-> error="не удалось подключиться к базе данных"; return false; exit();}
        mysql_select_db($_SESSION['dbname'],$link);
        require_once "db_connect.lib.php";
        collation();
		$query="select `access` from `users` where `user_id`='".$this-> user_id."'";
		$result=mysql_query($query,$link);
		$row=mysql_fetch_array($result);
		require_once ("../includes/access.lib.php");
		if (isSAdmin($row['access'])) $this-> v_admin=true;
		
		}
function getVote($id) {
	$this-> v_id=$id;
	session_start();
error_reporting(0);
        if (!$link)
                $link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
        if (!$link) { $this-> error="не удалось подключиться к базе данных"; return false; exit();}
        mysql_select_db($_SESSION['dbname'],$link);
        require_once "db_connect.lib.php";
        collation();
	$query="select * from `votes` where `vote_id`='".$this-> v_id."'";
	$result=mysql_query($query,$link);
	if (!$result) {return "Не удалось получить данное голосование";}
	$row=mysql_fetch_array($result);
	$this-> author_id=$row['user_id'];
	$this-> v_date=$row['date'];
	$this-> v_name=$row['name'];
	$query="select * from `vote_options` where `vote_id`='".$this-> v_id."'";
	$result=mysql_query($query,$link);
	$this-> opt=array();
	while ($row=mysql_fetch_array($result)) {
		$this-> v_count++;
		$this-> opt_id[$this-> v_count]=$row['option_id'];
		$this-> opt_name[$this-> v_count]=$row['name'];
		$this-> opt_count[$this-> v_count]=$row['count'];
		$this-> v_summ+=$row['count'];
		}
	}
function printVote() {
	$html= "
	<script language=JavaScript>
	function makeVote(vote_id,user_id) {
	Handler= function(Request) {
                answer=Request.responseText;
                if (answer.length==1) {               	       
                        document.getElementById('tr_vote').style.display='none';
			document.getElementById('tr_res').style.display='';
			}
                else 
                        document.getElementById('error').innerHTML=Request.responseText;
                }
	opt=document.getElementsByName('option');
	opt_id='none';
	for (i=0; i< opt.length; i++)
		if (opt[i].checked) opt_id=opt[i].value;
	if (opt_id=='none') alert('Выберите вариант');
	else {
        	str='user_id='+user_id+'&vote_id='+vote_id+'&opt_id='+opt_id;
		SendRequest('post','../includes/vote.class.php',str,Handler);
        	}
	}
	</script>";
	 session_start();
error_reporting(0);
        if (!$link)
                $link= mysql_connect($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['dbname']);
        if (!$link) { $this-> error="не удалось подключиться к базе данных"; return false; exit();}
        mysql_select_db($_SESSION['dbname'],$link);
        require_once "db_connect.lib.php";
        collation();

	$query="select * from `vote_users` where `vote_id`='".$this-> v_id."' and `user_id`='".$this-> user_id."'";
        $result=mysql_query($query,$link);
        if (mysql_num_rows($result)==0) $this-> v_able=true;
	if ($this-> v_able) {
		$tr_res="display:none";
		$tr_vote='';
		}
	else {
		$tr_vote="display:none";
                $tr_res='';

		}
	$html.= "
	<div class='form_settings'>
	<table class='vote'>
	 <tr> <th class='header'> Голосование </th> </tr>
         <tr> <td> <table class='content'>
	 <tr> <th align='left' height='25px'>".$this-> v_name."</th></tr>	
	 <tr id='tr_res' style='".$tr_res."'> <td> <table> ";
	for ($i=1; $i<= $this-> v_count; $i++) {
		$perc=round($this-> opt_count[$i] /$this-> v_summ * 100);
		$len=2*$perc;
		$html.= "
		<tr> 
		 <td width='140px'>".$i.". ".$this-> opt_name[$i]."</td>
		 <td width='60px' align='right'>".$perc."%</td>
		</tr>
		<tr>
		 <td colspan=2 width='200px' align='right'>
		 <hr width='".$len."px' class='line'>  </td>
		</tr>";
		}
	
	$html.= "  
		<tr> <td colspan=2> Всего: ".$this-> v_summ." </td> </tr>
		</table> </td> </tr>
	<tr id='tr_vote' style='".$tr_vote."'> <td> <table>";
	for ($i=1; $i<= $this-> v_count; $i++) {
                
                $html.= "
                <tr> 
 		 <td width='180px'>".$i.". ".$this-> opt_name[$i]."</td>
                 <td width='20px'><input type='radio' name='option' value='".$this-> opt_id[$i]."'></td>
                </tr>
		<tr> <td id='error'> </td>";
                }

		$html.= "
		<tr> 
		 <td colspan=2><input type='button' class='submit' name='makevote' value='Голосовать'
				onclick=\" makeVote(".$this-> v_id.",".$this-> user_id.");
				\"
				>
		 </td> 
		</tr>
		</table>
		</td> </tr>";
		if ($this-> v_admin) { 
			$html.= "
			 <tr>
			  <td height=40px valign='bottom'><a href='#' name='modal' class='submit'>Создать голосование</a></td>
			 </tr>";
			/*$html.= 
			"<div id='boxes'>
				<div id='dialog' class='window'>
					adsfasdf
					<div class='closed'></div>
				</div>
				<div id='mask'></div>
			</div>";
*/
			}
	$html.="	</table>
		</div>";		
             
	return $html;
	}
}
?>
