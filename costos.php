<?php 
require_once('Connections/cotizacion.php');    
require_once('codigos/vagon.php');             

$query_cotizaciones = "SELECT * FROM cotizaciones";
$cotizaciones = mysql_query($query_cotizaciones,$cotizacion) or die("primer select costos");
$row_cotizaciones = mysql_fetch_assoc($cotizaciones);
$totalRows_cotizaciones = mysql_num_rows($cotizaciones);

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "Administrador,Cotizador";
$MM_donotCheckaccess = "false";

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
}

$query_RecordsetM = "SELECT SUM( `CIF` ) AS total FROM `mano de obra maquina`";
$RecordsetM = mysql_query($query_RecordsetM, $cotizacion) or die("2 select costos");
$row_RecordsetM = mysql_fetch_assoc($RecordsetM);
$totalRows_RecordsetM = mysql_num_rows($RecordsetM);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="css/moodalbox.css" type="text/css" media="screen"/> 
   	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/logo.PNG">
    <title>Imecauca</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
  </head>
  
<body">
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<center>
	<img src="images/Banner.png" width="100%" title="Imecol del cauca">
	</center>
<!-- Responsive Design-->
<div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>	
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
<!-- Fin Resposive Design-->
</div>
	<div class="collapse navbar-collapse navbar-ex1-collapse">
   		<ul class="nav navbar-nav navbar-center"> 
        	<li><a href="inicio.php"    >  Inicio  </a></li>
        	<li><a href="cotizar.php"   >│ Cotizar</a></li>
   			<li><a href="diseno.php"    >│ Diseño </a></li>
   			<li><a href="logout.php"    >│ <img src="images/SALIR.png" width="20" height="20"></a></li>
        </ul>
   	</div>
</nav>
<div class="container">
<div class="section">
<div class="row">
<div class="col-lg-4 col-md-4">
</div>
<div class="col-lg-4 col-md-4">
</div>
<div class="col-lg-4 col-md-4">
</div></div><!-- /.row --></div><!-- /.container --></div><!-- /.section -->
<br>
<div class="container">
	<div class="row alert">
