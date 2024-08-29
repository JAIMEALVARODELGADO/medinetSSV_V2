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
            window.open("mn_ingresopaciente23.php?id_ingreso="+id_,"_self");
        }
    </script>
<?php
require("mn_funciones.php");
//require("pp_menu.php");
$link=conectarbd();
$sql_="INSERT INTO actividades_fav(id_actividad, id_ingreso, descripcion) VALUES(0,'$_POST[id_ingreso]', '$_POST[descripcion]')";
//echo "<br>".$sql_;
$link->query($sql_);
$id_ingreso=$_POST['id_ingreso'];
?>
<body onload="continuar('<?php echo $id_ingreso;?>')">
<form name='form1' method="post" action="mn_ingresopaciente23.php">
    

</form>
</body>
</html>
