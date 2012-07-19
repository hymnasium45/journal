<table class='userClub' id='div{$user_id}'>
 <tr> 
  <td rowspan=2> {$avatar} </td>
  <td id='tab_name'>Имя: </td> 
  <td id='name'>{$name} </td>  
 </tr>
 <tr> 
   <td align='right'> <input type='submit' class='userClubGreen' 
		onclick="acceptApply({$user_id},'div{$user_id}','apply_error{$user_id}');" value='Принять' ></td>
  <td style='padding-left:40px'> <input type='submit' class='userClubRed'  value='Отклонить'
		onclick="deleteApply({$club_id},{$user_id},'div{$user_id}','apply_error{$user_id}');"></td>    
 
 </tr>
 <tr>
  <td colspan=3 class='error' align=right style='padding-right:200px'> </td>
 </tr>
</table>
