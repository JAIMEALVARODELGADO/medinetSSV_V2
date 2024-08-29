<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es-ES" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="UTF-8"/>
        <meta description="Registro y cotrol de actividades asistenciales"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="fonts/style.css">
        <link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type='text/javascript' src='js/jquery.autocomplete.js'></script>
        <script type="text/javascript">
            $().ready(function() {  
                $("#course2").autocomplete("mn_autocomp_cie.php", {
                    width: 460,
                    matchContains: false,
                    mustMatch: false,
                    selectFirst: false
                });

                $("#course3").autocomplete("mn_autocomp_cie.php", {
                    width: 460,
                    matchContains: false,
                    mustMatch: false,
                    selectFirst: false
                });
                
                $("#course2").result(function(event, data, formatted) {
                    $("#course_val2").val(data[1]);
                });

                $("#course3").result(function(event, data, formatted) {
                    $("#course_val3").val(data[1]);
                });
            });
        </script>

        <title>Medinet</title>
    </head>
    <script language="JavaScript">
        function validar(){
            var error='';
            if(document.form1.fecha_ing.value==''){error+="Fecha de ingreso\n";}
            if(document.form1.peso.value==''){error+="Peso\n";}
            if(document.form1.id_eps.value==''){error+="Seleccionar la EPS\n";}
            if(document.form1.control_esfin.value==''){error+="Contro de esfinteres\n";}
            if(document.form1.cual_desp.value==''){error+="Desplazamiento\n";}
            if(document.form1.alimentacion_indep.value==''){error+="Alimentacion independiente\n";}
            if(document.form1.comunicacion_verbal.value==''){error+="Comunicacion verbal\n";}
            if(document.form1.cual_med.value==''){error+="Alergia a medicamentos\n";}
            if(document.form1.cual_ali.value==''){error+="Alergia a alimentos\n";}
            if(error!=''){
                alert("Es necesario complementar la siguiente informaci�n:\n"+error);
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
require("mn_menu_ingreso.php");
$link=conectarbd();
$consulta="SELECT id_ingreso,tipo_iden,identificacion,papellido,sapellido,pnombre,snombre,fecha_nacim,direccion,telefono,sexo,jornada,fecha_ing,peso,id_eps,control_esfin,desplazam,alimentacion_indep,comunicacion_verbal,alergia_medicame,alergia_alimento,observacion_ing,diag_prin,diag_rel1,codigo_cie,descripcion_cie,cie_rel1,desc_cie_rel1,estado
FROM vw_ingreso WHERE id_ingreso='$_GET[id_ingreso]'";
//echo "<br>".$consulta;
$consulta=$link->query($consulta);
if($consulta->num_rows > 0){
    $row=$consulta->fetch_array();
    $identificacion=$row['tipo_iden'].' '.$row['identificacion'].' '.$row['pnombre'].' '.$row['snombre'].' '.$row['papellido'].' '.$row['sapellido'];
    $jornada=$row['jornada'];
    $fecha_ing=$row['fecha_ing'];
    $peso=$row['peso'];
    $id_eps=$row['id_eps'];
    $control_esfin=$row['control_esfin'];
    $desplazam=$row['desplazam'];
    $alimentacion_indep=$row['alimentacion_indep'];
    $comunicacion_verbal=$row['comunicacion_verbal'];
    $alergia_medicame=$row['alergia_medicame'];
    $alergia_alimento=$row['alergia_alimento'];
    $observacion_ing=$row['observacion_ing'];
    $diag_prin=$row['diag_prin'];
    $diag_rel1=$row['diag_rel1'];
    $diag_principal=$row['codigo_cie'].' '.$row['descripcion_cie'];
    $diag_relacionado=$row['cie_rel1'].' '.$row['desc_cie_rel1'];
    $estado=$row['estado'];
}
?>
<form name='form1' method="post" action="mn_ingresopaciente211.php">
    <?php
    require("mn_datos_ingreso.php");
    echo "<input type='hidden' name='id_ingreso' value='$_GET[id_ingreso]'/>";
    ?>
    <button type="button" onclick='validar()'><span class="icon-save"></span> Guardar</button>
    <script language="JavaScript">
        document.form1.nombre_pac.value='<?php echo $identificacion;?>';
        document.form1.nombre_pac.disabled=true;
        document.form1.jornada.value='<?php echo $jornada;?>';
        document.form1.fecha_ing.value='<?php echo $fecha_ing;?>';
        document.form1.peso.value='<?php echo $peso;?>';
        document.form1.id_eps.value='<?php echo $id_eps;?>';
        document.form1.control_esfin.value='<?php echo $control_esfin;?>';
        document.form1.desplazam.value='<?php echo $desplazam;?>';
        document.form1.desplazam.disabled=true;
        document.form1.cual_desp.value='<?php echo $desplazam;?>';
        document.form1.alimentacion_indep.value='<?php echo $alimentacion_indep;?>';
        document.form1.comunicacion_verbal.value='<?php echo $comunicacion_verbal;?>';
        document.form1.alergia_medicame.value='<?php echo $alergia_medicame;?>';
        document.form1.alergia_medicame.disabled=true;
        document.form1.cual_med.value='<?php echo $alergia_medicame;?>';
        document.form1.alergia_alimento.value='<?php echo $alergia_alimento;?>';
        document.form1.alergia_alimento.disabled=true;
        document.form1.cual_ali.value='<?php echo $alergia_alimento;?>';
        document.form1.diag_principal.value='<?php echo $diag_principal;?>';
        document.form1.diag_prin.value='<?php echo $diag_prin;?>';
        document.form1.diag_relacionado.value='<?php echo $diag_relacionado;?>';
        document.form1.diag_rel1.value='<?php echo $diag_rel1;?>';
        document.form1.estado.value='<?php echo $estado;?>';
    </script>
</form>
</body>
</html>
