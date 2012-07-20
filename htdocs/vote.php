<?
session_start();
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");

require_once("../includes/vote.class.php");
//$t=new vote(11);
//$t-> getVote(1);
?>
<html>
<head>
<link rel='stylesheet' href='../css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/topbar.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/form.css' type='text/css' media='screen' />  
<link rel='stylesheet' href='../css/comments.css' type='text/css' media='screen' />  
<link rel='stylesheet' href='../css/vote.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../css/window.css' type='text/css' media='screen' />  
<script type='text/javascript' src='../includes/jquery-1.3.2.min.js'></script>
<script type='text/javascript' src='../includes/window.js'></script>
<script type='text/javascript' src='../includes/ajax.js'></script>
</head>

<body>

<a href='#dialog' name='modal'>test</a>

<div id='main'>
<div id='content'>
<div id='boxes'>
<div id='dialog' class='window'>
adsfasdf

<div class='closed'></div>
</div>
<div id='mask'>
</div>

</div>
</div>
</div>
</body>
</html>

