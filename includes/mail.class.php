<?php
class mail {
	private $title;
	private $text;
	private $receiver;
	private $error=true;
	private $headers; 	

function __construct($receiver,$title,$text) {
	require_once("defence.lib.php");
	$this-> receiver=$receiver;
	$this-> title=makeText($title);
	$this-> text=$text;
	$this-> headers="From: \"Hymnasium 45\" journal@ag45.org.ua\r\n.".
					"Reply-To: journal@ag45.org.ua\r\n".
					"Content-Type: text/html; charset=\"utf-8\" ";
	}
function sendMail() {
	require_once("defence.lib.php");
	if (!isEmail($this-> receiver)) {
		$this-> error="Ошибка. Неправильный электронный адрес.";
		return false;
		}
	if (mail ($this-> receiver,$this-> title,$this-> text,$this-> headers)) 
		return true;
	else {
		$this-> error="Ошибка. Не удалось отправить письмо.";
		return false;		
		}
	}
function getError() {
	return $this-> error;
	}
}
?>
