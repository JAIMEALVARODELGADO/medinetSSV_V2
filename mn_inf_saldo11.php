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
//echo $_POST['sql_'];
$consulta=$link->query($_POST['sql_']);
$f=240;
$pag=0;
$id_ingreso=-1;
$producto=-1;
while($row=$consulta->fetch_array(MYSQLI_ASSOC)){
    if($f>=240){
      $pag++;
      encabezado($pdf,$pag,$row['tipo_iden'],$row['identificacion'],$row['nombres'],$row['apellidos'],$row['id_ingreso'],$row['fecha_ing']);
      $f=35;
    }
    if($id_ingreso!=$row['id_ingreso']){
        $f+=2;
        $pdf->SetXY(5,$f);
        $pdf->Cell(20,4,'Nro. Ingreso: '.$row['id_ingreso'],0,0,'L');
        $f+=4;
        $pdf->SetXY(5,$f);
        $pdf->Cell(40,4,'Fecha de Ingreso: '.$row['fecha_ing'],0,0,'L');
        $f+=4;
        $pdf->SetXY(5,$f);
        $pdf->Cell(120,4,'Identificacion: '.$row['tipo_iden'].' '.$row['identificacion'].'  Nombre: '.$row['nombres'].' '.$row['apellidos'],0,0,'L');
        $id_ingreso=$row['id_ingreso'];
        $f+=4;
        $pdf->SetXY(10,$f);
        $pdf->Cell(130,5,'Medicamento/Dispositivo Médico',0,0,'C',true);
        $pdf->SetXY(140,$f);
        $pdf->Cell(20,5,'Ingresos',1,0,'C',true);
        $pdf->SetXY(160,$f);
        $pdf->Cell(20,5,'Egresos',1,0,'C',true);
        $pdf->SetXY(180,$f);
        $pdf->Cell(20,5,'Saldo',1,0,'C',true);
        $f+=5;
    }
    $pdf->SetXY(10,$f);
    $pdf->Cell(130,4,$row['producto'],1,'J');
    $pdf->SetXY(140,$f);
    $pdf->Cell(20,4,$row['cantidad_ingresa'],1,0,'R');
    $pdf->SetXY(160,$f);
    $pdf->Cell(20,4,$row['cantidad_aplicada'],1,0,'R');
    $pdf->SetXY(180,$f);
    $pdf->Cell(20,4,$row['saldo'],1,0,'R');
    $f+=4;
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
  $pdf->Cell(20,4,'',1,0,'C');
  $pdf->SetXY(165,10);
  $pdf->Cell(35,4,'FECHA DE ELABORACION',1,0,'C');

  $pdf->SetXY(125,14);
  $pdf->Cell(20,4,'VERSION',1,0,'C');
  $pdf->SetXY(145,14);
  $pdf->Cell(20,4,'',1,0,'C');
  $pdf->SetXY(165,14);
  $pdf->Cell(35,4,'',1,0,'C');

  $pdf->SetFont('Arial','',10);
  $pdf->SetXY(75,22);
  $pdf->Cell(125,4,'SALDO DE MEDICAMENTOS',0,0,'C');
  $pdf->SetXY(75,26);
  $pdf->Cell(125,4,'Y DISPOSITIVOS MEDICOS',0,0,'C');
  $pdf->SetFont('Arial','',7);

  $pdf->SetXY(180,30);
  $pdf->Cell(15,4,'Hoja No.',0,0,'R');
  $pdf->SetXY(185,30);
  $pdf->Cell(15,4,$pag_,0,0,'R');
}
?>
