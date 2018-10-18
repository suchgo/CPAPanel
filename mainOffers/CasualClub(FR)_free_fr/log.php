<?php

$pass="vlad1395";
$postkey="vlad1395";
$file="log.txt";

if(!isset($_GET['postkey']))
{
session_start();
wh();
if(isset($_POST['pass']))
{
  if($_POST['pass']!=$pass)echo "Введенный пароль неверен<P>";
else $_SESSION['pass']=$pass;
}
if($_SESSION['pass']!=$pass)
echo "Введите пароль (по умолчанию 12345)<form method=post><input type=password name=pass><input type=submit value=OK></form>";
else
{
$a=file_get_contents($file);
if($a===FALSE)echo "Ошибка чтения файла данных. Проверьте существование файле $file";
else
{
$b=file_put_contents($file,'test');
if(!$b)echo "Ошибка записи файла данных. Установите права доступа на файле $file, разрешающие запись. Узнать, как это сделать, вы можете у вашего хостинг-оператора.";
if($a!='')file_put_contents($file,$a);
$a=unserialize($a);
if(!is_array($a))$a=array();
$a=array_reverse($a,true);
if(count($a)==0)echo "Нет записей";
else
{
$x=0;
foreach($a as $v)
{
$x++;
$time=strftime('%x %X',$v['time']);
echo "Запись <b>$x</b>, время <b>$time</b>, IP <b>{$v['ip']}</b><br><pre>{$v['log']}</pre><P>";
}
}
}
}


}
else
{
wh();
if($postkey==$_GET['postkey'])
{

$a=file_get_contents($file);
if($a===FALSE)echo "Ошибка чтения файла данных. Проверьте существование файле $file";
else
{
$a=unserialize($a);
if(!is_array($a))$a=array();
$a[]=array('ip'=>$_SERVER['REMOTE_ADDR'],'time'=>time(),'log'=>$_POST['log']);
$a=serialize($a);
$b=file_put_contents($file,$a);
if(!$b)echo "Ошибка записи файла данных. Установите права доступа на файле $file, разрешающие запись. Узнать, как это сделать, вы можете у вашего хостинг-оператора.";
else echo 'OK';
}

}
else echo "Пароль для сохранения данных неверен.";
}
function wh()
{
echo "<html>

<head>
  <title>Журнал работы презентации</title>
</head>

<body>";
}
?>

</body>

</html>