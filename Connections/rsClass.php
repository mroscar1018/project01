<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_rsClass = "localhost";
$database_rsClass = "id9346713_cykao";
$username_rsClass = "id9346713_cykao";
$password_rsClass = "Os10012663";
$rsClass = mysql_connect($hostname_rsClass, $username_rsClass, $password_rsClass) or die (' 無法連結資料庫 '); 
mysql_query("set names utf8");
?>