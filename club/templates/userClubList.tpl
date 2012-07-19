<div class='form_settings'>

		    <div id='boxes'>
			 <div id='dialog' class='window' style='width:500px; height:250px;'>
			  <div id='head'> Создание клуба </div>
			  <div id='w_content'>
			   <table >
			    <tr>
			     <td ><h1>Название:</h1></td>
			    </tr>
			    <tr>
			     <td><input maxlength=50 style='width:450px'type='text' class='text' id='name' placeholder='Введите значение'></td>
			    </tr>
               </table>
              </div>
			  <div id='footer'>
			   <table height=100%>
				<tr>
				 <td  width=340px align='right'><input type='button' id='create' class='w_button' value='Создать клуб'
						onclick="
						var name=getElementById('name').value;
						createClub(name,'index.php','createError');"></td>
				 <td width=110px align='right'><input type='button' class='w_button' value='Отменить'
					onclick="location.href='';"></td>
				</tr>
				<tr>
				 <td colspan=2 align=right class='error' id='createError'> </td>
				</tr>
			   </table>
			  </div>
			  <div class='closed'></div>
             </div>
             <div id='mask'></div>
		    </div>

<TABLE align='center'>
 	<tr>
     <td>
     <table>
      <tr>
      <td> 
      <ul id="navigation" style='width:500px'>
	   <li {if $page== 'clubs' } class='selected' 
		{else}  class='none' {/if}> <a  href='' onclick='showClub();'>Мои клубы</a> </li>
	   <li {if $page== 'invites' } class='selected' 
                {else}  class='none' {/if} > 
                <a  onclick='showInvite();' href=''>Мои Приглашения
                {if ($invite_count>0)} ({$invite_count}) {/if}
                </a> </li>
	  </ul>
      </td>
      <td width=130px><a href='all_clubs.php'>Все клубы</a></td>
      <td width=170px><a href='#dialog' name='modal' >Создать клуб </a></td>
	</tr>
    <table>
    </td>
    </tr>
    <tr id='my_club' {if $page== 'invites' }  style='display:none' {/if}>
       
   <td id='tab_content'>
	<table >
	 <tr>
	  <td id='tab_header'>{$club_count_name}</td>
	 </tr>
     <tr>
      <td id='userClubCentent'> {$club_content} </td>
     </tr>
	<tr>
	 <td align='center' id='clubs_page_pattern'>{$clubs_page_pattern}</td>
	</tr>
	 </table>
   </td>
  </tr>
  <tr id='my_invite' {if $page== 'clubs' }  style='display:none' {/if}>
   <td id='tab_content'>
	<table>
	<tr>
	 <td id='tab_header'> {$invite_count_name}</td>
	</tr>
	<tr>
	 <td id='userInviteContent'> {$invite_content} </td>
	</tr>
	<tr>
	 <td align='center' id='invites_page_pattern'>{$invites_page_pattern}</td>
	</tr>
	
	</table>
   </td>
  </tr>
   
</TABLE>
