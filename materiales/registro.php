<?php
//conexion a base de datos
  $bd_host = "localhost"; 
  $bd_usuario = "root"; 
  $bd_password = ""; 
  $bd_base = "cotizacion"; 
$con = mysql_connect($bd_host, $bd_usuario, $bd_password); 
mysql_select_db($bd_base, $con); 
 
@session_start();
@$id=$_SESSION['id'];
 
//variables POST
  @$mat=$_POST['centro_trabajo'];
  @$id=$_POST['id_cotizacion'];
  @$cant=$_POST['Precio_hora'];
  

$resultados = mysql_query("SELECT * FROM `material/cotizacion` m, materiales m_m  WHERE material LIKE '%$mat%'",$con)or die("Error" . mysql_error());
while($row = mysql_fetch_array($resultados)) { 
$material=$row['id_material'];
$precio=$row['precio'];
$total=@$precio*$cant;
}

$sql="INSERT INTO `material/cotizacion` VALUES('','$id', '$material','$cant','$total')";
mysql_query($sql,$con) or die('Error. '.mysql_error());
include('consulta.php');
?>