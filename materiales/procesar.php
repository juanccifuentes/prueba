<?php
include_once 'conexion PDO/conexion.php';
sleep(1);
$select=$_POST['select'];
$id=$_POST['id'];


$sth = $con->prepare("UPDATE  `cotizacion`.`materiales` SET  `clasificacion` =  ? WHERE  `materiales`.`id_material` =?;");
$datos = array($select,$id);
$sth->execute($datos);


?>