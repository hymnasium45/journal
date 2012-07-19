<table class='userClub' id='div{$user_id}'>
	<tr>
	 <td rowspan=3 valign=top><a href='../htdocs/profile.php?id={$user_id}'>{$avatar}</a> </td>
	 <td id='tab_name'> Имя:
      </td>
	 <td class='name'> <a href='../htdocs/profile.php?id={$user_id}'>{$name}</a> </td>
	</tr>
	<tr> 
	 <td id='tab_name'>Вступил в клуб: </td>
	 <td> {$date} </td>
	</tr>
	<tr>
	 <td id='tab_name'>Роль в клубе:</td>
     <td>{$role}</td>
	</tr>
	<tr>
	 <td> {$rate} </td>
	</tr>
	<tr>
	 <td colspan=3 align=right style='padding-right:200px'> 
	 	<button type='button' class='user_club_button'
	    title='Сделать администратором' id='make{$user_id}' 
	    {if ($canEdit || $isCreater || $user_id==$viewer_id)} style="display:none" {/if}
		onclick=" makeAdmin('makeAdmin','{$user_id}','action_error{$user_id}');"
		> <img src='images/makeAdmin.png' style='height:30px;'></button>
	 
	 	<button type='button' class='user_club_button'
	    title='Удалить из администраторов' id='unmake{$user_id}' 
        {if (!$canEdit || $isCreater || $user_id==$viewer_id) } style="display:none" {/if}
        onclick=" makeAdmin('unmakeAdmin','{$user_id}','action_error{$user_id}');"
		> <img src='images/unmakeAdmin.png' style='height:30px;'></button>
	 
        <button type='button' class='user_club_button'
	    title='Заблокировать' id='mute{$user_id}' 
        {if ($isCreater || !$canWrite || $user_id==$viewer_id) } style='display:none' {/if}
		onclick=" muteUser('muteUser','{$user_id}','action_error{$user_id}');"
		> <img src='images/mute.png' style='height:30px;'></button>      
      
     	<button type='button' class='user_club_button'
	    title='Разблокировать' id='unmute{$user_id}' 
        {if ($canWrite || $isCreater || $user_id==$viewer_id)} style='display:none' {/if}
        onclick=" muteUser('unmuteUser','{$user_id}','action_error{$user_id}');"
		> <img id='admin_image{$user_id}'src='images/unmute.png' style='height:30px;'></button>
	
      
      {if (!$isCreater && $user_id != $viewer_id) }
     	<button type='button' class='user_club_button'
	    title='Удалить' id='delete{$user_id}' 
        onclick=" deleteUser('{$user_id}','div{$user_id}','action_error{$user_id}');"
		> <img src='images/delete.png' style='height:30px;'></button>
	  {/if}
      </td>
	</tr>
	<tr> 
	 <td colspan=3 align=right style='padding-right:200px' class='error' id='action_error{$user_id}'></td>
	</tr>
</table>
