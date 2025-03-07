<?php

require("mn_funciones.php");

$link=conectarbd();

$fechainicioatencion = str_replace('T', ' ', $_POST['fechainicioatencion']);
$numautorizacion = $_POST['numautorizacion'];
$codconsulta = $_POST['codconsulta'];
$modalidadgruposervicio = $_POST['modalidadgruposervicio'];
$gruposervicio = $_POST['gruposervicio'];
$codservicio = $_POST['codservicio'];
$finalidadtecnologiasalud = $_POST['finalidadtecnologiasalud'];
$causamotivoatencion = $_POST['causamotivoatencion'];
$coddiagnosticoprincipal = $_POST['coddiagnosticoprincipal'];
$coddiagnosticorelacionado1 = $_POST['coddiagnosticorelacionado1'];
$coddiagnosticorelacionado2 = $_POST['coddiagnosticorelacionado2'];
$coddiagnosticorelacionado3 = $_POST['coddiagnosticorelacionado3'];
$tipodiagnosticoprincipal = $_POST['tipodiagnosticoprincipal'];
$vrservicio = $_POST['vrservicio'];
$conceptorecaudo = $_POST['conceptorecaudo'];
$valorpagomoderador = $_POST['valorpagomoderador'];
$numfevpagomoderador = $_POST['numfevpagomoderador'];
$id_factura = $_POST['id_factura'];


$consultaconsecutivo="SELECT MAX(consecutivo) as consecutivo FROM nrconsulta
WHERE id_factura = '$id_factura'";
$resultado = mysqli_query($link, $consultaconsecutivo);
$row = mysqli_fetch_array($resultado);
$consecutivo = $row['consecutivo'] + 1;


//Aqui consulto la factura
$sql = "INSERT INTO nrconsulta(fechainicioatencion,numautorizacion,codconsulta,modalidadgruposervicio,gruposervicio,codservicio,finalidadtecnologiasalud,causamotivoatencion,coddiagnosticoprincipal,coddiagnosticorelacionado1,coddiagnosticorelacionado2,coddiagnosticorelacionado3,tipodiagnosticoprincipal,vrservicio,conceptorecaudo,valorpagomoderador,numfevpagomoderador,consecutivo,id_factura)
values(
'$fechainicioatencion',
'$numautorizacion',
'$codconsulta',
'$modalidadgruposervicio',
'$gruposervicio',
'$codservicio',
'$finalidadtecnologiasalud',
'$causamotivoatencion',
'$coddiagnosticoprincipal',
'$coddiagnosticorelacionado1',
'$coddiagnosticorelacionado2',
'$coddiagnosticorelacionado3',
'$tipodiagnosticoprincipal',
'$vrservicio',
'$conceptorecaudo',
'$valorpagomoderador',
'$numfevpagomoderador',
'$consecutivo',
'$id_factura')";
mysqli_query($link, $sql);
if(mysqli_affected_rows($link)>0){
    echo "1";}
else{
    echo "0";
}

?>