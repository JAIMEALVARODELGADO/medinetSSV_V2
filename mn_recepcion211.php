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
$consulta="SELECT movimiento_inventario.id_ingreso,movimiento_inventario.id_producto ,movimiento_inventario.cantidad FROM movimiento_inventario WHERE movimiento_inventario.id_movimiento='$_POST[id_movimiento]'";
//echo "<br>".$consulta;
$link->query($consulta);
$consulta=$link->query($consulta);
$diferencia=0;
if($consulta->num_rows<>0){
    $row=$consulta->fetch_array();
    $diferencia=$_POST['cantidad']-$row['cantidad'];
}
$sql_="UPDATE movimiento_inventario SET fecha_mov='$_POST[fecha_mov]', remite='$_POST[remite]', lote='$_POST[lote]', cantidad='$_POST[cantidad]', observacion_mov='$_POST[observacion]' WHERE id_movimiento='$_POST[id_movimiento]'";
//echo "<br>".$sql_;
$link->query($sql_);   

$consultainv="SELECT inventario_paciente.id_inventario, inventario_paciente.cantidad_ingresa FROM inventario_paciente WHERE inventario_paciente.id_ingreso='$row[id_ingreso]' AND id_producto='$row[id_producto]'";
//echo "<br>".$consultainv;
$link->query($consultainv);
$consultainv=$link->query($consultainv);
$rowinv=$consultainv->fetch_array();
$sql_="UPDATE inventario_paciente SET cantidad_ingresa=$rowinv[cantidad_ingresa]+$diferencia WHERE id_inventario='$rowinv[id_inventario]'";   
//echo "<br>".$sql_;
$link->query($sql_);
?>
<body onload="continuar()">
<form name='form1' method="post" action="mn_recepcion2.php">
    <?php 
    echo "<input type='hidden' name='id_movimiento' value='$_POST[id_movimiento]'>";
    ?>

</form>
</body>
</html>
