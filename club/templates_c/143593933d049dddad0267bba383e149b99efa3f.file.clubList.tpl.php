<?php /* Smarty version Smarty-3.1.8, created on 2012-06-04 11:35:07
         compiled from "templates/clubList.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17420466994f743c839fef83-67819611%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '143593933d049dddad0267bba383e149b99efa3f' => 
    array (
      0 => 'templates/clubList.tpl',
      1 => 1333128420,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17420466994f743c839fef83-67819611',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f743c83cac9b0_84476538',
  'variables' => 
  array (
    'club_count_name' => 0,
    'club_content' => 0,
    'clubs_page_pattern' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f743c83cac9b0_84476538')) {function content_4f743c83cac9b0_84476538($_smarty_tpl) {?><script type="text/javascript">
function setClubContent(page,max_page) {
	getPage= function(Request) {
		document.getElementById('clubs_page_pattern').innerHTML=Request.responseText;
		}	
	var str='p_num='+page+'&max_page='+max_page+'&function=setClubContent&action=getPage';
	SendRequest('post','../includes/page.lib.php',str,getPage);
	setContent=function(Request) {
		document.getElementById('clubCentent').innerHTML=Request.responseText;
		}
	var str='p_num='+page+'&action=setClubContent';
	SendRequest('post','all_clubs.php',str,setContent);
	
	//alert('qq');
	}
</script>

<div class='form_settings'>
<TABLE align='center'>
 	<tr>
     <td>
     <table>
      <tr>
      <td> 
      <ul id="navigation" style='width:500px'>
	   <li class='selected'><a href='#'>Клубы</a> </li>
	  </ul>
      </td>
      <td width=130px><a href='index.php'>Мои клубы</a></td>
    </tr>
    <table>
    </td>
    </tr>
    <tr id='my_club'>
       
   <td id='tab_content'>
	<table >
	 <tr>
	  <td id='tab_header'><?php echo $_smarty_tpl->tpl_vars['club_count_name']->value;?>
</td>
	 </tr>
     <tr>
      <td id='clubCentent'> <?php echo $_smarty_tpl->tpl_vars['club_content']->value;?>
 </td>
     </tr>
	<tr>
	 <td align='center' id='clubs_page_pattern'><?php echo $_smarty_tpl->tpl_vars['clubs_page_pattern']->value;?>
</td>
	</tr>
	 </table>
   </td>
  </tr>
</table>
</div>
<?php }} ?>