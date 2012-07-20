<?php /* Smarty version Smarty-3.1.8, created on 2012-05-15 14:35:49
         compiled from "../templates/page.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13461661904f4793e0b57f92-44359442%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '89f7de08a16ef9055d4633258590fc2892297afd' => 
    array (
      0 => '../templates/page.tpl',
      1 => 1333057260,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13461661904f4793e0b57f92-44359442',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f4793e0d0ad39_18684121',
  'variables' => 
  array (
    'title' => 0,
    'headers' => 0,
    'logo' => 0,
    'exit' => 0,
    'leftbar' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f4793e0d0ad39_18684121')) {function content_4f4793e0d0ad39_18684121($_smarty_tpl) {?><html>
<head>
<title><?php if ((isset($_smarty_tpl->tpl_vars['title']->value))){?> <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
 <?php }else{ ?> Сайт ХУВК № 45 <?php }?> </title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
<?php if ((isset($_smarty_tpl->tpl_vars['headers']->value))){?> <?php echo $_smarty_tpl->tpl_vars['headers']->value;?>
 <?php }?>

</head>
<body>
<div id='logo'>
<table style='width:100%' >
 <tr>
  <td style='width:85%'>
	<h1>
	<?php if ((isset($_smarty_tpl->tpl_vars['logo']->value))){?> <?php echo $_smarty_tpl->tpl_vars['logo']->value;?>
 <?php }else{ ?> AG 45 <?php }?> </h1> 
  </td>
  <td>
   <?php if (($_smarty_tpl->tpl_vars['exit']->value=='show')){?> <form method='POST'><input type='submit' name='exit' value='Выход'></form> <?php }?>
  </td>	
</tr>
</table>
</div>
<div id='main'>
 <div id='leftbar'>
 <?php echo $_smarty_tpl->tpl_vars['leftbar']->value;?>

 </div>
 <div id='content'>
 <?php echo $_smarty_tpl->tpl_vars['content']->value;?>

 </div>
</div>
</body>
</html>




<?php }} ?>