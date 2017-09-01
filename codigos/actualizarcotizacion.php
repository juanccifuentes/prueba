<?php require_once('../Connections/cotizacion.php'); ?>
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

// Variables para actualizar vagon C:
$pesokiloacero=1700;
$capacidadcubica=@$_POST['ancho']*@$_POST['altura_total']*@$_POST['longitud'];
$masa=@$_POST['densidad_cana_picada']*$capacidadcubica;
$Acero=@$_POST['peso_vagon']*$pesokiloacero;

//Captura el id_cotizacion Para Compararlo en el update :D
$f=@$_POST['id_cotizacion'];
$peso=@$_POST['peso_vagon'];


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("update cotizaciones 
inner join vagon 
on cotizaciones.id_cotizacion = vagon.id_cotizacion 
SET cliente=%s ,
descripcion=%s ,
longitud=%s,
nombre=%s ,
`altura total` = %s ,
`altura  chasis` = %s ,
`altura neta` = %s,
ancho = %s,
`densidad cana picada` = %s,
`densidad cana larga` = %s,
`capacidad volumetrica` = $capacidadcubica,
`capacidad cana picada` = $masa,
`acero` = $Acero,
`peso vagon` = $peso, 
`capacidad cana larga` = %s
where cotizaciones.id_cotizacion =%s",
                       GetSQLValueString($_POST['cliente'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"),
					   GetSQLValueString($_POST['longitud'], "date"),
					   GetSQLValueString($_POST['nombre'], "text"),
					   GetSQLValueString($_POST['altura_total'], "int"),
					   GetSQLValueString($_POST['altura__chasis'], "int"),
					   GetSQLValueString($_POST['alturaneta'], "int"),
					   GetSQLValueString($_POST['ancho'], "int"),
					   GetSQLValueString($_POST['densidad_cana_picada'], "int"),
					   GetSQLValueString($_POST['densidad_cana_larga'], "int"),
					   GetSQLValueString($_POST['capacidad_cana_larga'], "int"),
					   GetSQLValueString($_POST['id_cotizacion'], "int"));
	

mysql_select_db($database_cotizacion, $cotizacion);
$Result1 = mysql_query($updateSQL, $cotizacion) or die(mysql_error());

$updateGoTo = "../cotizar.php";
if (isset($_SERVER['QUERY_STRING'])) {
$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
$updateGoTo .= $_SERVER['QUERY_STRING'];
}
header(sprintf("Location: %s", $updateGoTo));
}

$colname_cotizacion = "-1";
if (isset($_GET['id_cotizacion'])) {
  $colname_cotizacion = $_GET['id_cotizacion'];
}
mysql_select_db($database_cotizacion, $cotizacion);
$query_cotizacion = sprintf("SELECT * 
FROM cotizaciones c,  `mano de obra maquina` cm,  `costos hombre` ch, vagon v
WHERE c.id_cotizacion = cm.id_cotizacion
AND c.id_cotizacion = ch.id_cotizacion
AND v.id_cotizacion = c.id_cotizacion
AND v.id_cotizacion = %s", GetSQLValueString($colname_cotizacion, "int"));
$cotizacion = mysql_query($query_cotizacion, $cotizacion) or die(mysql_error());
$row_cotizacion = mysql_fetch_assoc($cotizacion);
$totalRows_cotizacion = mysql_num_rows($cotizacion);

mysql_free_result($cotizacion);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="../css/moodalbox.css" type="text/css" media="screen"/> 
   	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap core CSS -->
    <link rel="shortcut icon" href="../images/logo.PNG">
    <title>Imecauca</title>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!-- Add custom CSS here -->
    <link href="../css/modern-business.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet">
  </head>
  
<body">
<img src="../images/Banner.png" width="100%" title="Imecol del cauca">
<hr>
<div class="container">
<div class="col-lg-4">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
<table class="table-hover table-bordered table-condensed pull-left">
 <tr>
    <td>Nombre del Equipo:</td><td><?php echo htmlentities($row_cotizacion['nombre'], ENT_COMPAT, ''); ?></td>
    </tr>
     <tr>
    <td>Capacidad Cubica :</td><td><?php echo htmlentities($row_cotizacion['capacidad volumetrica'], ENT_COMPAT, ''); ?></td>
    </tr>
    <tr>
    <td>Masa :</td><td><?php echo htmlentities($row_cotizacion['capacidad cana picada'], ENT_COMPAT, ''); ?></td>
    </tr>
     <tr>
    <td>Acero :</td><td>$<?php echo htmlentities($row_cotizacion['acero'], ENT_COMPAT, ''); ?></td>
    </tr>
</table>
</div>
<strong><h3>Actualizar Cotización 00<?php echo htmlentities($row_cotizacion['id_cotizacion'], ENT_COMPAT, ''); ?>A</strong></h3>
<div class="col-lg-1 col-md-4">

<table align="left">
    <tr valign="baseline">
    	<td nowrap="nowrap" align="right">Cliente:</td>
    	<td><input type="text" name="cliente" value="<?php echo htmlentities($row_cotizacion['cliente'], ENT_COMPAT, ''); ?>" size="32" required /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Descripcion:</td>
      <td><input type="text" name="descripcion" value="<?php echo htmlentities($row_cotizacion['descripcion'], ENT_COMPAT, ''); ?>" size="32" required />   </td>
    </tr>
     <tr valign="baseline">
      <td nowrap="nowrap" align="right">Longitud:</td>
      <td><input type="text" name="longitud" value="<?php echo htmlentities($row_cotizacion['longitud'], ENT_COMPAT, ''); ?>" size="32" required />   </td>
    </tr>
      <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nombre:</td>
      <td><input type="text" name="nombre" value="<?php echo htmlentities($row_cotizacion['nombre'], ENT_COMPAT, ''); ?>" size="32" required />   </td>
    </tr>
     </tr>
      <tr valign="baseline">
      <td nowrap="nowrap" align="right">Altura Total:</td>
      <td><input type="text" name="altura_total" value="<?php echo htmlentities($row_cotizacion['altura total'], ENT_COMPAT, ''); ?>" size="32" required />   </td>
    </tr>
    <tr>
    <td nowrap="nowrap" align="right">Altura Chasis</td>
    <td>
    <input type="text" name="altura__chasis" value="<?php echo htmlentities($row_cotizacion['altura  chasis'], ENT_COMPAT, ''); ?>" size="32" required/>
    </td>
    </tr>
      <tr>
    <td nowrap="nowrap" align="right">Altura Neta</td>
    <td>
    <input type="text" name="alturaneta" value="<?php echo htmlentities($row_cotizacion['altura neta'], ENT_COMPAT, ''); ?>" size="32" required/>
    </td>
    </tr>
    </tr>
      <tr valign="baseline">
      <td nowrap="nowrap" align="right">Ancho:</td>
      <td><input type="text" name="ancho" value="<?php echo htmlentities($row_cotizacion['ancho'], ENT_COMPAT, ''); ?>" size="32" required />   </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Peso:</td>
      <td><input type="text" name="peso_vagon" value="<?php echo htmlentities($row_cotizacion['peso vagon'], ENT_COMPAT, ''); ?>" size="32" required />   </td>
    </tr>
    <tr>
    <td>Producto a Transportar</td>
    <td>
    <select name="densidad_cana_picada" required title="Producto a Transportar">
    <option value="384"  >	Caña Larga			</option>
    <option value="420"  >	Caña Picada			</option>
    <option value="457"  >	Caña Picada 24 Ton	</option>
    <option value="924"  >	Gasolina			</option>
    <option value="260"  >	Palma Aceite		</option>
    <option value="2000" >	Malla Expandida		</option>
    <option value="768"  >	Urea				</option>
    <option value="1275" >	Vinaza				</option>
    <option value="1000" >	Agua				</option>
    <option value="1600" >	Arena				</option>
    </select>
    </td>
    </tr>
    <tr>
    
    <td><input type='hidden' name='densidad_cana_larga' required title='Densidad cana larga' maxlength='4' onkeypress='return soloNumeros(event)' value="<?php echo htmlentities($row_cotizacion['densidad cana larga'], ENT_COMPAT, ''); ?>"></td>
    </tr>
     <tr>
   
    <td><input type='hidden' name='capacidad_cana_larga' required title='capacidad cana larga' maxlength='4' onkeypress='return soloNumeros(event)' value="<?php echo htmlentities($row_cotizacion['capacidad cana larga'], ENT_COMPAT, ''); ?>"></td>
    </tr>
    <tr align="center">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit"  value="Actualizar"/></td>
    </tr>
</table>

<input type="hidden" name="MM_update" value="form1" />
<input type="hidden" name="id_cotizacion" value="<?php echo $row_cotizacion['id_cotizacion']; ?>" />
</form>

</div>
</div><!-- /.row -->
</div><!-- /.container -->


<hr>
<center>
<a href="../cotizar.php" class="btn  btn-primary"><span class="ui-icon ui-icon-newwin"></span>Volver</a></a>
<hr>
</center>


</div><!-- /.section -->
 <div class="section-colored text-center">
    <div class="row " style="background:url(../images/logo-50.png) no-repeat">
      <h2>Recuerde.</h2>
        <h4>Que la informaci&oacute;n que usted maneja es valiosa para la empresa.<br>Por favor al retirarse del centro de trabajo dejar el computador bloqueado o salirse del sistema para<br> prevenir acciones fraudulentas.</h4><br><br><br>
 </div>
  </div><!-- /.section-colored -->
   <div class="section">
    <div class="container">
<div class="container">
 <div class="row well">
  <div class="col-lg-8 col-md-8">
   <alert h4>Este aplicativo es para uso exclusivo de los funcionarios de la empresa. </h4><br>
    <alert h4>Copyright &copy; IMECAUCA S.A.2013</p>
     </div>
    <div class="col-lg-4 col-md-4">
<a class="btn btn-lg btn-primary pull-right" href="https://www.imecauca.com.co" target="new">IMECAUCA S.A.</a>
    </div>
   </div>
   <div class="container">
      <footer>
        <div class="row">
          <div class="col-lg-12">
            <p>Copyright &copy; IMECAUCA.S.A</p>
          </div>
          <div class="col-lg-12 text-left">
            <p>Camilo Cifuentes Web And Grafic Designer</p>
          </div>
        </div>
      </footer>
    </div><!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/modern-business.js"></script>
    <script src="../js/Funciones.js"></script>
    <script src="../jquery-ui-1.10.3.custom.js"></script>
    <script src="../js/ajax.js" language="JavaScript" type="text/javascript" ></script>
    <script src="../insertar.js"></script>
    <script>
		$( "#dialog" ).dialog({
			autoOpen: false,
			width: 400,
			buttons: [
				{
					text: "Ok",
					click: function() {
						$( this ).dialog( "close" );
					}
				},
				{
					text: "Cancel",
					click: function() {
						$( this ).dialog( "close" );
					}
				}
			]
		});

		// Link to open the dialog
		$( "#dialog-link" ).click(function( event ) {
			$( "#dialog" ).dialog( "open" );
			event.preventDefault();
		});
		
$( "#dialog-link, #icons li" ).hover(
			function() {
				$( this ).addClass( "ui-state-hover" );
			},
			function() {
				$( this ).removeClass( "ui-state-hover" );
			}
		); </script>
	<script type="text/javascript" src="../js/mootools.js"></script> 
	<script type="text/javascript" src="../js/moodalbox.js"></script> 
    <script language="JavaScript">
	function aviso(url){
	if (!confirm("Revise que los campos esten bien diligenciados ↓ y pulse Aceptar")) {
	return false;
		}
	else {
			document.location = url;
			return true;
		}
	}
</script>
  </body>
</html>
