<?php require_once('Connections/cotizacion.php'); ?>
<?php
$colname_hombres = "-1";
if (isset($_GET['consecutivo'])) {
  $colname_hombres = $_GET['consecutivo'];
  }

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

@$resultados = mysql_query("SELECT `centro trabajo` FROM `mano de obra maquina` WHERE consecutivo=$a");
		while(@$row = mysql_fetch_array($resultados)) { 
		@$centro=$row['consecutivo'];
		} 
@$a=$row_hombres['consecutivo'];

//variables POST
  @$centro=$_POST['centro_trabajo'];
  @$uso=$_POST['Uso_maquina'];
  @$horamaquina=$_POST['hora_maquina'];
  @$costotal=$_POST['total'];
  @$id=$_POST['id_cotizacion'];


if ($centro == 'armado') {
$preciohora = 6462;
}

if ($centro == 'soldadura-SMAW') {
$preciohora= 7313;
}

if ($centro == 'soldadura-SAW') {
$preciohora= 7313;
}

if ($centro == 'soldadura-MIG') {
$preciohora= 7313;
}

if ($centro == 'doblado') {
$preciohora= 11578;
}

if ($centro == 'torno') {
$preciohora= 7074;
}

if ($centro == 'taladro de fresa') {
$preciohora= 7074;
}

if ($centro =='taladro de radi') {
$preciohora= 7074;
}

if ($centro == 'ensamble') {
$preciohora= 6849;
}

if ($centro == 'terminado') {
$preciohora= 4492;
}

if ($centro == 'cizalla') {
$preciohora= 11578;
}

if ($centro == 'oxicorte') {
$preciohora= 6849;
}

if ($centro == 'plasma') {
$preciohora= 7827;
}

if ($centro == 'aserrado') {
$preciohora= 7074;
}

if ($centro == 'rolado') {
$preciohora= 11578;
}
	  
//variables POST
@$centro=$_POST['centro_trabajo'];
@$hombres=$_POST['hombres'];
@$horas=$_POST['jornales'];
@$id=$_POST['id_cotizacion'];
@	$con=$_POST['consecutivo'];

//Variables Calculadas

@$horastotales=($hombres*$horas);
@$preciohorahombre=9600;
@$costohombre=$preciohora*$horas;
@$costotal=($preciohorahombre*$horastotales+$costohombre);
@$cif=$preciohora*$horas; 


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
$updateSQL = sprintf("UPDATE `costos hombre` c,`mano de obra maquina`ch
SET c.`centro trabajo`='$centro', c. hombres = $hombres, c. horas=$horas,c.`total costo`= $costotal,c.id_cotizacion=$id ,c.consecutivo=$con , ch.`centro trabajo`='$centro' , ch. `precio hora`=$preciohora,ch. `uso maquina` = 100 , ch. `hora maquina`=$horas , ch.CIF=$cif , ch.id_cotizacion=$id
WHERE ch.CONSECUTIVOMACHINE = c.CONSECUTIVO
AND ch.consecutivomachine =  $colname_hombres ");



  mysql_select_db($database_cotizacion, $cotizacion);
  $Result1 = mysql_query($updateSQL, $cotizacion) or die(mysql_error());

  $updateGoTo = "../costos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


mysql_select_db($database_cotizacion, $cotizacion);
$query_hombres = sprintf("SELECT * FROM `costos hombre` WHERE consecutivo = $colname_hombres");
$hombres = mysql_query($query_hombres, $cotizacion) or die(mysql_error());
$row_hombres = mysql_fetch_assoc($hombres);
$totalRows_hombres = mysql_num_rows($hombres);

mysql_free_result($hombres);
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Centro trabajo:</td>
      <td><select name="centro_trabajo">
      <option value="armado">			Armado					</option>
      <option value="soldadura-SMAW">	Soldadura-SMAW			</option>
      <option value="soldadura-SAW">	Soldadura-SAW			</option>
      <option value="soldadura-MIG">	Soldadura-MIG			</option>
      <option value="doblado">			Doblado					</option>
      <option value="torno">			Torno					</option>
      <option value="taladro de fresa">	Taladro de fresa 		</option>
      <option value="taladro de radi">	Taladro de radi			</option>
      <option value="ensamble">			Ensamble				</option>
      <option value="cizalla">			Cizalla					</option>
      <option value="oxicorte">			Oxicorte				</option>			
      <option value="rolado">			Rolado					</option>
      <option value="terminado">		Terminado				</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Hombres:</td>
      <td><input type="text" name="hombres" value="<?php echo htmlentities($row_hombres['hombres'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Horas:</td>
      <td><input type="text" name="jornales" value="<?php echo htmlentities($row_hombres['horas'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
     
      <td><input type="hidden" name="horas" value="<?php echo htmlentities($row_hombres['horas'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    
    <tr valign="baseline">
      
      <td><input type="hidden" name="total_costo" value="<?php echo htmlentities($row_hombres['total costo'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <td><input type="hidden" name="id_cotizacion" value="<?php echo htmlentities($row_hombres['id_cotizacion'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="consecutivo" value="<?php echo $row_hombres['consecutivo']; ?>">
</form>

