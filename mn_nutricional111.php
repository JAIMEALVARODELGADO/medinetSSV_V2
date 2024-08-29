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

$fecha_nut=$hoy.' '.$_POST['hora'];

$sql_="INSERT INTO nutricional(id_nut,id_ingreso,fecha_nut,edad_actual_nut,diarrea_nut,estrenim_nut,gastritis_nut,ulceras_nut,nauceas_nut,pirosis_nut,vomito_nut,colitis_nut,dentadura_nut,otros_nut,observacion_nut,enfermedad_actual_nut,medicamentos_nut,cirugia_nut,altura_rodilla_nut,circ_brazo_nut,circ_cadera_nut,circ_cintura_nut,circ_pantorrilla_nut,peso_nut,talla_nut,dxnutricional_nut,id_operador) VALUES(0,'$_POST[id_ingreso]','$fecha_nut','$_POST[edad]','$_POST[diarrea_nut]','$_POST[estrenim_nut]','$_POST[gastritis_nut]','$_POST[ulceras_nut]','$_POST[nauceas_nut]','$_POST[pirosis_nut]','$_POST[vomito_nut]','$_POST[colitis_nut]','$_POST[dentadura_nut]','$_POST[otros_nut]','$_POST[observacion_nut]','$_POST[enfermedad_actual_nut]','$_POST[medicamentos_nut]','$_POST[cirugia_nut]','$_POST[altura_rodilla_nut]','$_POST[circ_brazo_nut]','$_POST[circ_cadera_nut]','$_POST[circ_cintura_nut]','$_POST[circ_pantorrilla_nut]','$_POST[peso_nut]','$_POST[talla_nut]','$_POST[dxnutricional_nut]','$_SESSION[gid_usuario]')";
//echo "<br>".$sql_;
$link->query($sql_);
//$id_evolucion=$link->insert_id;

if($link->affected_rows > 0){
    $msg="Registro guardado con exito";
}
else{$msg="Registro no guardado";}

?>
<body onload="continuar('<?php echo $msg;?>')">
<form name='form1' method="post" action="mn_nutricional1.php">
    <?php 
    echo "<br>".$msg;
    //echo "<input type='hidden' name='id_evolucion' value='$id_evolucion'>";
    ?>

</form>
</body>
</html>