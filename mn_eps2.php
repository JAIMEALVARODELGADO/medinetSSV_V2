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

        function eliminar(id_){
            alert("Opcion NO Disponible")
            //if(confirm("Desea eliminar la institucion\n"+id_)){
                //window.open("pp_institucion22.php?id_institucion="+id_,"_self");
            //}
        }

        function editar(id_){
            window.open("mn_eps21.php?id_eps="+id_,"_self");
        }
    </script>

<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_eps.php");
$link=conectarbd();
?>
<form name='form1' method="post" action="mn_eps11.php">
    <table width="50%">
        <th colspan="2">Opciones</th>
        <th>Nombre</th>
        <th>Nit</th>
        <th>Teléfono</th>
        <th>Contacto</th>
        <?php
            $consulta="SELECT id_eps,nit,nombre_eps,telefono_eps,nombre_cont FROM eps ORDER BY nombre_eps";
            $res=$link->query($consulta);
            if($res->num_rows<>0){
                while($row=$res->fetch_array()){
                    echo "<tr>";
                    echo "<td width='5%'><a href='#' onclick=editar('$row[id_eps]') title='Editar' class='btnhref'><span class='icon-edit'></span></a></td>";
                    echo "<td width='5%'><a href='#' onclick=eliminar('$row[id_eps]') title='Eliminar' class='btnhref'><span class='icon-trash Eliminar'></span></a></td>";
                    echo "<td>".$row['nombre_eps']."</td>";
                    echo "<td>".$row['nit']."</td>";
                    echo "<td>".$row['telefono_eps']."</td>";
                    echo "<td>".$row['nombre_cont']."</td>";
                    echo "</tr>";
                }
            }
        ?>
    </table>
</form>
</body>
</html>
