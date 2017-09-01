<?php
 include "db.php";
 
 @$title=$_POST["title"];
 
 $result=mysql_query("SELECT * FROM `materiales` WHERE material LIKE '%$title%'");
 $found=mysql_num_rows($result);
 
 if($found>0){
    while($row=mysql_fetch_array($result)){
    echo "<li>$row[material]<br>ITEM NUMERO: $row[id_material]</li>";
    }   
 }else{
    echo "<li>No Se Encontaron Coincidencias<li>";
 }
?>