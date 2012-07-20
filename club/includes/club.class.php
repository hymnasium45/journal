<?php
session_start();
error_reporting(0);
class club {
public $id;
public $name;
public $about;
public $avatar;
public $icon;
public $creater_id;
public $canView;
public $canWrite;
public $canEnter;
public $createDate;
public $enterDate;
public $isMember;
public $role="none";
private $user_id;
function __construct($id) {
	$this-> id=intval($id);
	}
function getInfo() {
	include ("../includes/connection.php");
	$query="select * from club where club_id='".$this-> id."'";
	$result=mysql_query($query,$link);
	$row=mysql_fetch_array($result);
	$this-> name=$row['name'];
	$this-> about=$row['about'];
	$this-> creater_id=$row['creater_id'];
	$this-> canWrite=$row['canWrite'];
	$this-> canView=$row['canView'];
	$this-> canEnter=$row['canEnter'];
	$this-> createDate=$row['createDate'];
	$this-> type="Закрытый клуб";
	if ($row['canEnter']) 
		$this-> type="Открытый клуб";
	if (file_exists("avatars/avatar".$this-> id.".png")) { 
		$avatar="<img src='avatars/avatar".$this-> id.".png'>";
		$icon="<img src='avatars/icon".$this-> id.".png'>";
		}
    else {
        $avatar="<img src='../avatars/noavatar.gif' width=200px height=200px'>";
		$icon="<img src='../avatars/noavatar.gif' width=80px height=80px'>";
		}
	$this-> avatar=$avatar;
	$this-> icon=$icon;
	$query="select * from users where user_id='".$this-> creater_id."'";
	$result=mysql_query($query,$link);
	$row=mysql_fetch_array($result);
	$this-> creater=$row['Name'];
	}		

function getMember($user_id) {
	include ("../includes/connection.php");
	require_once ("../includes/date.lib.php");
	$this-> user_id=intval($user_id);
	$query="select * from club_users where club_id='".$this-> id."' and user_id='".$this-> user_id."'";
	$result=mysql_query($query,$link);
	$row=mysql_fetch_array($result);
	$this-> enterDate=makeDate($row['date']);
	}


//функция, определяет роль пользователя в клубе, вызывать после того как вызвана getInfo()
function getRole($user_id) {
	$this-> user_id=intval($user_id);
	include ("../includes/connection.php");
	if ($user_id==$this-> creater_id) {
		$this-> role="creater";
		return "Создатель клуба";
		}
	else {
		$query="select * from club_admins where club_id='".$this-> id."' and user_id='".$user_id."'";
		$result=mysql_query($query,$link);
		if (mysql_num_rows($result)>0) {
			$this-> role="admin";
			return "Администратор клуба";
			}
		else {
			$query="select * from club_users where club_id='".$this-> id."' and user_id='".$user_id."'";
			$result=mysql_query($query,$link);
			if (mysql_num_rows($result)>0) {
				$this-> role="member";
				return "Член клуба";
				}
			else {
				$query="select * from club_invites where club_id='".$this-> id."' and user_id='".$user_id."'";
				$result=mysql_query($query,$link);
				if (mysql_num_rows($result)>0) {
					$this-> role="none";
					return "Получил приглашение";
					}
				else {
					$query="select * from club_applies where club_id='".$this-> id."' and user_id='".$user_id."'";
					$result=mysql_query($query,$link);
					if (mysql_num_rows($result)>0) {
						$this-> role="none";
						return "Подал заявку";
						}
					else {
						$this-> role="none";
						return "Не состоит в клубе";
						}
					}
				}
			}
		}
	}

function  isCreater() {
	return $this-> creater_id==$this-> user_id;
	}
function isMember() {
	include ("../includes/connetion.php");
	$query="select * from club_users where user_id='".$this-> user_id."' and club_id='".$this-> club_id."'";
	$result=mysql_query($query,$link);
	if (!$result)
		return "Ошибка. Не удалось выполнить запрос";
	return mysql_num_rows($result)>0; 
	}
function canWrite() {
	$user_id=intval($user_id);
	include ("../includes/connection.php");
	$query="select * from club_mute where club_id='".$this-> id."' and user_id='".$this-> user_id."'";
	$result=mysql_query($query,$link);
	if (!$result) 
		return "Ошибка. Не удалось выполнить запрос";
	if (mysql_num_rows($result)==0 && 
	($this-> role=="member" || $this-> role=="admin") || 
	$this-> role=="creater" || 
	$this-> canWrite) return true; else return false;
	}
function canView() {
	return $this-> canView||$this-> isMember;
	}
function canEdit() {
	if ($this-> role=="creater" || $this-> role=="admin") return true; else return false;
	}
function canEnter() {
	return $this-> canEnter&&$this-> role=="none";
	} 
	
function canRate() {
	return $this-> role!="none"; 
	}

function hasInvite() {
	include ("../includes/connection.php");
	if ($this-> role!="none") {
		require_once("includes/club.lib.php");
		deleteInvite($this-> id,$this->user_id);
		return false;
		}
	else {
		$query="select * from club_invites where user_id='".$this-> user_id."' and club_id='".$this-> id."'";
		$result=mysql_query($query,$link);
		if (mysql_num_rows($result)>0) return true; else return false;
		}
	}
function hasApply() {
	include ("../includes/connection.php");
	if ($this-> role!="none") {
		require_once("includes/club.lib.php");
		deleteApply($this-> id,$this-> user_id);
		return false;
		}
	else {
		$query="select * from club_applies where user_id='".$this-> user_id."' and club_id='".$this-> id."'";
		$result=mysql_query($query,$link);
		if (mysql_num_rows($result)>0) return true; else return false;
		}
	}
function getCountMember() {
	include ("../includes/connection.php");
	$query="select * from club_users where club_id='".$this-> id."'";
	$result=mysql_query($query,$link);
	return mysql_num_rows($result);
	}
function getCountApply() {
	include ("../includes/connection.php");
	$query="select * from club_applies where club_id='".$this-> id."'";
	$result=mysql_query($query,$link);
	return mysql_num_rows($result);
	}
function getMembers() {
	include ("../includes/connection.php");
	$query="select * from club_users where club_id='".$this-> id."'";
	$result=mysql_query($query,$link);
	$count=-1;
	$users=array();
	require_once("../user/includes/user.class.php");
	while ($row=mysql_fetch_array($result)) {
		$count++;
		$users[$count]=new user($row['user_id']);
		$users[$count]-> getUser();
		$users[$count]-> name=makeName($users[$count]-> name);
		}
	return $users;
	}

}

