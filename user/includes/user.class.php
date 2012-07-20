<?php 
class user {
public $id;
public $name;
public $avatar;
public $online;
function __construct($id) {
	$this-> id=intval($id);
	}
function getUser() {
	include ("../includes/connection.php");
	require_once("../includes/images.lib.php");
	$query="select * from users where user_id='".$this-> id."'";
	$result=mysql_query($query,$link);
	$row=mysql_fetch_array($result);
	$this-> name=$row['Name'];
	if (file_exists("../avatars/avatar".$row['user_id'].".png")) {
		$avatar="<img src='../avatars/avatar".$this-> id.".png'>";
		$icon="<img src='../avatars/icon".$this-> id.".png'>";
		}
    else {
		$avatar="<img src='../avatars/noavatar.gif' width=200px height=200px'>";
		$icon="<img src='../avatars/noavatar.gif' width=80px height=80px'>";
		}
    $this-> avatar=$avatar;
    $this-> icon=$icon;
	}

}
?>
