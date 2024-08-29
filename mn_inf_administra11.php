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
    if(($id_ingreso<>$row['id_ingreso']) or ($f>=240)){
      $pag++;
      encabezado($pdf,$pag,$row['tipo_iden'],$row['identificacion'],$row['nombres'],$row['apellidos'],$row['id_ingreso'],$row['fecha_ing']);
      $id_ingreso=$row['id_ingreso'];
      $f=47;
    }

    $fa=$f;
    $pdf->SetXY(30,$f);
    $pdf->MultiCell(90,6,$row['producto'],1,'J');

    $f=$pdf->Gety();
    $df=$f-$fa;

    $pdf->SetXY(5,$fa);
    $pdf->Cell(25,$df,$row['fecha_mov'],1,0,'L');
    $pdf->SetXY(120,$fa);
    $pdf->Cell(10,$df,$row['cantidad'],1,0,'R');
    $pdf->SetXY(130,$fa);
    $pdf->Cell(20,$df,$row['dosis'],1,0,'L');
    $pdf->SetXY(150,$fa);
    $pdf->Cell(20,$df,$row['via'],1,0,'L');
    $firma='firmas/'.$row['ident_oper'].'.jpg';
    if(file_exists($firma)){
      $pdf->SetXY(170,$fa);
      $pdf->Cell(30,$df,'',1,0,'L');
      //$pdf->image($firma,171,$fa+1,29,5);
    }
    else{
      $pdf->SetXY(170,$fa);
      $pdf->Cell(30,$df,$row['ident_oper'],1,0,'L');
    }
}
mysqli_free_result($consulta);
mysqli_close($link);
$pdf->Output();

function encabezado(&$pdf,$pag_,$tipoiden_,$identificacion_,$nombres_,$apellidos_,$ingreso_,$fechaing_){
  $pdf->AddPage();
  $logo_='icons/logosursalud.png';
  $pdf->image($logo_,5,10,70,20);

  $pdf->SetXY(125,10);
  $pdf->Cell(20,4,'CODIGO',1,0,'C');
  $pdf->SetXY(145,10);
  $pdf->Cell(20,4,'VERSION',1,0,'C');
  $pdf->SetXY(165,10);
  $pdf->Cell(35,4,'FECHA DE ELABORACION',1,0,'C');

  $pdf->SetXY(125,14);
  $pdf->Cell(20,4,'PMS-03',1,0,'C');
  $pdf->SetXY(145,14);
  $pdf->Cell(20,4,'001',1,0,'C');
  $pdf->SetXY(165,14);
  $pdf->Cell(35,4,'31-ene-18',1,0,'C');

  $pdf->SetFont('Arial','',10);
  $pdf->SetXY(75,22);
  $pdf->Cell(125,4,'REGISTRO DE MEDICAMENTOS',0,0,'C');
  $pdf->SetXY(75,26);
  $pdf->Cell(125,4,'Y DISPOSITIVOS MEDICOS',0,0,'C');
  $pdf->SetFont('Arial','',7);

  $pdf->SetXY(5,30);
  $pdf->Cell(15,4,'Hoja No.',0,0,'L');
  $pdf->SetXY(20,30);
  $pdf->Cell(10,4,$pag_,0,0,'L');
  
  $f=34;
  $pdf->SetXY(5,$f);
  $pdf->Cell(100,4,'Nombre: '.$nombres_.' '.$apellidos_,0,0,'L');
  $pdf->SetXY(180,$f);
  $pdf->Cell(20,4,'Nro. Ingreso: '.$ingreso_,0,0,'L');

  $f+=4;
  $pdf->SetXY(5,$f);
  $pdf->Cell(100,4,utf8_decode('IdentificaciÃ³n: ').$tipoiden_.' '.$identificacion_,0,0,'L');
  $pdf->SetXY(165,$f);
  $pdf->Cell(35,4,'Fecha de Ingreso: '.$fechaing_,0,0,'L');

  $f+=4;
  $pdf->SetXY(5,$f);
  $pdf->Cell(25,5,'Fecha y Hora',1,0,'C',true);
  $pdf->SetXY(30,$f);
  $pdf->Cell(90,5,'Medicamento/Dispositivo M¨¦dico',1,0,'C',true);
  $pdf->SetXY(120,$f);
  $pdf->Cell(10,5,'Cantidad',1,0,'C',true);
  $pdf->SetXY(130,$f);
  $pdf->Cell(20,5,'Dosis',1,0,'C',true);
  $pdf->SetXY(150,$f);
  $pdf->Cell(20,5,'Via',1,0,'C',true);
  $pdf->SetXY(170,$f);
  $pdf->Cell(30,5,'Responsable',1,0,'C',true);
}
?>
