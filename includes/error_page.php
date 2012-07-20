<?

function makeError($text) {
	echo"
<HTML>
<HEAD>
<title>Журнал</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
</HEAD>
<BODY>
<div id='logo'>";
 require_once("logo.php");
echo "
</div>
<div id='main'>
 <div id='leftbar'>";
  require_once "menu.php";
  echo "
 </div>
 <div id='content'>".$text."
  </div>
 </div>

</BODY>
</HTML>";
}



