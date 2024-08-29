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
            document.form1.action='mn_inf_movimiento1.php';
            document.form1.target='_self';
            document.form1.submit();
        }
        function imprimir(){
            //document.form1.action='mn_inf_movimiento11.php';
            document.form1.action='mn_inf_movimiento12.php';
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
$producto='';
if(isset($_POST['id_ingreso'])){$id_ingreso=$_POST['id_ingreso'];}
if(isset($_POST['identificacion'])){$identificacion=$_POST['identificacion'];}
if(isset($_POST['apellidos'])){$apellidos=$_POST['apellidos'];}
if(isset($_POST['nombres'])){$nombres=$_POST['nombres'];}
if(isset($_POST['producto'])){$producto=$_POST['producto'];}
?>
<div class="caja1">
    <h4>Informe de Movimiento de Medicamentos y Dispositivos</h4>
</div>
<form name='form1' method="post" action="mn_inf_recepcion1.php">
    <span class="form-el"><input type='text' id='identificacion' name='identificacion' maxlength='20' size='15' placeholder='Identificación' value="<?php echo $identificacion;?>"/></span>
    <span class="form-el"><input type='text' id='nombres' name='nombres' maxlength='30' size='20' placeholder='Nombres' value="<?php echo $nombres;?>"/></span>
    <span class="form-el"><input type='text' id='apellidos' name='apellidos' maxlength='30' size='20' placeholder='Apellidos' value="<?php echo $apellidos;?>"/></span>
    <span class="form-el"><input type='text' id='id_ingreso' name='id_ingreso' maxlength='5' size='5' placeholder='Nro Ingreso' value="<?php echo $id_ingreso;?>"/></span>
    <span class="form-el"><input type='text' id='producto' name='producto' maxlength='40' size='40' placeholder='Producto' value="<?php echo $producto;?>"/></span>
    <a href="#" onclick='validar();' title='Buscar'><span class="icon-magnifying-glass"></span> </a>
<?php
$orden='id_ingreso,id_producto,fecha_mov';
$condicion="";
if(!empty($id_ingreso)){$condicion=$condicion."id_ingreso='$id_ingreso' AND ";}
if(!empty($identificacion)){$condicion=$condicion."identificacion='$identificacion' AND ";}
if(!empty($apellidos)){$condicion=$condicion."(papellido LIKE '%$apellidos%' OR sapellido LIKE '%$apellidos%') AND ";}
if(!empty($nombres)){$condicion=$condicion."(pnombre LIKE '%$nombres%' OR snombre LIKE '%$nombres%') AND ";}
if(!empty($producto)){$condicion=$condicion."descripcion LIKE '%$producto%' AND ";}
//echo $condicion;
if(!empty($condicion)){
    //$condicion="tipo_mov='I' AND ".$condicion; 
    $condicion=substr($condicion,0,-5);
    //echo "<br>".$condicion;
    if(empty($orden)){$orden='identificacion';}
    $consulta="SELECT id_ingreso,fecha_ing,tipo_iden,identificacion,CONCAT(papellido,' ',sapellido) AS apellidos ,CONCAT(pnombre,' ',snombre) AS nombres, id_producto, CONCAT(descripcion,' ',concentracion,' ',presentacion) AS producto ,tipo_mov, fecha_mov, cantidad, operador FROM vw_movimientos WHERE ".$condicion." ORDER BY ".$orden;
    //echo "<br>".$consulta;
    $sql_=$consulta;
    $consulta=$link->query($consulta);
    if($consulta->num_rows<>0){
        echo "<br><br><table width='100%'>";
        $ingreso=-1;
        $producto=-1;
        while($row=$consulta->fetch_array()){
            if($ingreso!=$row['id_ingreso']){
                echo "<tr><td>Nro. Ingreso: $row[id_ingreso]</td></tr>";
                echo "<tr><td>Fecha de Ingreso: $row[fecha_ing]</td></tr>";
                echo "<tr><td>Identificacion: $row[tipo_iden] $row[identificacion] Nombre: $row[nombres] $row[apellidos]</td></tr>";
                $ingreso=$row['id_ingreso'];
                $producto=-1;
            }
            if($producto!=$row['id_producto']){
                echo "<th>Medicamento/Dispositovo</th>";
                echo "<th>Fecha Mov</th>";
                echo "<th>Ingreso</th>";
                echo "<th>Egreso</th>";
                echo "<th>Saldo</th>";
                echo "<tr><td>producto: $row[producto]</td></tr>";
                $producto=$row['id_producto'];
                echo "</tr>";
                $saldo=0;
            }
            echo "<tr>";
            echo "<td></td>";
            echo "<td>$row[fecha_mov]</td>";
            if($row['tipo_mov']=='I'){
                echo "<td align='right'>$row[cantidad]</td>";
                echo "<td></td>";
                $saldo=$saldo+$row['cantidad'];
                echo "<td align='right'>$saldo</td>";
            }
            else{
                echo "<td></td>";
                echo "<td align='right'>$row[cantidad]</td>";
                $saldo=$saldo-$row['cantidad'];
                echo "<td align='right'>$saldo</td>";
            }
            echo "</tr>";
        }
    }
    echo "</table>";
    //echo $sql_;
    ?>
    <input type="hidden" name="sql_" value="<?php echo $sql_;?>">
    <center><a href="#" onclick='imprimir();' title='Imprimir'><span class="icon-print"></span> Imprimir</a></center>
    <?php
}
?>
</form>
</body>
</html>
