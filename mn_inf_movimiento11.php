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
      $pdf->SetXY(5,$f);
      $pdf->Cell(20,4,'Nro. Ingreso: '.$row['id_ingreso'],0,0,'L');
      $f+=4;
      $pdf->SetXY(5,$f);
      $pdf->Cell(40,4,'Fecha de Ingreso: '.$row['fecha_ing'],0,0,'L');
      $f+=4;
      $pdf->SetXY(5,$f);
      $pdf->Cell(120,4,'Identificacion: '.$row['tipo_iden'].' '.$row['identificacion'].'  Nombre: '.$row['nombres'].' '.$row['apellidos'],0,0,'L');
      $id_ingreso=$row['id_ingreso'];
      $producto=-1;
      $f+=4;
    }
    if($producto!=$row['id_producto']){
      //$f+=6;
      $pdf->SetXY(10,$f);
      $pdf->Cell(130,5,'Medicamento/Dispositivo Médico',0,0,'C',true);
      $pdf->SetXY(140,$f);
      $pdf->Cell(30,5,'Fecha Mov',0,0,'C',true);

      $pdf->SetXY(170,$f);
      $pdf->Cell(10,5,'Ingresos',1,0,'C',true);
      $pdf->SetXY(180,$f);
      $pdf->Cell(10,5,'Egresos',1,0,'C',true);
      $pdf->SetXY(190,$f);
      $pdf->Cell(10,5,'Saldo',1,0,'C',true);
  
      $producto=$row['id_producto'];
      $saldo=0;
      $f+=6;
      $pdf->SetXY(10,$f);
      $pdf->Cell(130,4,$row['producto'],1,'J');
      $f+=4;
    }
    $pdf->SetXY(140,$f);
    $pdf->Cell(30,4,$row['fecha_mov'],1,'L');
    if($row['tipo_mov']=='I'){
      $pdf->SetXY(170,$f);
      $pdf->Cell(10,4,$row['cantidad'],1,0,'R');
      $pdf->SetXY(180,$f);
      $pdf->Cell(10,4,'',1,0,'R');
      $saldo=$saldo+$row['cantidad'];
    }
    else{
      $pdf->SetXY(170,$f);
      $pdf->Cell(10,4,'',1,0,'R');
      $pdf->SetXY(180,$f);
      $pdf->Cell(10,4,$row['cantidad'],1,0,'R');
      $saldo=$saldo-$row['cantidad'];
    }
    $pdf->SetXY(190,$f);
    $pdf->Cell(10,4,$saldo,1,0,'R');
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
  $pdf->Cell(125,4,'MOVIMIENTO DE MEDICAMENTOS',0,0,'C');
  $pdf->SetXY(75,26);
  $pdf->Cell(125,4,'Y DISPOSITIVOS MEDICOS',0,0,'C');
  $pdf->SetFont('Arial','',7);

  $pdf->SetXY(180,30);
  $pdf->Cell(15,4,'Hoja No.',0,0,'R');
  $pdf->SetXY(185,30);
  $pdf->Cell(15,4,$pag_,0,0,'R');
  
  /*

  $f+=4;
  $pdf->SetXY(5,$f);
  $pdf->Cell(100,4,'Identificación: '.$tipoiden_.' '.$identificacion_,0,0,'L');
  $pdf->SetXY(165,$f);
  $pdf->Cell(35,4,'Fecha de Ingreso: '.$fechaing_,0,0,'L');

  $f+=4;
  $pdf->SetXY(5,$f);
  $pdf->Cell(25,5,'Fecha y Hora',1,0,'C',true);
  $pdf->SetXY(30,$f);
  $pdf->Cell(70,5,'Medicamento/Dispositivo Médico',1,0,'C',true);
  $pdf->SetXY(100,$f);
  $pdf->Cell(53,5,'Remite',1,0,'C',true);
  $pdf->SetXY(153,$f);
  $pdf->Cell(22,5,'Lote',1,0,'C',true);
  $pdf->SetXY(175,$f);
  $pdf->Cell(8,5,'Cant.',1,0,'C',true);
  $pdf->SetXY(183,$f);
  $pdf->Cell(30,5,'Responsable',1,0,'C',true);*/
}
?>