<?php

//Ѕерем логин

$fp1 = file("names.txt");
$stroki1 = count($fp1);
$min1 = 0;
$need1 = mt_rand($min1, $stroki1-1); 
?>

Login: <input id = "names" name = "<?php echo $fp1[$need1] ?>" value = "<?php echo $fp1[$need1] ?>" >;

<?php

//удал€ем выбранный логин
unset($fp1[$need1]); 

$file1=fopen("names.txt","w"); 
fputs($file1,implode("",$fp1)); 
fclose($file1);

?>

<?php
//Ѕерем случайную почту дл€ активности
$fp8 = file("log_mails.txt");
$stroki8 = count($fp8);
$min8 = 0;
$need8 = mt_rand($min8, $stroki8-1); 
$pieces8 = explode(":", $fp8[$need8]);
?>

Login for activity: <input id = "alogin" name = "<?php echo $pieces8[0] ?>" value = "<?php echo $pieces8[0] ?>" >;
Password for activity: <input id = "apass" name = "<?php echo $pieces8[1] ?>" value = "<?php echo $pieces8[1] ?>" >;
