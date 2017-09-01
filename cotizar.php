<?php
require_once('Connections/cotizacion.php');        
require_once('codigos/cotizaciones.php'); 
 
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "Administrador,Cotizador";
$MM_donotCheckaccess = "false";

@$usuario=$_SESSION['usuario'];

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

$MM_restrictGoTo = "errologin.php";
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
<html lang="en">
  <head>
 	<link rel="stylesheet" href="css/moodalbox.css" type="text/css" media="screen"/> 
  	<link rel="shortcut icon" href="images/logo.PNG">
    <title>Imecauca</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">    
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Add custom CSS here -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-inverse " role="navigation">
<center>
<img src="images/Banner.png" width="100%" title="Imecol del cauca">
</center>
   <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
	</div>
<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse navbar-ex1-collapse">
   		<ul class="nav navbar-nav navbar-center">
        <li><a href="inicio.php"    >Inicio</a></li>
        <li><a href="cotizar.php"   >│ Cotizar</a></li>
   		<li><a href="diseno.php"    >│ Diseño</a></li>
   		<li><a href='logout.php'	>│ <img src="images/Salir.png"></a></li>
   		</ul>
        </ul> 
	</div>
    </nav>
<div class="container">
<div class="col-md-4 col-lg-6">
<h3><i class="icon-ok-circle"></i>MODULO COTIZACIÓN</h3>
<p>Acaba de Ingresar Al modulo de cotizacin en la lista de abajo encontrara las cotizaciones que se han realizado previamente para ser descargadas en PDF,<br>editarlas o eliminarlas si es necesario.
</div>
<div class="col-lg-4 col-md-10 ">
<a href="nuevacotizacion.php" rel="moodalbox 600 550"><h3><i class="icon-copy"></i>Crear Nueva Cotizacion</h3></a>
En Este Enlace Podra Crear una nueva Cotizacion.
</div>
</div>
<div class="section-colored text-center">
   <div class="row " style="background:url(images/logo-50.png) no-repeat">
        <h2>Listado de Cotizaciónes</h2>
        <h4>
 <?php if (@$row_cotizaciones > 0) { // Show if recordset not empty ?>   
<center> 
<?php
	include_once("pdfs/conexion.php");
	$con = new DB;
	$pacientes = $con->conectar();
	$strConsulta = "SELECT * FROM  `cotizaciones` ORDER BY  `cotizaciones`.`id_cotizacion` ASC LIMIT 5";
	$pacientes = mysql_query($strConsulta);	
	$numfilas = mysql_num_rows($pacientes)or die("No hay Cotizaciones Actualmente" . mysql_error());
	echo '<table border="2" cellspacing="2" class="table-bordered table-condensed  table-hover" align="center">';
	echo '<thead><tr align="center"><td>Proforma</td><td>Cliente</td><td>Descripcion</td><td>Fecha de Inicio</td><td>Estado</td><td colspan="5">opciónes</td></tr></thead>';
	for ($i=0; $i<$numfilas; $i++)
	{
		$fila = mysql_fetch_array($pacientes);
		$numlista = $i + 1;
		echo '<tr><td align="center">00'.$fila['id_cotizacion'].'A</td>';
		echo '<td>'.$fila['cliente'].'</td>';
        echo '<td>'.$fila['descripcion'].'</td><td> '.$fila['fec_ini'].'</td><td>'.$fila['estado_cot'].'</td>';
		echo '<td><a href="pdfs/reporte_historial.php?id='.$fila['id_cotizacion'].'" target="new"><img src="images/ver.png" width="20" height="20" title="Generar PDF"></a></td>';
?>	
<?php if(@$fila['estado_cot'] == "Proceso"){
   
?>
<td ><a href="codigos/actualizarcotizacion.php?id_cotizacion=<?php echo $fila['id_cotizacion']?>">
      <img src="images/update.PNG" width="30" height="27" title="Editar la  Cotizacion"></a></td>
      
      <td><a href="codigos/eliminarcotizacion.php?id=<?php echo $fila['id_cotizacion']?>">
      <img src="images/drop.png" width="25" height="25" title="Eliminar la Cotizacion"></a></td>
      
      <td><a href="eliminar_termino/index.php?id=<?php echo $fila['id_cotizacion']?>" target="new">
      <img src="images/termino.png" width="25" height="25" title="Terminos de la Cotizacion"></a></td>
      
      <td><a href="materiales/index.php?id=<?php echo $fila['id_cotizacion']?>" target="new">
      <img src="images/materiales.PNG" width="25" height="25" title="Materiales"></a></td>
     <?php  }} ?>
</tr>
</table>
<br>
<a href="pdfs/index.php" target="_blank"> 
<span class="btn btn-primary">Todas las Cotizaciones</span>
</a> 
</center>
<?php }  ?>
</h4><br><br><br>
</div>
</div>
<div class="section">
	<div class="row well">
      <div class="col-lg-8 col-md-8">
        <alert h4>Este aplicativo es para uso exclusivo de los funcionarios de la empresa. </h4><br>
        <alert h4>Copyright &copy; IMECAUCA S.A.2013</p>
      </div>
   <div class="col-lg-4 col-md-4">
<a class="btn btn-lg btn-primary pull-right">IMECAUCA S.A.</a>
      </div>
   </div>
</div>
    <p class="btn-toolbar">Camilo Cifuentes Web and Graffic Designer.</p>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/modern-business.js"></script>
    <script type="text/javascript" src="js/mootools.js"></script> 
	<script type="text/javascript" src="js/moodalbox.js"></script> 
</body>
</html>