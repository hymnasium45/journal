	<div id='div{$id}' class='' 
	     onmouseover="
					document.getElementById('div{$id}').className='comment_selected';
					if (document.getElementById('delete{$id}'))
						document.getElementById('delete{$id}').style.display='';
					if (document.getElementById('button{$id}'))
						document.getElementById('button{$id}').style.display='';
					
					"
				onmouseout="
					document.getElementById('div{$id}').className='';
					if (getElementById('num{$id}').style.display=='none') {
						if (document.getElementById('button{$id}'))
							document.getElementById('button{$id}').style.display='none';
						if (document.getElementById('delete{$id}'))
							document.getElementById('delete{$id}').style.display='none';
						
						}
					"
				>
        <TABLE id='tr{$id}' class='comment'>
         <tr>
          <td colspan=2 class='error' id='rateError{$id}' align=right> </td>
         </tr>
         <TR> 
          <TD valign='top' rowspan=4>{$avatar}</TD>
		  <td> 
		   <table>
		    <tr>		   
             <TD class='date'>{$date}</td>
             <td rowspan=2> 
			  <table>
			   <tr>
				<td style='color:{if ($rate>0)}green{elseif ($rate<0)}red{/if}' id='rate{$id}' class='rate' align=right rowspan=2>
				{if ($rate>0)}+{/if}
				{$rate}</td>
								<td>
				{if ($canRate)} <button type='button' id='up{$id}' class='rate_up'
						onclick="rateMessage('up','{$id}','rate{$id}','rateError{$id}');">{/if}
				</td>
			   </tr>
			   <tr>
				<td>
				
				{if ($canRate)}  <button type='button' id='down{$id}' class='rate_down'
						onclick= "rateMessage('down','{$id}','rate{$id}','rateError{$id}');">{/if}
				</td>
			   </tr>
			  </table>
		     </td>
		    </tr>
		    <TR>
			  <TD class='sender_name' ><a href='../htdocs/profile.php?id={$sender_id}'>{$sender}</a>
			  {if ($online)} <img src='../images/online.gif' title='Онлайн'> {/if}
			</td>
			 </tr>
		  </table>
		 </td>
	    </tr>
							
       <TR><TD> <TABLE class='answer'>	
	{section name=i loop=$answers step=-1}
			<tr> 
			 <td class='answer_name' style='padding-left:{$smarty.section.i.index*5}px'>{$answers[i]-> sender_name}</td>
			</tr>
			<tr> 
			 <td class='answer_text' style='padding-left:{$smarty.section.i.index*5}px'>{$answers[i]-> text}</td>
			</tr>
	{/section} 
	</TABLE></TD></TR>
       <TR><TD class='sender_text' id='text{$id}' width='500px' valign='top' style='padding-top:10px;
	{if ($rate<0) }
		   color:gray;'
		   
		   onmouseover="
			document.getElementById('$text{$id}').style.color='black';"
		   onmouseout="
			document.getElementById('$text{$id}').style.color='gray';"
	{else}'{/if}
	class='sender_text'>{$text}</TD>
                </TR>

	<tr> <TD colspan=2 align='right' height=40px>
	 {if ($canWrite) }
				<button type='button' class='mess_button'  id='button{$id}' 
				title='Ответить'
				style='display:none'
				onclick="
				if (getElementById('num{$id}').style.display=='none')
					getElementById('num{$id}').style.display=''; 
				else    
		                        getElementById('num{$id}').style.display='none'; 
				" 
				><img src='../images/Balloon.png' style='height:30px;'></button>
	 {/if}
		{if ($canEdit) } 	
					
                              <button type='button' class='mess_button'
                                title='Удалить сообщение' id='delete{$id}' name='delete'
                                onclick=" deleteMess('{$id}','div{$id}');"
                                style='display:none'>
                                <img src='../images/Button_delete.png' style='height:30px;'> </button>
        {/if}
        </TD> </tr>
	{if ($canWrite)}
	 <TR>
	  <TD align='center' colspan=2 id='num{$id}' style='display:none'> 
	    <table>   
		 <TR>
           <TD> 
		    <textarea style='width:600px; height:100px;' 
		     id='answer_text{$id}'  placeholder='Напишите сообщение' 
		     onkeyup=\"adjustHeight('answer_text{$id}');\"> </textarea> 		      
		   </TD>
          </TR>
          <TR>
           <TD align='right'> 
            <INPUT type='button' class='submit' id='send{$id}' value='Отправить'
							onclick="sendMessage(
							'{$club_id}',
							document.getElementById('answer_text{$id}').value,
							'{$id}','answer_error{$id}','club.php?club_id={$club_id}');"> 
		   </TD>
          </TR>
          <tr>
           <td id='answer_error{$id}' class='error' align=right></td>
          </tr>
         </table>
		</TD>
	   </TR>
     {/if}
	</TABLE>
	



