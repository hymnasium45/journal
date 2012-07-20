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
	   <li class='selected'><a  href='#' onclick='member_show();'>участники</a> </li>
	   <li class='none'> <a href='#' onclick='apply_show();'>заявки</a>
      </ul>
      </td>
      <td align='right'><a href='club.php?club_id={$club_id}'>Вернуться к клубу</td>
	</tr>
   </table> 
  </td>
  </tr> 
  <TR id='member'> 
   <td id='tab_content'  >
	<table>
	 <TD id='tab_header'>
	  Участники
	  ({$count_users})
	 </TD>
    </TR>
    <TR>
     <td>
	 {$users}
	 </td>
    </tr>
   </table>
   
   </td>
  </tr>
   <TR id='apply' style='display:none'> 
   <td id='tab_content'  >
	<table>
	 <TD id='tab_header'>
	  Заявки
	  ({$count_apply})
	 </TD>
    </TR>
    <TR>
     <td>
     {$applies}
	 </td>
    </tr>
   </table>
   
   </td>
  </tr>

</table>

