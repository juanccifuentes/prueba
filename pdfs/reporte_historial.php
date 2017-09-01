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
?>
<?php 
class EnLetras 
{ 
  var $Void = ""; 
  var $SP = " "; 
  var $Dot = "."; 
  var $Zero = "0"; 
  var $Neg = "Menos"; 
   
function ValorEnLetras($x,$Moneda )  
{ 
    $s=""; 
    $Ent=""; 
    $Frc=""; 
    $Signo=""; 
         
    if(floatVal($x) < 0) 
     $Signo = $this->Neg . " "; 
    else 
     $Signo = ""; 
     
    if(@intval(number_format($x,2,'.','') )!=$x) //<- averiguar si tiene decimales 
     @ $s = number_format($x,2,'.',''); 
    else 
      @$s = number_format($x,2,'.',''); 
        
    $Pto = strpos($s, $this->Dot); 
         
    if ($Pto === false) 
    { 
      $Ent = $s; 
      $Frc = $this->Void; 
    } 
    else 
    { 
      $Ent = substr($s, 0, $Pto ); 
      $Frc =  substr($s, $Pto+1); 
    } 

    if($Ent == $this->Zero || $Ent == $this->Void) 
       $s = "	 "; 
    elseif( strlen($Ent) > 7) 
    { 
       $s = $this->SubValLetra(intval( substr($Ent, 0,  strlen($Ent) - 6))) .  
             "Millones " . $this->SubValLetra(intval(substr($Ent,-6, 6))); 
    } 
    else 
    { 
      $s = $this->SubValLetra(intval($Ent)); 
    } 

    if (substr($s,-9, 9) == "Millones " || substr($s,-7, 7) == "Millón ") 
       $s = $s . "de "; 

  

    if($Frc != $this->Void) 
    { 
      // $s = $s . " " . $Frc. "/100"; 
      // $s = $s . " " . $Frc . "/100"; 
    } 
    $letrass=$Signo . $s . " M.N."; 
    return ($Signo . $s . " Pesos"); 
    
} 


function SubValLetra($numero)  
{ 
    $Ptr=""; 
    $n=0; 
    $i=0; 
    $x =""; 
    $Rtn =""; 
    $Tem =""; 

    $x = trim("$numero"); 
    $n = strlen($x); 

    $Tem = $this->Void; 
    $i = $n; 
     
    while( $i > 0) 
    { 
       $Tem = $this->Parte(intval(substr($x, $n - $i, 1).  
                           str_repeat($this->Zero, $i - 1 ))); 
       If( $Tem != "Cero" ) 
          $Rtn .= $Tem . $this->SP; 
       $i = $i - 1; 
    } 

     
    //--------------------- GoSub FiltroMil ------------------------------ 
    $Rtn=str_replace(" Mil Mil", " Un Mil", $Rtn ); 
    while(1) 
    { 
       $Ptr = strpos($Rtn, "Mil ");        
       If(!($Ptr===false)) 
       { 
          If(! (strpos($Rtn, "Mil ",$Ptr + 1) === false )) 
            $this->ReplaceStringFrom($Rtn, "Mil ", "", $Ptr); 
          Else 
           break; 
       } 
       else break; 
    } 

    //--------------------- GoSub FiltroCiento ------------------------------ 
    $Ptr = -1; 
    do{ 
       $Ptr = strpos($Rtn, "Cien ", $Ptr+1); 
       if(!($Ptr===false)) 
       { 
          $Tem = substr($Rtn, $Ptr + 5 ,1); 
          if( $Tem == "M" || $Tem == $this->Void) 
             ; 
          else           
             $this->ReplaceStringFrom($Rtn, "Cien", "Ciento", $Ptr); 
       } 
    }while(!($Ptr === false)); 

    //--------------------- FiltroEspeciales ------------------------------ 
    $Rtn=str_replace("Diez Un", "Once", $Rtn ); 
    $Rtn=str_replace("Diez Dos", "Doce", $Rtn ); 
    $Rtn=str_replace("Diez Tres", "Trece", $Rtn ); 
    $Rtn=str_replace("Diez Cuatro", "Catorce", $Rtn ); 
    $Rtn=str_replace("Diez Cinco", "Quince", $Rtn ); 
    $Rtn=str_replace("Diez Seis", "Dieciseis", $Rtn ); 
    $Rtn=str_replace("Diez Siete", "Diecisiete", $Rtn ); 
    $Rtn=str_replace("Diez Ocho", "Dieciocho", $Rtn ); 
    $Rtn=str_replace("Diez Nueve", "Diecinueve", $Rtn ); 
    $Rtn=str_replace("Veinte Un", "Veintiun", $Rtn ); 
    $Rtn=str_replace("Veinte Dos", "Veintidos", $Rtn ); 
    $Rtn=str_replace("Veinte Tres", "Veintitres", $Rtn ); 
    $Rtn=str_replace("Veinte Cuatro", "Veinticuatro", $Rtn ); 
    $Rtn=str_replace("Veinte Cinco", "Veinticinco", $Rtn ); 
    $Rtn=str_replace("Veinte Seis", "Veintiseís", $Rtn ); 
    $Rtn=str_replace("Veinte Siete", "Veintisiete", $Rtn ); 
    $Rtn=str_replace("Veinte Ocho", "Veintiocho", $Rtn ); 
    $Rtn=str_replace("Veinte Nueve", "Veintinueve", $Rtn ); 

    //--------------------- FiltroUn ------------------------------ 
    If(substr($Rtn,0,1) == "M") $Rtn = "Un " . $Rtn; 
    //--------------------- Adicionar Y ------------------------------ 
    for($i=65; $i<=88; $i++) 
    { 
      If($i != 77) 
         $Rtn=str_replace("a " . Chr($i), "* y " . Chr($i), $Rtn); 
    } 
    $Rtn=str_replace("*", "a" , $Rtn); 
    return($Rtn); 
} 


function ReplaceStringFrom(&$x, $OldWrd, $NewWrd, $Ptr) 
{ 
  $x = substr($x, 0, $Ptr)  . $NewWrd . substr($x, strlen($OldWrd) + $Ptr); 
} 


function Parte($x) 
{ 
    $Rtn=''; 
    $t=''; 
    $i=''; 
    Do 
    { 
      switch($x) 
      { 
         Case 0:  $t = "Cero";break; 
         Case 1:  $t = "Un";break; 
         Case 2:  $t = "Dos";break; 
         Case 3:  $t = "Tres";break; 
         Case 4:  $t = "Cuatro";break; 
         Case 5:  $t = "Cinco";break; 
         Case 6:  $t = "Seis";break; 
         Case 7:  $t = "Siete";break; 
         Case 8:  $t = "Ocho";break; 
         Case 9:  $t = "Nueve";break; 
         Case 10: $t = "Diez";break; 
         Case 20: $t = "Veinte";break; 
         Case 30: $t = "Treinta";break; 
         Case 40: $t = "Cuarenta";break; 
         Case 50: $t = "Cincuenta";break; 
         Case 60: $t = "Sesenta";break; 
         Case 70: $t = "Setenta";break; 
         Case 80: $t = "Ochenta";break; 
         Case 90: $t = "Noventa";break; 
         Case 100: $t = "Cien";break; 
         Case 200: $t = "Doscientos";break; 
         Case 300: $t = "Trescientos";break; 
         Case 400: $t = "Cuatrocientos";break; 
         Case 500: $t = "Quinientos";break; 
         Case 600: $t = "Seiscientos";break; 
         Case 700: $t = "Setecientos";break; 
         Case 800: $t = "Ochocientos";break; 
         Case 900: $t = "Novecientos";break; 
         Case 1000: $t = "Mil";break; 
         Case 1000000: $t = "Millón";break; 
      } 

      If($t == $this->Void) 
      { 
        $i = $i + 1; 
        $x = $x / 1000; 
        If($x== 0) $i = 0; 
      } 
      else 
         break; 
            
    }while($i != 0); 
    
    $Rtn = $t; 
    Switch($i) 
    { 
       Case 0: $t = $this->Void;break; 
       Case 1: $t = " Mil";break; 
       Case 2: $t = " Millones";break; 
       Case 3: $t = " Billones";break; 
    } 
    return($Rtn . $t); 
} 

} 
 
