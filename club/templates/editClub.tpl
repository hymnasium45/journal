<div class='form_settings'>
<TABLE align='center'>
 <TR>
  <TH align='left' valign='bottom' colspan=2><H6>{$name}</H6></TH>
 </TR>
 <tr>
  <td>
   <table>
	<tr>
     <td> 
      <ul id="navigation" style='width:700px'>
	   <li class='selected'>  <a  href='#' onclick='info_show();'>Информация</a> </li>
	  </ul>
      </td>
      <td align='right'><a href='club.php?club_id={$club_id}'>Вернуться к клубу</td>
	</tr>
   </table> 
  </td>
  </tr> 
  <TR id='info'> 
   <td id='tab_content'  >
    <table>
     <tr>
     <td id='tab_name'>Удалить клуб:</td> 
     <td> <input type='submit' name='delete' class='simple' value="Удалить" 
			onclick="deleteClub({$club_id},'index.php','delete_error');"</td>
     </tr>
     <tr>
     <td id='delete_error' class='error' align=right> </td>
     </tr>
     <tr>
	  <th id='tab_header' colspan=2 align=left> Информация о клубе: </th>
	 </tr>
	 <tr>
	  <TD id='tab_name' align='right' height=40px width=200px> Название: </TD> 
      <TD> <input type='text' class='text' style='width:500px' id='name' value='{$name}'>  </TD>
     </tr>
     <tr>
      <td id='tab_name' align='right' > О нас:
       <TD> <textarea style="width:500px;font-size:12px; height:100px; " name='message'   
		id='club_info' onkeyup="adjustHeight('about'); ">{$info} </textarea> </TD>
     </tr>
    <tr>
     <td colspan=2 align='right' id='savetext' class='error'></td>
    </tr>
	<tr>
	  <td id='tab_header' colspan=2> Приватность клуба:</td>
	 </tr>
	 <tr>
	  <td>
	  </td>
	 </tr>
	 <tr>
	  <td id='tab_name' >  Могут просматривать контент клуба:</td>
	  <td> <select id='canView'>
		      <option value='1' {if ($canView)} selected {/if}> Все </option>
		      <option value='0' {if (!$canView)} selected {/if}> Только участники</option>
		     </select>
	  </td>
	  </tr>
	  <tr>
	   <td id='tab_name' style='width:300px'> Могут пополнять контент клуба:</td>
	   <td> <select id='canWrite'>
		      <option value='1' {if ($canWrite)} selected {/if}> Все </option>
		      <option value='0' {if (!$canWrite)} selected {/if}> Только участники</option>
		    </select>
	   </td>
	  </tr>
	  <tr>
	   <td id='tab_name'>Могут вступать в клуб: </td>
	   <td> <select id='canEnter'>
		      <option value='1' {if ($canEnter)} selected {/if}> Все </option>
		      <option value='0' {if (!$canEnter)} selected {/if}> Только участники</option>
	          </select>
	  </td>
	 </tr>
	 <tr>
      <td colspan=2 height=40px align='right'>
      <input type='button' class='submit' name='save' value='Сохранить'
	   onclick="updateClub('save_error');">
	  </td>
     </tr>
     <tr>
      <td colspan=2 align='right' id='save_error' class='error'></td>
     </tr> 
	</table>
   </td>
  </tr>
 
</table>
</div>

</div>


