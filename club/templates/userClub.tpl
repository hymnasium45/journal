<table class='userClub'>
<tr>
 <td rowspan=7 valign='top' class='avatar'>
	<a href='club.php?club_id={$club_id}'>{$avatar}</a></td>
 <td id='tab_name'>Название:</td>
 <td class='name'><a href='club.php?club_id={$club_id}'>{$name}</a></td>
</tr>
<tr>
 <td id='tab_name'>Создатель:</td>
 <td class='name'><a href='../profile.php?id={$creater_id}'>{$creater}</a>
</tr>
<tr>
 <td id='tab_name'>Тип клуба:</td>
 <td>{$type}</td>
</tr>
<tr>
 <td id='tab_name'>Кол-во участников:</td>
 <td>{$countMember}</td>
</tr>
{if ($role!='Не состоит в клубе' && $role!='Получил приглашение' && $role!='Подал заявку')}
<tr>
 <td id='tab_name'>Вы вступили в клуб:</td>
 <td>{$date}</td>
</tr>
{/if}
<tr>
 <td id='tab_name'>Роль в клубе:</td>
 <td>{$role}</td>
</tr>
<tr>
 <td></td>
 <td>
 {if ($role!='Создатель клуба' && ($role=='Администратор клуба' || $role=='Член клуба'))} 
	<input type='submit' class='userClubRed'  value='Выйти из клуба'
	onclick="leaveClub({$club_id},'{$loc}','userClubError');">
 {/if}
 {if ($role=='Создатель клуба')}
	<input type='submit' class='userClubRed' value='Удалить клуб'
	onclick="deleteClub({$club_id},'{$loc}','userClubError');">
 {/if}
 
 </td>
</tr>
<tr>
<td></td><td class='error' id='userClubError'></td> 
</tr>
</table>
