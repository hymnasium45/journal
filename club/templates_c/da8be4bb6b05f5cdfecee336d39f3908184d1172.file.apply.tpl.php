<?php /* Smarty version Smarty-3.1.8, created on 2012-03-30 20:39:11
         compiled from "templates/apply.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3210106164f6c55f5be8f98-92144752%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'da8be4bb6b05f5cdfecee336d39f3908184d1172' => 
    array (
      0 => 'templates/apply.tpl',
      1 => 1333128835,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3210106164f6c55f5be8f98-92144752',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f6c55f5d41cb6_87335355',
  'variables' => 
  array (
    'user_id' => 0,
    'avatar' => 0,
    'name' => 0,
    'club_id' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f6c55f5d41cb6_87335355')) {function content_4f6c55f5d41cb6_87335355($_smarty_tpl) {?><table class='userClub' id='div<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
'>
 <tr> 
  <td rowspan=2> <?php echo $_smarty_tpl->tpl_vars['avatar']->value;?>
 </td>
  <td id='tab_name'>Имя: </td> 
  <td id='name'><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
 </td>  
 </tr>
 <tr> 
   <td align='right'> <input type='submit' class='userClubGreen' 
		onclick="acceptApply(<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
,'div<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
','apply_error<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" value='Принять' ></td>
  <td style='padding-left:40px'> <input type='submit' class='userClubRed'  value='Отклонить'
		onclick="deleteApply(<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
,<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
,'div<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
','apply_error<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');"></td>    
 
 </tr>
 <tr>
  <td colspan=3 class='error' align=right style='padding-right:200px'> </td>
 </tr>
</table>
<?php }} ?>