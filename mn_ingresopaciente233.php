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
        function continuar(id_){
            //alert(id_);
            //document.form1.submit();
            window.open("mn_ingresopaciente23.php?id_ingreso="+id_,"_self");
        }
    </script>
<?php
require("mn_funciones.php");
//require("pp_menu.php");
$link=conectarbd();
$sql_="INSERT INTO acudiente(id_acudiente, id_ingreso, nombre_acud, telefono_acud, direccion_acud, parentesco,tipo_identificacion,identificacion,correo,fecha_nacimiento) 
VALUES(0,'$_POST[id_ingreso]', '$_POST[nombre_acud]', '$_POST[telefono_acud]', '$_POST[direccion_acud]', '$_POST[parentesco]' , '$_POST[tipo_identificacion]', '$_POST[identificacion]', '$_POST[correo]', '$_POST[fecha_nacimiento]')";
//echo "<br>".$sql_;
$link->query($sql_);
$id_ingreso=$_POST['id_ingreso'];
?>
<body onload="continuar('<?php echo $id_ingreso;?>')">
<form name='form1' method="post" action="mn_ingresopaciente23.php">
    

</form>
</body>
</html>
