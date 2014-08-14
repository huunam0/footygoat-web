<?php

$connect_string='localhost';
$connect_username='root';
$connect_password='usbw';
$conect_db='footygoat';
mysql_connect($connect_string,$connect_username,$connect_password) or die(mysql_error());
mysql_select_db($conect_db) or die(mysql_error());
mysql_set_charset("utf8");
?>