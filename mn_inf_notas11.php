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
$consulta=$link->query($_POST['sql_']);
$f=40;
$id_ingreso='';
$pag=0;
while($row=$consulta->fetch_array(MYSQLI_ASSOC)){
    if(($id_ingreso<>$row['id_ingreso']) or ($f>=225)){
      $pag++;
      encabezado($pdf,$pag,$row['tipo_iden'],$row['identificacion'],$row['nombres'],$row['apellidos'],$row['id_ingreso'],$row['fecha_ing'],$_POST['descripcion_for'],$row['codigo_cie'],$row['descripcion_cie']);
      $id_ingreso=$row['id_ingreso'];
      $f=51;
    }

    $fa=$f;
    $pdf->SetXY(30,$f);
    $pdf->MultiCell(140,6,$row['observacion'],1,'J');

    $f=$pdf->Gety();
    $df=$f-$fa;

    $pdf->SetXY(5,$fa);
    $pdf->Cell(25,$df,$row['fecha_evol'],1,0,'L');
    
    $firma='firmas/'.$row['ident_oper'].'.png';
    if(file_exists($firma)){
      $pdf->SetXY(170,$fa);
      $pdf->Cell(30,$df,'',1,0,'L');
      $pdf->image($firma,171,$fa+1,29,5);
    }
    else{
      $pdf->SetXY(170,$fa);
      $pdf->Cell(30,$df,$row['ident_oper'],1,0,'L');
    }
}


mysqli_free_result($consulta);
mysqli_close($link);
$pdf->Output();

function encabezado(&$pdf,$pag_,$tipoiden_,$identificacion_,$nombres_,$apellidos_,$ingreso_,$fechaing_,$formato,$cie_,$desccie_){
  $pdf->AddPage();
  $pdf->SetFont('Arial','',10);
  $logo_='icons/logosursalud.png';
  $pdf->image($logo_,5,10,70,20);

  $pdf->SetFont('Arial','',7);
  $pdf->SetXY(80,10);
  $pdf->Cell(30,4,'CODIGO',1,0,'L');
  $pdf->SetXY(110,10);
  $pdf->Cell(30,4,'PMS-05',1,0,'L');
  
  $pdf->SetXY(140,10);
  $pdf->Cell(30,8,'Hoja No.',1,0,'C');
  $pdf->SetXY(170,10);
  $pdf->Cell(30,8,$pag_,1,0,'C');

  $pdf->SetXY(80,14);
  $pdf->Cell(30,4,'VERSION',1,0,'L');
  $pdf->SetXY(110,14);
  $pdf->Cell(30,4,'001',1,0,'L');

  $pdf->SetXY(80,18);
  $pdf->Cell(30,4,'FECHA',1,0,'L');
  $pdf->SetXY(110,18);
  $pdf->Cell(30,4,'31/01/2018',1,0,'L');

  $pdf->SetXY(140,18);
  $pdf->Cell(30,4,'No HISTORIA',1,0,'L');
  $pdf->SetXY(170,18);
  $pdf->Cell(30,4,$identificacion_,1,0,'L');

  $pdf->SetFont('Arial','',10);
  $pdf->SetXY(115,24);
  $pdf->Multicell(50,5,$formato,0,'C');
  $pdf->SetFont('Arial','',7);

  $f=34;
  $pdf->SetXY(5,$f);
  $pdf->Cell(100,4,'Nombre: '.$nombres_.' '.$apellidos_,0,0,'L');
  $pdf->SetXY(150,$f);
  $pdf->Cell(40,4,'Nro. Ingreso: '.$ingreso_,0,0,'L');

  $f+=4;
  $pdf->SetXY(5,$f);
  $pdf->Cell(100,4,utf8_decode('Identificación: ').$tipoiden_.' '.$identificacion_,0,0,'L');
  $pdf->SetXY(150,$f);
  $pdf->Cell(40,4,'Fecha de Ingreso: '.$fechaing_,0,0,'L');

  $f=$f+4;
  $pdf->SetXY(5,$f);
  $pdf->Cell(100,4,'Diagnóstico de Ingreso: '.$cie_.' '.$desccie_,0,0,'L');

  $f+=4;
  $pdf->SetXY(5,$f);
  $pdf->Cell(25,5,'Fecha y Hora',1,0,'C',true);
  $pdf->SetXY(30,$f);
  $pdf->Cell(140,5,utf8_decode('Observación'),1,0,'C',true);
  $pdf->SetXY(170,$f);
  $pdf->Cell(30,5,'Firma',1,0,'C',true);
}
?>
