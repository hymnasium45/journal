<?php /* Smarty version Smarty-3.1.8, created on 2012-05-16 15:03:39
         compiled from "templates/clubUser.tpl" */ ?>
<?php /*%%SmartyHeaderCode:470380784f6b7f113e2e74-43065231%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cfa518b32fb9a0e66a7b1fc16fc02787d198037a' => 
    array (
      0 => 'templates/clubUser.tpl',
      1 => 1333144260,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '470380784f6b7f113e2e74-43065231',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f6b7f11521330_14491074',
  'variables' => 
  array (
    'user_id' => 0,
    'avatar' => 0,
    'name' => 0,
    'date' => 0,
    'role' => 0,
    'rate' => 0,
    'canEdit' => 0,
    'isCreater' => 0,
    'viewer_id' => 0,
    'canWrite' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f6b7f11521330_14491074')) {function content_4f6b7f11521330_14491074($_smarty_tpl) {?><table class='userClub' id='div<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
'>
	<tr>
	 <td rowspan=3 valign=top><a href='../htdocs/profile.php?id=<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['avatar']->value;?>
</a> </td>
	 <td id='tab_name'> Имя:
      </td>
	 <td class='name'> <a href='../htdocs/profile.php?id=<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a> </td>
	</tr>
	<tr> 
	 <td id='tab_name'>Вступил в клуб: </td>
	 <td> <?php echo $_smarty_tpl->tpl_vars['date']->value;?>
 </td>
	</tr>
	<tr>
	 <td id='tab_name'>Роль в клубе:</td>
     <td><?php echo $_smarty_tpl->tpl_vars['role']->value;?>
</td>
	</tr>
	<tr>
	 <td> <?php echo $_smarty_tpl->tpl_vars['rate']->value;?>
 </td>
	</tr>
	<tr>
	 <td colspan=3 align=right style='padding-right:200px'> 
	 	<button type='button' class='user_club_button'
	    title='Сделать администратором' id='make<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
' 
	    <?php if (($_smarty_tpl->tpl_vars['canEdit']->value||$_smarty_tpl->tpl_vars['isCreater']->value||$_smarty_tpl->tpl_vars['user_id']->value==$_smarty_tpl->tpl_vars['viewer_id']->value)){?> style="display:none" <?php }?>
		onclick=" makeAdmin('makeAdmin','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
','action_error<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');"
		> <img src='images/makeAdmin.png' style='height:30px;'></button>
	 
	 	<button type='button' class='user_club_button'
	    title='Удалить из администраторов' id='unmake<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
' 
        <?php if ((!$_smarty_tpl->tpl_vars['canEdit']->value||$_smarty_tpl->tpl_vars['isCreater']->value||$_smarty_tpl->tpl_vars['user_id']->value==$_smarty_tpl->tpl_vars['viewer_id']->value)){?> style="display:none" <?php }?>
        onclick=" makeAdmin('unmakeAdmin','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
','action_error<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');"
		> <img src='images/unmakeAdmin.png' style='height:30px;'></button>
	 
        <button type='button' class='user_club_button'
	    title='Заблокировать' id='mute<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
' 
        <?php if (($_smarty_tpl->tpl_vars['isCreater']->value||!$_smarty_tpl->tpl_vars['canWrite']->value||$_smarty_tpl->tpl_vars['user_id']->value==$_smarty_tpl->tpl_vars['viewer_id']->value)){?> style='display:none' <?php }?>
		onclick=" muteUser('muteUser','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
','action_error<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');"
		> <img src='images/mute.png' style='height:30px;'></button>      
      
     	<button type='button' class='user_club_button'
	    title='Разблокировать' id='unmute<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
' 
        <?php if (($_smarty_tpl->tpl_vars['canWrite']->value||$_smarty_tpl->tpl_vars['isCreater']->value||$_smarty_tpl->tpl_vars['user_id']->value==$_smarty_tpl->tpl_vars['viewer_id']->value)){?> style='display:none' <?php }?>
        onclick=" muteUser('unmuteUser','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
','action_error<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');"
		> <img id='admin_image<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
'src='images/unmute.png' style='height:30px;'></button>
	
      
      <?php if ((!$_smarty_tpl->tpl_vars['isCreater']->value&&$_smarty_tpl->tpl_vars['user_id']->value!=$_smarty_tpl->tpl_vars['viewer_id']->value)){?>
     	<button type='button' class='user_club_button'
	    title='Удалить' id='delete<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
' 
        onclick=" deleteUser('<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
','div<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
','action_error<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');"
		> <img src='images/delete.png' style='height:30px;'></button>
	  <?php }?>
      </td>
	</tr>
	<tr> 
	 <td colspan=3 align=right style='padding-right:200px' class='error' id='action_error<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
'></td>
	</tr>
</table>
<?php }} ?>