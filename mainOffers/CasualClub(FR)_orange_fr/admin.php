<?php

//Берем случайную почту и кликаем с нее по реф ссылке, затем отправляем на нее письмо для подртверждения реги
$fp = file("mails.txt");
$stroki = count($fp);
$min = 0;
$need = mt_rand($min, $stroki-1); 
$pieces = explode(":", $fp[$need]);

//удаляем выбранную почту из файла

unset($fp[$need]); 
$file=fopen("mails.txt","w"); 
fputs($file,implode("",$fp)); 
fclose($file);

//записываем айпи юзера
$ip = $_SERVER['REMOTE_ADDR'];

//записываем лог
$filename = "log_mails.txt";
$text = $pieces[0].":".substr($pieces[1], 0, -2).": IP-adress - ".$ip." : Date - ".date("d.m.y / H:i:s\n");
file_put_contents($filename, $text, FILE_APPEND);
fclose($filename);

?>

E-mail: <input id = "login" name = "<?php echo $pieces[0] ?>" value = "<?php echo $pieces[0] ?>" >;
pass: <input id = "pass" name = "<?php echo $pieces[1] ?>" value = "<?php echo $pieces[1] ?>" >;

<?php

//Берем логин

$fp1 = file("names.txt");
$stroki1 = count($fp1);
$min1 = 0;
$need1 = mt_rand($min1, $stroki1-1); 
?>

Login: <input id = "names" name = "<?php echo $fp1[$need1] ?>" value = "<?php echo $fp1[$need1] ?>" >;

<?php

//удаляем выбранный логин
unset($fp1[$need1]); 

$file1=fopen("names.txt","w"); 
fputs($file1,implode("",$fp1)); 
fclose($file1);

?>

<?php

//Берем index
$fp2 = file("city_France.txt");
$stroki2 = count($fp2);
$min2 = 0;
$need2 = mt_rand($min2, $stroki2-1);

?>
Index: <input id = "index" name = "<?php echo $fp2[$need2] ?>" value = "<?php echo $fp2[$need2] ?>" ></hr>;
