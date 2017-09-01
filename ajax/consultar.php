<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="../css/moodalbox.css" type="text/css" media="screen"/> 
   	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!-- Add custom CSS here -->
    <link href="../css/modern-business.css" rel="stylesheet">
    <link href="..//font-awesome/css/font-awesome.min.css" rel="stylesheet">
  </head>

<?php

//Configuracion de la conexion a base de datos
  $bd_host = "localhost"; 
  $bd_usuario = "root"; 
  $bd_password = ""; 
  $bd_base = "cotizacion"; 
 
	$con = mysql_connect($bd_host, $bd_usuario, $bd_password); 
mysql_select_db($bd_base, $con); 
$resultados = mysql_query('SELECT id_cotizacion FROM cotizacion.`cotizaciones` ORDER BY `cotizaciones`.`id_cotizacion` DESC LIMIT 1');
while($row = mysql_fetch_array($resultados)) { 
$id_cot=$row['id_cotizacion'];
}
$query_RecordsetT = "SELECT SUM( `total costo` ) AS total FROM cotizacion.`costos hombre` WHERE id_cotizacion = $id_cot";
$RecordsetT = mysql_query($query_RecordsetT, $con) or die(mysql_error());
$row_RecordsetT = mysql_fetch_assoc($RecordsetT);
$totalRows_RecordsetT = mysql_num_rows($RecordsetT);
//consulta todos los empleados
$sql=mysql_query("SELECT * FROM cotizacion.`costos hombre` ch ,  cotizacion.`mano de obra maquina` m  WHERE m.id_cotizacion = m.id_cotizacion AND m.id_cotizacion =  '$id_cot' AND m.consecutivomachine = ch.consecutivo",$con);
?>
<table class="table-condensed table-bordered" style="width:800px">
	<tr style="background:#CCCCCC;">
		<td>Centro de trabajo</td>
		<td>Hombres</td>
        <td>horas</td>
        <td>total costo</td>
        <td>Uso Maquina</td>
        <td>CIF</td>
        <td>Opciónes</td>
	</tr>
<?php
  while(@$row = mysql_fetch_array($sql)){
  echo "<tr>";
  	echo "<td>".$row['centro trabajo']."</td>";
  	echo "<td>".$row['hombres']."</td>";
	echo "<td>".$row['horas']."</td>";
  	echo "<td>".$row['total costo']."</td>";
	echo "<td>".$row['Uso maquina']."%</td>";
	echo "<td>".$row['CIF']."</td>";
?><td>
<a href='codigos/actualizarhombre.php?consecutivo=<?php echo $row['consecutivo'] ?>' rel="moodalbox 400 250">
   <img src='images/update.PNG' width='25' height='25'> </a>
<a href='codigos/eliminarhombre.php?consecutivo=<?php echo $row['consecutivo'] ?>'>
   <img src='images/drop.PNG' width='25' height='25'> </a>
</td>
</tr>
<?php } ?>
</table>