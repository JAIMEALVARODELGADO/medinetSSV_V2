<?php
require("mn_funciones.php");
$link=conectarbd();

echo "ya llegue";

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

echo "<br>".$numautorizacion;
echo "<br>".$idmipres;
echo "<br>".$fechasuministrotecnologia;
echo "<br>".$tipoos;
echo "<br>".$codtecnologia;
echo "<br>".$nomtecnologia;
echo "<br>".$cantidados;
echo "<br>".$vrunitos;
echo "<br>".$conceptorecaudo;
echo "<br>".$valorpagomoderador;
echo "<br>".$numfevpagomoderador;
echo "<br>".$id_factura;

/*for($i=0; $i <= $cont ;$i++){
    $id_otroservicio = $_POST['id_otroservicio'.$i];    
    $numautorizacion = $_POST['numautorizacion'.$i];
    $idmipres = $_POST['idmipres'.$i];
    $fechasuministrotecnologia = $_POST['fechasuministrotecnologia'.$i];
    $tipoos = $_POST['tipoos'.$i];
    $codtecnologia = $_POST['codtecnologia'.$i]; 
    $nomtecnologia = $_POST['nomtecnologia'.$i];
    //$cantidados = $_POST['cantidados'.$i];
    //$vrunitos = $_POST['vrunitos'.$i];
    //$vrservicio = $_POST['vrservicio'.$i];
    $conceptorecaudo = $_POST['conceptorecaudo'.$i];
    $valorpagomoderador = $_POST['valorpagomoderador'.$i];
    $numfevpagomoderador = $_POST['numfevpagomoderador'.$i];

    $sql="UPDATE nrotroservicios SET
    id_otroservicio = '$id_otroservicio',
    numautorizacion = '$numautorizacion',
    idmipres = '$idmipres',
    fechasuministrotecnologia = '$fechasuministrotecnologia',
    tipoos = '$tipoos',
    codtecnologia = '$codtecnologia',
    nomtecnologia = '$nomtecnologia',    
    conceptorecaudo = '$conceptorecaudo',
    valorpagomoderador = '$valorpagomoderador',
    numfevpagomoderador = '$numfevpagomoderador'
    WHERE id_otroservicio = '$id_otroservicio'";

    $link->query($sql);

    if($link->affected_rows > 0){
        $msg="Registro guardado con exito";
    }
    else{$msg="Registro no guardado";}

    
}*/
?>
