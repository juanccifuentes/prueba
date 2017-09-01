<?php
include('db.php');
if($_POST)
{
$q=$_POST['search'];
$sql_res=mysql_query("select * from materiales where material like '%$q%' or `id_material` like '%$q%' order by material LIMIT 10",$connection) or die("Error en: $busqueda: " . mysql_error());
while($row=mysql_fetch_array($sql_res))
{
$username=$row['material'];
$email=$row['id_material'];
$um=$row['medida'];
$b_username='<strong>'.$q.'</strong>';
$b_email='<strong>'.$q.'</strong>';
$final_username = str_ireplace($q, $b_username, $username);
$final_email = str_ireplace($q, $b_email, $email);
?>
<div class="show" align="left">
<span class="name"><?php echo $final_username; ?></span>&nbsp;<br/><?php echo 'Item Numero '.$final_email.'UM'.$um ?>
</div>
<?php
}
}
?>
 