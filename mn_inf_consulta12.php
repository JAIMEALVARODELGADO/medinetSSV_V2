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
$consulta="SELECT descripcion_for,fecha_con,reingreso_con,CONCAT(nombres,' ',apellidos) AS nombre,fecha_nacim,TRUNCATE((DATEDIFF(fecha_con,fecha_nacim))/365.25,0) AS edad, direccion, telefono, quien_con, motivo_con, CONCAT(codigo_cie,' ',descripcion_cie) AS dx_princ, CONCAT(codigo_cierel1,' ',descripcion_cierel1) AS dx_relac, observacion_con,ident_oper FROM vw_consulta WHERE id_consulta='$_POST[id_consulta]'";
//echo $consulta;
$consulta=$link->query($consulta);
$f=40;
$row=$consulta->fetch_array(MYSQLI_ASSOC);
encabezado($pdf,$row['descripcion_for']);
$f=39;

    $pdf->SetXY(5,$f);
    $pdf->Cell(40,6,'Fecha: '.cambiafechadmy($row['fecha_con']),1,'L');
    $pdf->SetXY(45,$f);
    $pdf->Cell(40,6,'Reingreso: '.$row['reingreso_con'],1,'L');
    $pdf->SetXY(85,$f);
    $pdf->Cell(40,6,'No de Ficha: '.$_POST['id_consulta'],1,'L');

    $f+=8;
    $pdf->SetXY(5,$f);
    $pdf->Cell(40,6,'I. IDENTIFICACION(I):',0,'L');

    $f+=6;
    $pdf->SetXY(5,$f);
    $pdf->Cell(40,6,'Nombre:',1,'L');
    $pdf->SetXY(45,$f);
    $pdf->Cell(160,6,$row['nombre'],1,'L');

    $f+=6;
    $pdf->SetXY(5,$f);
    $pdf->Cell(40,6,'Edad:',1,'L');
    $pdf->SetXY(45,$f);
    $pdf->Cell(160,6,$row['edad'],1,'L');

    $f+=6;
    $pdf->SetXY(5,$f);
    $pdf->Cell(40,6,'Fecha de Nacimiento:',1,'L');
    $pdf->SetXY(45,$f);
    $pdf->Cell(160,6,cambiafechadmy($row['fecha_nacim']),1,'L');

    $f+=6;
    $pdf->SetXY(5,$f);
    $pdf->Cell(40,6,'Domicilio/Telefono:',1,'L');
    $pdf->SetXY(45,$f);
    $pdf->Cell(160,6,$row['direccion'].' - '.$row['telefono'],1,'L');
    
    $f+=6;
    $pdf->SetXY(5,$f);
    $pdf->Cell(40,6,'Quien consulta:',1,'L');
    $pdf->SetXY(45,$f);
    $pdf->Cell(160,6,$row['quien_con'],1,'L');

    $f+=6;
    $pdf->SetXY(5,$f);
    $pdf->Cell(40,6,'Motivo de consulta:',1,'L');
    $pdf->SetXY(45,$f);
    $pdf->MultiCell(160,6,$row['motivo_con'],1,'J');

    $f=$pdf->Gety();
    $pdf->SetXY(5,$f);
    $pdf->Cell(40,6,'Diagnostico medico:',1,'L');
    $pdf->SetXY(45,$f);
    $pdf->MultiCell(160,6,$row['dx_princ'],1,'J');

    $f=$pdf->Gety();
    $pdf->SetXY(5,$f);
    $pdf->Cell(40,6,'Diagnostico relacionado:',1,'L');
    $pdf->SetXY(45,$f);
    $pdf->MultiCell(160,6,$row['dx_relac'],1,'J');

    $f=$pdf->Gety()+2;
    $pdf->SetXY(5,$f);
    $pdf->Cell(40,6,'Observacion:',0,'L');
    $f+=6;
    $pdf->SetXY(5,$f);
    $pdf->MultiCell(200,6,$row['observacion_con'],1,'J');

    $f=$pdf->Gety()+30;
    $firma='firmas/'.$row['ident_oper'].'.jpg';
    if(file_exists($firma)){
      //$pdf->SetXY(5,$f);
      //$pdf->Cell(30,6,'',1,0,'L');
      $pdf->image($firma,10,$f,40,10);
    }
    else{
      $pdf->SetXY(5,$f);
      $pdf->Cell(30,6,$row['ident_oper'],1,0,'L');
    }
    //$f=$pdf->Gety()+10;
    $f+=10;
    $pdf->line(5,$f,60,$f);
    //$f+=6;
    $pdf->SetXY(5,$f);
    $pdf->Cell(60,6,'FIRMA',0,'L');
    $pdf->SetXY(100,$f);
    $pdf->Cell(60,6,'SELLO',0,'L');

mysqli_free_result($consulta);
mysqli_close($link);
$pdf->Output();

function encabezado(&$pdf,$formato){
  $pdf->AddPage();
  $pdf->SetFont('Arial','',10);
  $logo_='icons/logosursalud.png';
  //$pdf->image($logo_,5,10,70,20);
  $pdf->image($logo_,5,10,200,20);
  $pdf->SetXY(75,20);
  $f=30;
  $pdf->SetXY(5,$f);
  $pdf->Cell(40,4,'Nit. 900.751.760-6',0,0,'L');

  $f+=4;
  $pdf->SetXY(5,$f);
  $pdf->Cell(200,4,$formato,0,0,'C');
}
?>