?>
<?php 
require('fpdf/fpdf.php');
require('conexion.php');
class PDF extends FPDF
{
var $widths;
var $aligns;

function SetWidths($w)
{
	//Set the array of column widths
	$this->widths=$w;
}

function SetAligns($a)
{
	//Set the array of column alignments
	$this->aligns=$a;
}

function Row($data)
{
	//Calculate the height of the row
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=5*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		//Draw the border
		
		$this->Rect($x,$y,$w,$h);

		$this->MultiCell($w,5,$data[$i],0,$a,'true');
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	$this->Ln($h);
}

function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
	//Computes the number of lines a MultiCell of width w will take
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}

function Header()
{

	$this->SetFont('Arial','',15);
	$this->Image('fpdf/logo.jpg' , 20,5, 50, 12);
	$this->Text(75,17,'PROFORMA COMERCIAL',0,'C', 0);
	$this->Ln(30);
}

function Footer()
{
	$this->SetY(-15);
	$this->SetFont('Arial','B',8);
	$this->Image('fpdf/marca.JPG' , 150,240,70,65);
	$this->Cell(170,15,'Calle 42 N0. 43-10 Barrio Fray Luis Amigo '.$this->ln(5).' Centro Agroindustrial Telefono 2817221-2818795 Palmira - Valle',0,0,'C');
	}
}
 	//--------------------------------------*VARIABLES*-----------------------------------------\\
	$id_cot= $_GET['id'];
	$con = new DB;
	$id_cots = $con->conectar();	
	$strConsulta = "SELECT * from cotizaciones where id_cotizacion =  '$id_cot'";
	$id_cots = mysql_query($strConsulta);
	$fila = mysql_fetch_array($id_cots);

	$pdf=new PDF('P','mm','A4');
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(20,20,20);
	$pdf->Ln(0);
	$dias  = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$hora  = $dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
	
	$query_RecordsetM = "SELECT SUM( `CIF` ) AS total FROM `mano de obra maquina` WHERE id_cotizacion = $id_cot";
	$RecordsetM = mysql_query($query_RecordsetM) or die(mysql_error());
	$row_RecordsetM = mysql_fetch_assoc($RecordsetM);
	$totalRows_RecordsetM = mysql_num_rows($RecordsetM);
	$cif=$row_RecordsetM['total'];

	$query_RecordsetT = "SELECT SUM( `total costo` ) AS total FROM `costos hombre` WHERE id_cotizacion = $id_cot";
	$RecordsetT = mysql_query($query_RecordsetT) or die(mysql_error());
	$row_RecordsetT = mysql_fetch_assoc($RecordsetT);
	$totalRows_RecordsetT = mysql_num_rows($RecordsetT);
	$cdh=$row_RecordsetT['total'];

	$query_sum = "SELECT SUM( `precio` ) AS total FROM `material/cotizacion` m, materiales m_m WHERE id_cotizacion = $id_cot AND m.id_material = m_m.id_material";
	$sum = mysql_query($query_sum) or die(mysql_error());
	$row_sum = mysql_fetch_assoc($sum);
	$totalRows_sum = mysql_num_rows($sum);
	$cdm=$row_sum['total'];

	$query_summ = "SELECT SUM( `acero` ) AS total FROM `vagon` WHERE id_cotizacion = $id_cot";
	$summ = mysql_query($query_summ) or die(mysql_error());
	$row_summ = mysql_fetch_assoc($summ);
	$totalRows_summ = mysql_num_rows($summ);
	$cdv=$row_summ['total'];
	
