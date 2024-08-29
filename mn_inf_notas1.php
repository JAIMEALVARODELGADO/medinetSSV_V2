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
            document.form1.action='mn_inf_notas1.php';
            document.form1.target='_self';
            document.form1.submit();
        }
        function imprimir(){
            //window.open("mn_administracion22.php?id_movimiento="+id_,"_self");
            //window.open("mn_inf_notas11.php","_new","width=300,he ight=500,toolbar=0,location=0,directories=0,status=0,menubar=0");
            //document.form1.action='mn_inf_notas11.php';
            document.form1.action='mn_inf_notas12.php';
            document.form1.target='_new';
            document.form1.submit();
        }
    </script>

<body>
<?php
require("mn_funciones.php");
require("mn_menu.php");
//require("mn_menu_administracion.php");
$id_ingreso='';
$identificacion='';
$apellidos='';
$nombres='';
$orden='';
$formato='';
$fecha_mov='';
$fecha_ini='';
$fecha_fin='';
$operador='';
if(isset($_POST['id_ingreso'])){$id_ingreso=$_POST['id_ingreso'];}
if(isset($_POST['identificacion'])){$identificacion=$_POST['identificacion'];}
if(isset($_POST['apellidos'])){$apellidos=$_POST['apellidos'];}
if(isset($_POST['nombres'])){$nombres=$_POST['nombres'];}
if(isset($_POST['orden'])){$orden=$_POST['orden'];}
if(isset($_POST['formato'])){$formato=$_POST['formato'];}
if(isset($_POST['fecha_ini'])){$fecha_ini=$_POST['fecha_ini'];}
if(isset($_POST['fecha_fin'])){$fecha_fin=$_POST['fecha_fin'];}
if(isset($_POST['operador'])){$operador=$_POST['operador'];}
?>
<div class="caja1">
    <h4>Informe Notas de Enfermería</h4>
</div>
<form name='form1' method="post" action="mn_inf_notas1.php">
    <span class="form-el"><input type='text' id='identificacion' name='identificacion' maxlength='20' size='15' placeholder='Identificaci�n' value="<?php echo $identificacion;?>"/></span>
    <span class="form-el"><input type='text' id='nombres' name='nombres' maxlength='30' size='20' placeholder='Nombres' value="<?php echo $nombres;?>"/></span>
    <span class="form-el"><input type='text' id='apellidos' name='apellidos' maxlength='30' size='20' placeholder='Apellidos' value="<?php echo $apellidos;?>"/></span>
    <span class="form-el"><input type='text' id='id_ingreso' name='id_ingreso' maxlength='5' size='5' placeholder='Nro Ingreso' value="<?php echo $id_ingreso;?>"/></span>
    <span class="form-el">Formato
        <select id='formato' name='formato'">
            <option value=''>Todos</option>
        <?php
            $consultafor="SELECT id_formato,descripcion_for FROM formatos ORDER BY descripcion_for";
            $sql_=$consultafor;
            $consultafor=$link->query($consultafor);
            while($rowfor=$consultafor->fetch_array()){
                echo "<option value='$rowfor[id_formato]'>$rowfor[descripcion_for]</option>";
            }
        ?>
        </select>
    </span>
    <br>
    <span class="form-el">Fecha Inicial: <input type='date' id='fecha_ini' name='fecha_ini' value="<?php echo $fecha_ini;?>"/></span>
    <span class="form-el">Fecha Final: <input type='date' id='fecha_fin' name='fecha_fin' value="<?php echo $fecha_fin;?>"/></span>
    <span class="form-el">Profesional: <input type='text' size='20' id='operador' name='operador' placeholder='Nombre del Profesional' value="<?php echo $operador;?>"/></span>
    <span class="form-el">Orden
        <select id='orden' name='orden' value="<?php echo $orden;?>">
            <option value='identificacion'>Identificaci�n</option>
            <option value='apellidos'>Apellidos</option>
            <option value='nombres'>Nombres</option>
            <option value='fecha_evol'>Fecha</option>
        </select>
    </span>
    <a href="#" onclick='validar();' title='Buscar'><span class="icon-magnifying-glass"></span> </a>
<?php
$condicion="";
if(!empty($id_ingreso)){$condicion=$condicion."id_ingreso='$id_ingreso' AND ";}
if(!empty($identificacion)){$condicion=$condicion."identificacion='$identificacion' AND ";}
if(!empty($apellidos)){$condicion=$condicion."apellidos LIKE '%$apellidos%' AND ";}
if(!empty($nombres)){$condicion=$condicion."nombres LIKE '%$nombres%' AND ";}
if(!empty($formato)){$condicion=$condicion."id_formato='$formato' AND ";}
if(!empty($fecha_ini)){$condicion=$condicion."fecha_evol BETWEEN '$fecha_ini 00:00' AND '$fecha_fin 23:59' AND ";}
if(!empty($operador)){$condicion=$condicion."operador LIKE '%$operador%' AND ";}
//echo $condicion;
if(!empty($condicion)){
    //$condicion="grupo_for='1' AND ";
    $condicion=substr($condicion,0,-5);
    //echo "<br>".$condicion;
    if(empty($orden)){$orden='identificacion';}
    $consulta="SELECT id_ingreso,fecha_ing,tipo_iden,identificacion,apellidos,nombres,fecha_evol,observacion,id_operador,operador, ident_oper,grupo_for,descripcion_for,codigo_cie,descripcion_cie FROM vw_evolucion_notas WHERE ".$condicion." ORDER BY ".$orden;
    //echo "<br>".$consulta;
    $sql_=$consulta;
    $consulta=$link->query($consulta);
    if($consulta->num_rows<>0){
        echo "<br><br><table width='100%'>";
        echo "<th>Ingreso</th>".
            "<th>Fecha Ingreso</th>".
            "<th>Tp.Iden.</th>".
            "<th>Identificaci�n.</th>".
            "<th>Nombres</th>".
            "<th>Apellidos</th>".
            "<th>Fecha Evol</th>",
            "<th>Observaci�n</th>",
            "<th>Responsable</th>";
        while($row=$consulta->fetch_array()){
            $descripcion_for=$row['descripcion_for'];
            //echo $descripcion_for;
            echo "<tr>";
            echo "<td>$row[id_ingreso]</td>";
            echo "<td>$row[fecha_ing]</td>";
            echo "<td>$row[tipo_iden]</td>";
            echo "<td>$row[identificacion]</td>";
            echo "<td>$row[nombres]</td>";
            echo "<td>$row[apellidos]</td>";
            echo "<td>$row[fecha_evol]</td>";
            echo "<td>$row[observacion]</td>";
            echo "<td>$row[operador]</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    //echo $sql_;
    ?>
    <input type="hidden" name="sql_" value="<?php echo $sql_;?>">
    <input type="hidden" name="descripcion_for" value="<?php echo $descripcion_for;?>">
    <center><a href="#" onclick='imprimir();' title='Imprimir'><span class="icon-print"></span> Imprimir</a></center>
    <script language="JavaScript">
        document.form1.orden.value='<?php echo $orden;?>';
        document.form1.formato.value='<?php echo $formato;?>';
    </script>
    <?php
}
?>
</form>
</body>
</html>
