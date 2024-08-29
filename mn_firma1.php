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
            document.form1.submit();
        }        
    </script>

<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
//require("mn_menu_cups.php");
$ruta='';
if(isset($_POST['ruta'])){$ruta=$_POST['ruta'];}
?>
<form name='form1' method="post" action="mn_firma11.php" enctype="multipart/form-data">
    <br><h3>Subir la firma del personal asistencial</h3>
    
    <br>
    <br><b>Antención!</b>
    <br>
    <br>La firma debe ser un archivo en formato <b>jpg</b>, con el número de idetificación como nombre
    <br>Ejemplo: <b>123456789.jpg</b>
    <br><br><input type="file" id="firma" name="firma">


    <!--<br><button type="button" id="btnNuevo" class="btn btn-primary">Guardar <span class="fas fa-save"></span></button>-->
    
    <br><button type="button" onclick='validar()'><span class="icon-save"></span> Guardar</button>
    
    
</form>
</body>
</html>
