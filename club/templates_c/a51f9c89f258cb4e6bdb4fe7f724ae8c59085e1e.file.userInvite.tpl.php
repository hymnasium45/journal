<?php /* Smarty version Smarty-3.1.8, created on 2012-03-30 20:41:01
         compiled from "templates/userInvite.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12141596564f58d242a8b871-94826944%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a51f9c89f258cb4e6bdb4fe7f724ae8c59085e1e' => 
    array (
      0 => 'templates/userInvite.tpl',
      1 => 1333115990,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12141596564f58d242a8b871-94826944',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f58d242daaa44_88341650',
  'variables' => 
  array (
    'avatar' => 0,
    'club_id' => 0,
    'name' => 0,
    'creater_id' => 0,
    'creater_name' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f58d242daaa44_88341650')) {function content_4f58d242daaa44_88341650($_smarty_tpl) {?><table class='userClub'>
 <tr>
  <td rowspan=4 valign='top' width=80px;><?php echo $_smarty_tpl->tpl_vars['avatar']->value;?>
</td>
  <td id='tab_name'>Название:</td>
  <td class='name'><a href='club.php?club_id=<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a></td>
 </tr>
 <tr>
  <td id='tab_name'>Создатель клуба:</td>
  <td class='name'><a href='../htdocs/profile.php?id=<?php echo $_smarty_tpl->tpl_vars['creater_id']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['creater_name']->value;?>
</a></td>
 </tr>
 <tr>
  <td align='right'> <input type='submit' class='userClubGreen' 
		onclick="acceptInvite(<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
,'index.php?page=invites','invite_error<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
');" value='Принять' ></td>
  <td style='padding-left:40px'> <input type='submit' class='userClubRed'  value='Отклонить'
		onclick="declineInvite(<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
,'index.php?page=invites','invite_error<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
');"></td>    
 </tr>
 <tr>
 <td></td><td class='error' id='invite_error<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
'></td>
 </tr>
</table>
<?php }} ?>