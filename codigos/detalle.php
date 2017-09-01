<?php include_once("Connections/cotizacion.php");?>
<!DOCTYPE html>
<html>
<head>
<style>
body {
	background: #EEE;	
	font-family: "Trebuchet MS",Verdana,Arial,sans-serif;
	font-size: 14px;
	line-height: 1.6;
}

#content {
	width: 80%;
	margin: 50px auto;
	padding: 20px;
	background: #FFF;	
	border: 1px solid #CCC;
}

h1 {
	margin: 0;
}

hr {
	border: none;
	height: 1px; line-height: 1px;
	background: #CCC;	
	margin-bottom: 20px;
	padding: 0;
}

p {
	margin: 0;	
	padding: 7px 0;
}

.clear {
	clear: both;
	line-height: 1px;
	font-size: 1px;
}

a { 
	outline-color: #888;	
}

table {
		background:#F2F6F6;
		margin-bottom:30px;
		width:96%;
		}
		table thead {
			background:#444;
			color:#eff4f4;
			font-weight:bold;
			text-transform:uppercase;			
			font-family:"Myriad Pro", Verdana, Arial;
			font-size:15px;
			letter-spacing:-1px;
			text-align:left;
			}			
	table th,
	table td {
		padding:10px;
		border-bottom:1px solid #F0F0F0;
		vertical-align:text-top;
		}
		
		
.btn {
  display: inline-block;
  padding: 6px 12px;
  margin-bottom: 0;
  font-size: 10px;
  font-weight: normal;
  line-height: 1.428571429;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  cursor: pointer;
  border: 1px solid transparent;
  border-radius: 4px;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
       -o-user-select: none;
          user-select: none;
}

.btn:focus {
  outline: thin dotted #333;
  outline: 5px auto -webkit-focus-ring-color;
  outline-offset: -2px;
}

.btn:hover,
.btn:focus {
  color: #333333;
  text-decoration: none;
}

.btn:active,
.btn.active {
  background-image: none;
  outline: 0;
  -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
          box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
}

.btn.disabled,
.btn[disabled],
fieldset[disabled] .btn {
  pointer-events: none;
  cursor: not-allowed;
  opacity: 0.65;
  filter: alpha(opacity=65);
  -webkit-box-shadow: none;
          box-shadow: none;
}

.btn-default {
  color: #333333;
  background-color: #ffffff;
  border-color: #cccccc;
}

.btn-default:hover,
.btn-default:focus,
.btn-default:active,
.btn-default.active,
.open .dropdown-toggle.btn-default {
  color: #333333;
  background-color: #ebebeb;
  border-color: #adadad;
}

.btn-default:active,
.btn-default.active,
.open .dropdown-toggle.btn-default {
  background-image: none;
}

.btn-default.disabled,
.btn-default[disabled],
fieldset[disabled] .btn-default,
.btn-default.disabled:hover,
.btn-default[disabled]:hover,
fieldset[disabled] .btn-default:hover,
.btn-default.disabled:focus,
.btn-default[disabled]:focus,
fieldset[disabled] .btn-default:focus,
.btn-default.disabled:active,
.btn-default[disabled]:active,
fieldset[disabled] .btn-default:active,
.btn-default.disabled.active,
.btn-default[disabled].active,
fieldset[disabled] .btn-default.active {
  background-color: #ffffff;
  border-color: #cccccc;
}

.btn-primary {
  color: #ffffff;
  background-color: #990000;
  border-color: #333333;
}

.btn-primary:hover,
.btn-primary:focus,
.btn-primary:active,
.btn-primary.active,
.open .dropdown-toggle.btn-primary {
  color: #ffffff;
  background-color: #CC0000;
  opacity:0.8;
  border-color: #285e8e;
}

.btn-primary:active,
.btn-primary.active,
.open .dropdown-toggle.btn-primary {
  background-image: none;
}

.btn-primary.disabled,
.btn-primary[disabled],
fieldset[disabled] .btn-primary,
.btn-primary.disabled:hover,
.btn-primary[disabled]:hover,
fieldset[disabled] .btn-primary:hover,
.btn-primary.disabled:focus,
.btn-primary[disabled]:focus,
fieldset[disabled] .btn-primary:focus,
.btn-primary.disabled:active,
.btn-primary[disabled]:active,
fieldset[disabled] .btn-primary:active,
.btn-primary.disabled.active,
.btn-primary[disabled].active,
fieldset[disabled] .btn-primary.active {
  background-color: #428bca;
  border-color: #357ebd;
}
</style>
</head>
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
$id=$_GET['id'];
mysql_select_db($database_cotizacion, $cotizacion);
$query_row = "SELECT * FROM cotizaciones c, `costos hombre` ch, vagon v ,  `mano de obra maquina` m
			WHERE c.id_cotizacion = ch.id_cotizacion and c.id_cotizacion = v.id_cotizacion and c.id_cotizacion = $id 
			AND m.`consecutivomachine` = ch.consecutivo";
$row = mysql_query($query_row, $cotizacion) or die(mysql_error());
$row_row = mysql_fetch_assoc($row);
$totalRows_row = mysql_num_rows($row);
?>
<body>
<div id="content">
<h1 align="center">Caracteristicas del Equipo <?php echo $row_row['nombre'];?></h1>
<table>
<tr bgcolor="#CCCCCC">
<td>Longitud</td>
<td>altura del chasis</td>
<td>altura neta</td>
<td>ancho</td>
<td>capacidad volumetrica</td>
<td>capacidad caña picada</td>
<td>capacidad cana larga</td>
<td>Peso del equipo</td>
<td>Total acero</td>
</tr>
<tr>
<td><?php echo $row_row['longitud'];?></td>
<td><?php echo $row_row['altura  chasis'];?></td>
<td><?php echo $row_row['altura neta'];?></td>
<td><?php echo $row_row['ancho'];?></td>
<td><?php echo $row_row['capacidad volumetrica'];?></td>
<td><?php echo $row_row['capacidad cana picada'];?></td>
<td><?php echo $row_row['capacidad cana larga'];?></td>
<td><?php echo $row_row['peso vagon'];?></td>
<td><?php echo $row_row['acero'];?></td>
</tr>
</table>
<h2 align="center">Costos por Centro de trabajo</h2>
<table>
<tr bgcolor="#cccccc" >
<td>Centros de trabajo</td>
<td>Costos indirectos</td>
<td>Hombres</td>
<td>Horas</td>
<td>Total Costo</td>
</tr>
<tr>
<?php do { ?>
<td><?php echo $row_row['centro trabajo'];?></td>
<td><?php echo $row_row['CIF'];?></td>
<td><?php echo $row_row['hombres'];?></td>
<td><?php echo $row_row['horas'];?></td>
<td><?php echo $row_row['total costo'];?></td>
</tr>
<?php } while ($row_row = mysql_fetch_assoc($row)); ?>
</table>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($row);
?>