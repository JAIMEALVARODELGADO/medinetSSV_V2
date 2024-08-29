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
            alert(msg_);
            document.form1.submit();
        }
    </script>
<?php
require("mn_funciones.php");
//require("pp_menu.php");
$link=conectarbd();
$hoy=cambiafecha(hoy());

$fecha_sign=$hoy.' '.$_POST['hora'];


$sql_="INSERT INTO signos_vitales(id_signos,id_ingreso,fecha_sign,tasistol_sign,tadiasto_sign,satoxig_sign,frecard_sign,frecresp_sign,temperatura_sign,observacion_sign,id_operador) VALUES('0','$_POST[id_ingreso]','$fecha_sign','$_POST[tasistol_sign]','$_POST[tadiasto_sign]','$_POST[satoxig_sign]','$_POST[frecard_sign]','$_POST[frecresp_sign]','$_POST[temperatura_sign]','$_POST[observacion_sign]','$_SESSION[gid_usuario]')";
//echo "<br>".$sql_;
$link->query($sql_);
//$id_evolucion=$link->insert_id;

if($link->affected_rows > 0){
    $msg="Registro guardado con exito";
}
else{$msg="Registro no guardado";}

?>
<body onload="continuar('<?php echo $msg;?>')">
<form name='form1' method="post" action="mn_signos1.php">
    <?php 
    echo "<br>".$msg;
    //echo "<input type='hidden' name='id_evolucion' value='$id_evolucion'>";
    ?>

</form>
</body>
</html>