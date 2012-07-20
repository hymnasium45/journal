<?php /* Smarty version Smarty-3.1.8, created on 2012-03-30 19:14:02
         compiled from "templates/searchUser.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10764643604f6dbec1b7b053-95490183%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f8976ad7ec2b4b0e32d2cce47d0a081d6d8284d' => 
    array (
      0 => 'templates/searchUser.tpl',
      1 => 1333115990,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10764643604f6dbec1b7b053-95490183',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f6dbec1d52263_25813895',
  'variables' => 
  array (
    'avatar' => 0,
    'user_id' => 0,
    'name' => 0,
    'role' => 0,
    'inClub' => 0,
    'hasInvite' => 0,
    'club_id' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f6dbec1d52263_25813895')) {function content_4f6dbec1d52263_25813895($_smarty_tpl) {?><table class='userClub'>
 <tr> 
  <td valign='top' rowspan=3><?php echo $_smarty_tpl->tpl_vars['avatar']->value;?>
</td>
  <td id='tab_name'>Имя:</td>
  <td class='name'><a href='../htdocs/profile.php?id=<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a></td>	
 </tr>
 <tr>
 <td id='tab_name'>Роль в клубе:</td>
 <td><?php echo $_smarty_tpl->tpl_vars['role']->value;?>
</td>
 </tr>
 <tr>
  <td>
  </td>
  <td>
  <?php if ((!$_smarty_tpl->tpl_vars['inClub']->value&&!$_smarty_tpl->tpl_vars['hasInvite']->value)){?>
  <input type='button' class='userClubGreen' value='Отослать приглашение'
  onclick="sendInvite('<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
','invite_error<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');">
  <?php }elseif(($_smarty_tpl->tpl_vars['inClub']->value)){?>
  Пользователь состоит в клубе
  <?php }elseif(($_smarty_tpl->tpl_vars['hasInvite']->value)){?>
  <input type='button' class='userClubRed' value='Удалить приглашение'
  onclick="deleteInvite('<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
','invite_error<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');">
  
  <?php }?>
  </td>
 <tr>
 <tr> 
  <td colspan=3 align=right class='error' style='padding-right:200px' id='invite_error<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
'></td>
 </tr>
</table>

	
<?php }} ?>