<?php /* Smarty version Smarty-3.1.8, created on 2012-05-16 15:03:39
         compiled from "templates/clubUsers.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10393069054f6b80b7b35955-22566999%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cac1a5fed52babb042a751c7520a5cd8f8b96564' => 
    array (
      0 => 'templates/clubUsers.tpl',
      1 => 1333057260,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10393069054f6b80b7b35955-22566999',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f6b80b7c4ac75_41646358',
  'variables' => 
  array (
    'name' => 0,
    'club_id' => 0,
    'count_users' => 0,
    'users' => 0,
    'count_apply' => 0,
    'applies' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f6b80b7c4ac75_41646358')) {function content_4f6b80b7c4ac75_41646358($_smarty_tpl) {?><TABLE align='center'>
 <TR>
  <TH align='left' valign='bottom' colspan=2><H6><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</H6></TH>
 </TR>
 <tr>
  <td>
   <table>
	<tr>
     <td> 
      <ul id="navigation" style='width:700px'>
	   <li class='selected'><a  href='#' onclick='member_show();'>участники</a> </li>
	   <li class='none'> <a href='#' onclick='apply_show();'>заявки</a>
      </ul>
      </td>
      <td align='right'><a href='club.php?club_id=<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
'>Вернуться к клубу</td>
	</tr>
   </table> 
  </td>
  </tr> 
  <TR id='member'> 
   <td id='tab_content'  >
	<table>
	 <TD id='tab_header'>
	  Участники
	  (<?php echo $_smarty_tpl->tpl_vars['count_users']->value;?>
)
	 </TD>
    </TR>
    <TR>
     <td>
	 <?php echo $_smarty_tpl->tpl_vars['users']->value;?>

	 </td>
    </tr>
   </table>
   
   </td>
  </tr>
   <TR id='apply' style='display:none'> 
   <td id='tab_content'  >
	<table>
	 <TD id='tab_header'>
	  Заявки
	  (<?php echo $_smarty_tpl->tpl_vars['count_apply']->value;?>
)
	 </TD>
    </TR>
    <TR>
     <td>
     <?php echo $_smarty_tpl->tpl_vars['applies']->value;?>

	 </td>
    </tr>
   </table>
   
   </td>
  </tr>

</table>

<?php }} ?>