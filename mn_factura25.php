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
//$pdf->AddPage();
$pdf->SetFont('Arial','',7);
$pdf->SetDrawColor(132,132,132);
//$pdf->SetFillColor(164,164,164);
$pdf->SetFillColor(210,207,207);

$link=conectarbd();
$consultaenti="SELECT entidad.nombre_ent,entidad.nit_ent,entidad.direccion_ent,entidad.telefonos_ent,entidad.encabezado_fac FROM entidad";
$consultaenti=$link->query($consultaenti);
$rowenti=$consultaenti->fetch_array(MYSQLI_ASSOC);
//echo $rowenti['nombre_ent'];

$consulta="SELECT id_factura,numero_fac,CONCAT(tipo_iden,' ',identificacion) AS identificacion,CONCAT(nombres,' ',apellidos) AS nombre,nombre_eps,fecha_fac,valor_total,ident_oper,operador,estado_fac FROM vw_factura WHERE id_factura='$_GET[id_factura]'";
//echo $consulta;
$consulta=$link->query($consulta);
$f=40;
$row=$consulta->fetch_array(MYSQLI_ASSOC);
encabezado($pdf,$row['numero_fac'],$rowenti);
    $f=32;
    $pdf->SetFont('Arial','',10);
    $pdf->SetXY(75,$f);
    $pdf->Cell(130,4,'FACTURA  Nro: '.$row['numero_fac'],0,0,'R');
    
    $pdf->SetFont('Arial','',8);
    $f+=4;
    $pdf->SetXY(5,$f);
    $pdf->Cell(40,4,'Eps: '.$row['nombre_eps'],0,'L');
    $pdf->SetXY(75,$f);
    $pdf->Cell(130,4,'Fecha: '.$row['fecha_fac'],0,'L');

    $f+=4;
    $pdf->SetXY(5,$f);
    $pdf->Cell(40,4,'Identificacion: '.$row['identificacion'],0,'L');
    $pdf->SetXY(75,$f);
    $pdf->Cell(130,4,'Nombre: '.$row['nombre'],0,'L');

    $f+=6;
    $pdf->SetXY(5,$f);
    $pdf->Cell(25,5,'Codigo',1,0,'C',true);
    $pdf->SetXY(30,$f);
    $pdf->Cell(100,5,'Descripcion',1,0,'C',true);
    $pdf->SetXY(130,$f);
    $pdf->Cell(25,5,'Cantidad',1,0,'C',true);
    $pdf->SetXY(155,$f);
    $pdf->Cell(25,5,'Valor Unitario',1,0,'C',true);
    $pdf->SetXY(180,$f);
    $pdf->Cell(25,5,'Valor Total',1,0,'C',true);
    $f+=5;
    $consultadet="SELECT codigo_cups,descripcion_cups,cantidad_det,valor_unitario,valor_total FROM vw_detalle_fac WHERE id_factura='$_GET[id_factura]'";
    //echo $consultadet;
    $consultadet=$link->query($consultadet);
    while($rowdet=$consultadet->fetch_array(MYSQLI_ASSOC)){
        $pdf->SetXY(5,$f);
        $pdf->Cell(25,5,$rowdet['codigo_cups'],0,0,'C');
        $pdf->SetXY(30,$f);
        //$pdf->Cell(100,5,$rowdet['descripcion_cups'],0,0,'L');
        $pdf->MultiCell(100,5,$rowdet['descripcion_cups'],0,'L');
        $fprox=$pdf->GetY()+5;
        $pdf->SetXY(130,$f);
        $pdf->Cell(25,5,$rowdet['cantidad_det'],0,0,'C');
        $pdf->SetXY(155,$f);
        $valor_unitario=number_format($rowdet['valor_unitario']);
        $pdf->Cell(25,5,$valor_unitario,0,0,'R');
        $pdf->SetXY(180,$f);
        $valor_total=number_format($rowdet['valor_total']);

        $pdf->Cell(25,5,$valor_total,0,0,'R');
        //$f+=5;
        $f=$fprox;
    }

    $pdf->SetFont('Arial','',9);
    $pdf->SetXY(5,$f);
    $pdf->Cell(175,5,'Total',0,0,'R',true);
    $pdf->SetXY(180,$f);
    $valor_total=number_format($row['valor_total']);
    $pdf->Cell(25,5,$valor_total,0,0,'R',true);
    
    if($row['estado_fac']=='N'){
        $pdf->image('icons/ANULADA.PNG',70,$f+5,70,10);
    }

    $f=$pdf->Gety()+10;
    $firma='firmas/'.$row['ident_oper'].'.PNG';
    if(file_exists($firma)){
      //$pdf->SetXY(5,$f);
      //$pdf->Cell(30,6,'',1,0,'L');
      $pdf->image($firma,10,$f,40,10);
    }
    else{
      $pdf->SetXY(5,$f);
      $pdf->Cell(30,6,$row['ident_oper'],0,0,'L');
    }
    //$f=$pdf->Gety()+10;
    
    $f+=7;
    $pdf->SetXY(5,$f);
    $pdf->Cell(60,6,$row['operador'],0,0,'L');
    $f+=6;
    $pdf->line(5,$f,80,$f);
    //$f+=6;
    $pdf->SetXY(5,$f);
    $pdf->Cell(60,6,'FIRMA',0,'L');
    $pdf->SetXY(100,$f);
    $pdf->Cell(60,6,'SELLO',0,'L');


mysqli_free_result($consulta);
mysqli_close($link);
$pdf->Output();

function encabezado(&$pdf,$numero_fac,$row_){
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
  $pdf->Cell(130,4,$row_['encabezado_fac'],0,0,'C');
}
?>
