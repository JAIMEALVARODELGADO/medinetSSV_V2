<?php
session_start();
//$_SESSION['datos'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="es-ES" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
        function eliminar(id_,numiden_){
            /*if(confirm("Desea eliminar a la persona con la identifición\n"+numiden_)){
                window.open("mn_persona22.php?id_persona="+id_,"_self");
            }*/
            alert("Opcion NO disponible");
        }
        function editar(id_){
            window.open("mn_ingresopaciente21.php?id_ingreso="+id_,"_self");
        }
        function acudiente(id_){
            window.open("mn_ingresopaciente23.php?id_ingreso="+id_,"_self");
        }
        function imprimir(id_){
            window.open("mn_ingresopaciente24.php?id_ingreso="+id_,"_new");
        }
    </script>

<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_ingreso.php");
$identificacion='';
$apellidos='';
$nombres='';
$orden='';
$id_ingreso='';
if(isset($_POST['identificacion'])){$identificacion=$_POST['identificacion'];}
if(isset($_POST['apellidos'])){$apellidos=$_POST['apellidos'];}
if(isset($_POST['nombres'])){$nombres=$_POST['nombres'];}
if(isset($_POST['orden'])){$orden=$_POST['orden'];}
if(isset($_POST['id_ingreso'])){$id_ingreso=$_POST['id_ingreso'];}
?>
<form name='form1' method="post" action="mn_ingresopaciente2.php">
    <span class="form-el"><input type='text' id='identificacion' name='identificacion' maxlength='20' size='20' placeholder='Identificación' value="<?php echo $identificacion;?>"/></span>
    <span class="form-el"><input type='text' id='nombres' name='nombres' maxlength='30' size='30' placeholder='Nombres' value="<?php echo $nombres;?>"/></span>
    <span class="form-el"><input type='text' id='apellidos' name='apellidos' maxlength='30' size='30' placeholder='Apellidos' value="<?php echo $apellidos;?>"/></span>
    <span class="form-el">Orden
        <select id='orden' name='orden' value="<?php echo $orden;?>">
            <option value='identificacion'>Identificación</option>
            <option value='papellido'>Apellidos</option>
            <option value='pnombre'>Nombres</option>
            <option value='fecha_ing'>Fecha de Ingreso</option>
        </select>
    </span>
    <a href="#" onclick='validar();' title='Buscar'><span class="icon-magnifying-glass"></span> </a>
<?php
$condicion="estado='AC' AND ";
if(!empty($id_ingreso)){$condicion=$condicion."id_ingreso='$id_ingreso' AND ";}
if(!empty($identificacion)){$condicion=$condicion."identificacion='$identificacion' AND ";}
if(!empty($apellidos)){$condicion=$condicion."(papellido LIKE '%$apellidos%' OR sapellido LIKE '%$apellidos%') AND ";}
if(!empty($nombres)){$condicion=$condicion."(pnombre LIKE '%$nombres%' OR snombre LIKE '%$nombres%') AND ";}
if(!empty($condicion)){
    $condicion=substr($condicion,0,-5);
    //echo "<br>".$condicion;
    if(empty($orden)){$orden='identificacion';}
    $consulta="SELECT id_ingreso,tipo_iden,identificacion,CONCAT(pnombre,' ',snombre) AS nombres,CONCAT(papellido,' ',sapellido) AS apellidos,fecha_ing,jornada,nombre_eps FROM vw_ingreso WHERE ".$condicion." ORDER BY ".$orden;
    //echo "<br>".$consulta;
    $consulta=$link->query($consulta);
    if($consulta->num_rows<>0){
        echo "<br><br><table width='100%'>";
        echo "<th colspan='3'>Opciones</th>".
            "<th>Tp.Iden.</th>".
            "<th>Identificación.</th>".
            "<th>Nombres</th>".
            "<th>Apellidos</th>".
            "<th>F.Ingreso</th>",
            "<th>Jornada</th>",
            "<th>EPS</th>";
        while($row=$consulta->fetch_array()){
            echo "<tr>";
            echo "<td width='5%'><a href='#' onclick=editar($row[id_ingreso]) title='Editar' class='btnhref'><span class='icon-edit'></span></a></td>";
            echo "<td width='5%'><a href='#' onclick=eliminar($row[id_ingreso],$row[identificacion]) title='Eliminar' class='btnhref'><span class='icon-trash Eliminar'></span></a></td>";
            echo "<td width='5%'><a href='#' onclick=acudiente($row[id_ingreso]) title='Acudientes y Actividades Favoritas' class='btnhref'><span class='icon-users'></span></a></td>";
            echo "<td width='5%'><a href='#' onclick=imprimir($row[id_ingreso]) title='Imprimir' class='btnhref'><span class='icon-print'></span></a></td>"; 
            echo "<td>$row[tipo_iden]</td>";
            echo "<td>$row[identificacion]</td>";
            echo "<td>$row[nombres]</td>";
            echo "<td>$row[apellidos]</td>";
            echo "<td>$row[fecha_ing]</td>";
            echo "<td>$row[jornada]</td>";
            echo "<td>$row[nombre_eps]</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
}
?>
</form>
</body>
</html>
