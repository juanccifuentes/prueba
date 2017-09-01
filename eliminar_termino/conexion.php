<?php
//Configuracion de la conexion a base de datos
$bd_host = "mysql5.000webhost.com"; 
$bd_usuario = "a4974285_root"; 
$bd_password = "imecauca2014"; 
$bd_base = "a4974285_cotizac"; 
$con = mysql_connect($bd_host, $bd_usuario, $bd_password); 
mysql_select_db($bd_base, $con); 
?>
