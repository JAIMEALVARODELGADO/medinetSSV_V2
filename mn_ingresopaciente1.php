<?php
session_start();
//$_SESSION['datos'];
//$datos[0]='nombre';
//$datos[1]='codigo';
?>
<!DOCTYPE html>
<html lang="es">
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
                $("#course").autocomplete("mn_autocomp_pac.php", {
                    width: 460,
                    matchContains: false,
                    mustMatch: false,
                    selectFirst: false
                });
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
                
                $("#course").result(function(event, data, formatted) {
                    $("#course_val").val(data[1]);
                });
                $("#course2").result(function(event, data, formatted) {
                    $("#course_val2").val(data[1]);
                });
                $("#course3").result(function(event, data, formatted) {
                    $("#course_val3").val(data[1]);
                });
                
            });
        </script>
        <script language='JavaScript'>
            function validar(){
                error="";
                if(document.form1.id_persona.value==''){error+="Seleccionar al paciente\n";}
                if(document.form1.jornada.value==''){error+="Seleccionar la jornada\n";}
                if(document.form1.fecha_ing.value==''){error+="Fecha de ingreso\n";}
                if(document.form1.peso.value==''){error+="Peso\n";}
                if(document.form1.id_eps.value==''){error+="Seleccionar la EPS\n";}
                if(document.form1.control_esfin.value==''){error+="Contro de esfinteres\n";}
                if(document.form1.desplazam.value==''){error+="Desplazamiento\n";}
                if(document.form1.alimentacion_indep.value==''){error+="Alimentacion independiente\n";}
                if(document.form1.comunicacion_verbal.value==''){error+="Comunicacion verbal\n";}
                if(document.form1.alergia_medicame.value==''){error+="Alergia a medicamentos\n";}
                if(document.form1.alergia_alimento.value==''){error+="Alergia a alimentos\n";}
                if(document.form1.nombre_acud1.value==''){error+="Nombre del acudiente\n";}
                if(document.form1.telefono_acud1.value==''){error+="Tel�fono del acudiente\n";}
                if(document.form1.direccion_acud1.value==''){error+="Direcci�n del acudiente\n";}
                if(document.form1.parentesco1.value==''){error+="Parentesco del acudiente\n";}

                if(error!=""){
                    alert("Es necesario complementar la siguiente informaci�n:\n"+error);
                }
                else{
                    document.form1.submit();
                }
            }
        </script>
        <title>Medinet</title>
    </head>
<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_ingreso.php");
$link=conectarbd();
?>

<form method="post" name='form1' action="mn_ingresopaciente11.php">

    <?php
    $observacion_ing='';
    require("mn_datos_ingreso.php");
    require("mn_datos_acudiente.php");
    require("mn_datos_actividad.php");
    ?>
    <button type="button" id='btnguardar' onclick='validar()'><span class="icon-save"></span> Guardar</button> 
</form>
</body>
</html>