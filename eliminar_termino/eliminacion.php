<?php
require('conexion.php');

//variable GET
$idemp=$_GET['idempleado'];

//elimina el registro de la tabla empleados
$sql="DELETE FROM terminos WHERE id_termino=$idemp";

mysql_query($sql,$con);

include('consulta.php');
?>