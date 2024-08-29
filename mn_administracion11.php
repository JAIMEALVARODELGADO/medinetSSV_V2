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
$hora=date("H:i:s");
$hoy=$hoy.' '.$hora;

$sql_="INSERT INTO movimiento_inventario(id_movimiento, tipo_mov, id_ingreso, fecha_mov, id_producto, cantidad, dosis, via,  observacion_mov, id_operador, fecha_reg) VALUES(0,'A','$_POST[id_ingreso]','$_POST[fecha_mov]','$_POST[id_producto]','$_POST[cantidad]','$_POST[dosis]','$_POST[via]','$_POST[observacion]','$_SESSION[gid_usuario]','$hoy')";
//echo "<br>".$sql_;
$link->query($sql_);
$id_movimiento=$link->insert_id;
if($link->affected_rows > 0){
    $msg="Registro guardado con exito;";
}
else{$msg="Registro no guardado;";}
$msg=$msg." A continuación se ingresará un nuevo registro";
$consulta="SELECT inventario_paciente.id_inventario, inventario_paciente.id_ingreso, inventario_paciente.id_producto,inventario_paciente.cantidad_aplicada FROM inventario_paciente WHERE inventario_paciente.id_ingreso='$_POST[id_ingreso]' AND inventario_paciente.id_producto='$_POST[id_producto]'";
//echo "<br>".$consulta;

//$link->query($consulta);
$consulta=$link->query($consulta);
if($consulta->num_rows<>0){
    $row=$consulta->fetch_array();
    $sql_="UPDATE inventario_paciente SET cantidad_aplicada=$row[cantidad_aplicada]+$_POST[cantidad] WHERE id_inventario='$row[id_inventario]'";
    //echo "<br>".$sql_;
    $link->query($sql_);   
}

?>
<body onload="continuar('<?php echo $msg;?>')">
<form name='form1' method="post" action="mn_administracion1.php">
    <?php 
    echo "<br>".$msg;
    //echo "<input type='hidden' name='id_movimiento' value='$id_movimiento'>";
    echo "<input type='hidden' name='id_ingreso' value='$_POST[id_ingreso]'>";
    ?>

</form>
</body>
</html>
