<?
//mail('sasha.melkonyan@mail.ru','test',"<html><head></head><body><a href='www.ag45.org.ua'>href</a></body></html>",
//'Content-Type:text-html; charset=windows-1251');
$message = '
<html>
<head></head>
<body>На сайте info-pages.com.ua на страничке <a href="http://info-pages.com.ua/e/13">http://info-pages.com.ua/e/13</a> добавлен новый комментарий такого содержания: "Здесь был Коля".
Почтовый ящик автора:"коля@ящик" . 
<br> 

</body>
</html>'; 

$header = "Content-Type: text/html; charset=utf-8";

// mail("sasha.melkonyan@mail.ru", "Восстановление пароля", $message, $header);
$header = "Content-Type: text/html; charset=utf-8";
                        $head= "Password";
                        $text=" <html>
                                <head>
                                </head>
                                <body>
                                Здраствуйте!<BR>
                                Ваша информация:<BR>
                                Логин: <BR>
                                Пароль: <BR>
                                Вводите пароль внимательно, с учётом регистра букв.<BR>
                                С уважением, администрация <a href='www.ag45.org.ua'>
                                                           сайта </a>
                                </body>
                                </html>";

                        
                        mail ('sasha.melkonyan@mail.ru',$head,$text,$header); 
?>
