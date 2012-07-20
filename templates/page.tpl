<html>
<head>
<title>{if (isset($title))} {$title} {else} Сайт ХУВК № 45 {/if} </title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
{if (isset($headers))} {$headers} {/if}

</head>
<body>
<div id='logo'>
<table style='width:100%' >
 <tr>
  <td style='width:85%'>
	<h1>
	{if (isset($logo))} {$logo} {else} AG 45 {/if} </h1> 
  </td>
  <td>
   {if ($exit=='show')} <form method='POST'><input type='submit' name='exit' value='Выход'></form> {/if}
  </td>	
</tr>
</table>
</div>
<div id='main'>
 <div id='leftbar'>
 {$leftbar}
 </div>
 <div id='content'>
 {$content}
 </div>
</div>
</body>
</html>




