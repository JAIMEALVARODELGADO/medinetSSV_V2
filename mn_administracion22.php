<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="es-ES" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <head>        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
<body>

<?php
require("mn_funciones.php");
//require("pp_menu.php");
//require("pp_menu_estudiante.php");
$link=conectarbd();
//echo $_GET['id_movimiento'];

$consulta="SELECT movimiento_inventario.id_ingreso,movimiento_inventario.id_producto ,movimiento_inventario.cantidad FROM movimiento_inventario WHERE movimiento_inventario.id_movimiento='$_GET[id_movimiento]'";
//echo "<br>".$consulta;
$link->query($consulta);
$consulta=$link->query($consulta);
$cantidad=0;
if($consulta->num_rows<>0){
    $row=$consulta->fetch_array();
    $id_ingreso=$row['id_ingreso'];
    $id_producto=$row['id_producto'];
    $cantidad=$row['cantidad'];
}
$sql_elim="DELETE FROM movimiento_inventario WHERE id_movimiento='$_GET[id_movimiento]'";
//echo "<br>".$sql_elim;
$link->query($sql_elim);
$msg='';
if($link->affected_rows > 0){
    $msg="Registro eliminado con exito";

    $consultainv="SELECT inventario_paciente.id_inventario, inventario_paciente.cantidad_aplicada FROM inventario_paciente WHERE inventario_paciente.id_ingreso='$id_ingreso' AND id_producto='$id_producto'";
    //echo "<br>".$consultainv;
    $link->query($consultainv);
    $consultainv=$link->query($consultainv);
    $rowinv=$consultainv->fetch_array();
    $sql_="UPDATE inventario_paciente SET cantidad_aplicada=$rowinv[cantidad_aplicada]-$cantidad WHERE id_inventario='$rowinv[id_inventario]'";
    //echo "<br>".$sql_;
    $link->query($sql_);
}
else{$msg="Registro no eliminado";}
?>
<form name='form1' method="post" action="mn_administracion2.php">
    <?php echo $msg;?>
    <script language="JavaScript">continuar('<?php echo $msg;?>');</script>
</form>
</body>
</html>