class userClub {
	public $name;
	public $creater;
	public $creater_id;
	public $avatar;
	public $id;
	public $isAdmin=false;
	public $isMember=false;
	public $role="Не состоит в клубе";
	public $enterDate;
	
	function getClub($club_id) {
		include ("../includes/connection.php");
		$club_id=intval($club_id);
		$query="select * from club where club_id='".$club_id."'";
		$result=mysql_query($query,$link);
		$row=mysql_fetch_array($result);;
		$this-> name=$row['name'];
		$this-> id=$row['club_id'];
		$this-> about=$row['about'];
		require_once("../includes/date.lib.php");
		$this-> date=makeDate($row['createDate']);
		$img=$row['avatar'];
		require_once ("../includes/images.lib.php");
		if (file_exists("../avatars/".$img) && $img!='') {
        $size=makePost("../avatars/".$img);
			$this-> avatar="<img src='../avatars/".$img."' width='".$size[0]."' height='".$size[1]."'>";
			}
		else
			$this-> avatar="<img src='../avatars/noavatar.gif' class='post_image'";
		$this-> avatar="<a href='club.php?club_id=".$this-> id."'>".
		$this-> avatar."</a>";
	
		$id=$row['creater_id'];
		$this-> creater_id=$id;
		$query="select * from users where user_id='".$id."'";
		$result=mysql_query($query,$link);
		$row=mysql_fetch_array($result);
		$this-> creater=$row['Name'];
		mysql_free_result($result);
		mysql_close($link);
		}
	
	function getUserClub($user_id) {
		include ("../includes/connection.php");
		$this-> role="Не состоит в клубе";
		$user_id=intval($user_id);
		if ($this-> isAdmin) 
			$this-> role="Администратор клуба";
		if ($user_id==$this-> creater_id) {
			$this-> role="Создатель клуба";
			$this-> isAdmin=true;
			$this-> enterDate=$this-> date;
			}
		if (!$this-> isAdmin) {
			$query="select * from club_users where club_id='".$this-> id."' and user_id='".$user_id."'";
			$result=mysql_query($query,$link);
			$num=mysql_num_rows($result);
			if ($num==0) return;
			$this-> role="Член клуба";
			$this-> isMember=true;
			$row=mysql_fetch_array($result);
			require_once("../includes/date.lib.php");
			$this-> enterDate=makeDate($row['date']);
			mysql_free_result($result);
			}
	 
		}

	function getUserClubTpl() {
		require_once ("../smarty/Smarty.class.php");
		$tpl= new Smarty;
		$tpl-> template_dir="templates/";
		$tpl-> compile_dir="templates_c/";
		$tpl-> config_dir="configs/";
		$tpl-> cache_dir="cache/";	
		$tpl-> assign("name",$this-> name);
		$tpl-> assign("date",$this-> enterDate);
		$tpl-> assign("avatar",$this-> avatar);
		$tpl-> assign("role",$this-> role);
		$tpl-> assign("club_id",$this-> id);
		return $tpl-> fetch("userClub.tpl");
		}
	function getUserInviteTpl() {
		require_once ("../smarty/Smarty.class.php");
		$tpl= new Smarty;
		$tpl-> template_dir="templates/";
		$tpl-> compile_dir="templates_c/";
		$tpl-> config_dir="configs/";
		$tpl-> cache_dir="cache/";	
		$tpl-> assign("name",$this-> name);
		$tpl-> assign("avatar",$this-> avatar);
		$tpl-> assign("creater_name",$this->creater);
		$tpl-> assign("creater_id",$this-> creater_id);
		$tpl-> assign("club_id",$this-> id);
		return $tpl-> fetch("userInvite.tpl");
		}	
	}
	


?>
