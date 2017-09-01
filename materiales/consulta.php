<!doctype HTML>
<html>
<head>
<script>
function eliminarDato(id_material){
	divResultado = document.getElementById('resultado');
	
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		
		ajax=objetoAjax();
		ajax.open("GET", "eliminarmaterial.php?id_material="+id_material);
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}
</script>
</head>
</html>
<?php
//Configuracion de la conexion a base de datos
  $bd_host = "localhost"; 
  $bd_usuario = "root"; 
  $bd_password = ""; 
  $bd_base = "cotizacion"; 
 
$con = mysql_connect($bd_host, $bd_usuario, $bd_password); 
mysql_select_db($bd_base, $con); 
	
$id=$_SESSION['id'];

$sql=mysql_query("SELECT * FROM  `material/cotizacion` m, materiales m_m WHERE id_cotizacion = $id AND m.id_material = m_m.id_material",$con);
?>
<div id="resultado">
<table>
	<tr style="background:#444444;color:#fff">
		<td>Item</td>
		<td>Material</td>
        <td>Cantidad</td>
		<td>Precio C/U</td>
		<td>U. Medida</td>
		<td>total</td>
		<td colspan="2">Opciones</td>
    </tr>
<?php
	while(@$row = mysql_fetch_array($sql)){
	echo "<tr>";
  	echo "<td>".$row['id_material']."</td>";
  	echo "<td>".$row['material']."</td>";
	echo "<td>".$row['cantidad']."</td>";
	echo "<td>".$row['precio']."</td>";
	echo "<td>".$row['medida']."</td>";
	echo "<td>".$row['total']."</td>";
	echo "<td><a style=\"text-decoration:underline;cursor:pointer;\" onclick=\"eliminarDato('".$row['id_material']."')\">Eliminar</a></td>";
	?>
<td></tr>
<?php } ?>
</table>
</div>