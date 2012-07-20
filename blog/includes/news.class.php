<?php	
class News
{
	private $data = array();
	
	
	public function __construct($row)
	{
		$this->data= $row;	
	}
	
	public function post_brief() 
	{
		$temp=$this->data;
		$num_comments=mysql_num_rows(mysql_query("select * from news_comments where news_id='".$temp['news_id']."'"));
		$pos=strpos($temp['text'],'</p>');	
		$temp['text']=substr($temp['text'],0,$pos+4);
		$name=mysql_fetch_array(mysql_query("select Name from users where user_id='".$temp['user_id']."'"));
		require_once("../includes/date.lib.php");
		$date=makeDate(substr($temp['date'],0,10)).substr($temp['date'],10,9);
		$tags=$temp['tags'];
		if (file_exists("../avatars/".$temp['image']) && $temp['image']!='') {
			require_once("../includes/images.lib.php");
			$size=makeImage("../avatars/".$temp['image'],600,400);
			$img="<a href='../htdocs/profile.php?id=".$temp['image']."'>
			<img src='../avatars/".$temp['image']."' id='img' style='width:".$size[0]."; height:".$size[1].": > </a>";
			}
			else
         $img="";

return "
	<div class='post' style='margin-bottom:30px;'>
	<table width='650'  style='padding-bottom:10px;'>
	<tr>
	<td ><a href='news.php?id=".$temp['news_id']."' id='name' >".$temp['name']."</a><br><a href='#' id='tick'> ".$temp['type']."</a>
	</td>
	</tr>
	</table>


	<hr  align='left' width='650' size='1' color='#E6E6FA' />
	<div id='tags' > Метки: ".$tags."</div>
	".$img."
	<div id='text' >".$temp['text']."</div>
	<a style='color:#3366FF;  padding-left:20px;' href='news.php?id=".$temp['news_id']."'>Смотреть дальше</a>

	<div class='aBox'>
	<div id='date'> ".$date." </div>
	<div id='author'><img src='../images/user.png' style='height:15px'><a  style='text-decoration:none; padding-left:5px;' href='../htdocs/profile.php?id=".$temp['user_id']."' >".$name['Name']."</a></div>
	<div id='comment'><img src='../images/Balloon.png' style='height:15px; padding-right:5px;' /><a href='news.php?id=".$temp['news_id']."'>$num_comments</a></div>

	</div>
	</div>
	";
	}
	
	public function post_full()
	{
		$temp=&$this->data;
		$num_comments=mysql_num_rows(mysql_query("select * from news_comments where news_id='".$temp['news_id']."'"));
		$name=mysql_fetch_array(mysql_query("select Name from users where user_id='".$temp['user_id']."'"));
		require_once("../includes/date.lib.php");
		$date=makeDate(substr($temp['date'],0,10)).substr($temp['date'],10,9);
		$tags=$temp['tags'];
		return "
		 <div class='post' style='margin-bottom:30px;'>
        
	
	<table width='650'  style='padding-bottom:10px;'>
        <tr>
        <td ><a href='news.php?id=".$temp['news_id']."' id='name' >".$temp['name']."</a><br><a href='#' id='tick'> ".$temp['type']."</a>
        </td>
        </tr>
        </table>


        <hr  align='left' width='650' size='1' color='#E6E6FA' />
        <div id='tags' > Метки: ".$tags."</div>

        <div id='text' >".$temp['text']."</div>
		
        <div class='aBox'>
        <div id='date'> ".$date." </div>
        <div id='author'><img src='../images/user.png' style='height:15px'><a  style='text-decoration:none; padding-left:5px;' href='profile.php?id=".$temp['user_id']."' >".$name['Name']."</a></div>
        <div id='comment'>
			<img src='../images/Balloon.png' style='height:15px; padding-right:5px;' />
			<a href='news.php?id=".$temp['news_id']."'>".$num_comments."</a>
		</div>

        </div>
        </div>


	";


			

	}


}
