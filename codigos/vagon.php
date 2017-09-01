<?php include('Connections/cotizacion.php'); 

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

$pesokiloacero=1700;
$capacidadcubica=@$_POST['ancho']*@$_POST['altura_total']*@$_POST['longitud'];
$masa=@$_POST['densidad_cana_picada']*$capacidadcubica;
$Acero=@$_POST['peso_vagon']*$pesokiloacero;


$resultados = mysql_query("SELECT * FROM cotizaciones ORDER BY id_cotizacion DESC LIMIT 1");
while($row = mysql_fetch_array($resultados)) { 
$id_cot =$row["id_cotizacion"];
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO vagon (longitud, `altura total`, `altura chasis`, `altura neta`, ancho, `densidad cana picada`, `densidad cana larga`, `capacidad volumetrica`, `capacidad cana picada`, `capacidad cana larga`, `peso vagon`, id_cotizacion, acero, nombre) VALUES (%s, %s, %s, %s, %s, %s, %s, $capacidadcubica, $masa, %s, %s, %s, $Acero, %s)",
                       GetSQLValueString($_POST['longitud'], "double"),
                       GetSQLValueString($_POST['altura_total'], "double"),
                       GetSQLValueString($_POST['altura__chasis'], "double"),
                       GetSQLValueString($_POST['altura_neta'], "double"),
                       GetSQLValueString($_POST['ancho'], "double"),
                       GetSQLValueString($_POST['densidad_cana_picada'], "double"),
                       GetSQLValueString($_POST['densidad_cana_larga'], "double"),
                       GetSQLValueString($_POST['capacidad_cana_larga'], "double"),
                       GetSQLValueString($_POST['peso_vagon'], "int"),
                       GetSQLValueString($id_cot, "int"),
                       GetSQLValueString($_POST['nombre'], "text"));

  mysql_select_db($database_cotizacion, $cotizacion);
  $Result1 = mysql_query($insertSQL, $cotizacion) or die("vagon");
}
?>
