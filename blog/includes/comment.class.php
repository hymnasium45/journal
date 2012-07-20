<?php

class Comment
{	public $comments = array();
	public $array =array();
	private $data = array();
	
	public function __construct($row)
	{
		/*
		/	The constructor
		*/
		
		$this->data = $row;
	}
	
	
	public function sort_ans($id,$i,$padding, $status, $num, $news_id)
	{	if ($num<6) $padding+=25;	
		
		if ($status=='1') $i=0;
		$result=mysql_query("select * from news_comments where answer_id='".$id."'and news_id='".$news_id."' order by date");
		
		if (mysql_num_rows($result)>0) {
		while ($row=mysql_fetch_array($result))
			{	
				
				$i++;
				$temp= new Comment($row);	
				$comments[$i]=$temp->markup($padding);
				
				echo $comments[$i];
				$count=$this->sort_ans($row['comment_id'],$i,$padding,'0',$num+1,$news_id);
				$i=$i+intval($count);
			 	//$comments=array_merge($comments, $array);
	}
	}
	if (  $status=='0') return mysql_num_rows($result);
	}











	

	public function markup($padding) {
		/*
		/	This method outputs the XHTML markup of the comment
		*/
		
		// Setting up an alias, so we don't have to write $this->data every time:
		$d = &$this->data;
		$way= getcwd();
		if (!strpos($way,'includes'))
			chdir("includes");
		//echo getcwd();
		$name=mysql_fetch_array(mysql_query("select * from users where user_id='".$d['user_id']."'"));
		
		if (file_exists("../../avatars/".$name['avatar']) && $name['avatar']!='') {
			require_once("../../includes/images.lib.php");
			$size=makeImage("../../avatars/".$name['avatar'],50,50);
			$img="<a href='../htdocs/profile.php?id=".$name['user_id']."'>
			<img src='../avatars/".$name['avatar']."' width='".$size[0]."' height='".$size[1]."' > </a>";
			}
			else
         $img="<img src='../avatars/noavatar.gif' height=50px width=50px>";

        
		// Converting the time to a UNIX timestamp:
		require_once("../../includes/date.lib.php");
		$date=makeDateTime($d['date']);
		// Needed for the default gravatar image:
		
		if ($d['rate']<0) { $color='#F76541';}
		else { 
		if ($d['rate']>0) { $d['rate']='+'.$d['rate']; $color='#4E9258';}
		else if ($d['rate']==0) { $color='#c2c2c2';}
		}
		$text_pad=$padding+10;
	if ($d['text']=='The message was deleted by user') 

		{
		  $str2pass="
                <div class='block".$d['comment_id']."' >        
                        <div class='comment' style='margin-left:".$padding."px; opacity: 0.5 '  >
                                                             
                                <div class='name'><a href='../../htdocs/profile.php?id=".$name['user_id']."'>".$name['Name']."</a></div>
                               
				 <p style='font-size:18px'>Сообщение удалено.</p>
				
			</div>
		</div>
		";
 

		}


else {
	
	$str2pass="
		<div class='block".$d['comment_id']."' >	
			<div class='comment' style='margin-left:".$padding."px; '  >
				<div class='avatar'>
				".$img."
				</div>
				
				<div class='name'>
				\<a href='../htdocs/profile.php?id=".$name['user_id']."'>".$name['Name']."</a></div>
				<div class='date' title='Пост был добавлен ".$date."'>".$date."</div>
				<div class='rate' style='color:$color;'>".$d['rate']."</div>
		";
		if ($d['user_id']!=$_SESSION['user_id']) {
				$temp_1="<div class='up'><a href='#'>
				<img style='height:15px;' src='../images/Arrow_up.png' title='Проголосовать за'/></a></div>
				<div class='down'><a href='#'>
				<img style='height:15px;' src='../images/Arrow_down.png' title='Проголосовать против'/><a/></div>
		";
				$str2pass.=$temp_1;}
		else {$temp_2="
			          <div class='edit'><a href='#'>
			          <img style='height:20px;' src='../images/pencil.png' title='Редактировать'/></a></div>

				<div class='delete'><a href='#' >
				<img style='height:20px;' src='../images/Button_delete.png' title='Удалить'/></a></div>";
			$str2pass.=$temp_2;	}
		$temp_3="
				<div class='response'><a  href='#'>
				<img style='height:20px;' src='../images/Balloon.png' title='Ответить'/></a></div>  
				<p>".$d['text']."</p>
			</div>
			
			
			<p id='ans' style='display:none; line-height:15px; padding-left: ".$text_pad."px; width:520px; padding-top:10px;'> <e>Ваш ответ: </e>
			<textarea style='width:470px;' rows=4 ></textarea> <br> 
			<input type='submit' class='submit' style='margin-bottom:10px;'
					value='Ответить'> | 
			<a href='#' class='hide' style='position:relative; right:0px; '> Скрыть</a>
			<input type='hidden' id='ans_num' value='".$d['comment_id']."'>	</p>
		</div>
	
		";
		$str2pass.=$temp_3;
 	}
	chdir($way);	
		return $str2pass;
	//*/
	//return "test";
	}
	
	public static function validate(&$arr)
	{
		/*
		/	This method is used to validate the data sent via AJAX.
		/
		/	It return true/false depending on whether the data is valid, and populates
		/	the $arr array passed as a paremter (notice the ampersand above) with
		/	either the valid input data, or the error messages.
		*/
		
		$errors = array();
		$data	= array();
		
		
		if(!($data['text'] = filter_input(INPUT_POST,'text',FILTER_CALLBACK,array('options'=>'Comment::validate_text'))))
		{
			$errors['text'] = 'Please enter a comment body.';
		}
		
		$data['ans_num']=filter_input(INPUT_POST, 'ans_num', FILTER_VALIDATE_INT);
		$data['margin']=filter_input(INPUT_POST, 'margin');
		
		/*
		if(!($data['name'] = filter_input(INPUT_POST,'name',FILTER_CALLBACK,array('options'=>'Comment::validate_text'))))
		{
			$errors['name'] = 'Please enter a name.';
		}
		*/
		if(!empty($errors)){
			
			// If there are errors, copy the $errors array to $arr:
			
			$arr = $errors;
			return false;
		}
		
		// If the data is valid, sanitize all the data and copy it to $arr:
		
		foreach($data as $k=>$v){
			$arr[$k] = mysql_real_escape_string($v);
		}
		
		// Ensure that the email is lower case:
		
		
		
		return true;
		
	}

	private static function validate_text($str)
	{
		/*
		/	This method is used internally as a FILTER_CALLBACK
		*/
		
		if(mb_strlen($str,'utf8')<1)
			return false;
		
		// Encode all html special characters (<, >, ", & .. etc) and convert
		// the new line characters to <br> tags:
		
		$str = nl2br(htmlspecialchars($str));
		
		// Remove the new line characters that are left
		$str = str_replace(array(chr(10),chr(13)),'',$str);
		
		return $str;
	}

}

?>
