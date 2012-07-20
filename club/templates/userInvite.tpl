<table class='userClub'>
 <tr>
  <td rowspan=4 valign='top' width=80px;>{$avatar}</td>
  <td id='tab_name'>Название:</td>
  <td class='name'><a href='club.php?club_id={$club_id}'>{$name}</a></td>
 </tr>
 <tr>
  <td id='tab_name'>Создатель клуба:</td>
  <td class='name'><a href='../htdocs/profile.php?id={$creater_id}'>{$creater_name}</a></td>
 </tr>
 <tr>
  <td align='right'> <input type='submit' class='userClubGreen' 
		onclick="acceptInvite({$club_id},'index.php?page=invites','invite_error{$club_id}');" value='Принять' ></td>
  <td style='padding-left:40px'> <input type='submit' class='userClubRed'  value='Отклонить'
		onclick="declineInvite({$club_id},'index.php?page=invites','invite_error{$club_id}');"></td>    
 </tr>
 <tr>
 <td></td><td class='error' id='invite_error{$club_id}'></td>
 </tr>
</table>
