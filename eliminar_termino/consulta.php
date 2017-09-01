<table cellpadding="0" cellspacing="0">
<thead>
<tr  align="center">
	<td>titulo</td>
	<td>descripcion</td>
    <td>Opciones</td>
</tr>
</thead>
<?php
require('../Connections/cotizacion.php');

@session_start();
$id_cot=$_SESSION['id_cot'];

$sql=mysql_query("SELECT * FROM terminos WHERE id_cotizacion = $id_cot");
while($row = mysql_fetch_array($sql)){
	echo "	<tr>";
	echo " 	<td>".$row['titulo']."</td>";
	echo " 	<td>".$row['descripcion_ter']."</td>";
	echo " 	<td><a style=\"text-decoration:underline;cursor:pointer;\" onclick=\"eliminarDato('".$row['id_termino']."')\">".'Eliminar'."</a></td>";
	echo "	</tr>";
}
?>
</table>
