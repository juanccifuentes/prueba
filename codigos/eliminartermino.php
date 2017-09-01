<?php require_once('../Connections/cotizacion.php'); ?>
<?php

@$termino = $_GET['id_termino'];

$deleteSQL = sprintf("DELETE FROM cotizacion.terminos WHERE id_termino=$termino");

mysql_select_db($database_cotizacion, $cotizacion);
$Result1 = mysql_query($deleteSQL, $cotizacion) or die(mysql_error());

  $deleteGoTo = "../termino.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));

?>
