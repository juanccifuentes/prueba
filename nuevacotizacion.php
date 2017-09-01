<?php require_once('Connections/cotizacion.php');    ?>       <!--Conexion mysql-->
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

session_start();

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


@$usuario =$_SESSION['usuario'];	
@$nombre_cotizacion =$_SESSION['cliente'];

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO cotizaciones (estado_cot, id_usuario, cliente, descripcion) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['estado_cot'], "text"),
                       GetSQLValueString($_POST['id_usuario'], "text"),
                       GetSQLValueString($_POST['cliente'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"));

  mysql_select_db($database_cotizacion, $cotizacion);
  $Result1 = mysql_query($insertSQL, $cotizacion) or die(mysql_error());

  $insertGoTo = "costos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<?php

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "Administrador,Cotizador";
$MM_donotCheckaccess = "false";

echo "<br><br><br><br>";

function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  $isValid = False; 
  if (!empty($UserName)) { 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}
$MM_restrictGoTo = "inicio.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}?>
<!--Comineza HTML -->
<!DOCTYPE html>
<html lang="en">
  <head>
   	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap core CSS -->
    <link rel="shortcut icon" href="images/logo.PNG">
    <title>Imecauca</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Add custom CSS here -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
  </head>
<body>
<div class="row">
       <h3 class="text-center alert-titulo">Nueva Cotización</h3>
       <br>    
	<!-- Inicia el Formulario -->  
	<center>      
		<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
   		<!--usuario-->
    	<input type="hidden" name="id_usuario" value="<?php echo $usuario ?>" readonly >
        <input type="text" name="cliente" placeholder="Cliente" title="Cliente" required autofocus size="65">
        <br>
    	<textarea name="descripcion" title="Descripción" required placeholder="Descripcion De la Cotización" cols="50" rows="5"></textarea>
	<br>
    Estado de La Cotizacion:<br>
	<select name='estado_cot'>
	<option value='Proceso'>Proceso
    </option>
    </select>
    <br>  
	<hr>
    <input type="submit" value="Empezar a Cotizar" id="button" class="btn btn-primary">  
  	<input type="hidden" name="MM_insert" value="form1">
</center>   
</div><!-- /.section -->
 
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/modern-business.js"></script>
    <script src="js/Funciones.js"></script>
    <script src="js/jquery-ui-1.10.3.custom.js"></script>
</body>
</html>
<?php
@mysql_free_result(@$cotizaciones);
?>
