<?php
include("Connections/cotizacion.php");//se incluyen los datos para realizar la conexion a su base de datos
@$id=$_GET["id"];
?>
<?php
session_start();
$_SESSION['id']=$id;

$sql = "SELECT * FROM cotizacion.cotizaciones WHERE id_cotizacion =$id";
	$termi = mysql_query($sql) or die (mysqli_error());
	while($columna = mysql_fetch_array($termi)) { 
	$cliente=$columna['cliente'];
	$cotdes=$columna['descripcion'];
	}

?>
<!doctype html>
<html>
<head>
<script type="text/javascript" src="js/moodalbox.js" 			></script> 
<script type="text/javascript" src="js/mootools.js" 			></script> 
<script type="text/javascript" src="js/mootools.v1.00.full.js"  ></script> 
<script type="text/javascript" src="js/moodalbox.v1.2.full.js"  ></script> 
<script type="text/javascript" src="ajax.js" 					></script>
<script type="text/javascript" src="jquery-1.8.0.min.js"		></script>
<script type="text/javascript">
$(function(){
$(".search").keyup(function() 
{ 
var searchid = $(this).val();
var dataString = 'search='+ searchid;
if(searchid!='')
{
	$.ajax({
	type: "POST",
	url: "search.php",
	data: dataString,
	cache: false,
	success: function(html)
	{
	$("#result").html(html).show();
	}
	});
}return false;    
});

jQuery("#result").live("click",function(e){ 
	var $clicked = $(e.target);
	var $name = $clicked.find('.name').html();
	var decoded = $("<div/>").html($name).text();
	$('#searchid').val(decoded);
});
jQuery(document).live("click", function(e) { 
	var $clicked = $(e.target);
	if (! $clicked.hasClass("search")){
	jQuery("#result").fadeOut(); 
	}
});
$('#searchid').click(function(){
	jQuery("#result").fadeIn();
});
});
</script>
<style type="text/css">
	body{ 
		font-family:Tahoma, Geneva, sans-serif;
		font-size:18px;
	}
	.content{
		
		margin:0 auto;
	}
	#searchid
	{
		width:500px;
		border:solid 1px #000;
		padding:10px;
		font-size:14px;
	}
	#result
	{
		position:absolute;
		width:50%;
		padding:1%;
		display:none;
		margin-top:-1px;
		border-top:0px;
		overflow:hidden;
		border:1px #CCC solid;
		background-color: white;
	}
	.show
	{
		padding:10px; 
		border-bottom:1px #999 dashed;
		font-size:15px; 
		height:50px;
	}
	.show:hover
	{
		background:#4c66a4;
		color:#FFF;
		cursor:pointer;
	}
	
</style>
<link href="css/moodalbox.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">
 </head>
 <body>
 <div id="content">
<h1 align="center">Materiales Para <?php  echo $cliente.'Por la '.$cotdes ?></h1>
<table width="100%" align="center">
<form name="nuevo_empleado2" action="" onsubmit="enviarDatosEmpleado(); return false"  id="tags">
<tr><td align="center">
<input type="text" class="search" id="searchid" placeholder="Material" name="centro_trabajo"  autocomplete="off" required/>
<div id="result"></div>
</td></tr>
<tr><td align="center"> 
<input type="text" name="Precio_hora" id="searchid"  placeholder="cantidad" autocomplete="off" required >
</td></tr>
<tr><td align="center">
<a href="materiales.php" rel="moodalbox  500 800" target="_blank">Todos los Items</a>
<input type="hidden" name="Uso_maquina" placeholder="Uso maquina" autocomplete="off" >
<input type="hidden" name="hora" maxlength="4"  placeholder="Hora maquina"  required>
<input  type="hidden" name="id_cotizacion"  value="<?php echo $id ?>"><br><br>
<input type="submit" name="Submit" value="Agregar"/>
</td></table>
<div id="resultado"><?php include('consulta.php');?></div>
</div>       
</body>
</html>
<script>

function soloNumeros(e) {
    tecla = (document.all)?e.keyCode:e.which;
    if (tecla==8) return true;
    patron = /\d/;
    te = String.fromCharCode(tecla);
    return patron.test(te); 
} 
</script>

