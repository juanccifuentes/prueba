<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "Administrador,Gerente,Produccion,Costos";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../errologin.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta/>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<div id="content">
<h1>Cotizaciones</h1>
<hr />
<?php
	include_once("conexion.php");

	$con = new DB;
	$pacientes = $con->conectar();
	$strConsulta = "SELECT * from cotizaciones";
	$pacientes = mysql_query($strConsulta);	
	$numfilas = mysql_num_rows($pacientes)or die("No hay Cotizaciones Actualmente" . mysql_error());
	
	echo '<table cellpadding="0" cellspacing="0">';
	echo '<thead><tr><td>cotizacion</td><td>Cliente</td><td>Descripcion</td><td>Estado</td><td>Fecha Inicio</td><td>Generar PDF</td><td>Editar</td><td>Eliminar</td><td>Caracteristicas</td></tr></thead>';
	for ($i=0; $i<$numfilas; $i++)
	{
		$fila = mysql_fetch_array($pacientes);
		$numlista = $i + 1;
		echo '<tr><td>'.$fila['id_cotizacion'].'</td>';
		echo '<td>'.$fila['cliente'].'</td>';
        echo '<td>'.$fila['descripcion'].'</td><td> '.$fila['estado_cot'].'</td><td> '.$fila['fec_ini'].'</td>';
		echo '<td><a href="reporte_historial.php?id='.$fila['id_cotizacion'].'">ver</a></td>';
		?>	
<td><a href="../codigos/actualizarcotizacion.php?id_cotizacion=<?php echo $fila['id_cotizacion']?>">
      Editar</a></td>
      <td><a href="../codigos/eliminarcotizacion.php?id_cotizacion=<?php echo $fila['id_cotizacion']?>">
      Eliminar</a></td>
      <td><a href="../codigos/detalle.php?id=<?php echo $fila['id_cotizacion']?>">
      Caracteristicas</a></td>
     <?php  } ?>
	</table>
</div>
</body>
</html>