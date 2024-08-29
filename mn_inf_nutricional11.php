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
$consulta="SELECT 
id_ingreso,jornada,fecha_nut,tipo_iden,identificacion,CONCAT(nombres,' ',apellidos) AS nombre,direccion,telefono ,fecha_nacim, edad_actual_nut,
diarrea_nut,
estrenim_nut,
gastritis_nut,
ulceras_nut,
nauceas_nut,
pirosis_nut,
vomito_nut,
colitis_nut,
dentadura_nut,
otros_nut,
observacion_nut,
enfermedad_actual_nut,
medicamentos_nut,
cirugia_nut,
altura_rodilla_nut,
circ_brazo_nut,
circ_cadera_nut,
circ_cintura_nut,
circ_pantorrilla_nut,
peso_nut,
talla_nut,
dxnutricional_nut,
ident_oper,
operador,
((altura_rodilla_nut*1.91)+(edad_actual_nut*0.17))+75 AS talla_muj,
(altura_rodilla_nut*2.08)+59.01 AS talla_hom,
((altura_rodilla_nut*1.09)+(circ_brazo_nut*2.68))-65.51 AS peso_muj,
((altura_rodilla_nut*1.1)+(circ_brazo_nut*3.07))-75.81 AS peso_hom,
circ_cadera_nut/circ_cintura_nut AS riesgo,
(talla_nut-100)*0.9 AS peso_ideal,
peso_nut/POWER(talla_nut,2) AS imc
FROM vw_hcnutricional WHERE id_nut='$_POST[id_nut]'";

