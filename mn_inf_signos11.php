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
      encabezado($pdf,$pag,$row['tipo_iden'],$row['identificacion'],$row['nombres'],$row['apellidos'],$row['id_ingreso'],$row['fecha_ing']);
      $id_ingreso=$row['id_ingreso'];
      $f=47;
    }

    $fa=$f;
    $pdf->SetXY(105,$f);
    $pdf->MultiCell(65,6,$row['observacion_sign'],1,'J');

    $f=$pdf->Gety();
    $df=$f-$fa;

    $pdf->SetXY(5,$fa);
    $pdf->Cell(25,$df,$row['fecha_sign'],1,0,'L');

    $pdf->SetXY(30,$fa);
    $pdf->Cell(15,$df,$row['tasistol_sign'].' / '.$row['tadiasto_sign'],1,0,'L');

    $pdf->SetXY(45,$fa);
    $pdf->Cell(15,$df,$row['satoxig_sign'].' %',1,0,'L');
    $pdf->SetXY(60,$fa);
    $pdf->Cell(15,$df,$row['frecard_sign'],1,0,'L');
    $pdf->SetXY(75,$fa);
    $pdf->Cell(15,$df,$row['frecresp_sign'],1,0,'L');
    $pdf->SetXY(90,$fa);
    $pdf->Cell(15,$df,$row['temperatura_sign'],1,0,'L');
    
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

function encabezado(&$pdf,$pag_,$tipoiden_,$identificacion_,$nombres_,$apellidos_,$ingreso_,$fechaing_){
  $pdf->AddPage();
  $pdf->SetFont('Arial','',10);
  $logo_='icons/logosursalud.png';
  $pdf->image($logo_,5,10,70,20);

  $pdf->SetFont('Arial','',7);
  $pdf->SetXY(150,10);
  $pdf->Cell(20,4,'CODIGO',1,0,'L');
  $pdf->SetXY(170,10);
  $pdf->Cell(30,4,'PMS-04',1,0,'L');

  $pdf->SetXY(150,14);
  $pdf->Cell(20,4,'FECHA',1,0,'L');
  $pdf->SetXY(170,14);
  $pdf->Cell(30,4,'01/01/2018',1,0,'L');
  
  $pdf->SetXY(150,18);
  $pdf->Cell(20,4,'VERSION',1,0,'L');
  $pdf->SetXY(170,18);
  $pdf->Cell(30,4,'001',1,0,'L');

  $pdf->SetXY(150,22);
  $pdf->Cell(20,4,'Hoja No.',1,0,'L');
  $pdf->SetXY(170,22);
  $pdf->Cell(30,4,$pag_,1,0,'C');

  /*$pdf->SetXY(140,18);
  $pdf->Cell(30,4,'No HISTORIA',1,0,'L');
  $pdf->SetXY(170,18);
  $pdf->Cell(30,4,$identificacion_,1,0,'L');*/

  $pdf->SetFont('Arial','',10);
  $pdf->SetXY(75,16);
  $pdf->Multicell(75,5,'HOJA DE SIGNOS VITALES',0,'C');
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

  /*$f=$f+4;
  $pdf->SetXY(5,$f);
  $pdf->Cell(100,4,'Diagnóstico de Ingreso: '.$cie_.' '.$desccie_,0,0,'L');*/

  $f+=4;
  $pdf->SetXY(5,$f);
  $pdf->Cell(25,5,'Fecha y Hora',1,0,'C',true);
  $pdf->SetXY(30,$f);
  $pdf->Cell(15,5,'TA mm Hg',1,0,'C',true);
  $pdf->SetXY(45,$f);
  $pdf->Cell(15,5,'Sat O2',1,0,'C',true);
  $pdf->SetXY(60,$f);
  $pdf->Cell(15,5,'FC x min',1,0,'C',true);
  $pdf->SetXY(75,$f);
  $pdf->Cell(15,5,'FR x min',1,0,'C',true);
  $pdf->SetXY(90,$f);
  $pdf->Cell(15,5,'T °C',1,0,'C',true);
  
  $pdf->SetXY(105,$f);
  $pdf->Cell(65,5,utf8_decode('Observación'),1,0,'C',true);
  $pdf->SetXY(170,$f);
  $pdf->Cell(30,5,'Firma',1,0,'C',true);
}
?>
