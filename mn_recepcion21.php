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
        function validar(){
            var error='';
            if(document.form1.fecha_mov.value==''){error+="Fecha\n";}
            if(document.form1.cantidad.value==''){error+="Cantidad\n";}
            if(error!=''){
                alert("Es necesario complementar la siguiente información:\n"+error);
            }
            else{
                document.form1.submit();
            }
        }
    </script>
<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_recepcion.php");
$link=conectarbd();
$consulta="SELECT id_movimiento,tipo_iden,identificacion,papellido,sapellido,pnombre,snombre,fecha_mov, CONCAT(descripcion,' ',concentracion,' ',presentacion) AS producto, lote, remite, cantidad, observacion_mov FROM vw_movimientos WHERE id_movimiento='$_GET[id_movimiento]'";
//echo "<br>".$consulta;
$consulta=$link->query($consulta);
if($consulta->num_rows > 0){
    $row=$consulta->fetch_array();
    $identificacion=$row['tipo_iden'].' '.$row['identificacion'].' '.$row['pnombre'].' '.$row['snombre'].' '.$row['papellido'].' '.$row['sapellido'];
    $fecha_mov=SUBSTR($row['fecha_mov'],0,10);
    $producto=$row['producto'];
    $remite=$row['remite'];
    $lote=$row['lote'];
    $cantidad=$row['cantidad'];
    $observacion_mov=$row['observacion_mov'];
}
?>
<form name='form1' method="post" action="mn_recepcion211.php">
    <?php
    require("mn_datos_recepcion.php");
    echo "<input type='hidden' name='id_movimiento' value='$_GET[id_movimiento]'/>";
    ?>
    <button type="button" onclick='validar()'><span class="icon-save"></span> Guardar</button>
    <script language="JavaScript">
        document.form1.nombre_pac.value='<?php echo $identificacion;?>';
        document.form1.nombre_pac.disabled=true;
        document.form1.fecha_mov.value='<?php echo $fecha_mov;?>';
        document.form1.nombre_prod.value='<?php echo $producto;?>';
        document.form1.nombre_prod.disabled=true;
        document.form1.remite.value='<?php echo $remite;?>';
        document.form1.lote.value='<?php echo $lote;?>';
        document.form1.cantidad.value='<?php echo $cantidad;?>';
        document.form1.observacion.value='<?php echo $observacion_mov;?>';
    </script>
</form>
</body>
</html>