//echo $consulta;
$consulta=$link->query($consulta);
$f=40;
$row=$consulta->fetch_array(MYSQLI_ASSOC);
encabezado($pdf);
$f=39;

    $pdf->SetXY(10,$f);
    $pdf->Cell(40,6,'Fecha: '.cambiafechadmy($row['fecha_nut']),1,'L');
    $pdf->SetXY(50,$f);
    $pdf->Cell(40,6,'No de Ficha: '.$_POST['id_nut'],1,'L');

    $f+=8;
    $pdf->SetXY(10,$f);
    $pdf->Cell(195,5,'IDENTIFICACION',0,0,'C',true);

    $f+=6;
    $pdf->SetXY(10,$f);
    $pdf->Cell(95,6,'Identificacion: '.$row['tipo_iden'].' '.$row['identificacion'],1,'L');
    $pdf->SetXY(105,$f);
    $pdf->Cell(100,6,'Nombre: '.$row['nombre'],1,'L');
    
    $f+=6;
    $pdf->SetXY(10,$f);
    $pdf->Cell(95,6,'Fecha de Nacimiento: '.cambiafechadmy($row['fecha_nacim']).' Edad: '.$row['edad_actual_nut'],1,'L');
    $pdf->SetXY(105,$f);
    $pdf->Cell(100,6,'Domicilio/Telefono: '.$row['direccion'].' - '.$row['telefono'],1,'L');

    $f+=8;
    $pdf->SetXY(10,$f);
    $pdf->Cell(195,5,'INDICADORES CLINICOS',0,0,'C',true);
    
    $f+=6;
    $pdf->SetXY(10,$f);
    $pdf->Cell(95,6,'Diarrea: '.$row['diarrea_nut'],1,'L');
    $pdf->SetXY(105,$f);
    $pdf->Cell(100,6,'Pirosis: '.$row['pirosis_nut'],1,'L');

    $f+=6;
    $pdf->SetXY(10,$f);
    $pdf->Cell(95,6,'Estreñimiento: '.$row['estrenim_nut'],1,'L');
    $pdf->SetXY(105,$f);
    $pdf->Cell(100,6,'Vomito: '.$row['vomito_nut'],1,'L');

    $f+=6;
    $pdf->SetXY(10,$f);
    $pdf->Cell(95,6,'Gastritis: '.$row['gastritis_nut'],1,'L');
    $pdf->SetXY(105,$f);
    $pdf->Cell(100,6,'Colitis: '.$row['colitis_nut'],1,'L');

    $f+=6;
    $pdf->SetXY(10,$f);
    $pdf->Cell(95,6,'Ulceras: '.$row['ulceras_nut'],1,'L');
    $pdf->SetXY(105,$f);
    $pdf->Cell(100,6,'Dentadura: '.$row['dentadura_nut'],1,'L');

    $f+=6;
    $pdf->SetXY(10,$f);
    $pdf->Cell(95,6,'Nauceas: '.$row['nauceas_nut'],1,'L');
    $pdf->SetXY(105,$f);
    $pdf->Cell(100,6,'Otro: '.$row['otros_nut'],1,'L');

    $f+=6;
    $pdf->SetXY(10,$f);
    $pdf->MultiCell(195,6,'Observaciones: '.$row['observacion_nut'],1,'J');
    
    $f=$pdf->GetY();
    $pdf->SetXY(10,$f);
    $pdf->MultiCell(195,6,'Enfermedad(es) Actual(es): '.$row['enfermedad_actual_nut'],1,'J');

    $f=$pdf->GetY();
    $pdf->SetXY(10,$f);
    $pdf->MultiCell(195,6,'Medicamentos que Consume: '.$row['medicamentos_nut'],1,'J');

    $f=$pdf->GetY();
    $pdf->SetXY(10,$f);
    $pdf->MultiCell(195,6,'Procedimientos Qx: '.$row['cirugia_nut'],1,'J');

    $f+=8;
    $pdf->SetXY(10,$f);
    $pdf->Cell(195,5,'INDICADORES ANTROPOMETRICOS',0,0,'C',true);
    
    $f+=6;
    $pdf->SetXY(10,$f);
    $pdf->Cell(50,6,'Altura de Rodilla: '.$row['altura_rodilla_nut'].' Cm',1,'L');
    $pdf->SetXY(60,$f);
    $pdf->Cell(50,6,'Talla Estimada Mujer: '.$row['talla_muj'],1,'L');
    $pdf->SetXY(110,$f);
    $pdf->Cell(95,6,'Talla Estimada Hombre: '.$row['talla_hom'],1,'L');

    $f+=6;
    $pdf->SetXY(10,$f);
    $pdf->Cell(50,6,'Circunferencia de Brazo: '.$row['circ_brazo_nut'].' Cm',1,'L');
    $pdf->SetXY(60,$f);
    $pdf->Cell(50,6,'Peso Estimada Mujer: '.$row['peso_muj'],1,'L');
    $pdf->SetXY(110,$f);
    $pdf->Cell(95,6,'Peso Estimada Hombre: '.$row['peso_hom'],1,'L');

    $f+=6;
    $pdf->SetXY(10,$f);
    $pdf->Cell(50,6,'Circunferencia de Cadera: '.$row['circ_cadera_nut'].' Cm',1,'L');
    $pdf->SetXY(60,$f);
    $pdf->Cell(50,6,'Circunferencia de Cintura: '.$row['circ_cintura_nut'].' Cm',1,'L');
    $pdf->SetXY(110,$f);
    $pdf->Cell(95,6,'Riesgo Cardiovascular: '.$row['riesgo'],1,'L');

    $f+=6;
    $pdf->SetXY(10,$f);
    $pdf->Cell(50,6,'Circunferencia de Pantorrilla: '.$row['circ_pantorrilla_nut'].' Cm',1,'L');
    $pdf->SetXY(60,$f);
    $pdf->Cell(35,6,'Peso: '.$row['peso_nut'].' Kg',1,'L');
    $pdf->SetXY(95,$f);
    $pdf->Cell(35,6,'Talla: '.$row['talla_nut'].' Cm',1,'L');
    $pdf->SetXY(130,$f);
    $pdf->Cell(35,6,'Peso Ideal: '.$row['peso_ideal'].' Kg',1,'L');
    $pdf->SetXY(165,$f);
    $pdf->Cell(40,6,'IMC: '.$row['imc'],1,'L');

    $f+=8;
    $pdf->SetXY(10,$f);
    $pdf->Cell(195,5,'DIAGNOSTICO NUTRICIONAL',0,0,'C',true);

    $f+=6;
    $pdf->SetXY(10,$f);
    $pdf->MultiCell(195,6,$row['dxnutricional_nut'],1,'J');

    $f=$pdf->Gety()+30;
    $firma='firmas/'.$row['ident_oper'].'.jpg';
    if(file_exists($firma)){
      $pdf->image($firma,10,$f,40,10);
    }
    else{
      $pdf->SetXY(10,$f);
      $pdf->Cell(30,6,$row['ident_oper'],1,0,'L');
    }
    //$f=$pdf->Gety()+10;
    $f+=10;
    $pdf->line(10,$f,60,$f);
    //$f+=6;
    $pdf->SetXY(10,$f);
    $pdf->Cell(60,6,'FIRMA',0,'L');
    //$pdf->SetXY(100,$f);
    //$pdf->Cell(60,6,'SELLO',0,'L');

mysqli_free_result($consulta);
mysqli_close($link);
$pdf->Output();

function encabezado(&$pdf){
  $pdf->AddPage();
  //$pdf->SetFont('Arial','',7);
  $logo_='icons/logosursalud.jpg';
  $pdf->image($logo_,10,10,70,20);

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
  $pdf->Cell(125,4,'HISTORIA CLINICA NUTRICIONAL',0,0,'C');
  $pdf->SetXY(75,26);
  $pdf->Cell(125,4,'Y DISPOSITIVOS MEDICOS',0,0,'C');
  $pdf->SetFont('Arial','',7);

  $pdf->SetXY(180,30);
  $pdf->Cell(15,4,'Hoja No.',0,0,'R');
  $pdf->SetXY(185,30);
  $pdf->Cell(15,4,'1',0,0,'R');

  /*$pdf->SetXY(75,20);
  $f=30;
  $pdf->SetXY(5,$f);
  $pdf->Cell(40,4,'Nit. 900.751.760-6',0,0,'L');

  $f+=4;
  $pdf->SetXY(5,$f);*/
  //$pdf->Cell(200,4,$formato,0,0,'C');
}
?>
