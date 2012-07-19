<?php /* Smarty version Smarty-3.1.8, created on 2012-05-16 15:03:25
         compiled from "templates/clubMenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4811247894f5f286b6ae4c3-58374018%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd737ac6b0381edf58110cfdaffa5a816662573cc' => 
    array (
      0 => 'templates/clubMenu.tpl',
      1 => 1333144260,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4811247894f5f286b6ae4c3-58374018',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f5f286b7e4203_91291205',
  'variables' => 
  array (
    'role' => 0,
    'hasInvite' => 0,
    'hasApply' => 0,
    'club_id' => 0,
    'canEnter' => 0,
    'user_id' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f5f286b7e4203_91291205')) {function content_4f5f286b7e4203_91291205($_smarty_tpl) {?><table class='ClubMenu'> 
 <tr> 
  <th> 
  <?php if (($_smarty_tpl->tpl_vars['role']->value=='creater')){?>Вы являетесь создателем клуба <?php }?>
  <?php if (($_smarty_tpl->tpl_vars['role']->value=='admin')){?> Вы являетесь администратором клуба <?php }?>
  <?php if (($_smarty_tpl->tpl_vars['role']->value=='member')){?>Вы являетесь членом клуба <?php }?> 
  <?php if (($_smarty_tpl->tpl_vars['role']->value=='none'&&$_smarty_tpl->tpl_vars['hasInvite']->value)){?> Вы получили приглашение в клуб <?php }?>
  <?php if (($_smarty_tpl->tpl_vars['role']->value=='none'&&$_smarty_tpl->tpl_vars['hasApply']->value)){?> Вы подали заявку на вступоение в клуб <?php }?>
  <?php if (($_smarty_tpl->tpl_vars['role']->value=='none'&&!$_smarty_tpl->tpl_vars['hasInvite']->value&&!$_smarty_tpl->tpl_vars['hasApply']->value)){?> Вы не являетесь членом клуба <?php }?>
  </th>
 </tr>
 <tr>
  <td>
   <ul>
   <?php if (($_smarty_tpl->tpl_vars['role']->value=='creater')){?>
   <li><a href='club_edit.php'>Редактировать</a></li> 
   <?php }?>
   <?php if (($_smarty_tpl->tpl_vars['role']->value=='creater'||$_smarty_tpl->tpl_vars['role']->value=='admin')){?> 
	 <li><a href='club_members.php'>Участники</a></li>
    <li><a href='club_invite.php'>Пригласить</a></li>
    <li><a href='#dialog' name='modal' >Обновить фото</a></li>
   <?php }?>
   <?php if (($_smarty_tpl->tpl_vars['role']->value=='member'||$_smarty_tpl->tpl_vars['role']->value=='admin')){?>  
    <li onclick="leaveClub(<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
,'club.php?club_id=<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
','menu_error');"><a href='#'>Выйти</a></li>
   <?php }?>
   <?php if (($_smarty_tpl->tpl_vars['canEnter']->value)){?> 
    <li onclick="
		addUser(<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
,<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
,'menu_error',location.href='club.php?club_id=<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
');"><a href='#'>Войти</a></li> 
   <?php }?>
   <?php if ((!$_smarty_tpl->tpl_vars['canEnter']->value&&$_smarty_tpl->tpl_vars['role']->value=="none"&&!$_smarty_tpl->tpl_vars['hasApply']->value)){?>
   <li onclick="
		addApply(<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
,<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
,'club.php?club_id=<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
','menu_error');"><a href='#'>Подать заявку</a></li>
   <?php }?>
   
   <?php if (($_smarty_tpl->tpl_vars['role']->value=="none"&&$_smarty_tpl->tpl_vars['hasApply']->value)){?>
   <li onclick="
		cancelApply(<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
,<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
,'club.php?club_id=<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
','menu_error');"><a href='#'>Удалить заявку</a></li>
   <?php }?>
   
   </ul>
   
 </tr>
 <tr>
 <td class='error' id='menu_error'> </td>
 </tr>
</table>
<?php }} ?>