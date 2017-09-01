<?php require_once('Connections/cotizacion.php'); ?>
<?php
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE cotizaciones SET estado_cot=%s WHERE id_cotizacion=%s",
                       GetSQLValueString($_POST['estado_cot'], "text"),
                       GetSQLValueString($_POST['id_cotizacion'], "int"));

  mysql_select_db($database_cotizacion, $cotizacion);
  $Result1 = mysql_query($updateSQL, $cotizacion) or die(mysql_error());

  $updateGoTo = "mod_costos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_cotizaciones = "-1";
if (isset($_GET['id'])) {
  $colname_cotizaciones = $_GET['id'];
}
mysql_select_db($database_cotizacion, $cotizacion);
$query_cotizaciones = sprintf("SELECT id_cotizacion, estado_cot FROM cotizaciones WHERE id_cotizacion = %s", GetSQLValueString($colname_cotizaciones, "int"));
$cotizaciones = mysql_query($query_cotizaciones, $cotizacion) or die(mysql_error());
$row_cotizaciones = mysql_fetch_assoc($cotizaciones);
$totalRows_cotizaciones = mysql_num_rows($cotizaciones);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>
<body style="padding:10%">
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Estado_cot:</td>
      <td><select name="estado_cot">
  		  <option>Opcion</option>  
 		  <option value="Proceso">Proceso</option>
          <option value="Finalizada">Finalizada</option>
     	  </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id_cotizacion" value="<?php echo $row_cotizaciones['id_cotizacion']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($cotizaciones);
?>
