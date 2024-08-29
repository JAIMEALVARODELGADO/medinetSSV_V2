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
            document.form1.submit();
        }

        function eliminar(id_){
            alert("Opcion NO Disponible")
            //if(confirm("Desea eliminar la institucion\n"+id_)){
                //window.open("pp_institucion22.php?id_institucion="+id_,"_self");
            //}
        }

        function editar(id_){
            window.open("mn_cups21.php?id_cups="+id_,"_self");
        }
    </script>

<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_cups.php");
$link=conectarbd();
$descripcion_cups='';
$codigo_cups='';
$estado_cups='';
if(isset($_POST['descripcion_cups'])){$descripcion_cups=$_POST['descripcion_cups'];}
if(isset($_POST['codigo_cups'])){$codigo_cups=$_POST['codigo_cups'];}
if(isset($_POST['estado_cups'])){$estado_cups=$_POST['estado_cups'];}
?>
<form name='form1' method="post" action="mn_cups2.php">
    <span class="form-el"><input type='text' id='descripcion_cups' name='descripcion_cups' maxlength='60' size='60' placeholder='Descripción' value="<?php echo $descripcion_cups;?>"/></span>
    <span class="form-el"><input type='text' id='codigo_cups' name='codigo_cups' maxlength='8' size='8' placeholder='Código' value="<?php echo $codigo_cups;?>"/></span>
    <span class="form-el">
        Estado:<select id='estado_cups' name='estado_cups' value="<?php echo $estado_cups;?>">
            <option value=''></option>
            <option value='AC'>Activo</option>
            <option value='IN'>Inactivo</option>
        </select>
    </span>
    <a href="#" onclick='validar();' title='Buscar'><span class="icon-magnifying-glass"></span> </a>
<?php
$condicion='';
if(!empty($descripcion_cups)){$condicion=$condicion."descripcion_cups LIKE '%$descripcion_cups%' AND ";}
if(!empty($codigo_cups)){$condicion=$condicion."codigo_cups LIKE '%$codigo_cups%' AND ";}
if(!empty($estado_cups)){$condicion=$condicion."estado_cups='$estado_cups' AND ";}
if(!empty($condicion)){
    $condicion=substr($condicion,0,-5);
    //echo "<br>".$condicion;
}
    $consulta="SELECT id_cups,codigo_cups,descripcion_cups,estado_cups FROM cups";
    if(!empty($condicion)){$consulta=$consulta." WHERE ".$condicion;}
    $consulta=$consulta." ORDER BY descripcion_cups";
    //echo "<br>".$consulta;
    $consulta=$link->query($consulta);
    if($consulta->num_rows<>0){
        echo "<br><br><table width='100%'>";
        echo "<th colspan='2'>Opciones</th>".
            "<th>Código</th>".
            "<th>Descripción</th>".
            "<th>Estado</th>";
        while($row=$consulta->fetch_array()){
            echo "<tr>";
            echo "<td width='5%'><a href='#' onclick=editar($row[id_cups]) title='Editar' class='btnhref'><span class='icon-edit'></span></a></td>";
            echo "<td width='5%'><a href='#' onclick=eliminar($row[id_cups]) title='Eliminar' class='btnhref'><span class='icon-trash Eliminar'></span></a></td>";
            echo "<td>$row[codigo_cups]</td>";
            echo "<td>$row[descripcion_cups]</td>";
            echo "<td>$row[estado_cups]</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
//}
?>
</form>
</body>
</html>
