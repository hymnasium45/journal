<?php /* Smarty version Smarty-3.1.8, created on 2012-05-25 12:49:02
         compiled from "templates/userClub.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14649118524f46584cd24956-37841544%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa2ef9c9486ee0b134a7c171cb8134bb1123a5cf' => 
    array (
      0 => 'templates/userClub.tpl',
      1 => 1337939338,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14649118524f46584cd24956-37841544',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f46584d10e834_58989595',
  'variables' => 
  array (
    'club_id' => 0,
    'avatar' => 0,
    'name' => 0,
    'creater_id' => 0,
    'creater' => 0,
    'type' => 0,
    'countMember' => 0,
    'role' => 0,
    'date' => 0,
    'loc' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f46584d10e834_58989595')) {function content_4f46584d10e834_58989595($_smarty_tpl) {?><table class='userClub'>
<tr>
 <td rowspan=7 valign='top' class='avatar'>
	<a href='club.php?club_id=<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['avatar']->value;?>
</a></td>
 <td id='tab_name'>Название:</td>
 <td class='name'><a href='club.php?club_id=<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a></td>
</tr>
<tr>
 <td id='tab_name'>Создатель:</td>
 <td class='name'><a href='../profile.php?id=<?php echo $_smarty_tpl->tpl_vars['creater_id']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['creater']->value;?>
</a>
</tr>
<tr>
 <td id='tab_name'>Тип клуба:</td>
 <td><?php echo $_smarty_tpl->tpl_vars['type']->value;?>
</td>
</tr>
<tr>
 <td id='tab_name'>Кол-во участников:</td>
 <td><?php echo $_smarty_tpl->tpl_vars['countMember']->value;?>
</td>
</tr>
<?php if (($_smarty_tpl->tpl_vars['role']->value!='Не состоит в клубе'&&$_smarty_tpl->tpl_vars['role']->value!='Получил приглашение'&&$_smarty_tpl->tpl_vars['role']->value!='Подал заявку')){?>
<tr>
 <td id='tab_name'>Вы вступили в клуб:</td>
 <td><?php echo $_smarty_tpl->tpl_vars['date']->value;?>
</td>
</tr>
<?php }?>
<tr>
 <td id='tab_name'>Роль в клубе:</td>
 <td><?php echo $_smarty_tpl->tpl_vars['role']->value;?>
</td>
</tr>
<tr>
 <td></td>
 <td>
 <?php if (($_smarty_tpl->tpl_vars['role']->value!='Создатель клуба'&&($_smarty_tpl->tpl_vars['role']->value=='Администратор клуба'||$_smarty_tpl->tpl_vars['role']->value=='Член клуба'))){?> 
	<input type='submit' class='userClubRed'  value='Выйти из клуба'
	onclick="leaveClub(<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
,'<?php echo $_smarty_tpl->tpl_vars['loc']->value;?>
','userClubError');">
 <?php }?>
 <?php if (($_smarty_tpl->tpl_vars['role']->value=='Создатель клуба')){?>
	<input type='submit' class='userClubRed' value='Удалить клуб'
	onclick="deleteClub(<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
,'<?php echo $_smarty_tpl->tpl_vars['loc']->value;?>
','userClubError');">
 <?php }?>
 
 </td>
</tr>
<tr>
<td></td><td class='error' id='userClubError'></td> 
</tr>
</table>
<?php }} ?>