<table class='userClub'>
 <tr> 
  <td valign='top' rowspan=3>{$avatar}</td>
  <td id='tab_name'>Имя:</td>
  <td class='name'><a href='../htdocs/profile.php?id={$user_id}'>{$name}</a></td>	
 </tr>
 <tr>
 <td id='tab_name'>Роль в клубе:</td>
 <td>{$role}</td>
 </tr>
 <tr>
  <td>
  </td>
  <td>
  {if (!$inClub && !$hasInvite)}
  <input type='button' class='userClubGreen' value='Отослать приглашение'
  onclick="sendInvite('{$club_id}','{$user_id}','invite_error{$user_id}');">
  {elseif ($inClub)}
  Пользователь состоит в клубе
  {elseif ($hasInvite)}
  <input type='button' class='userClubRed' value='Удалить приглашение'
  onclick="deleteInvite('{$club_id}','{$user_id}','invite_error{$user_id}');">
  
  {/if}
  </td>
 <tr>
 <tr> 
  <td colspan=3 align=right class='error' style='padding-right:200px' id='invite_error{$user_id}'></td>
 </tr>
</table>

	
