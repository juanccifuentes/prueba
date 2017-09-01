<?php require_once('Connections/cotizacion.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
?>

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
@$_SESSION['usuario']=$_REQUEST['id_usuario'];
?>
<?php
$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['id_usuario'])) {
  $loginUsername=$_POST['id_usuario'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "rol";
  $MM_redirectLoginSuccess = "inicio.php";
  $MM_redirectLoginFailed = "errologin.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_cotizacion, $cotizacion);
  	
  $LoginRS__query=sprintf("SELECT id_usuario, contrasena, rol FROM usuarios WHERE id_usuario=%s AND contrasena=%s",
  GetSQLValueString($loginUsername, "int"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $cotizacion) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'rol');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
  	<link rel="shortcut icon" href="images/logo.PNG">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Imecauca</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    </head>
<body oncontextmenu="return false" onselectstart="return false" ondragstart="return false" oncopy="return false">
	<center>
<img src="images/Banner.png" width="100%" title="Imecol del cauca">
	</center>

        <br>
	    <div class="section-colored text-center">
        <div class="row">
        <div id='mid' class='alert-danger mensajes'><img src='images/error.png' width='40' height='40'/>Upss.! Datos Incorrectos Intentelo de nuevo.</div>
        <form class="form-horizontal" action="<?php echo $loginFormAction; ?>" name="form1" method="POST">
		<div class="control-group">			
		<div class="controls">
		<br>
        <br>	             
		<input type="text"  name="id_usuario" id="id_usuario" placeholder="Usuario"  required autofocus><br><span style="color:#CCC">(Nombre De usuario)</span>
		</div>
		</div>        
		<div class="control-group">			
		<div class="controls">
		<br>
        <br>
		<input type="password" name="password" id="password" placeholder="Contraseña" required><br><span style="color:#CCC">(Contraseña Actual)</span>
		</div>
		</div>
        <br></br>
        <div class="control-group">
		<div class="controls">				
		<button type="submit" name="button" id="button" class="btn  btn-primary">Ingresar</button>
		</div>
		</div>
		</form>
   </div>
</div>
<div class="section row" style="padding:50px">
<h4><font color="#666666">Señor usuario recuerde que este aplicativo fue desarrollado para el manejo de los procesos de la empresa IMECAUCA S.A. asi que por lo tanto sea cuidadoso con el manejo de las contraseñas si surge algun error a la hora de ingresar favor comunicarse con el administrador del aplicativo para poder brindarle una solucion a su problema.</font></h4>
</div><!-- /.section -->

    <div class="row well">
  <div class="col-lg-8 col-md-8">
<h4 style="text-align:left">Este aplicativo es para uso exclusivo de los funcionarios de la empresa.</h4>
<p style="text-align:left">Copyright &copy; IMECAUCA S.A.2013</p>
  </div>
     <div class="col-lg-4 col-md-4">
<img src="images/logo-50.png" width="100" height="100" class="pull-right"/></a>
      </div>
   </div>
</div>
<p class="btn-toolbar">Camilo Cifuentes Web and Graffic Designer.</p>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/modern-business.js"></script>
</body>
</html>