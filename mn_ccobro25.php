<?php
session_start();
if(!isset($_SESSION['gid_usuario'])){
    ?>
        <script type="text/javascript">
            alert("La sesion ha finalizado. \nIngrese nuevamente");
            window.open('blanco.html','_self',''); 
            window.close(); 
        </script>
    <?php
}

require("mn_funciones.php");
require('fpdf.php');
$pdf=new FPDF('P','mm','Letter');
$pdf->SetFont('Arial','',7);
$pdf->SetDrawColor(132,132,132);
//$pdf->SetFillColor(164,164,164);
$pdf->SetFillColor(210,207,207);

$link=conectarbd();
$consultaenti="SELECT entidad.nombre_ent,entidad.nit_ent,entidad.direccion_ent,entidad.telefonos_ent,entidad.encabezado_fac FROM entidad";
$consultaenti=$link->query($consultaenti);
$rowenti=$consultaenti->fetch_array(MYSQLI_ASSOC);
//echo $rowenti['nombre_ent'];

$consulta="SELECT numero_ccob,nit,nombre_eps,fecha_ccob,concepto_ccob FROM vw_cuenta_cobro WHERE id_ccob='$_GET[id_ccob]'";
//echo $consulta;
$consulta=$link->query($consulta);
$f=40;
$row=$consulta->fetch_array(MYSQLI_ASSOC);
encabezado($pdf,$rowenti);
$f=40;
$pdf->SetFont('Arial','',11);
$pdf->SetXY(10,$f);
$fecha_ccob=date_create($row['fecha_ccob']);
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$mes=$meses[date('m', strtotime($row['fecha_ccob']))-1];
$fecha_ccob=date_format($fecha_ccob,"d").' de '.$mes.' de '.date_format($fecha_ccob,"Y");
$pdf->Cell(130,4,'San Juan de Pasto, '.$fecha_ccob,0,0,'L');
$f+=10;
$pdf->SetXY(10,$f);
$pdf->Cell(190,4,'CUENTA DE COBRO',0,0,'C');
$f+=5;
$pdf->SetXY(10,$f);
$pdf->Cell(190,4,$row['numero_ccob'],0,0,'C');
$f+=8;
$pdf->SetXY(10,$f);
$pdf->Cell(190,4,$row['nombre_eps'],0,0,'C');
$f+=5;
$pdf->SetXY(10,$f);
$pdf->Cell(190,4,'NIT: '.$row['nit'],0,0,'C');

$f+=8;
$pdf->SetXY(10,$f);
$pdf->Cell(190,4,'DEBE A:',0,0,'C');
$f+=8;
$pdf->SetXY(10,$f);
$pdf->Cell(190,4,$rowenti['nombre_ent'],0,0,'C');

$f+=8;
$pdf->SetXY(10,$f);
$pdf->Cell(190,4,'POR CONCEPTO DE:',0,0,'C');
$f+=8;
$pdf->SetXY(10,$f);
$pdf->MultiCell(190,5,utf8_decode($row['concepto_ccob']),0,'J');

$f=$pdf->GetY();
$f+=5;
$consultadet="SELECT CONCAT(pnombre,' ',snombre,' ',papellido,' ',sapellido) AS nombre,edad,sexo,codigo_cups,codigo_cie,numero_fac,autoriza_fac,total FROM vw_detalle_ccob WHERE id_ccob='$_GET[id_ccob]'";
//echo $consultadet;
$consultadet=$link->query($consultadet);
    $pdf->SetFont('Arial','',7);
    $pdf->SetXY(10,$f);
    $pdf->Cell(70,5,'Nombre',1,0,'C');
    $pdf->SetXY(80,$f);
    $pdf->Cell(7,5,'Edad',1,0,'C');
    $pdf->SetXY(87,$f);
    $pdf->Cell(10,5,'Genero',1,0,'C');
    $pdf->SetXY(97,$f);
    $pdf->Cell(20,5,'Cups',1,0,'C');
    $pdf->SetXY(117,$f);
    $pdf->Cell(20,5,'Autorizacion',1,0,'C');
    $pdf->SetXY(137,$f);
    $pdf->Cell(20,5,'Dx Princ',1,0,'C');
    //$pdf->SetXY(152,$f);
    //$pdf->Cell(15,5,'Dx Sec',1,0,'C');
    $pdf->SetXY(157,$f);
    $pdf->Cell(15,5,'Factura',1,0,'C');
    $pdf->SetXY(172,$f);
    $pdf->Cell(25,5,'Valor',1,0,'C');
    $f+=5;
    $total=0;
    while($rowdet=$consultadet->fetch_array(MYSQLI_ASSOC)){
        $pdf->SetXY(10,$f);
        $pdf->Cell(70,5,$rowdet['nombre'],1,0,'L');
        $pdf->SetXY(80,$f);
        $pdf->Cell(7,5,$rowdet['edad'],1,0,'C');
        $pdf->SetXY(87,$f);
        $pdf->Cell(10,5,$rowdet['sexo'],1,0,'C');
        $pdf->SetXY(97,$f);
        $pdf->Cell(20,5,$rowdet['codigo_cups'],1,0,'L');

        $pdf->SetXY(117,$f);
        $pdf->Cell(20,5,$rowdet['autoriza_fac'],1,0,'C');
        $pdf->SetXY(137,$f);
        $pdf->Cell(20,5,$rowdet['codigo_cie'],1,0,'C');
        //$pdf->SetXY(152,$f);
        //$pdf->Cell(15,5,'Dx Sec',1,0,'C');
        $pdf->SetXY(157,$f);
        $pdf->Cell(15,5,$rowdet['numero_fac'],1,0,'C');
        $pdf->SetXY(172,$f);
        //$pdf->Cell(15,5,$rowdet['total'],1,0,'R');
        $pdf->Cell(25,5,number_format($rowdet['total'],2,'.',','),1,0,'R');
        //number_format($rowdet['total'],2,'.',',')
        $total=$total+$rowdet['total'];
        $f+=5;
    }
    $pdf->SetXY(10,$f);
    $pdf->Cell(162,5,'TOTAL',1,0,'R');
    $pdf->SetXY(172,$f);
    $pdf->Cell(25,5,number_format($total,2,'.',','),1,0,'R');

    $f+=10;
    $pdf->SetFont('Arial','',11);
    $pdf->SetXY(10,$f);
    $pdf->Cell(175,5,'Atentamente,',0,0,'L');
    $f+=20;
    $pdf->SetXY(10,$f);
    $pdf->Cell(175,5,'EDISON GUSTAVO BURGOS CH.',0,0,'L');
    $f+=5;
    $pdf->SetXY(10,$f);
    $pdf->Cell(175,5,'Gerente',0,0,'L');
    

mysqli_free_result($consulta);
mysqli_close($link);
$pdf->Output();

function encabezado(&$pdf,$row_){
  $pdf->AddPage();
  $pdf->SetFont('Arial','',15);
  $logo_='icons/logosursalud.png';
  $pdf->image($logo_,5,10,70,20);

  $pdf->SetXY(75,10);
  $pdf->Cell(130,4,$row_['nombre_ent'],0,0,'C');
  $pdf->SetFont('Arial','',7);
  $pdf->SetXY(75,15);
  $pdf->Cell(130,4,'Nit: '.$row_['nit_ent'],0,0,'C');
  $pdf->SetXY(75,19);
  $pdf->Cell(130,4,$row_['direccion_ent'],0,0,'C');
  $pdf->SetXY(75,23);
  $pdf->Cell(130,4,$row_['telefonos_ent'],0,0,'C');
  $pdf->SetXY(75,27);
}
?>
