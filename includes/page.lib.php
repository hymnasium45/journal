<?php
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");

if ($_SESSION['login']!=1) {
	die();
	}

if ($_POST['action']=='getPage') {
	echo getPagePattern($_POST['p_num'],$_POST['max_page'],$_POST['function']);
	die();
	}
function getPagePattern($page,$max_page,$function) {
	$page_id=intval($page);
	$p_count=intval($max_page);
	if ($page_id>1) $first=$page_id-1; else $first=1;
	if ($page_id<$p_count) $last=$page_id+1; else $last=$p_count;
	if ($last<1) $last=1;
	if ($page_id<1) $page_id=1;

	$html.="
	<table>
     <TR> 
      <TD colspan=2 align='center' height=100px>";
     if ($page_id==1) 
		$html.="<input type='button' class='this_page' value='1'>";
	if ($page_id>1)      
		$html.="<input type='button' class='page' value='Пред.'
		onclick=\"".$function."('".$first."','".$p_count."');\" > 
		  <input type='button' style='page' class='page' value='1' 
		  onclick=\"".$function."('1','".$p_count."');\">";
	 if ($page_id==2) 
		$html.="<input type='button' class='this_page' value='2'>";
	 if ($page_id==3)
		$html.="
		<input type='button' style='page' class='page' value='2'
		onclick=\"".$function."('2','".$p_count."');\">
		<font class='this_page'>3</font>";
	 if ($page_id>3) 
		$html.="
		<input type='button' style='page' class='page' value='".$first."' 
		onclick=\"".$function."('".$first."','".$p_count."');\">
		<input type='button' class='this_page' value='".$page_id."'>";
     if ($page_id<$p_count) 
		$html.="
		<input type='button' style='page' class='page' value='".$last."' 
		onclick=\"".$function."('".$last."','".$p_count."');\">";
	 if ($page_id<$p_count-2) 
		$html.="";
	 if ($page_id<$p_count-1) 
		$html.="
		<input type='button' style='page' class='page' value='".$p_count."' onclick=\"".$function."('".$p_count."','".$p_count."');\">";
	 if ($page_id<$p_count)
		$html.="
		<input type='button' class='page' value='След.'	onclick=\"".$function."('".$last."','".$p_count."');\" >";
	 $html.= "
	 <input type='text' class='page_input' id='p_num".$function."' maxlength=4>
	 <input type='button' class='page' value='Перейти'	
		onclick=\"".$function."(document.getElementById('p_num".$function."').value,".$p_count.");\" >
	</td></tr></table>";
	return $html;
	}
?>
