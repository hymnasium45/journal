<?php /* Smarty version Smarty-3.1.8, created on 2012-03-30 13:55:40
         compiled from "templates/clubInvite.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15409644074f7223279ed074-64490740%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1d07691e8fdd21f385df61bf19f14e28defc9a64' => 
    array (
      0 => 'templates/clubInvite.tpl',
      1 => 1333042894,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15409644074f7223279ed074-64490740',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f722327ad4d50_77269838',
  'variables' => 
  array (
    'club_id' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f722327ad4d50_77269838')) {function content_4f722327ad4d50_77269838($_smarty_tpl) {?><div class='form_settings'>
 <table align='center' id='tab_content'>
 <tr>
  <td> <a href='club.php?club_id=<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
'><- Обратно</a></td>
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
	 '<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
',
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

<?php }} ?>