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



$maxRows_cotizaciones = 10;
$pageNum_cotizaciones = 0;
if (isset($_GET['pageNum_cotizaciones'])) {
  $pageNum_cotizaciones = $_GET['pageNum_cotizaciones'];
}
$startRow_cotizaciones = $pageNum_cotizaciones * $maxRows_cotizaciones;

mysql_select_db($database_cotizacion, $cotizacion);
$query_cotizaciones = "SELECT * FROM cotizaciones";
$query_limit_cotizaciones = sprintf("%s LIMIT %d, %d", $query_cotizaciones, $startRow_cotizaciones, $maxRows_cotizaciones);
$cotizaciones = mysql_query($query_limit_cotizaciones, $cotizacion) or die(mysql_error());
$row_cotizaciones = mysql_fetch_assoc($cotizaciones);

if (isset($_GET['totalRows_cotizaciones'])) {
  $totalRows_cotizaciones = $_GET['totalRows_cotizaciones'];
} else {
  $all_cotizaciones = mysql_query($query_cotizaciones);
  $totalRows_cotizaciones = mysql_num_rows($all_cotizaciones);
}
$totalPages_cotizaciones = ceil($totalRows_cotizaciones/$maxRows_cotizaciones)-1;

mysql_free_result($cotizaciones);
?>
