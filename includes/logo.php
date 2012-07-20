<?
if (isset($_POST['exit'])) {
	session_destroy();
	echo("<script>location.href='../../index.php'</script>");	}

$p=$_SERVER['REQUEST_URI'];
$index=preg_match("|/index.php|",$p);
$index1=preg_match("|^/$|",$p);
$index3=preg_match("|^/?|",$p);
$registr=preg_match("|^/journal/htdocs/registration.php|",$p);
$pass=preg_match("|^/journal/htdocs/forgot_pass.php|",$p);
$error=preg_match("|^/journal/htdocs/error.php|",$p);


?>

<table style='width:100%' >
	<tr>
		<td style='width:85%'><h1>Journal</h1> </td>
		<td ><form  method='post'>
<?if (!$index && !$index1  && !$error && !$pass && !$registr)
echo"
<input type='submit' name='exit' value='Выход'>";?> 
 </form>
</td>	
</tr>
</table>
</div>
