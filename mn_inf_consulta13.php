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
//------Este es el nuevo formato de impresion de la consulta de acuerdo a la nueva consulta------
?>
<html lang="es-ES" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>        
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <meta description="Registro y cotrol de actividades asistenciales"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="fonts/style.css">
        <title>Medinet</title>
    </head>
<body class="body3">
<?php

require("mn_funciones.php");
$link=conectarbd();
$consulta="SELECT descripcion_for,fecha_con,reingreso_con,CONCAT(nombres,' ',apellidos) AS nombre,fecha_nacim,TRUNCATE((DATEDIFF(fecha_con,fecha_nacim))/365.25,0) AS edad, direccion, telefono, quien_con, motivo_con,enfermedad_con,revsistemas_con,anteced_per_con,anteced_fam_con, CONCAT(codigo_cie,' ',descripcion_cie) AS dx_princ, CONCAT(codigo_cierel1,' ',descripcion_cierel1) AS dx_relac, observacion_con,analisis_con,plan_con,ident_oper,tipo_iden,identificacion
    FROM vw_consulta WHERE id_consulta='$_POST[id_consulta]'";
//echo $consulta;
$consulta=$link->query($consulta);
$row=$consulta->fetch_array(MYSQLI_ASSOC);
encabezado($row['descripcion_for']);
?>
<br>
<br>
<table class="Tbl3">
    <tr>
        <td>Fecha: <?php echo cambiafechadmy($row['fecha_con']);?></td>
        <td>Reingreso: <?php echo $row['reingreso_con'];?></td>
        <td>No de Ficha:  <?php echo $_POST['id_consulta'];?></td>
    </tr>
</table>
<br><h4>IDENTIFICACION</h4>
<table class="Tbl3">
    <tr>
        <td>Identificación:</td>
        <td><?php echo $row['tipo_iden'].' '.$row['identificacion'];?></td>
    </tr>
    <tr>
        <td>Nombre:</td>
        <td><?php echo $row['nombre'];?></td>
        <td>Fecha de Nacimiento:</td>
        <td><?php echo cambiafechadmy($row['fecha_nacim']);?></td>
    </tr>
    <tr>
        <td>Quien consulta:</td>
        <td><?php echo $row['quien_con'];?></td>
        <td>Edad:</td>
        <td><?php echo $row['edad'];?></td>
    </tr>
    <tr>
        <td>Domicilio/Telefono:</td>
        <td colspan="3"><?php echo $row['direccion'].' - '.$row['telefono'];?></td>
    </tr>
</table>

<br><h4>ANAMNESIS</h4>
<table class="Tbl3">
    <tr>
        <td>Motivo de Consulta</td>
        <td><?php echo $row['motivo_con'];?></td>        
    </tr>
    <tr>
        <td>Enfermedad Actual:</td>
        <td><?php echo $row['enfermedad_con'];?></td>        
    </tr>
    <tr>
        <td>Revision por Sistemas</td>
        <td><?php echo $row['revsistemas_con'].' - '.$row['telefono'];?></td>
    </tr>
</table>

<br><h4>ANTECEDENTES</h4>
<table class="Tbl3">
    <tr>
        <td>Antecedente Personales</td>
        <td><?php echo $row['anteced_per_con'];?></td>        
    </tr>
    <tr>
        <td>Antecedente Familiares:</td>
        <td><?php echo $row['anteced_fam_con'];?></td>        
    </tr>
</table>
<?php 
$consultasv="SELECT tension_sig,frec_respi_sig,frec_card_sig,temperat_sig,peso_sig,talla_sig,observacion_sig
FROM vw_consulta_signos WHERE id_consulta='$_POST[id_consulta]'";
//echo $consultasv;
$consultasv=$link->query($consultasv);
if($consultasv->num_rows<>0){
    $rowsv=$consultasv->fetch_array(MYSQLI_ASSOC);
    ?>    
    <br><h5>SIGNOS VITALES</h5>
    <table class="Tbl3">
        <tr>
            <td>Tension Arterial mm Hg:</td>
            <td><?php echo $rowsv['tension_sig'];?></td>            
            <td>Frecuencia Respiratoria:</td>
            <td><?php echo $rowsv['frec_respi_sig'];?> Por Min</td>
            <td>Frecuencia Cardiaca:</td>
            <td><?php echo $rowsv['frec_card_sig'];?> Por Min</td>
        </tr>
        <tr>
            <td>Temperatura:</td>
            <td><?php echo $rowsv['temperat_sig'];?> °C</td>
            <td>Peso:</td>
            <td><?php echo $rowsv['peso_sig'];?> Kg</td>
            <td>Talla:</td>
            <td><?php echo $rowsv['talla_sig'];?> Cm</td>        
        </tr>
        <tr>
            <td>Observaciones:</td>
            <td colspan="5"><?php echo $rowsv['observacion_sig'];?></td>        
        </tr>
    </table>
    <?php
}

