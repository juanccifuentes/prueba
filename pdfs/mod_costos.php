<?php require_once('Connections/cotizacion.php');    ?>       <!--actualizar Conexion mysql-->
<?php require_once('codigos/actualizarhombre.php');        ?>       <!--actualizar hombre-->
<?php require_once('codigos/actualizarmaquina.php'); ?>       <!--actualizar Maquina-->
<?php require_once('codigos/vagon.php'); ?>       <!--actualizar Maquina-->
<?php session_start(); ?>

<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "Administrador,Costos";
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

</center>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<center>
<img src="images/Banner.png" width="100%" title="Imecol del cauca">
</center>
<a class="navbar-brand" href="inicio.php">
<!--<font color="#999999"><img src="images/logo.JPG" width="50" height="50" class="img-responsive"/>
</font>--></a> 
   <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- You'll want to use a responsive image option so this logo looks good on devices - I recommend using something like retina.js (do a quick Google search for it and you'll find it) -->
   </div>
<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse navbar-ex1-collapse">
   		<ul class="nav navbar-nav navbar-center">
        <li><a href="#"    >Inicio</a></li>
        <li><a href="mod_costos.php"    >│ Costos</a></li>
   		<li><a href="logout.php"    >│ Salir</a></li>
   		</ul>
       
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
            
          </div>
        </div><!-- /.row -->

      </div><!-- /.container -->

    </div><!-- /.section -->
<br>
<br>
<br>
<br>
<div class="container">
<div class="col-lg-4 col-md-4">
<h3><i class="icon-ok-circle"></i>MODULO COTIZACIÓN</h3>
<p>Acaba de Ingresar Al modulo de cotizacin en la lista de abajo encontrara las cotizaciones que se han hecho previamente para ser descargadas en PDF o editarlas si es necesario.</p>
</div>
<div class="col-lg-4 col-md-4">
<h3><i class="icon-copy"></i>&nbsp;Aqui se realizan las aprobaciónes de las cotizaciones</h3>
En Este Enlace Podra Elegir Crear una nueva Cotizacion.<br><br>
<a href="#"><input type="button" value="Crear Cotizacion" class="btn btn-primary" /></a>
</div>
<div class="col-lg-4 col-md-4 pull-right" >
<img src="images/logo-50.png"/>
<br>
   <br>
</div>

</div><!-- /.container -->
    <div class="section-colored text-center">
          <div class="row " style="background:url(images/logo-50.png) no-repeat">
            <h2>Listado de Cotizaciónes</h2>
            <h4>
                            
		<table border="2" cellspacing="2" class="table-bordered table-hover" align="center">
   		<tr>
   			<td>Nombre del equipo   &nbsp;&nbsp;</td>
            <td>Id del Equipo       &nbsp;&nbsp;</td>
            <td>peso Del Eqiupo     &nbsp;&nbsp;</td> 
            <td>Id de la cotizacion &nbsp;&nbsp;</td>
            <td>PDF                		        </td>
    	</tr>
    <?php do { ?>
      <tr>
      <td><?php echo $row_vagon['nombre']; ?></td>
              <td><?php echo $row_vagon['id_vagon']; ?></td>
              <td><?php echo $row_vagon['peso vagon']; ?></td>
              <td><?php echo $row_vagon['id_cotizacion']; ?></td>
              <td><a href="generarpdf.php"><img src="images/pdf.gif" width="17" height="17"/></a></td>
      </tr>
      <?php } while ($row_vagon = mysql_fetch_assoc($vagon)); ?> 
  </table>
      <table border="2" cellspacing="2" class="table-bordered table-hover" align="center">
 <tr>
    <td>
	<?php if ($pageNum_vagon > 0) {
    echo "<a href="; printf('%s?pageNum_vagon=%d%s', $currentPage, max(0, $pageNum_vagon - 1), $queryString_vagon);  echo "><img    src='images/atras.PNG'>.</a>";
    } 
	echo "</td>";
    echo "<td>&nbsp;";
    echo "Registros &nbsp;"; 
	echo ($startRow_vagon + 1) ;
	echo " &nbsp; a &nbsp;";  
	echo min($startRow_vagon + $maxRows_vagon, $totalRows_vagon);
	echo " &nbsp; de &nbsp;"; 
	echo $totalRows_vagon;
	echo "</td>";
    echo "<td>";
	if ($pageNum_vagon < $totalPages_vagon) { // Show if not last page 
    echo "<a href="; printf('%s?pageNum_vagon=%d%s', $currentPage, min($totalPages_vagon, $pageNum_vagon + 1), $queryString_vagon); echo">"; 
	echo "<img src='images/adelante.PNG'>";
	echo "</a>";
     } ?></td>
  </tr>
</table>
</h4><br><br><br>
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
   </div><!-- /.row -->
</div><!-- /.container -->
<!-- Pie de pagina *-* 
<footer>
    <p class="btn-toolbar">Camilo Cifuentes Web and Graffic Designer.</p>
<!-- </footer> -->
    <!--JavaScript -->    
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/modern-business.js"></script>
  </body>
</html>