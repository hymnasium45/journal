<table class='ClubMenu'> 
 <tr> 
  <th> 
  {if ($role=='creater') }Вы являетесь создателем клуба {/if}
  {if ($role=='admin') } Вы являетесь администратором клуба {/if}
  {if ($role=='member') }Вы являетесь членом клуба {/if} 
  {if ($role=='none' && $hasInvite) } Вы получили приглашение в клуб {/if}
  {if ($role=='none' && $hasApply) } Вы подали заявку на вступоение в клуб {/if}
  {if ($role=='none' && !$hasInvite && !$hasApply )} Вы не являетесь членом клуба {/if}
  </th>
 </tr>
 <tr>
  <td>
   <ul>
   {if ($role=='creater')}
   <li><a href='club_edit.php'>Редактировать</a></li> 
   {/if}
   {if ($role=='creater' || $role=='admin') } 
	 <li><a href='club_members.php'>Участники</a></li>
    <li><a href='club_invite.php'>Пригласить</a></li>
    <li><a href='#dialog' name='modal' >Обновить фото</a></li>
   {/if}
   {if ($role=='member' || $role=='admin') }  
    <li onclick="leaveClub({$club_id},'club.php?club_id={$club_id}','menu_error');"><a href='#'>Выйти</a></li>
   {/if}
   {if ($canEnter)} 
    <li onclick="
		addUser({$club_id},{$user_id},'menu_error',location.href='club.php?club_id={$club_id}');"><a href='#'>Войти</a></li> 
   {/if}
   {if (!$canEnter && $role=="none" && !$hasApply)}
   <li onclick="
		addApply({$club_id},{$user_id},'club.php?club_id={$club_id}','menu_error');"><a href='#'>Подать заявку</a></li>
   {/if}
   
   {if ($role=="none" && $hasApply)}
   <li onclick="
		cancelApply({$club_id},{$user_id},'club.php?club_id={$club_id}','menu_error');"><a href='#'>Удалить заявку</a></li>
   {/if}
   
   </ul>
   
 </tr>
 <tr>
 <td class='error' id='menu_error'> </td>
 </tr>
</table>
