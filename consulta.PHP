<?php require_once('Connections/cotizacion.php');   
//@$v=$_POST['consulta'];
@$v=6;

mysql_select_db($database_cotizacion, $cotizacion);
$query_Recordset1 ="SELECT * FROM cotizaciones c,`mano de obra maquina` cm,`costos hombre` ch,vagon v 
where
c.id_cotizacion = cm.id_cotizacion
and c.id_cotizacion = ch.id_cotizacion
and c.id_cotizacion = 2";
$Recordset1 = mysql_query($query_Recordset1, $cotizacion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $row_Recordset1['cliente'].' Por la '.$row_Recordset1['descripcion'] ?></title>
</head>
<body>
<table border="2" cellspacing="2" class="table-bordered table-hover" align="center">
   		 <tr>
          <td colspan="7" align="center"><?php echo 'Cotizacion a '.$row_Recordset1['cliente'].' Por la '.$row_Recordset1['descripcion'] ?></td>
        </tr>
        <tr >	
   			<td>nombre  &nbsp;&nbsp;</td>
            <td> peso vagon &nbsp;&nbsp;</td>
            <td> id_cotizacion &nbsp;&nbsp;</td>
            <td> horas totales &nbsp;&nbsp;</td>
            <td> centro de trabajo &nbsp;&nbsp;</td>
            <td> CIf &nbsp;&nbsp;</td>
            <td> uso maquina&nbsp;&nbsp;</td>
        </tr>
        <tr>
	   		<td><?php echo $row_Recordset1['nombre']; 			?></td>
            <td><?php echo $row_Recordset1['peso vagon']; 	 	?></td>
            <td><?php echo $row_Recordset1['id_cotizacion']; 	?></td>
            <td><?php echo $row_Recordset1['horas totales'];  	?></td>
            <td><?php echo $row_Recordset1['centro trabajo']; 	?></td>
            <td><?php echo $row_Recordset1['CIF']; 				?></td>
            <td><?php echo $row_Recordset1['Uso maquina']; 		?></td>
            <td><a href="codigos/actualizarcotizacion.php?id_cotizacion=<?php echo $row_Recordset1['id_cotizacion']?>" rel="moodalbox">
      <img src="update.PNG" width="30" height="27"></a></td>
      <td><a href="eliminarcotizacion.php?id_cotizacion=<?php echo $row_cotizaciones['id_cotizacion']?>">
         </tr>
       
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
