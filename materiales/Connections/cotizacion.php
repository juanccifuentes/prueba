<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cotizacion = "localhost";
$database_cotizacion = "cotizacion";
$username_cotizacion = "root";
$password_cotizacion = "";
$cotizacion = mysql_pconnect($hostname_cotizacion, $username_cotizacion, $password_cotizacion)or die("<h2 align='center'>Comencemos.!</h2>" . mysql_error());
?>