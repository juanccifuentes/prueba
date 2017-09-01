<?php
//Configuracion de la conexion a base de datos
  $bd_host = "localhost"; 
  $bd_usuario = "root"; 
  $bd_password = ""; 
  $bd_base = "cotizacion"; 
$con = mysql_connect($bd_host, $bd_usuario, $bd_password); 
mysql_select_db($bd_base, $con); 
 
  
//variables POST
@$centro=$_POST['centro_trabajo'];
@$hombres=$_POST['hombres'];
@$horas=$_POST['jornales'];
@$id=$_POST['id_cotizacion'];


if ($centro == 'armado') {
$preciohora = 6462;
}

if ($centro == 'soldadura-SMAW') {
$preciohora= 7313;
}

if ($centro == 'soldadura-SAW') {
$preciohora= 7313;
}

if ($centro == 'soldadura-MIG') {
$preciohora= 7313;
}

if ($centro == 'doblado') {
$preciohora= 11578;
}

if ($centro == 'torno') {
$preciohora= 7074;
}

if ($centro == 'taladro de fresa') {
$preciohora= 7074;
}

if ($centro =='taladro de radi') {
$preciohora= 7074;
}

if ($centro == 'ensamble') {
$preciohora= 6849;
}

if ($centro == 'terminado') {
$preciohora= 4492;
}

if ($centro == 'cizalla') {
$preciohora= 11578;
}

if ($centro == 'oxicorte') {
$preciohora= 6849;
}

if ($centro == 'plasma') {
$preciohora= 7827;
}

if ($centro == 'aserrado') {
$preciohora= 7074;
}

if ($centro == 'rolado') {
$preciohora= 11578;
}



//Variables Calculadas
@$horastotales=($hombres*$horas);
@$preciohorahombre=9600;
@$costohombre=$preciohora*$horas;
@$costotal=($preciohorahombre*$horastotales+$costohombre);
@$cif=$preciohora*$horas; 


$sql="INSERT INTO  `costos hombre` (`centro trabajo` , hombres,  horas,  `total costo` , id_cotizacion)  VALUES ('$centro', '$hombres', '$horas', '$costotal','$id')";
mysql_query($sql,$con) or die('Error. '.mysql_error()); 

$sql_maquina="Insert into `mano de obra maquina`  Values ('','$centro','$preciohora',100,'$horas','$cif','$id')"; 
mysql_query($sql_maquina,$con) or die('Error. '.mysql_error()); 



 
include('consultar.php');
?>