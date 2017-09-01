<?php

$server = "localhost";//nombre del servidor
$usuario = "root";//nombre del usuario
$pwd = "";//contraseña de mysql
$db = "cotizacion";//nombre de la base de datos, en nuestro caso se llama autocompleta


$conexion = mysql_connect($server,$usuario,$pwd);

	if($conexion){

		//echo "conectado<br>";

	}else{

		echo "No hay Conexion";


}


$base = mysql_select_db($db);

	if($base){

		//echo "Conectado a las base de datos: ".$db;

	}else{

		echo "Error en la base de datos";


}


?>
