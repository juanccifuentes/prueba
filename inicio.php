<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "Costos,Administrador,Cotizador";
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
<meta charset="utf-8">
  <head>
  	<link rel="shortcut icon" href="images/logo.PNG">
    <title>Imecauca</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-inverse " role="navigation">
	 <center>
<img src="images/Banner.png" width="100%" title="Imecol del cauca">
     </center>
<!--Diseño Responsable-->
   <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
   </div>
	<div class="collapse navbar-collapse navbar-ex1-collapse">
   		<ul class="nav navbar-nav navbar-center">
        <li><a href="inicio.php"    > inicio</a></li>
        <li><a href="cotizar.php"   >| Cotizar</a></li>
       	<li><a href='diseno.php'>| Dise&ntilde;o</a></li>
   		<li><a href='logout.php'>| <img src="images/Salir.png"></a></li>
   		</ul>
        </ul> 
	</div>
</nav>
<div class="container">
  <?php
if(@$_SESSION['MM_Username'] == 'Costos'){
echo $MM_restrictGoTo;
}?>
      <div class='col-lg-4 col-md-4'>
         <A href='cotizar.php'><h3><i class='icon-ok-circle'></i><span class='alert'>MODULO COTIZAR</span></h3></A>
           <p>EN ESTE MODULO SE REALIZAN LAS COTIZACIONES PARA UNA MEJOR ATENCION AL CLIENTE.</p>
         </div>
       <div class='col-lg-4 col-md-4'>
           <A href='#'><h3><i class='icon-pencil'></i><span class='alert'>MODULO DISE&Ntilde;O</span></h3></A>
           <p>EN ESTE MODULO SE ANALIZAN LAS NECESIDADES DEL CLIENTE Y SE LE GENERA UNA PROPUESTA PARA SATISFACER ESAS NECESIDADES.</p>
       </div>
     <div class='col-lg-4 col-md-4'>
   
     
      		<A href='mod_costos.php'><h3><i class='icon-folder-open-alt'></i><span class='alert'>MODULO COSTOS</span></h3></A>       
            <p>EN ESTE MODULO SE REALIZA EL ANALISIS DE COSTOS Y PRECIOS PARA ASI GENERAR UNA PROPUESTA REAL Y VERIDICA.</p>
            <br><br>
          </div>
       </div>
    <div class="section-colored text-center">
       <div class="row " style="background:url(images/logo-50.png) no-repeat">
            <h2><?php 
ini_set('date.timezone','America/Bogota'); 
$today = getdate(); 
$hora=date("G"); 
if ($hora<6) { 
echo(" Hoy has madrugado mucho. "); 
}
elseif($hora<12)
{ 
echo(" Buenos Dias."); 
}
elseif($hora<=18){ 
echo("Buenas Tardes."); 
}else
{
echo("Buenas Noches.");
 } 
?> </h2>
<h4>Bienvenido al sistema de informacion el cual le permitira desarrollar una cotizacion en poco tiempo de manera facil y efectiva.<br>Recuerde Que la informaci&oacute;n que usted maneja es valiosa para la empresa.<br>Por favor al retirarse del centro de trabajo dejar el computador bloqueado<br> o salirse del sistema para prevenir acciones fraudulentas.</h4>
	</div>
    </div>
<div class="section">
		<div class="row well">
      		<div class="col-lg-8 col-md-8">
        <alert h4>Este aplicativo es para uso exclusivo de los funcionarios de la empresa. </h4><br>
        <alert h4>Copyright &copy; IMECAUCA S.A.2013</p>
      </div>
   <div class="col-lg-4 col-md-4">
<a class="btn btn-lg btn-primary pull-right" href="#">IMECAUCA S.A.</a>
      </div>
   </div>
</div>
<p class="btn-toolbar">Camilo Cifuentes Web and Graffic Designer.</p>
    <!--JavaScript -->    
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/modern-business.js"></script>
  </body>
</html>