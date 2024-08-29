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
                $("#course").autocomplete("mn_autocomp_pac_ingre.php", {
                    width: 460,
                    matchContains: false,
                    mustMatch: false,
                    selectFirst: false
                });
                $("#course2").autocomplete("mn_autocomp_producto.php", {
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
            });
        </script>
        <script language='JavaScript'>
            function validar(){
                error="";
                if(document.form1.id_ingreso.value==''){error+="Seleccionar al paciente\n";}
                if(document.form1.fecha_mov.value==''){error+="Fecha\n";}
                if(document.form1.id_producto.value==''){error+="Seleccionar el producto\n";}
                if(document.form1.cantidad.value==''){error+="Cantidad\n";}
                if(error!=""){
                    alert("Es necesario complementar la siguiente información:\n"+error);
                }
                else{
                    if(confirm("Recuerde que al guardar, se afecta el inventario.\nDesea Guardar?")){
                        document.form1.submit();
                    }
                }
            }
        </script>
        <title>Medinet</title>
    </head>
<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_recepcion.php");
$link=conectarbd();
?>

<form method="post" name='form1' action="mn_recepcion11.php">

    <?php
    require("mn_datos_recepcion.php");
    ?>
    <br><button type="button" id='btnguardar' onclick='validar()'><span class="icon-save"></span> Guardar</button> 
</form>
</body>
</html>