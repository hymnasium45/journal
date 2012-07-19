<?php /* Smarty version Smarty-3.1.8, created on 2012-03-30 14:00:06
         compiled from "templates/editClub.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3413495454f6c747f2eba10-03460355%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5fe489cfb5deaf38391e65796da3731d4811de94' => 
    array (
      0 => 'templates/editClub.tpl',
      1 => 1333042894,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3413495454f6c747f2eba10-03460355',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f6c747f40e353_06253854',
  'variables' => 
  array (
    'name' => 0,
    'club_id' => 0,
    'info' => 0,
    'canView' => 0,
    'canWrite' => 0,
    'canEnter' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f6c747f40e353_06253854')) {function content_4f6c747f40e353_06253854($_smarty_tpl) {?><div class='form_settings'>
<TABLE align='center'>
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
	   <li class='selected'>  <a  href='#' onclick='info_show();'>Информация</a> </li>
	  </ul>
      </td>
      <td align='right'><a href='club.php?club_id=<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
'>Вернуться к клубу</td>
	</tr>
   </table> 
  </td>
  </tr> 
  <TR id='info'> 
   <td id='tab_content'  >
    <table>
     <tr>
     <td id='tab_name'>Удалить клуб:</td> 
     <td> <input type='submit' name='delete' class='simple' value="Удалить" 
			onclick="deleteClub(<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
,'index.php','delete_error');"</td>
     </tr>
     <tr>
     <td id='delete_error' class='error' align=right> </td>
     </tr>
     <tr>
	  <th id='tab_header' colspan=2 align=left> Информация о клубе: </th>
	 </tr>
	 <tr>
	  <TD id='tab_name' align='right' height=40px width=200px> Название: </TD> 
      <TD> <input type='text' class='text' style='width:500px' id='name' value='<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
'>  </TD>
     </tr>
     <tr>
      <td id='tab_name' align='right' > О нас:
       <TD> <textarea style="width:500px;font-size:12px; height:100px; " name='message'   
		id='club_info' onkeyup="adjustHeight('about'); "><?php echo $_smarty_tpl->tpl_vars['info']->value;?>
 </textarea> </TD>
     </tr>
    <tr>
     <td colspan=2 align='right' id='savetext' class='error'></td>
    </tr>
	<tr>
	  <td id='tab_header' colspan=2> Приватность клуба:</td>
	 </tr>
	 <tr>
	  <td>
	  </td>
	 </tr>
	 <tr>
	  <td id='tab_name' >  Могут просматривать контент клуба:</td>
	  <td> <select id='canView'>
		      <option value='1' <?php if (($_smarty_tpl->tpl_vars['canView']->value)){?> selected <?php }?>> Все </option>
		      <option value='0' <?php if ((!$_smarty_tpl->tpl_vars['canView']->value)){?> selected <?php }?>> Только участники</option>
		     </select>
	  </td>
	  </tr>
	  <tr>
	   <td id='tab_name' style='width:300px'> Могут пополнять контент клуба:</td>
	   <td> <select id='canWrite'>
		      <option value='1' <?php if (($_smarty_tpl->tpl_vars['canWrite']->value)){?> selected <?php }?>> Все </option>
		      <option value='0' <?php if ((!$_smarty_tpl->tpl_vars['canWrite']->value)){?> selected <?php }?>> Только участники</option>
		    </select>
	   </td>
	  </tr>
	  <tr>
	   <td id='tab_name'>Могут вступать в клуб: </td>
	   <td> <select id='canEnter'>
		      <option value='1' <?php if (($_smarty_tpl->tpl_vars['canEnter']->value)){?> selected <?php }?>> Все </option>
		      <option value='0' <?php if ((!$_smarty_tpl->tpl_vars['canEnter']->value)){?> selected <?php }?>> Только участники</option>
	          </select>
	  </td>
	 </tr>
	 <tr>
      <td colspan=2 height=40px align='right'>
      <input type='button' class='submit' name='save' value='Сохранить'
	   onclick="updateClub('save_error');">
	  </td>
     </tr>
     <tr>
      <td colspan=2 align='right' id='save_error' class='error'></td>
     </tr> 
	</table>
   </td>
  </tr>
 
</table>
</div>

</div>


<?php }} ?>