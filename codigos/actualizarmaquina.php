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



 		@$resultados = mysql_query("SELECT `centro trabajo` FROM `costos hombre` WHERE consecutivomachine=$a");
		while(@$row = mysql_fetch_array($resultados)) { 
		@$centro=$row['consecutivomachine'];
		} 
@$a=$row_maquina['consecutivomachine'];

//variables POST
  @$centro=$_POST['centro_trabajo'];
  @$uso=$_POST['Uso_maquina'];
  @$horamaquina=$_POST['hora_maquina'];
  @$costotal=$_POST['total'];
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
@$cif=$preciohora*$horamaquina;




if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE `mano de obra maquina` SET `centro trabajo`=%s, `Precio hora`=%s, `Uso maquina`=%s, `hora maquina`=%s, CIF=%s, total=%s, id_cotizacion=%s WHERE consecutivomachine=%s",
                       GetSQLValueString($_POST['centro_trabajo'], "text"),
                       GetSQLValueString($preciohora, "double"),
                       GetSQLValueString($_POST['Uso_maquina'], "int"),
                       GetSQLValueString($_POST['hora_maquina'], "double"),
                       GetSQLValueString($cif, "double"),
                       GetSQLValueString($_POST['total'], "double"),
                       GetSQLValueString($_POST['id_cotizacion'], "int"),
                       GetSQLValueString($_POST['consecutivomachine'], "int"));

  mysql_select_db($database_cotizacion, $cotizacion);
  $Result1 = mysql_query($updateSQL, $cotizacion) or die(mysql_error());

  $updateGoTo = "../costos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_maquina = "-1";
if (isset($_GET['consecutivomachine'])) {
  $colname_maquina = $_GET['consecutivomachine'];
}
mysql_select_db($database_cotizacion, $cotizacion);
$query_maquina = sprintf("SELECT * FROM `mano de obra maquina` WHERE consecutivomachine = %s", GetSQLValueString($colname_maquina, "int"));
$maquina = mysql_query($query_maquina, $cotizacion) or die(mysql_error());
$row_maquina = mysql_fetch_assoc($maquina);
$totalRows_maquina = mysql_num_rows($maquina);

mysql_free_result($maquina);
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Centro trabajo:</td>
      <td><select name="centro_trabajo">
      <option value="armado">			Armado					</option>
      <option value="soldadura-SMAW">	Soldadura-SMAW			</option>
      <option value="soldadura-SAW">	Soldadura-SAW			</option>
      <option value="soldadura-MIG">	Soldadura-MIG			</option>
      <option value="doblado">			Doblado					</option>
      <option value="torno">			Torno					</option>
      <option value="taladro de fresa">	Taladro de fresa 		</option>
      <option value="taladro de radi">	Taladro de radi			</option>
      <option value="ensamble">			Ensamble				</option>
      <option value="cizalla">			Cizalla					</option>
      <option value="oxicorte">			Oxicorte				</option>			
      <option value="rolado">			Rolado					</option>
      <option value="terminado">		Terminado				</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      
      <td><input type="hidden" name="Precio_hora" value="<?php echo htmlentities($row_maquina['Precio hora'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Uso maquina:</td>
      <td><input type="text" name="Uso_maquina" value="<?php echo htmlentities($row_maquina['Uso maquina'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Hora maquina:</td>
      <td><input type="text" name="hora_maquina" value="<?php echo htmlentities($row_maquina['hora maquina'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      
      <td><input type="hidden" name="CIF" value="<?php echo htmlentities($row_maquina['CIF'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      
      <td><input type="hidden" name="total" value="<?php echo htmlentities($row_maquina['total'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
  
      <td><input type="hidden" name="id_cotizacion" value="<?php echo htmlentities($row_maquina['id_cotizacion'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="consecutivomachine" value="<?php echo $row_maquina['consecutivomachine']; ?>">
</form>
<p>&nbsp;</p>
