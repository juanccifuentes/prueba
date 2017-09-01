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

if ((isset($_GET['consecutivo'])) && ($_GET['consecutivo'] != "")) {
  $deleteSQL = sprintf("DELETE  `costos hombre` , `mano de obra maquina` From `costos hombre` JOIN  `mano de obra maquina` WHERE `costos hombre`.consecutivo=`mano de obra maquina`.consecutivomachine AND `mano de obra maquina`.consecutivomachine =%s ", 
                       GetSQLValueString($_GET['consecutivo'], "int"));
					   
  

  mysql_select_db($database_cotizacion, $cotizacion);
  $Result1 = mysql_query($deleteSQL, $cotizacion) or die(mysql_error());

  $deleteGoTo = "../costos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>
$deleteSQL = sprintf("DELETE FROM `mano de obra maquina` WHERE consecutivomachine=%s",
                       GetSQLValueString($_GET['consecutivo'], "int"));				   

DELETE `costos hombre`, vagon ,`mano de obra maquina` ,terminos ,clausulas,`total materiales` ,cotizaciones
						From `costos hombre`, vagon ,terminos ,clausulas ,`total materiales` ,cotizaciones
						JOIN `mano de obra maquina`
						WHERE  vagon.id_cotizacion = `mano de obra maquina`.id_cotizacion
						AND `mano de obra maquina`.id_cotizacion =  terminos.id_cotizacion
						AND clausulas.id_cotizacion =  terminos.id_cotizacion
						AND `total materiales`.id_cotizacion = vagon.id_cotizacion 
						AND cotizaciones.id_cotizacion = vagon.id_cotizacion 
						AND  vagon.id_cotizacion = 3