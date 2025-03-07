<?php

require("mn_funciones.php");

$link=conectarbd();
$id_consulta = $_POST['id_consulta'];
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

//Aqui se actualiza la consulta
$sql = "UPDATE nrconsulta SET
fechainicioatencion='$fechainicioatencion',
numautorizacion='$numautorizacion',
codconsulta='$codconsulta',
modalidadgruposervicio='$modalidadgruposervicio',
gruposervicio='$gruposervicio',
codservicio='$codservicio',
finalidadtecnologiasalud='$finalidadtecnologiasalud',
causamotivoatencion='$causamotivoatencion',
coddiagnosticoprincipal='$coddiagnosticoprincipal',
coddiagnosticorelacionado1='$coddiagnosticorelacionado1',
coddiagnosticorelacionado2='$coddiagnosticorelacionado2',
coddiagnosticorelacionado3='$coddiagnosticorelacionado3',
tipodiagnosticoprincipal='$tipodiagnosticoprincipal',
vrservicio='$vrservicio',
conceptorecaudo='$conceptorecaudo',
valorpagomoderador='$valorpagomoderador',
numfevpagomoderador='$numfevpagomoderador'
WHERE id_consulta = '$id_consulta'";

//echo $sql;
mysqli_query($link, $sql);
if(mysqli_affected_rows($link)>0){
    echo "1";}
else{
    echo "0";
}

?>