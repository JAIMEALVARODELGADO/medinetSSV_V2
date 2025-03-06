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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es-ES" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <meta description="Registro y cotrol de actividades asistenciales"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="fonts/style.css">
        <title>Medinet</title>
    </head>
    <script language="JavaScript">
        function continuar(msg_){
            //alert(msg_);
            document.form1.submit();
        }
    </script>
<?php
require("mn_funciones.php");
$link=conectarbd();

$cont=$_POST['cont'];

for($i=0; $i <= $cont ;$i++){
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

    
}
?>

<body onload="continuar('<?php echo $msg;?>')">
<form name='form1' method="post" action="mn_factura263.php">
    <?php 
    echo "<br>".$msg;
    //echo "<input type='hidden' name='id_factura' value='$id_factura'>";
    ?>
</form>
</body>
</html>


