 <div class='form_settings'>

<FORM method='POST' enctype='multipart/form-data' class='form_settings'>
 		<div id='boxes'>
			 <div id='dialog' class='window' style='width:500px; height:250px;'>
			  <table style='padding:30px'>
			  <tr>
			   <th colspan=2>Загрузка фотографии</th>
			  </tr>
			  <tr>
			   <td height=50px>Выберите файл:
			    <input style='padding-top:30px;' name='userfile' type='file'/>
			   </td>
			  </tr>
			  <tr>
			  <th height=60px valign='bottom'>
		      <input type='submit' name='upload' class='submit' value='Загрузить'>
              <input type='hidden' name='MAX_FILE_SIZE' value='30M' />
              </th>
              </tr>
              </table>
			  <div class='closed'></div>
             </div>
			 <div id='mask'></div>
			</div>
</form>    
 <TABLE align='center'>
 
  <TR>
   <TH align='left' valign='bottom' colspan=2><H6>{$name}</H6></TH>
  </TR>
  <tr>
   <TD width='200px' valign='top' style='padding-top:50px;'>
    <TABLE>
     <TR valign='top'>
      <TD  height='300px' width='200px' >{$avatar}</TD>
     </TR>
     <tr>
      <td>{$menu}</td>
    </tr>
   </TABLE>
  </TD>
  <TD valign='top' width=650px>
   <TABLE>
    <tr>
     <td>    	  
       <ul id="navigation" style='width:650px'>
	    <li class='none'>  <a  href='#' onclick="showInfo();">О нас</a> </li>
	    <li class='selected'> <a href='#' onclick='showChat();'>Чат</a> </li> 
       </ul>
      </td>
     </tr>  
	<TR style='display:none;' id='club_info'>
     <td id='tab_content'>
      <table >
	   <tr>
	    <TD id='tab_header'> О нас: </TD>
       </TR>
       <TR>
        <TD height='50px' valign='top'>{$info}</TD>
       </tr>
       <TR>
        <TD id='tab_header'>{$count_member}</TD>
       </TR>
       <TR>
        <TD> 
         <TABLE >
     {assign var="count" value=-1}
     {section name=i loop=$members}
	 {$count=$count+1}
	 {if ($count%6==0)} <tr> {/if}
     
      <td>
		<table>
			<tr>
			 <td align='center' class='post_image' valign='top'><a href='../htdocs/profile.php?id={$members[i]-> id}'>{$members[i]-> icon}</a></td>
			</tr>
			<tr>
	  		 <td width=100px align='center'><a href='../htdocs/profile.php?id={$members[i]-> id}'>{$members[i]-> name}</a></td>
			</tr>
		</table>
 		 </td>
 	
     {if ($count%6==5)} </tr>{/if}
     {/section}
       </TABLE>
      </TD>
     </TR>
    
     </table>
     </td>
   </TR>
   <TR id='club_chat'>
    <td id='tab_content'>
	 <table>
	  <tr> 
       <TD id='tab_header'> Чат({$message_count})</TD>
      </TR>
      {if ($canWrite) }
      <TR> 
      <TD align='center'> 
       <textarea style="width:650px;  height:100px;" class='textarea' name='message' placeholder='Напишите сообщение' 
		id='textarea' 
		onkeyup= "adjustHeight('textarea');"> </textarea>  
	  </TD>
    </TR>
    <TR>
     <TD align='right' style='padding-right:15px'> <INPUT type='submit' class='submit' id='send_message' value='Отправить'
     onclick="sendMessage({$club_id},document.getElementById('textarea').value,0,'send_error',
				'club.php?club_id={$club_id}&page={$page}');"> </TD>
    </TR>
    <tr> <td align='right' id='send_error' class='error'> </td> </tr>
    {else} 
    <tr> 
	 <td class='error' align='center' style='height:30px'> Вы не можете писать сообщения </td>
	</tr> 
	{/if}
	 
    <TR>
     <td id='clubChatContent'>{$chat_content}</TD>
    </TR>
    <tr>
     <td align='center' id='chatPagePattern'>{$chat_page_pattern}</td>
    </tr>
   </TABLE>
  </td>
 </tr>
 </table>
   
 
  </TD>
 </TR>
</TABLE>
</div>
    
