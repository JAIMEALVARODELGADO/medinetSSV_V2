<?php
require("mn_funciones.php");
$link=conectarbd();

$numautorizacion = $_POST['numautorizacion'];
$idmipres = $_POST['idmipres'];
$fechasuministrotecnologia = $_POST['fechasuministrotecnologia'];
$tipoos = $_POST['tipoos'];
$codtecnologia = $_POST['codtecnologia'];
$nomtecnologia = $_POST['nomtecnologia'];
$cantidados = $_POST['cantidados'];
$vrunitos = $_POST['vrunitos'];
$conceptorecaudo = $_POST['conceptorecaudo'];
$valorpagomoderador = $_POST['valorpagomoderador'];
$numfevpagomoderador = $_POST['numfevpagomoderador'];
$id_factura = $_POST['id_factura'];
$vrservicio = $vrunitos*$cantidados;

$consultausu="SELECT u.tipo_documento, u.numdocumento FROM nrusuario u WHERE id_factura='$id_factura'";
$consultausu=$link->query($consultausu);
if($consultausu->num_rows<>0){
    $row=$consultausu->fetch_array();
    $tipodocumentoidentificacion = $row['tipo_documento'];
    $numdocumentoidentificacion = $row['numdocumento'];
}

$consultaotr="SELECT COUNT(*) as consecutivo FROM nrotroservicios n 
where n.id_factura ='id_factura'";
$consultaotr=$link->query($consultaotr);
$rowotr=$consultaotr->fetch_array();
$consecutivo = $rowotr['consecutivo']+1;

$sql="INSERT INTO nrotroservicios(
numautorizacion,
idmipres,
fechasuministrotecnologia,
tipoos,
codtecnologia,
nomtecnologia,
cantidados,
tipodocumentoidentificacion,
numdocumentoidentificacion,
vrunitos,
vrservicio,
conceptorecaudo,
valorpagomoderador,
numfevpagomoderador,
consecutivo,
id_factura)
VALUES(     
'$numautorizacion',
'$idmipres',
'$fechasuministrotecnologia',
'$tipoos',
'$codtecnologia',
'$nomtecnologia',    
'$cantidados',    
'$tipodocumentoidentificacion',
'$numdocumentoidentificacion',
'$vrunitos',
'$vrservicio',
'$conceptorecaudo',
'$valorpagomoderador',
'$numfevpagomoderador',
'$consecutivo',
'$id_factura')";
//echo $sql;

$link->query($sql);

if($link->affected_rows > 0){
    echo 1;
}
else{
    echo 0;
}

    
?>
