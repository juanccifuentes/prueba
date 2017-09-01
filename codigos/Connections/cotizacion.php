<?php
//codigos
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cotizacion = "mysql5.000webhost.com";
$database_cotizacion = "a4974285_cotizac";
$username_cotizacion = "a4974285_root";
$password_cotizacion = "imecauca2014";
$cotizacion = mysql_pconnect($hostname_cotizacion, $username_cotizacion, $password_cotizacion)or die(mysql_errno());
?>