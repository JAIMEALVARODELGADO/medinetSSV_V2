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
        function continuar(){
            document.form1.submit();
        }
    </script>
<?php
require("mn_funciones.php");
//require("pp_menu.php");
$link=conectarbd();

$desplazam=$_POST['cual_desp'];
$alergia_medicame=$_POST['cual_med'];
$alergia_alimento=$_POST['cual_ali'];


$sql_="UPDATE ingreso SET jornada='$_POST[jornada]', fecha_ing='$_POST[fecha_ing]', peso='$_POST[peso]', id_eps='$_POST[id_eps]', control_esfin='$_POST[control_esfin]', desplazam='$desplazam', alimentacion_indep='$_POST[alimentacion_indep]', comunicacion_verbal='$_POST[comunicacion_verbal]', alergia_medicame='$alergia_medicame', alergia_alimento='$alergia_alimento',observacion_ing='$_POST[observacion_ing]',diag_prin='$_POST[diag_prin]',diag_rel1='$_POST[diag_rel1]', estado='$_POST[estado]' WHERE id_ingreso='$_POST[id_ingreso]'";   
//echo "<br>".$sql_;
$link->query($sql_);
?>
<body onload="continuar()">
<form name='form1' method="post" action="mn_ingresopaciente2.php">
    <?php 
    echo "<input type='hidden' name='id_ingreso' value='$_POST[id_ingreso]'>";
    ?>

</form>
</body>
</html>
