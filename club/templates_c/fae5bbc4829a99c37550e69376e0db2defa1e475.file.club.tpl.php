<?php /* Smarty version Smarty-3.1.8, created on 2012-05-25 12:56:19
         compiled from "templates/club.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19060468824f5fb7c4774c20-72250849%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fae5bbc4829a99c37550e69376e0db2defa1e475' => 
    array (
      0 => 'templates/club.tpl',
      1 => 1337939777,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19060468824f5fb7c4774c20-72250849',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f5fb7c4a78d50_71016064',
  'variables' => 
  array (
    'name' => 0,
    'avatar' => 0,
    'menu' => 0,
    'info' => 0,
    'count_member' => 0,
    'members' => 0,
    'count' => 0,
    'message_count' => 0,
    'canWrite' => 0,
    'club_id' => 0,
    'page' => 0,
    'chat_content' => 0,
    'chat_page_pattern' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f5fb7c4a78d50_71016064')) {function content_4f5fb7c4a78d50_71016064($_smarty_tpl) {?> <div class='form_settings'>

<FORM method='POST' enctype='multipart/form-data' class='form_settings'>
 		<div id='boxes'>
			 <div id='dialog' class='window' style='width:500px; height:250px;'>
			  <table style='padding:30px'>
			  <tr>
			   <th colspan=2>Загрузка фотографии</th>
			  </tr>
			  <tr>
			   <td height=50px>Выберите файл:
			    <input style='padding-top:30px;' name='userfile' type='file'/>
			   </td>
			  </tr>
			  <tr>
			  <th height=60px valign='bottom'>
		      <input type='submit' name='upload' class='submit' value='Загрузить'>
              <input type='hidden' name='MAX_FILE_SIZE' value='30M' />
              </th>
              </tr>
              </table>
			  <div class='closed'></div>
             </div>
			 <div id='mask'></div>
			</div>
</form>    
 <TABLE align='center'>
 
  <TR>
   <TH align='left' valign='bottom' colspan=2><H6><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</H6></TH>
  </TR>
  <tr>
   <TD width='200px' valign='top' style='padding-top:50px;'>
    <TABLE>
     <TR valign='top'>
      <TD  height='300px' width='200px' ><?php echo $_smarty_tpl->tpl_vars['avatar']->value;?>
</TD>
     </TR>
     <tr>
      <td><?php echo $_smarty_tpl->tpl_vars['menu']->value;?>
</td>
    </tr>
   </TABLE>
  </TD>
  <TD valign='top' width=650px>
   <TABLE>
    <tr>
     <td>    	  
       <ul id="navigation" style='width:650px'>
	    <li class='none'>  <a  href='#' onclick="showInfo();">О нас</a> </li>
	    <li class='selected'> <a href='#' onclick='showChat();'>Чат</a> </li> 
       </ul>
      </td>
     </tr>  
	<TR style='display:none;' id='club_info'>
     <td id='tab_content'>
      <table >
	   <tr>
	    <TD id='tab_header'> О нас: </TD>
       </TR>
       <TR>
        <TD height='50px' valign='top'><?php echo $_smarty_tpl->tpl_vars['info']->value;?>
</TD>
       </tr>
       <TR>
        <TD id='tab_header'><?php echo $_smarty_tpl->tpl_vars['count_member']->value;?>
</TD>
       </TR>
       <TR>
        <TD> 
         <TABLE >
     <?php $_smarty_tpl->tpl_vars["count"] = new Smarty_variable(-1, null, 0);?>
     <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['i'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['members']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total']);
?>
	 <?php $_smarty_tpl->tpl_vars['count'] = new Smarty_variable($_smarty_tpl->tpl_vars['count']->value+1, null, 0);?>
	 <?php if (($_smarty_tpl->tpl_vars['count']->value%6==0)){?> <tr> <?php }?>
     
      <td>
		<table>
			<tr>
			 <td align='center' class='post_image' valign='top'><a href='../htdocs/profile.php?id=<?php echo $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]->id;?>
'><?php echo $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]->icon;?>
</a></td>
			</tr>
			<tr>
	  		 <td width=100px align='center'><a href='../htdocs/profile.php?id=<?php echo $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]->id;?>
'><?php echo $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]->name;?>
</a></td>
			</tr>
		</table>
 		 </td>
 	
     <?php if (($_smarty_tpl->tpl_vars['count']->value%6==5)){?> </tr><?php }?>
     <?php endfor; endif; ?>
       </TABLE>
      </TD>
     </TR>
    
     </table>
     </td>
   </TR>
   <TR id='club_chat'>
    <td id='tab_content'>
	 <table>
	  <tr> 
       <TD id='tab_header'> Чат(<?php echo $_smarty_tpl->tpl_vars['message_count']->value;?>
)</TD>
      </TR>
      <?php if (($_smarty_tpl->tpl_vars['canWrite']->value)){?>
      <TR> 
      <TD align='center'> 
       <textarea style="width:650px;  height:100px;" class='textarea' name='message' placeholder='Напишите сообщение' 
		id='textarea' 
		onkeyup= "adjustHeight('textarea');"> </textarea>  
	  </TD>
    </TR>
    <TR>
     <TD align='right' style='padding-right:15px'> <INPUT type='submit' class='submit' id='send_message' value='Отправить'
     onclick="sendMessage(<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
,document.getElementById('textarea').value,0,'send_error',
				'club.php?club_id=<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
&page=<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
');"> </TD>
    </TR>
    <tr> <td align='right' id='send_error' class='error'> </td> </tr>
    <?php }else{ ?> 
    <tr> 
	 <td class='error' align='center' style='height:30px'> Вы не можете писать сообщения </td>
	</tr> 
	<?php }?>
	 
    <TR>
     <td id='clubChatContent'><?php echo $_smarty_tpl->tpl_vars['chat_content']->value;?>
</TD>
    </TR>
    <tr>
     <td align='center' id='chatPagePattern'><?php echo $_smarty_tpl->tpl_vars['chat_page_pattern']->value;?>
</td>
    </tr>
   </TABLE>
  </td>
 </tr>
 </table>
   
 
  </TD>
 </TR>
</TABLE>
</div>
    
<?php }} ?>