/*SELECT * 
FROM  `material/cotizacion` m, materiales m_m
WHERE id_cotizacion =8
AND m.id_material = m_m.id_material*/

	$neto=$cif+$cdh+$cdm+$cdv;
	$letras=$neto; 
	$iva=$neto*0.16;
	//$pago=$row['forma_pago'];
	
	$Precioventa=$iva+$neto;
	
	@$V=new EnLetras(); 
    $lettter=strtoupper($V->ValorEnLetras($letras,"pesos"));
	
	function formatMoney($number, $fractional=false) { 
    if ($fractional) { 
        $number = sprintf('%.2f', $number); 
    } 
    while (true) { 
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number); 
        if ($replaced != $number) { 
            $number = $replaced; 
    } else { 
    break; 
    } 
    } 
    return $number; 
	} 
	if(@$fila['id_cotizacion'] != null)
	{
	//--------------------------------------*FIN VARIABLES :[*-----------------------------------------\\
	$pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,5,'Proforma Numero:  00'.$fila['id_cotizacion'].'A',0,1);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(0,6,'Fecha: Palmira,  '.$hora,0,1);
	$pdf->Cell(0,6,'Cliente: '.$fila['cliente'],0,1); 
	$pdf->Cell(0,6,'Descripcion: Propuesta por la '.$fila['descripcion'],0,1); 
	$pdf->ln();
	$pdf->Cell(0,6,'Atendiendo su solicitud presentamos nuestra proforma No. 00'.$fila['id_cotizacion'].'A por la ',0,1); 
	$pdf->Cell(0,6,utf8_decode($fila['descripcion'].' con las características detalladas según Referencia 156-1'),0,1);
	
    $pdf->ln();
	$pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,5,'TERMINOS TECNICOS DE REFERENCIA Y ALCANCE DE LA PROPUESTA:',0,0,'L');
	$pdf->SetFont('Arial','',12);
	$pdf->Ln(10);
	$pdf->Cell(0,5,'Descripcion: Propuesta por '.$fila['descripcion'],0,1,'L'); 
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0);
	$f=0;
	$sql = "select * from terminos WHERE id_cotizacion = '$id_cot' ";
	$summados = mysql_query($sql);
	while($row = mysql_fetch_array($summados)) { 
	$titulo= $row["titulo"];
	$descripciontermino=$row["descripcion_ter"];
	$descripcion = $fila["descripcion"];
	
	
	for($i=0;$i<1;$i++)
	{$f++;
	$pdf->SetFont('Arial','B',12);
	$pdf->Row(array($f.'.'.$titulo.':'));
	$pdf->SetFont('Arial','',12);
	$pdf->Row(array($descripciontermino));
	$pdf->ln();
	}
	}
	$sql = "SELECT * FROM clausulas WHERE id_cotizacion =$id_cot";
	$termi = mysql_query($sql) or die (mysql_error());
	while($row = mysql_fetch_array($termi)) { 
	$pago=$row['forma_pago'];
	$plazo=$row['entrega'];
	$garantia=$row['garantia'];
	$nota=$row['Nota'];
	}
		
	$pdf->SetFont('arial','b',12);
	$pdf->Cell(0,6,'PROPUESTA ECONOMICA',0,1); 
	$pdf->ln();
	$pdf->SetWidths(array(80, 12, 36, 50, 20));
	$pdf->SetFont('Arial','B',10);
	$pdf->SetFillColor(215,215,215);
    $pdf->SetTextColor(0);
	$pdf->Row(array('DESCRIPCION', 'CANT', 'Precio venta($/UND)', 'Precio venta'));
	$pdf->SetFont('Arial','',11);
	$pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0);
	$pdf->Row(array(@$fila['descripcion'],'1','$'.formatMoney($neto),'$'.formatMoney($neto)));
	$pdf->Row(array('Subtotal','','','$'.formatMoney($neto)));
	$pdf->Row(array('IVA','','','$'.formatMoney($iva)));
	$pdf->Row(array('TOTAL','','','$'.formatMoney($Precioventa)));	
	$pdf->SetFont('Arial','',12);
	$pdf->ln(5);
	$pdf->SetWidths(160, 12, 36, 25, 18);
	$pdf->SetFont('Arial','',12);
 	$pdf->Row(array(utf8_decode('EL PRECIO OFERTADO ES DE: ')));
	$pdf->SetFont('Arial','B',12);
	$pdf->Row(array(utf8_decode($lettter.' ,MAS IVA.')));
	$pdf->ln(5);
	$pdf->SetFont('Arial','',12);
	if(@$nota != null)
	{
	$pdf->Row(array('Nota : '.@$nota.'.'));
	$pdf->ln(5);
	}
	if(@$pago != null)
	{
	$pdf->Cell(0,6,(utf8_decode('FORMA DE PAGO '.@$pago.'  dias calendario contra entrega.'))); 
	}
	if(@$plazo != null)
	{
	$pdf->ln(10);
	$pdf->Cell(0,6,(utf8_decode('PLAZO DE ENTREGA '.@$plazo.' días hábiles contra entrega de orden.')));
	$pdf->ln(10);
	}
	if(@$garantia != null)
	{
	$pdf->Row(array(utf8_decode('GARANTIA: '.@$garantia.' meses de garantía contra cualquier defecto de fabricación y de materiales 		   	suministrados por nosotros, encontrados por fuera de los términos de
	referencia establecidos y estando el producto debidamente manejado y operando 
	bajo condiciones normales de funcionamiento.')));
	$pdf->ln(15);
	}
	$pdf->Cell(0,6,'IMECAUCA S.A.',0,1,'C');
	$pdf->SetFont('Arial','',12);
	$pdf->Row(array(utf8_decode('Está comprometido con el mejoramiento continuo de los productos y servicios del cliente y espera satisfacer sus expectativas con esta propuesta.')));
	$pdf->ln(20);
	$pdf->SetFont('Arial','b',12);
	$pdf->Cell(0,6,'Cordial saludo ',0,1,'L');
	$pdf->ln(15);
	$pdf->Image('fpdf/firma.JPG');
	$pdf->SetFont('Arial','b',12);
	$pdf->Cell(0,6,'CARLOS ARTURO TORO',0,1,'L');
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(0,6,utf8_decode('Gerente de Fabricación.'),0,1,'L');
	$pdf->Cell(0,6,'Cel.: 311 358 18 64 ',0,1,'L');
	$pdf->Cell(0,6,'Tel. 2818795 - 2817221 Ext. 215 Palmira-Valle  ',0,1,'L');
$pdf->Output();
	}
?>