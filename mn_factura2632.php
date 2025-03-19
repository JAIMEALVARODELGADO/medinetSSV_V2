<?php
require("mn_funciones.php");

$link=conectarbd();

$id_otroservicio = $_POST['id_otroservicio'];
$numautorizacion = $_POST['numautorizacion'];
$idmipres = $_POST['idmipres'];
$fechasuministrotecnologia = str_replace('T', ' ',$_POST['fechasuministrotecnologia']);
$tipoos = $_POST['tipoos'];
$codtecnologia = $_POST['codtecnologia'];
$nomtecnologia = $_POST['nomtecnologia'];
$cantidados = $_POST['cantidados'];
$vrunitos = $_POST['vrunitos'];
$conceptorecaudo = $_POST['conceptorecaudo'];
$valorpagomoderador = $_POST['valorpagomoderador'];
$numfevpagomoderador = $_POST['numfevpagomoderador'];
$vrservicio = $vrunitos*$cantidados;

$sql="UPDATE nrotroservicios SET
numautorizacion = '$numautorizacion',
idmipres = '$idmipres',
fechasuministrotecnologia = '$fechasuministrotecnologia',
tipoos = '$tipoos',
codtecnologia = '$codtecnologia',
nomtecnologia = '$nomtecnologia',
cantidados = '$cantidados',
vrunitos = '$vrunitos',
conceptorecaudo = '$conceptorecaudo',
valorpagomoderador = '$valorpagomoderador',
numfevpagomoderador = '$numfevpagomoderador',
vrservicio = $vrunitos*$cantidados
WHERE id_otroservicio='$id_otroservicio'";

//echo $sql;
$link->query($sql);

if($link->affected_rows > 0){
    echo 1;
}
else{
    echo 0;
}

?>
