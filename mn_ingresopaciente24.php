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

$consulta="SELECT ingreso.fecha_ing,CONCAT(persona.pnombre,' ',persona.snombre,' ',persona.papellido,' ',persona.sapellido) AS nombre,persona.tipo_iden,persona.identificacion,persona.fecha_nacim,FLOOR(DATEDIFF(ingreso.fecha_ing,persona.fecha_nacim)/365) AS edad,persona.direccion,ingreso.peso, ingreso.control_esfin,ingreso.desplazam,ingreso.alimentacion_indep,ingreso.comunicacion_verbal,ingreso.alergia_medicame,ingreso.alergia_alimento,ingreso.diag_prin,cie.codigo_cie,cie.descripcion_cie, paciente.tipo_sangre,eps.nombre_eps, operador.identificacion AS ident_oper,CONCAT(operador.pnombre,' ',operador.snombre,' ',operador.papellido,' ',operador.sapellido) AS nombre_oper
  FROM ingreso 
  INNER JOIN persona ON persona.id_persona=ingreso.id_persona 
  INNER JOIN paciente ON paciente.id_persona=persona.id_persona 
  INNER JOIN persona AS operador ON operador.id_persona=ingreso.id_operador 
  INNER JOIN eps ON eps.id_eps=ingreso.id_eps 
  INNER JOIN cie ON cie.id_cie=ingreso.diag_prin WHERE id_ingreso='$_GET[id_ingreso]'";
