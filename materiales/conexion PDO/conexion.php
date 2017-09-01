<?php

$manejador="mysql";
$host="localhost";
$bd="cotizacion";
$usuario="root";
$pass="";

try
{
 $con = new PDO("$manejador:host=$host;dbname=$bd", $usuario, $pass);
 $con ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }
catch (PDOException $e)
{
 echo "La conexion ha fallado por:". $e->getMessage();
}
?>

