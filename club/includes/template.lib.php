<?php 
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");

function getUserClubTpl($club_id,$creater_id,$creater,$name,$avatar,$role,$enterDate,$countMember,$type,$loc) {
	$way= getcwd();
	chdir("includes");
	require_once ("../../smarty/Smarty.class.php");
	chdir($way);
	$tpl= new Smarty;
	$tpl-> template_dir="templates/";
	$tpl-> compile_dir="templates_c/";
	$tpl-> config_dir="configs/";
	$tpl-> cache_dir="cache/";	
	$tpl-> assign("name",$name);
	$tpl-> assign("date",$enterDate);
	$tpl-> assign("avatar",$avatar);
	$tpl-> assign("role",$role);
	$tpl-> assign("club_id",$club_id);
	$tpl-> assign("creater_id",$creater_id);
	$tpl-> assign("creater",$creater);
	$tpl-> assign("countMember",$countMember);
	$tpl-> assign("type",$type);
	$tpl-> assign("loc",$loc);
	return $tpl-> fetch("userClub.tpl");
	}

function getUserInviteTpl($name,$avatar,$creater,$creater_id,$club_id) {
	$way= getcwd();
	chdir("includes");
	require_once ("../../smarty/Smarty.class.php");
	chdir($way);
	$tpl= new Smarty;
	$tpl-> template_dir="templates/";
	$tpl-> compile_dir="templates_c/";
	$tpl-> config_dir="configs/";
	$tpl-> cache_dir="cache/";	
	$tpl-> assign("name",$name);
	$tpl-> assign("avatar",$avatar);
	$tpl-> assign("creater_name",$creater);
	$tpl-> assign("creater_id",$creater_id);
	$tpl-> assign("club_id",$club_id);
	return $tpl-> fetch("userInvite.tpl");
	}	
	
?>
