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
            //if(document.form1.nombre.value=='' && document.form1.municipio.value==''&& document.form1.director.value==''){
            //    alert("Para la busqueda, al menos se debe digitar el valor de un campon"+error);
            //}
            //else{
                document.form1.submit();
            //}
        }

        function eliminar(id_){
            if(confirm("Desea eliminar el producto\n")){
                window.open("mn_producto22.php?id_producto="+id_,"_self");
            }
        }

        function editar(id_){
            window.open("mn_producto21.php?id_producto="+id_,"_self");
        }
    </script>

<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_producto.php");
$link=conectarbd();
$tipo_producto='';
$descripcion='';
$codigo_producto='';
if(isset($_POST['tipo_producto'])){$nombre=$_POST['tipo_producto'];}
if(isset($_POST['descripcion'])){$descripcion=$_POST['descripcion'];}
if(isset($_POST['codigo_producto'])){$codigo_producto=$_POST['codigo_producto'];}
?>
<form name='form1' method="post" action="mn_producto2.php">
    <span class="form-el">
        Tipo:<select id='tipo_producto' name='tipo_producto' value="<?php echo $tipo_producto;?>">
            <option value=''></option>
            <option value='M'>Medicamento</option>
            <option value='D'>Dispositivo</option>
        </select>

        
    </span>
    <span class="form-el"><input type='text' id='descripcion' name='descripcion' maxlength='60' size='60' placeholder='Nombre' value="<?php echo $descripcion;?>"/></span>
    <span class="form-el"><input type='text' id='codigo_producto' name='codigo_producto' maxlength='20' size='20' placeholder='C�digo' value="<?php echo $descripcion;?>"/></span>
    <a href="#" onclick='validar();' title='Buscar'><span class="icon-magnifying-glass"></span> </a>
<?php
$condicion='';
if(!empty($tipo_producto)){$condicion=$condicion."tipo_producto=='$tipo_producto' AND ";}
if(!empty($descripcion)){$condicion=$condicion."descripcion LIKE '%$descripcion%' AND ";}
if(!empty($condicion)){
    $condicion=substr($condicion,0,-5);
    //echo "<br>".$condicion;
}
    $consulta="SELECT id_producto,tipo_producto,codigo_producto,descripcion,concentracion,presentacion FROM producto";
    if(!empty($condicion)){$consulta=$consulta." WHERE ".$condicion;}
    $consulta=$consulta." ORDER BY descripcion";
    //echo "<br>".$consulta;
    $consulta=$link->query($consulta);
    if($consulta->num_rows<>0){
        echo "<br><br><table width='100%'>";
        echo "<th colspan='2'>Opciones</th>".
            "<th>Tipo de Producto</th>".
            "<th>C�digo</th>".
            "<th>Nombre</th>".
            "<th>Concentraci�n</th>".
            "<th>Presentaci�n</th>";
        while($row=$consulta->fetch_array()){
            //echo "<br>".$row['nombre'];
            $nombre=$row['descripcion'];
            if($row['tipo_producto']=='M'){$tipo='Medicamento';}
            else{$tipo='Dispositivo';}
            echo "<tr>";
            echo "<td width='5%'><a href='#' onclick=editar($row[id_producto]) title='Editar' class='btnhref'><span class='icon-edit'></span></a></td>";
            echo "<td width='5%'><a href='#' onclick=eliminar($row[id_producto]) title='Eliminar' class='btnhref'><span class='icon-trash Eliminar'></span></a></td>";
            echo "<td>$tipo</td>";
            echo "<td>$row[codigo_producto]</td>";
            echo "<td>$row[descripcion]</td>";
            echo "<td>$row[concentracion]</td>";
            echo "<td>$row[presentacion]</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
//}
?>
</form>
</body>
</html>
