<div class='form_settings'>
 <table align='center' id='tab_content'>
 <tr>
  <td> <a href='club.php?club_id={$club_id}'><- Обратно</a></td>
 </tr>
 <tr> <td id='tab_header' colspan=2 > Поиск пользователей: </td> </tr>
 <tr>
 <td>
 <table>
 <tr> <td colspan=2 height='40px' > <input type='checkbox' class='checkbox' name='showClubMembers' id='showClubMembers'> 
	Не отображать пользоветелей, состоящих в клубе </td> </tr>
 <tr> 
   <td width=300px> Введите значение: <br> 
	<font style='font-size:small; color:gray; font-style:oblique;'>(Имя, эл. адрес)</font> </td> 
   <td> <input type='text' class='text' style='width:500px' id='argc' name='argc'> </td>
 </tr>
 <tr>
  <td> </td> <td id='error' height=20px class='error'> </td>
 </tr>
 <tr> <td colspan=2 align='right'> 
	<input type='button' class='submit' name='search' value='Поиск' 
	 onclick="searchUser(
	 '{$club_id}',
	 document.getElementById('argc').value,
	 'result'
	 );"></td></tr>
 </table>
 </td>
 </tr>
 <tr>
  <td colspan=2 id='tab_header'> Результаты поиска: </td> 
 </tr>
 <tr >
  <td colspan=2 id='result' ></td>
 </tr>
 </div>
 </div>
</div>