$consultaef="SELECT cabeza_estado_efis,cabeza_hallazgo_efis,cuello_estado_efis,cuello_hallazdo_efis,torax_estado_efis,torax_hallazgo_efis,abdomen_estado_efis,abdomen_hallazgo_efis,columna_estado_efis,columna_hallazgo_efis,extremi_estado_efis,extremi_hallazgo_efis FROM vw_consulta_examenfisico WHERE id_consulta='$_POST[id_consulta]'";
//echo $consultaef;
$consultaef=$link->query($consultaef);
if($consultaef->num_rows<>0){
    $rowef=$consultaef->fetch_array(MYSQLI_ASSOC);
    ?>    
    <br><h5>EXAMEN FISICO</h5>
    <table class="Tbl3">
        <th>DESCRIPCION</th>
        <th>ESTADO</th>
        <th>HALLAZGO</th>
        <tr>
            <td>Cabeza</td>            
            <td><?php echo $rowef['cabeza_estado_efis'];?></td>
            <td><?php echo $rowef['cabeza_hallazgo_efis'];?></td>
        </tr>
        <tr>
            <td>Cuello</td>
            <td><?php echo $rowef['cuello_estado_efis'];?></td>
            <td><?php echo $rowef['cuello_hallazdo_efis'];?></td>
        </tr>
        <tr>
            <td>Torax</td>
            <td><?php echo $rowef['torax_estado_efis'];?></td>
            <td><?php echo $rowef['torax_hallazgo_efis'];?></td>
        </tr>
        <tr>
            <td>Abdomen</td>
            <td><?php echo $rowef['abdomen_estado_efis'];?></td>
            <td><?php echo $rowef['abdomen_hallazgo_efis'];?></td>
        </tr>
        <tr>
            <td>Columna</td>
            <td><?php echo $rowef['columna_estado_efis'];?></td>
            <td><?php echo $rowef['columna_hallazgo_efis'];?></td>
        </tr>
        <tr>
            <td>Extremidades</td>
            <td><?php echo $rowef['extremi_estado_efis'];?></td>
            <td><?php echo $rowef['extremi_hallazgo_efis'];?></td>
        </tr>
    </table>
    <?php
}
?>
<br><h4>IMPRESION DIAGNÓSTICA</h4>
<table class="Tbl3">
    <tr>
        <td>Diagnóstico Principal:</td>
        <td><?php echo $row['dx_princ'];?></td>        
    </tr>
    <tr>
        <td>Diagnóstico Relacionado:</td>
        <td><?php echo $row['dx_relac'];?></td>        
    </tr>
    <tr>
        <td>Observaciones:</td>
        <td><?php echo $row['observacion_con'];?></td>        
    </tr>
    <tr>
        <td>Análisis:</td>
        <td><?php echo $row['analisis_con'];?></td>        
    </tr>
    <tr>
        <td>Plan de Manejo:</td>
        <td><?php echo $row['plan_con'];?></td>        
    </tr>
</table>
<?php
$firma='firmas/'.$row['ident_oper'].'.jpg';
echo "<table class='Tbl3'>";
echo "<tr>";
if(file_exists($firma)){
    echo "<td width='30%' align='center'><img src='$firma' width='150' height='80'></td>";
}
else{          
    echo "<td width='30%' align='center'>$row[ident_oper]</td>";
}
echo "</tr>";
echo "<tr>";
echo "<td width='30%' align='center'>FIRMA</td>";
echo "<td width='30%' align='center'>SELLO</td>";
echo "</tr>";
echo "</table>"
?>

<?php
mysqli_free_result($consulta);
mysqli_close($link);

function encabezado($formato){
  ?>
  <table class="Tbl3">
      <tr>
          <td width="30%"><img src="icons/logosursalud.png" width="200" height="80"></td>
          <td width="70%" align="center"><h4><?php echo $formato;?></h4></td>
      </tr>
  </table>  
  <br>
  Nit. 900.751.760-6
  <?php
}
?>

<script type="text/javascript">
//function imprimir() {
    window.print();
    //window.close();
//}
</script>
