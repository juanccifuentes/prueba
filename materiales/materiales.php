<?php require_once('Connections/cotizacion.php'); ?>
<?php
session_start();
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_cotizacion, $cotizacion);
$query_row = "SELECT * FROM materiales order by material asc";
$row = mysql_query($query_row, $cotizacion) or die(mysql_error());
$row_row = mysql_fetch_assoc($row);
$totalRows_row = mysql_num_rows($row);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Agregar Materiales</title>
</head>

<body>
<div style="position:fixed;width:50px;height:40px;text-align:center;padding:2px"><a href="../buscar/index.php"><img src="../images/buscar.png" width="40" height="40" title="buscar"></a></div>
<table border="1" cellspacing="1" align="center">
  <tr bgcolor="#666666" style="color:#FFF">
    <td>Item</td>
    <td>Descripcion</td>
    <td>precio</td>
    <td>Clasificacion</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_row['id_material'];?></td>
      <td><?php echo $row_row['material'];?></td>
      <td><?php echo '$'.$row_row['precio'];?></td>
      <td>
<form type="GET">
       <select name="select" id="select" onchange="insertar();">
                <option><?php echo $row_row['clasificacion']; ?></option>
                <option value="aceros">			   Aceros 					</option>
                <option value="lamina">			   Lamina					</option>
                <option value="tornilleria">	   Tornilleria				</option>
                <option value="barras perforadas"> Barras perforadas		</option>
                <option value="tubulares">         Tubulares				</option>
                <option value="accesorios">        Accesorios				</option>
                <option value="pintura">           Pintura					</option>
                <option value="consumibles">       Consumibles				</option>
                <option value="perfileria">        Perfileria				</option>
				<input type="hidden" value="<?php echo $row_row['id_material']; ?>" id="id" name="id" />
</select>
</form>
</td>
</td>
</tr>
<?php } while ($row_row = mysql_fetch_assoc($row)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($row);
?>
<script src="js/funcionAjax.js"></script>