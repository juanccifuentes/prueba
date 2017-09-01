<?php require_once('../Connections/cotizacion.php'); ?>
<?php
session_start();
$_SESSION['id_cot']=$_GET['id'];


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

$id_cot= $_GET['id'];

$sql = "SELECT * FROM a4974285_cotizac.clausulas WHERE id_cotizacion =$id_cot ";
	$termi = mysql_query($sql) or die ("Error 403 Select1");
	while($row = mysql_fetch_array($termi)) { 
	$nota=$row['Nota'];
	$pago=$row['forma_pago'];
	$plazo=$row['entrega'];
	$garantia=$row['garantia'];
}

$sql = "SELECT * FROM a4974285_cotizac.cotizaciones WHERE id_cotizacion =$id_cot";
	$termi = mysql_query($sql) or die ("Error 403 Select");
	while($columna = mysql_fetch_array($termi)) { 
	$cliente=$columna['cliente'];
	$cotdes=$columna['descripcion'];
	}

@$titulo=$_POST['titulo'];
@$des=$_POST['descripcion_ter'];

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO terminos (titulo, descripcion_ter, id_cotizacion) VALUES (%s, %s, %s)",
                       GetSQLValueString(@$titulo, "text"),
                       GetSQLValueString(@$des, "text"),
                       GetSQLValueString(@$id_cot, "int"));

if(@$pago == null){
$insertSQL = sprintf("INSERT INTO clausulas (id_cotizacion, Nota, forma_pago, entrega, garantia) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString(@$id_cot, "int"),
                       GetSQLValueString(@$_POST['Nota'], "text"),
                       GetSQLValueString(@$_POST['forma_pago'], "int"),
                       GetSQLValueString(@$_POST['entrega'], "int"),
                       GetSQLValueString(@$_POST['garantia'], "int"));
					   }
  mysql_select_db($database_cotizacion, $cotizacion);
  $Result1 = mysql_query($insertSQL, $cotizacion) or die("Error 402 Insert ");
  
  
   $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}?>
<!doctype html>
<html>
<meta charset="utf-8">
<link rel="stylesheet" href="../css/moodalbox.css" type="text/css" media="screen"/> 
<link rel="stylesheet" href="../pdfs/style.css" />
<div id="content">
<h1 align="center">Terminos Tecnicos de la Cotizacion Para <?php  echo $cliente.'Por la '.$cotdes ?></h1>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table  width="100%" align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Titulo:</td>
      <td><input type="text" name="titulo" value="" size="65" required /></td>
    </tr>
    <tr valign="baseline">
    <td align="right">Contenido</td>
    <td>
    <textarea cols="50" rows="5" name="descripcion_ter" required ></textarea>
    </td>
    </tr>
   
   
    <?php if(@$pago == null)
	{ ?>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nota:</td>
      <td>
       <textarea cols="20" rows="6" name="Nota" ></textarea></td>
    </tr>
     <tr valign="baseline">
      <td nowrap="nowrap" align="right">Forma_pago:</td>
      <td><input type="number" name="forma_pago" required size="32" /><span style="color:#999">Dias</span></td>
    </tr>
    <?php } ?>
     <?php if(@$plazo == null)
	{ ?>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Entrega:</td>
      <td><input type="number" name="entrega" required size="32" /><span style="color:#999">Dias</span></td>
    </tr>
    <?php } ?>
     <?php if(@$garantia == null)
	{ ?>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Garantia:</td>
      <td><input type="number" name="garantia" required size="32" /><span style="color:#999">Meses</span></td>
    </tr>
    <?php } ?>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro" class="btn  btn-primary"/></td>
    </tr>
  </table>
  
  <input type="hidden" name="MM_insert" value="form1" />
</form>



<body>
<div id="resultado">
<?php
	include('consulta.php');
?>
</div>
<?php 


if(@$nota != null) {?>
   	<strong>Nota</strong><br/>
	<?php echo $nota ?><br />
    <?php }?>
    
    <?php if(@$pago != null) {?>
    <strong>Forma de Pago </strong><br />
	<?php echo $pago.' dias calendario contra entrega'?><br />
    <?php }?>
    
     <?php if(@$plazo != null) {?>
    <strong>Entrega</strong> <br />
    <?php echo $plazo.' dias habiles contra entrega de orden.'?> <br />
    <?php }?>
    
     <?php if(@$garantia != null) {?>
    <strong>Garantia</strong> <br />
	<?php echo $garantia.' Meses de garantía contra cualquier defecto de fabricación y de 
materiales suministrados por nosotros, encontrados por fuera de los términos de referencia establecidos y estando el producto debidamente manejado y operando 
bajo condiciones normales de funcionamiento.'?>
<?php }?>
<hr>
 <?php if(@$garantia != null) {?>
<a href="../codigos/actualizar_clausula.php?id=<?php echo $id_cot ?>" rel="moodalbox 400 310">Editar Clausulas de la Cotizacion</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="../codigos/eliminarclausula.php?id=<?php echo $id_cot ?>">Eliminar Clausulas de la Cotizacion</a>
 <?php }?>

</body>
</html>
<script language="JavaScript" type="text/javascript" src="ajax.js"></script>
<script type="text/javascript" src="../js/mootools.js"></script> 
<script type="text/javascript" src="../js/moodalbox.js"></script> 