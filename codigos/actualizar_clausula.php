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
  $updateSQL = sprintf("UPDATE clausulas SET id_cotizacion=%s, Nota=%s, forma_pago=%s, entrega=%s, garantia=%s WHERE id_clausula=%s",
                       GetSQLValueString($_POST['id_cotizacion'], "int"),
                       GetSQLValueString($_POST['Nota'], "text"),
                       GetSQLValueString($_POST['forma_pago'], "int"),
                       GetSQLValueString($_POST['entrega'], "int"),
                       GetSQLValueString($_POST['garantia'], "int"),
                       GetSQLValueString($_POST['id_clausula'], "int"));

  mysql_select_db($database_cotizacion, $cotizacion);
  $Result1 = mysql_query($updateSQL, $cotizacion) or die(mysql_error());

  $updateGoTo = "../eliminar_termino/index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_cotizacion, $cotizacion);
$query_Recordset1 = sprintf("SELECT * FROM clausulas WHERE id_cotizacion = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $cotizacion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


  
?>
<!doctype html>
<html>
<meta charset="utf-8">
<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
  
      <td><input type="hidden" name="id_cotizacion" value="<?php echo htmlentities($row_Recordset1['id_cotizacion'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nota:</td>
      <td>
      <textarea name="Nota"  rows="5" cols="17"><?php echo htmlentities($row_Recordset1['Nota'], ENT_COMPAT, 'utf-8'); ?></textarea>
</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Forma_pago:</td>
      <td><input type="number" name="forma_pago" value="<?php echo htmlentities($row_Recordset1['forma_pago'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Entrega:</td>
      <td><input type="number" name="entrega" value="<?php echo htmlentities($row_Recordset1['entrega'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Garantia:</td>
      <td><input type="number" name="garantia" value="<?php echo htmlentities($row_Recordset1['garantia'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td colspan="2"><input type="image" src="../images/actualizar.png" value="Actualizar registro" width="25" title="actualizar"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id_clausula" value="<?php echo $row_Recordset1['id_clausula']; ?>">
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
