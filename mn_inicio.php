<?php
session_start();
/*echo "<br>".$_SESSION['gid_usuario'];
echo "<br>".$_SESSION['gnombre'];*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="es-ES" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <meta description="Registro y cotrol de actividades asistenciales"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <title>Medinet</title>
    </head>
<body>

<header>
</header>
<?php
require("mn_funciones.php");
require("mn_menu.php");
/*$link=conectarbd();
$consulta="SELECT 
codigo_mun,
nombre,
departamento FROM municipio ORDER BY nombre";
echo "<br>".$consulta;
$consulta=$link->query($consulta);
if($consulta->num_rows<>0){
    while($row=$consulta->fetch_array()){
        echo "<br>".$row['codigo_mun'];
    }
}
*/                                                                                                                                           
?>
</body>
</html>