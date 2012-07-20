<?php /* Smarty version Smarty-3.1.8, created on 2012-05-25 12:59:06
         compiled from "templates/message.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17671576624f625808397699-69808210%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d73f0f7bdc1c11c2c7323d4161059f8fe0cbdc4' => 
    array (
      0 => 'templates/message.tpl',
      1 => 1337939943,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17671576624f625808397699-69808210',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f625808491150_47093197',
  'variables' => 
  array (
    'id' => 0,
    'avatar' => 0,
    'date' => 0,
    'rate' => 0,
    'canRate' => 0,
    'sender_id' => 0,
    'sender' => 0,
    'online' => 0,
    'answers' => 0,
    'text' => 0,
    'canWrite' => 0,
    'canEdit' => 0,
    'club_id' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f625808491150_47093197')) {function content_4f625808491150_47093197($_smarty_tpl) {?>	<div id='div<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
' class='' 
	     onmouseover="
					document.getElementById('div<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
').className='comment_selected';
					if (document.getElementById('delete<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
'))
						document.getElementById('delete<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
').style.display='';
					if (document.getElementById('button<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
'))
						document.getElementById('button<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
').style.display='';
					
					"
				onmouseout="
					document.getElementById('div<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
').className='';
					if (getElementById('num<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
').style.display=='none') {
						if (document.getElementById('button<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
'))
							document.getElementById('button<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
').style.display='none';
						if (document.getElementById('delete<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
'))
							document.getElementById('delete<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
').style.display='none';
						
						}
					"
				>
        <TABLE id='tr<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
' class='comment'>
         <tr>
          <td colspan=2 class='error' id='rateError<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
' align=right> </td>
         </tr>
         <TR> 
          <TD valign='top' rowspan=4><?php echo $_smarty_tpl->tpl_vars['avatar']->value;?>
</TD>
		  <td> 
		   <table>
		    <tr>		   
             <TD class='date'><?php echo $_smarty_tpl->tpl_vars['date']->value;?>
</td>
             <td rowspan=2> 
			  <table>
			   <tr>
				<td style='color:<?php if (($_smarty_tpl->tpl_vars['rate']->value>0)){?>green<?php }elseif(($_smarty_tpl->tpl_vars['rate']->value<0)){?>red<?php }?>' id='rate<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
' class='rate' align=right rowspan=2>
				<?php if (($_smarty_tpl->tpl_vars['rate']->value>0)){?>+<?php }?>
				<?php echo $_smarty_tpl->tpl_vars['rate']->value;?>
</td>
								<td>
				<?php if (($_smarty_tpl->tpl_vars['canRate']->value)){?> <button type='button' id='up<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
' class='rate_up'
						onclick="rateMessage('up','<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
','rate<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
','rateError<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
');"><?php }?>
				</td>
			   </tr>
			   <tr>
				<td>
				
				<?php if (($_smarty_tpl->tpl_vars['canRate']->value)){?>  <button type='button' id='down<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
' class='rate_down'
						onclick= "rateMessage('down','<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
','rate<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
','rateError<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
');"><?php }?>
				</td>
			   </tr>
			  </table>
		     </td>
		    </tr>
		    <TR>
			  <TD class='sender_name' ><a href='../htdocs/profile.php?id=<?php echo $_smarty_tpl->tpl_vars['sender_id']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['sender']->value;?>
</a>
			  <?php if (($_smarty_tpl->tpl_vars['online']->value)){?> <img src='../images/online.gif' title='Онлайн'> <?php }?>
			</td>
			 </tr>
		  </table>
		 </td>
	    </tr>
							
       <TR><TD> <TABLE class='answer'>	
	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['i'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['answers']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = ((int)-1) == 0 ? 1 : (int)-1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max']);
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
			<tr> 
			 <td class='answer_name' style='padding-left:<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['i']['index']*5;?>
px'><?php echo $_smarty_tpl->tpl_vars['answers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]->sender_name;?>
</td>
			</tr>
			<tr> 
			 <td class='answer_text' style='padding-left:<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['i']['index']*5;?>
px'><?php echo $_smarty_tpl->tpl_vars['answers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]->text;?>
</td>
			</tr>
	<?php endfor; endif; ?> 
	</TABLE></TD></TR>
       <TR><TD class='sender_text' id='text<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
' width='500px' valign='top' style='padding-top:10px;
	<?php if (($_smarty_tpl->tpl_vars['rate']->value<0)){?>
		   color:gray;'
		   
		   onmouseover="
			document.getElementById('$text<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
').style.color='black';"
		   onmouseout="
			document.getElementById('$text<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
').style.color='gray';"
	<?php }else{ ?>'<?php }?>
	class='sender_text'><?php echo $_smarty_tpl->tpl_vars['text']->value;?>
</TD>
                </TR>

	<tr> <TD colspan=2 align='right' height=40px>
	 <?php if (($_smarty_tpl->tpl_vars['canWrite']->value)){?>
				<button type='button' class='mess_button'  id='button<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
' 
				title='Ответить'
				style='display:none'
				onclick="
				if (getElementById('num<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
').style.display=='none')
					getElementById('num<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
').style.display=''; 
				else    
		                        getElementById('num<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
').style.display='none'; 
				" 
				><img src='../images/Balloon.png' style='height:30px;'></button>
	 <?php }?>
		<?php if (($_smarty_tpl->tpl_vars['canEdit']->value)){?> 	
					
                              <button type='button' class='mess_button'
                                title='Удалить сообщение' id='delete<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
' name='delete'
                                onclick=" deleteMess('<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
','div<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
');"
                                style='display:none'>
                                <img src='../images/Button_delete.png' style='height:30px;'> </button>
        <?php }?>
        </TD> </tr>
	<?php if (($_smarty_tpl->tpl_vars['canWrite']->value)){?>
	 <TR>
	  <TD align='center' colspan=2 id='num<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
' style='display:none'> 
	    <table>   
		 <TR>
           <TD> 
		    <textarea style='width:600px; height:100px;' 
		     id='answer_text<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
'  placeholder='Напишите сообщение' 
		     onkeyup=\"adjustHeight('answer_text<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
');\"> </textarea> 		      
		   </TD>
          </TR>
          <TR>
           <TD align='right'> 
            <INPUT type='button' class='submit' id='send<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
' value='Отправить'
							onclick="sendMessage(
							'<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
',
							document.getElementById('answer_text<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
').value,
							'<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
','answer_error<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
','club.php?club_id=<?php echo $_smarty_tpl->tpl_vars['club_id']->value;?>
');"> 
		   </TD>
          </TR>
          <tr>
           <td id='answer_error<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
' class='error' align=right></td>
          </tr>
         </table>
		</TD>
	   </TR>
     <?php }?>
	</TABLE>
	



<?php }} ?>