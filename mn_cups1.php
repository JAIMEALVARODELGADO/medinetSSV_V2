<?php
session_start();
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
        function validar(){
            var error='';
            if(document.form1.codigo_cups.value==''){error+="Cóodigo\n";}
            if(document.form1.descripcion_cups.value==''){error+="Descripción\n";}
            if(document.form1.estado_cups.value==''){error+="Estado\n";}
            if(error!=''){
                alert("Es necesario complementar la siguiente información:\n"+error);
            }
            else{
                document.form1.submit();
            }
            return true;
        }        
    </script>

<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_cups.php");
?>
<form name='form1' method="post" action="mn_cups11.php">
    <?php
    require("mn_datos_cups.php");
    ?>
    <button type="button" onclick='validar()'><span class="icon-save"></span> Guardar</button>
</form>
</body>
</html>