<h2 class="text-center alert-titulo">
<?php 
$sql = "SELECT cliente,descripcion FROM `cotizaciones` ORDER BY cotizaciones.id_cotizacion DESC LIMIT 1";
$resultados = mysql_query($sql);
while($row = mysql_fetch_array($resultados)) { 
echo 'Cotizacion a '.$row["cliente"].' Por la '.$row["descripcion"];
}
?>
</h2>
<center>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
<h3><label>Proforma Comercial Numero &nbsp;
<?php 
$resultados = mysql_query("SELECT id_cotizacion FROM `cotizaciones` ORDER BY id_cotizacion DESC LIMIT 1");
while($row = mysql_fetch_array($resultados)) { 
echo $row["id_cotizacion"];
$id_cot = $row["id_cotizacion"];
}
?>
</h3>
<hr> 
<?php @$descr=$_POST['titulo'] ?><!-- Variable de  los termninos de la cotizacion-->
<!-- Inicia el Formulario -->
<?php if ($totalRows_cotizaciones > 0) {  ?>  

<div class="col-lg-4 col-md-4">
</i><strong><h4 class="pull-left">CARACTERISTICAS GENERALES</strong><br><span style="color:#CCC">(Peso en Kilogramos)</span></h4>
<!-- Inicio de el formulario sobre caracteristicas generales-->     
<input type="text" name="nombre"  required placeholder="nombre" title="nombre" autofocus>
<input type="text" name="longitud"  size="32" required placeholder="Longitud" title="Longitud" autocomplete="on" maxlength="5" onkeypress="return soloNumeros(event)">
<input type="text" name="altura_total" value="" size="32" required placeholder="Altura" title="Altura" autocomplete="on" maxlength="4" onkeypress="return soloNumeros(event)">
<input type="text" name="ancho" value="" size="32" required placeholder="Ancho" title="Ancho" autocomplete="on" maxlength="4" onkeypress="return soloNumeros(event)">
<input type="text" name="altura__chasis" value="" size="32" required placeholder="Altura Del chasis"title="Altura Del chasis" autocomplete="on" maxlength="4" onkeypress="return soloNumeros(event)">
<input type="text" name="altura_neta" value="" size="32" required placeholder="Altura Desde el Piso" title="Altura Desde el Piso" autocomplete="on" maxlength="4" onkeypress="return soloNumeros(event)"><br>
</div>
<div class="col-lg-4 col-md-4">
</div>
<div class="col-lg-4 col-md-4">
</i><strong><h4 class="pull-left">TIPO DE CARGA Y DESEMPEÑO</strong></h4>
    <!--Producto a Transportar
    <!--densidad_cana_picada Es igual a producto-->
	<select name="densidad_cana_picada" required title="Producto a Transportar">
    <option value="384"  >	Caña Larga			</option>
    <option value="420"  >	Caña Picada			</option>
    <option value="924"  >	Gasolina			</option>
    <option value="260"  >	Palma Aceite		</option>
    <option value="2000" >	Malla Expandida		</option>
    <option value="768"  >	Urea				</option>
    <option value="1275" >	Vinaza				</option>
    <option value="1000" >	Agua				</option>
    <option value="1600" >	Arena				</option>
    </select>
<!--Densidad cana larga-->
<input type='hidden' name='densidad_cana_larga' required placeholder='Densidad cana larga'  title='Densidad cana larga' autocomplete='on' maxlength='4' onkeypress='return soloNumeros(event)'>
<!--Capacidad cana larga-->
<input type='text' name='capacidad_cana_larga' required placeholder='Capacidad Producto' title='Capacidad cana larga'
autocomplete='on' maxlength='4' onkeypress='return soloNumeros(event)'>
<!--Peso vagon:-->
<input type='text' name='peso_vagon' required placeholder='Peso vagon' title='Peso vagon' autocomplete='on' maxlength='4' onkeypress='return soloNumeros(event)'><br>
</div>

</div><!-- /.row -->
</div><!-- /.container -->
<center>
<a href="eliminar_termino/index.php?id=<?php echo $id_cot ?>" id="dialog-link" class="ui-state-default ui-corner-all" target="NEW">
	<span class="ui-icon ui-icon-newwin"></span>Terminos Tecnicos De la Cotización</a><br><br>
  
    <input type="submit" value="Agregar" id="button" class="btn  btn-primary">  
  	<input type="hidden" name="MM_insert" value="form1">
    </form>
    </center>
     <hr>
<div class="container">
<center>
</i><strong><h4 style="text-align:center">COSTOS POR CENTRO DE TRABAJO</strong></h4>
<table>
<form name="nuevo_empleado" action="" onsubmit="enviarDatosEmpleado(); return false">
 	  <tr><td><select name="centro_trabajo">
      <option value="armado">			Armado					</option>
      <option value="soldadura-SMAW">	Soldadura-SMAW			</option>
      <option value="soldadura-SAW">	Soldadura-SAW			</option>
      <option value="soldadura-MIG">	Soldadura-MIG			</option>
      <option value="doblado">			Doblado					</option>
      <option value="torno">			Torno					</option>
      <option value="taladro de fresa">	Taladro de fresa 		</option>
      <option value="taladro de radi">	Taladro Radial			</option>
      <option value="ensamble">			Ensamble				</option>
      <option value="cizalla">			Cizalla					</option>
      <option value="oxicorte">			Oxicorte				</option>			
      <option value="rolado">			Rolado					</option>
      <option value="terminado">		Terminado				</option>
      <option value="aserrado">			Aserrado				</option>
      <option value="plasma">			Plasma  		 		</option>
      </select></td></tr>
<tr><td>      
      <input type="text" name="hombres" maxlength="4" onkeypress="return soloNumeros(event)" type="number" min="0" max="999" required autocomplete="OFF" placeholder="Hombres">
      </td></tr>
      <tr><td>
       <input type="text" name="jornales" maxlength="4" onkeypress="return soloNumeros(event)" type="number" min="0" max="999" required autocomplete="OFF"  placeholder="Horas">
</td></tr>
<tr><td align="center"><input type="submit" name="Submit" value="+" id="button"> <!--class="btn  btn-primary"-->
      	<input  type="hidden" name="id_cotizacion" readonly value="<?php 
		$resultados = mysql_query("SELECT id_cotizacion FROM `cotizaciones` ORDER BY `id_cotizacion` DESC LIMIT 1");
		while($row = mysql_fetch_array($resultados)) { 
		printf( $row['id_cotizacion']);
		}
	?>">
<tr><td align="center">
</form></td></table>

<div id="resultado"><?php include('ajax/consultar.php');?></div></center>
<br>
</div>
<div class="col-lg-4 col-md-4">
</div>

</div><!-- /.container -->
<center>
<hr>
<center>
<a href="cotizar.php" class="btn  btn-primary"><span class="ui-icon ui-icon-newwin"></span>Finalizar La Cotizacion</a></a>
  <hr>
  
</center>
<?php } // Show if recordset not empty 
 if ($totalRows_cotizaciones == 0) { // Show if recordset empty ?>
<center>
<div class="alert-info"><br>
No hay Cotizaciones Actualmente ↓↓ Puede Empezar a Crear Una Aqui<br><br>
	<a href="nuevacotizacion.php" rel="moodalbox 1000 600 ">
<input type="button" value="Empezar a Cotizar" id="button" class="btn btn-primary">
	</a>
    </div>
</center>
      <?php } // Show if recordset empty ?>
</center>   
</div><!-- /.section -->
 <div class="section-colored text-center">
    <div class="row " style="background:url(images/logo-50.png) no-repeat">
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
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/modern-business.js"></script>
    <script src="js/Funciones.js"></script>
    <script src="jquery-ui-1.10.3.custom.js"></script>
    <script src="js/ajax.js" language="JavaScript" type="text/javascript" ></script>
    <script src="insertar.js"></script>
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
	<script type="text/javascript" src="js/mootools.js"></script> 
	<script type="text/javascript" src="js/moodalbox.js"></script> 
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