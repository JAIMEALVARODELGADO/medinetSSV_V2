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

$desplazam=$_POST['desplazam'];
if($_POST['desplazam']=='Otro'){
    $desplazam=$_POST['cual_desp'];
}

$alergia_medicame=$_POST['alergia_medicame'];
if($_POST['alergia_medicame']=='Si'){
    $alergia_medicame=$_POST['cual_med'];
}

$alergia_alimento=$_POST['alergia_alimento'];
if($_POST['alergia_alimento']=='Si'){
    $alergia_alimento=$_POST['cual_ali'];
}

$diag_rel1=0;
if(!empty($_POST['diag_rel1'])){
    $diag_rel1=$_POST['diag_rel1'];
}

$sql_="INSERT INTO ingreso(id_ingreso, id_persona, jornada, fecha_ing, peso, id_eps, control_esfin, desplazam, alimentacion_indep, comunicacion_verbal, alergia_medicame, alergia_alimento, estado, id_operador, fecha_reg, observacion_ing,diag_prin,diag_rel1) VALUES(0,'$_POST[id_persona]','$_POST[jornada]','$_POST[fecha_ing]','$_POST[peso]','$_POST[id_eps]','$_POST[control_esfin]','$desplazam','$_POST[alimentacion_indep]','$_POST[comunicacion_verbal]','$alergia_medicame','$alergia_alimento','AC','$_SESSION[gid_usuario]','$hoy','$_POST[observacion_ing]','$_POST[diag_prin]','$diag_rel1')"; 
//echo "<br>".$sql_;
$link->query($sql_);
$id_ingreso=$link->insert_id;
if($link->affected_rows > 0){
    $msg="Registro guardado con exito";
}
else{$msg="Registro no guardado";}
if(!empty($_POST['nombre_acud1'])){
    $sql_="INSERT INTO acudiente(id_acudiente, id_ingreso, nombre_acud, telefono_acud, direccion_acud, parentesco,tipo_identificacion,identificacion,correo,fecha_nacimiento) 
    VALUES(0,$id_ingreso,'$_POST[nombre_acud1]','$_POST[telefono_acud1]','$_POST[direccion_acud1]','$_POST[parentesco1]','$_POST[tipo_identificacion1]','$_POST[identificacion1]','$_POST[correo1]','$_POST[fecha_nacimiento1]')";
    //echo "<br>".$sql_;
    $link->query($sql_);
}
if(!empty($_POST['nombre_acud2'])){
    $sql_="INSERT INTO acudiente(id_acudiente, id_ingreso, nombre_acud, telefono_acud, direccion_acud, parentesco,tipo_identificacion,identificacion,correo,fecha_nacimiento) 
    VALUES(0,$id_ingreso,'$_POST[nombre_acud2]','$_POST[telefono_acud2]','$_POST[direccion_acud2]','$_POST[parentesco2]','$_POST[tipo_identificacion2]','$_POST[identificacion2]','$_POST[correo2]','$_POST[fecha_nacimiento2]')";
    //echo "<br>".$sql_;
    $link->query($sql_);
}

for($i=1;$i<=8;$i++){
    $var_='actividad'.$i;
    $actividad=$_POST[$var_];
    if(!empty($actividad)){
        $sql_="INSERT INTO actividades_fav(id_actividad,id_ingreso,descripcion) VALUES(0,'$id_ingreso','$actividad')";
        //echo "<br>".$sql_;
        $link->query($sql_);
    }
}


?>
<body onload="continuar('<?php echo $msg;?>')">
<form name='form1' method="post" action="mn_ingresopaciente2.php">
    <?php 
    echo "<br>".$msg;
    echo "<input type='hidden' name='id_ingreso' value='$id_ingreso'>";
    ?>

</form>
</body>
</html>