//echo $consulta;
$consulta=$link->query($consulta);
$f=40;
$row=$consulta->fetch_array(MYSQLI_ASSOC);
encabezado($pdf,$_GET['id_ingreso'],$rowenti);
    $f=42;
    $pdf->SetFont('Arial','',8);
    $pdf->SetXY(10,$f);
    $pdf->Cell(190,5,'INFORMACION PERSONAL',0,0,'C',true);

    $f+=6;
    $pdf->SetXY(10,$f);
    $pdf->Cell(35,5,'IDENTIFICACION: ',1,0,'L');
    $pdf->SetXY(45,$f);
    $pdf->Cell(50,5,$row['tipo_iden'].' '.$row['identificacion'],1,0,'L');

    //$f+=5;
    $pdf->SetXY(95,$f);
    $pdf->Cell(30,5,'NOMBRE: ',1,0,'L');
    $pdf->SetXY(125,$f);
    $pdf->Cell(75,5,$row['nombre'],1,0,'L');
    
    $f+=5;
    $pdf->SetXY(10,$f);
    $pdf->Cell(35,5,'FECHA DE NACIMIENTO: ',1,0,'L');
    $pdf->SetXY(45,$f);
    $pdf->Cell(50,5,$row['fecha_nacim'],1,0,'L');

    $pdf->SetXY(95,$f);
    $pdf->Cell(30,5,'EDAD: ',1,0,'L');
    $pdf->SetXY(125,$f);
    $pdf->Cell(75,5,$row['edad'],1,0,'L');
    
    $f+=5;
    $pdf->SetXY(10,$f);
    $pdf->Cell(35,5,'DIRECCION: ',1,0,'L');
    $pdf->SetXY(45,$f);
    $pdf->Cell(155,5,$row['direccion'],1,0,'L');

    $f+=5;
    $pdf->SetXY(10,$f);
    $pdf->Cell(35,5,'TIPO DE SANGRE: ',1,0,'L');
    $pdf->SetXY(45,$f);
    $pdf->Cell(155,5,$row['tipo_sangre'],1,0,'L');

    $f+=6;
    $pdf->SetXY(10,$f);
    $pdf->Cell(190,5,'INFORMACION DEL INGRESO',0,0,'C',true);
    $f+=6;
    $pdf->SetXY(10,$f);
    $pdf->Cell(35,5,'FECHA DE INGRESO: ',1,0,'L');
    $pdf->SetXY(45,$f);
    $pdf->Cell(50,5,$row['fecha_ing'],1,0,'L');

    $pdf->SetXY(95,$f);
    $pdf->Cell(30,5,'PESO: ',1,0,'L');
    $pdf->SetXY(125,$f);
    $pdf->Cell(75,5,$row['peso'],1,0,'L');
    $f+=5;
    $pdf->SetXY(10,$f);
    $pdf->Cell(35,5,'DIAGNOSTICO: ',1,0,'L');
    $pdf->SetXY(45,$f);
    $pdf->Cell(155,5,$row['codigo_cie'].' '.$row['descripcion_cie'],1,0,'L');

    $f+=5;
    $pdf->SetXY(10,$f);
    $pdf->Cell(190,4,'ENTIDAD DE SALUD A LA QUE PERTENECE: '.$row['nombre_eps'],1,0,'L');
    
    $f+=6;
    $pdf->SetXY(10,$f);
    $pdf->Cell(190,5,'INFORMACION DEL(LOS) CUIDADOR(ES)',0,0,'C',true);

    $consultaacud="SELECT acudiente.nombre_acud,acudiente.telefono_acud,acudiente.direccion_acud,acudiente.parentesco FROM acudiente WHERE acudiente.id_ingreso='$_GET[id_ingreso]'";
    $consultaacud=$link->query($consultaacud);
    //if($consultaacud->mysql_num_rows()<>0){
    if(mysqli_num_rows($consultaacud)<>0){
      $c=1;
      while($rowacud=$consultaacud->fetch_array(MYSQLI_ASSOC)){
        $f+=7;
        $pdf->SetXY(10,$f);
        $pdf->Cell(190,5,'NOMBRE DEL FAMILIAR O CUIDADOR - '.$c.' : '.$rowacud['nombre_acud'],1,0,'L');
        $f+=5;
        $pdf->SetXY(10,$f);
        $pdf->Cell(35,5,'PARENTESCO: ',1,0,'L');
        $pdf->SetXY(45,$f);
        $pdf->Cell(50,5,$rowacud['parentesco'],1,0,'L');

        $pdf->SetXY(95,$f);
        $pdf->Cell(30,5,'TELEFONO: ',1,0,'L');
        $pdf->SetXY(125,$f);
        $pdf->Cell(75,5,$rowacud['telefono_acud'],1,0,'L');

        $f+=5;
        $pdf->SetXY(10,$f);
        $pdf->Cell(190,5,'DIRECCION: '.$rowacud['direccion_acud'],1,0,'L');
        $c++;
      }
    }

    $f+=8;
    $pdf->SetXY(10,$f);
    $pdf->Cell(190,5,'INFORMACION ADICIONAL',0,0,'C',true);
    $f+=5;
    $pdf->SetXY(10,$f);
    $pdf->Cell(190,5,'CONTROLA ESFINTERES: '.$row['control_esfin'],1,0,'L');
    $f+=5;
    $pdf->SetXY(10,$f);
    $pdf->Cell(190,5,'DESPLAZAMIENTO: '.$row['desplazam'],1,0,'L');
    $f+=5;
    $pdf->SetXY(10,$f);
    $pdf->Cell(190,5,'ES INDEPENDIENTE EN SU ALIMENTACION (LO REALIZA POR SI SOLO): '.$row['alimentacion_indep'],1,0,'L');
    $f+=5;
    $pdf->SetXY(10,$f);
    $pdf->Cell(190,5,'SE COMUNICA VERBALMENTE SIN DIFICULTAD: '.$row['comunicacion_verbal'],1,0,'L');
    $f+=5;
    $pdf->SetXY(10,$f);
    $pdf->Cell(190,5,'PRESENTA ALERGIA A MEDICAMENTOS: '.$row['alergia_medicame'],1,0,'L');
    $f+=5;
    $pdf->SetXY(10,$f);
    $pdf->Cell(190,5,'PRESENTA ALERGIA O ES INTOLERANTE A ALGUN ALIMENTO: '.$row['alergia_alimento'],1,0,'L');

    $f+=8;
    $pdf->SetXY(10,$f);
    $pdf->Cell(190,4,'GUSTOS Y ACTIVIDADES FAVORITAS QUE LE GUSTA REALIZAR AL ADULTO MAYOR',0,0,'C',true);
    $consultaact="SELECT descripcion FROM actividades_fav WHERE id_ingreso='$_GET[id_ingreso]'";
    $consultaact=$link->query($consultaact);
    if(mysqli_num_rows($consultaacud)<>0){
      $c=1;
      while($rowact=$consultaact->fetch_array(MYSQLI_ASSOC)){
        $f+=5;
        $pdf->SetXY(10,$f);
        $pdf->Cell(5,5,$c,1,0,'L');
        $pdf->SetXY(15,$f);
        $pdf->Cell(185,5,$rowact['descripcion'],1,0,'L');
        $c++;
      }
    }

    $f+=10;
    $pdf->SetXY(10,$f);
    $pdf->Cell(130,4,'NOMBRE Y FIRMA QUIEN DILIGENCIA',0,0,'L');
    $f+=10;
    $pdf->SetXY(10,$f);
    $pdf->Cell(130,4,'NOMBRE: '.$row['nombre_oper'],0,0,'L');
    $f+=10;
    $pdf->SetXY(10,$f);
    $pdf->Cell(130,4,'FIRMA: ',0,0,'L');

    $firma='firmas/'.$row['ident_oper'].'.PNG';
    if(file_exists($firma)){
      $pdf->image($firma,30,$f-5,50,15);
    }
    else{
      $pdf->SetXY(10,$f);
      $pdf->Cell(30,6,$row['ident_oper'],0,0,'L');
    }
    


mysqli_free_result($consulta);
mysqli_free_result($consultaacud);
mysqli_free_result($consultaact);
mysqli_close($link);
$pdf->Output();

function encabezado(&$pdf,$numero_ing,$row_){
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

  $pdf->SetFont('Arial','',9);
  $pdf->SetXY(75,28);
  $pdf->Cell(110,4,'Ingreso Nro: ',0,0,'R');
  $pdf->SetXY(185,28);
  $pdf->Cell(20,4,$numero_ing,1,0,'R');

  $pdf->SetFont('Arial','',10);
  $pdf->SetXY(10,34);
  $pdf->Cell(190,6,'INFORMACION GENERAL DE USUARIO PARA INGRESO ADULTO MAYOR A JORNADA 1, 2  O LARGA ESTANCIA',0,0,'C');
  $pdf->SetFont('Arial','',7);
  
}
?>
