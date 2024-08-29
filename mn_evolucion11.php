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
//echo "AAAAAAAAA".$_POST['descripcion_for'];
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
//require("pp_menu.php");
$link=conectarbd();
$hoy=cambiafecha(hoy());
$hora=date("H:i:s");
$hoy=$hoy.' '.$hora;
$guardar='S';
if(isset($_POST['salida']) and $_POST['salida']=='S'){
    $consultasaldo="SELECT descripcion,saldo FROM vw_inventario_paciente WHERE id_ingreso='$_POST[id_ingreso]' AND saldo<>0";
    echo "<br>".$consultasaldo;
    $consultasaldo=$link->query($consultasaldo);
    if($consultasaldo->num_rows<>0){
        $msg="Registro no guardado\n Hay existencias en el inventario del paciente";
        $guardar='N';
        ?>
        <script type="text/javascript">alert('Registro no guardado\n Hay existencias en el inventario del paciente,\n estas deben estar en cero (0) para poderle dar salida');</script>
        <?php
    }
    else{
        $sql_="UPDATE ingreso SET fecha_egreso='$_POST[fecha_evol]', id_operador_egre='$_SESSION[gid_usuario]', estado='RE' WHERE id_ingreso='$_POST[id_ingreso]'";
        //echo "<br>".$sql_;
        $link->query($sql_);
    }
}
if($guardar=='S'){
    $fecha_evol=$_POST['fecha_evol'].' '.$_POST['hora_evol'];
    //echo $fecha_evol;
    $sql_="INSERT INTO evolucion_nota(id_evolucion, id_ingreso, fecha_evol, observacion, id_operador, fecha_reg, id_formato) VALUES(0,'$_POST[id_ingreso]','$fecha_evol','$_POST[observacion]','$_SESSION[gid_usuario]','$hoy','$_POST[id_formato]')";
    //echo "<br>".$sql_;
    $link->query($sql_);
    $id_evolucion=$link->insert_id;
}
if($link->affected_rows > 0){
    $msg="Registro guardado con exito";
}
else{$msg="Registro no guardado";}

?>
<body onload="continuar('<?php echo $msg;?>')">
<form name='form1' method="post" action="mn_lista_pacientes1.php">
    <?php 
    echo "<br>".$msg;
    //echo "<input type='hidden' name='id_evolucion' value='$id_evolucion'>";
    ?>
</form>
</body>
</html>
