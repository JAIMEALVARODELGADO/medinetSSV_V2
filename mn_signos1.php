<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="es-ES" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="UTF-8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <meta description="Registro y cotrol de actividades asistenciales"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="fonts/style.css">
        <title>Medinet</title>
    </head>
    <script language="JavaScript">
        function consulta(id_,id_formato){
            url_="mn_signos11.php?id_ingreso="+id_;
            //alert(url_);
            window.open(url_,"_self");
        }
    </script>

<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
//require("mn_menu_evolucion.php");
require("mn_menu_signos.php");
?>
<form name='form1' method="post" action="mn_administracion2.php">
<?php
$consulta="SELECT id_ingreso,tipo_iden,identificacion,CONCAT(pnombre,' ',snombre) AS nombres,CONCAT(papellido,' ',sapellido) AS apellidos, nombre_eps, fecha_ing FROM vw_ingreso WHERE estado='AC' ORDER BY nombres";
//echo "<br>".$consulta;
    $consulta=$link->query($consulta);
    if($consulta->num_rows<>0){
        echo "<br><br><table width='100%'>";
        echo "<th>Opciones</th>".
            "<th>Tp.Iden.</th>".
            "<th>Identificación.</th>".
            "<th>Nombres</th>".
            "<th>Apellidos</th>".
            "<th>Fecha Ingreso</th>",
            "<th>EPS</th>";
        while($row=$consulta->fetch_array()){
            echo "<tr>";
            echo "<td width='5%'><a href='#' onclick=consulta($row[id_ingreso]) title='Registrar Signos Vitales' class='btnhref'><span class='icon-calendar'></span></a></td>";        
            echo "<td>$row[tipo_iden]</td>";
            echo "<td>$row[identificacion]</td>";
            echo "<td>$row[nombres]</td>";
            echo "<td>$row[apellidos]</td>";
            echo "<td>$row[fecha_ing]</td>";
            echo "<td>$row[nombre_eps]</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
?>
</form>
</body>
</html>
