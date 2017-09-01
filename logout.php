<?php session_start();
//Vaciamos la sesión
$_SESSION = array();
//Borramos cada cookie que tengamos
setcookie("$_SESSION[MM_Username]","",time()-3600,"/","index.php");
//Destruimos la sesión
session_destroy();
//Redirigimos hacia la pagina index.php
header ("Location: index.php"); 
?>