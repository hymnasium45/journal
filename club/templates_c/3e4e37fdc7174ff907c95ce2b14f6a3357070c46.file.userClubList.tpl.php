<?php /* Smarty version Smarty-3.1.8, created on 2012-05-15 14:35:48
         compiled from "templates/userClubList.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5736527294f466cac219807-86799507%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3e4e37fdc7174ff907c95ce2b14f6a3357070c46' => 
    array (
      0 => 'templates/userClubList.tpl',
      1 => 1333057260,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5736527294f466cac219807-86799507',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f466cac3301b1_53108552',
  'variables' => 
  array (
    'page' => 0,
    'invite_count' => 0,
    'club_count_name' => 0,
    'club_content' => 0,
    'clubs_page_pattern' => 0,
    'invite_count_name' => 0,
    'invite_content' => 0,
    'invites_page_pattern' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f466cac3301b1_53108552')) {function content_4f466cac3301b1_53108552($_smarty_tpl) {?><div class='form_settings'>

		    <div id='boxes'>
			 <div id='dialog' class='window' style='width:500px; height:250px;'>
			  <div id='head'> Создание клуба </div>
			  <div id='w_content'>
			   <table >
			    <tr>
			     <td ><h1>Название:</h1></td>
			    </tr>
			    <tr>
			     <td><input maxlength=50 style='width:450px'type='text' class='text' id='name' placeholder='Введите значение'></td>
			    </tr>
               </table>
              </div>
			  <div id='footer'>
			   <table height=100%<?php ?>>
				<tr>
				 <td  width=340px align='right'><input type='button' id='create' class='w_button' value='Создать клуб'
						onclick="
						var name=getElementById('name').value;
						createClub(name,'index.php','createError');"></td>
				 <td width=110px align='right'><input type='button' class='w_button' value='Отменить'
					onclick="location.href='';"></td>
				</tr>
				<tr>
				 <td colspan=2 align=right class='error' id='createError'> </td>
				</tr>
			   </table>
			  </div>
			  <div class='closed'></div>
             </div>
             <div id='mask'></div>
		    </div>

<TABLE align='center'>
 	<tr>
     <td>
     <table>
      <tr>
      <td> 
      <ul id="navigation" style='width:500px'>
	   <li <?php if ($_smarty_tpl->tpl_vars['page']->value=='clubs'){?> class='selected' 
		<?php }else{ ?>  class='none' <?php }?>> <a  href='' onclick='showClub();'>Мои клубы</a> </li>
	   <li <?php if ($_smarty_tpl->tpl_vars['page']->value=='invites'){?> class='selected' 
                <?php }else{ ?>  class='none' <?php }?> > 
                <a  onclick='showInvite();' href=''>Мои Приглашения
                <?php if (($_smarty_tpl->tpl_vars['invite_count']->value>0)){?> (<?php echo $_smarty_tpl->tpl_vars['invite_count']->value;?>
) <?php }?>
                </a> </li>
	  </ul>
      </td>
      <td width=130px><a href='all_clubs.php'>Все клубы</a></td>
      <td width=170px><a href='#dialog' name='modal' >Создать клуб </a></td>
	</tr>
    <table>
    </td>
    </tr>
    <tr id='my_club' <?php if ($_smarty_tpl->tpl_vars['page']->value=='invites'){?>  style='display:none' <?php }?>>
       
   <td id='tab_content'>
	<table >
	 <tr>
	  <td id='tab_header'><?php echo $_smarty_tpl->tpl_vars['club_count_name']->value;?>
</td>
	 </tr>
     <tr>
      <td id='userClubCentent'> <?php echo $_smarty_tpl->tpl_vars['club_content']->value;?>
 </td>
     </tr>
	<tr>
	 <td align='center' id='clubs_page_pattern'><?php echo $_smarty_tpl->tpl_vars['clubs_page_pattern']->value;?>
</td>
	</tr>
	 </table>
   </td>
  </tr>
  <tr id='my_invite' <?php if ($_smarty_tpl->tpl_vars['page']->value=='clubs'){?>  style='display:none' <?php }?>>
   <td id='tab_content'>
	<table>
	<tr>
	 <td id='tab_header'> <?php echo $_smarty_tpl->tpl_vars['invite_count_name']->value;?>
</td>
	</tr>
	<tr>
	 <td id='userInviteContent'> <?php echo $_smarty_tpl->tpl_vars['invite_content']->value;?>
 </td>
	</tr>
	<tr>
	 <td align='center' id='invites_page_pattern'><?php echo $_smarty_tpl->tpl_vars['invites_page_pattern']->value;?>
</td>
	</tr>
	
	</table>
   </td>
  </tr>
   
</TABLE>
<?php }} ?>